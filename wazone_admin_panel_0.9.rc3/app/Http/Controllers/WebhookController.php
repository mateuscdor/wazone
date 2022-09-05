<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Outbox;
use GuzzleHttp\Client;
use App\Models\Blocked;
use App\Models\Template;
use App\Helpers\Formatter;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class WebhookController extends Controller
{

    /**
     * Salla fetch user endpoint.
     *
     * @var string
     */
    const USER_API = 'https://api.salla.dev/admin/v2/oauth2/user/info';

    /**
     * Resolve message parameters.
     *
     * @param ParameterBag $payload
     * @param string $message
     * @return array
     */
    public function parseMessage(ParameterBag $payload, string $message): array
    {
        $map = [];
        $event = $payload->get('event');

        switch ($event) {
            case 'order.created':
            case 'order.payment.cod':
            case 'order.payment.updated':
                $mobile = $payload->get('data')['customer']['mobile'];
                $map['اسم العميل'] = $payload->get('data')['customer']['first_name'];
                $map['اسم المنتج'] = $payload->get('data')['items'][0]['name'];
                $map['رقم الطلب'] = $payload->get('data')['reference_id'];
                $map['رابط معلومات الطلب'] = $payload->get('data')['urls']['customer'];
                $map['قيمة الطلب'] = $payload->get('data')['items'][0]['amounts']['total']['amount'];
                $map['العملة'] = $payload->get('data')['currency'];
                $map['حالة الطلب'] = $payload->get('data')['status']['customized']['name'];
                $map['شركة الشحن'] = $payload->get('data')['shipping']['company'];
                $map['رقم التتبع'] = $payload->get('data')['shipping']['id'];
                $map['رابط التتبع'] = $payload->get('data')['shipping']['shipment']['tracking_link'];
                $map['طريقة الدفع'] = $payload->get('data')['payment_method'];
            break;

            case 'order.status.updated':
            case 'order.status.updated.payment_pending':
            case 'order.status.updated.under_review':
            case 'order.status.updated.in_progress':
            case 'order.status.updated.completed':
            case 'order.status.updated.delivering':
            case 'order.status.updated.delivered':
            case 'order.status.updated.shipped':
            case 'order.status.updated.canceled':
            case 'order.status.updated.restored':
            case 'order.status.updated.restoring':
                $mobile = $payload->get('data')['order']['customer']['mobile'];
                $map['اسم العميل'] = $payload->get('data')['order']['customer']['name'];
                $map['اسم المنتج'] = implode(',', array_column($payload->get('data')['order']['items'], 'name'));
                $map['رقم الطلب'] = $payload->get('data')['order']['reference_id'];
                $map['رابط معلومات الطلب'] = $payload->get('data')['order']['urls']['customer'];
                $map['قيمة الطلب'] = $payload->get('data')['order']['amounts']['total']['amount'];
                $map['العملة'] = $payload->get('data')['order']['currency'];
                $map['حالة الطلب'] = $payload->get('data')['status'];
                $map['شركة الشحن'] = $payload->get('data')['order']['shipping']['company'];
                $map['رقم التتبع'] = $payload->get('data')['order']['shipping']['id'];
                $map['رابط التتبع'] = $payload->get('data')['order']['shipping']['shipment']['tracking_link'];
                $map['طريقة الدفع'] = $payload->get('data')['order']['payment_method'];
            break;

            case 'abandoned.cart':
                $mobile = $payload->get('data')['customer']['mobile'];
                $map['اسم العميل'] = $payload->get('data')['customer']['name'];
                $map['اسم المنتج'] = implode(',', array_column($payload->get('data')['items'], 'product_id'));
                $map['قيمة الطلب'] = $payload->get('data')['total']['amount'];
                $map['العملة'] = $payload->get('data')['total']['currency'];
            break;

            case 'customer.otp.request':
                $mobile = $payload->get('data')['contact'];
                $map['رمز التحقق'] = $payload->get('data')['code'];
            break;
        }

        $mobile = Formatter::pf($mobile);
        $keys = array_map(fn ($e) => '{{' . $e . '}}', array_keys($map));
        return [$mobile, str_replace($keys, array_values($map), $message)];
    }

    /**
     * Save the message to the outbox.
     *
     * @param User $user
     * @param string $mobile
     * @param string $message
     * @param int $delay
     * @return void
     */
    protected function saveMessage(User $user, string $mobile, string $message, int $delay = 0): void
    {
        if (Blocked::where('mobile', $mobile)->where('user_id', $user->id)->doesntExist()) {
            $outbox = new Outbox();
            $outbox->user_id = $user->id;
            $outbox->sender = $user->phone;
            $outbox->receiver = Formatter::pf($mobile);
            $outbox->msgtext = $message;
            $outbox->schedule = time() + 300;
            $outbox->schedule = Carbon::now()->addMinutes($delay);
            $outbox->save();
        }
    }

    /**
     * Save user settings.
     *
     * @param string $merchant
     * @param ParameterBag $payload
     * @return void
     */
    protected function saveSettings(string $merchant, ParameterBag $payload): void
    {
        $user = User::where('merchant_id', $merchant)->first();
        $settings = new ParameterBag($payload->get('data')['settings']);

        /* Handle Templates */
        $switches = collect($settings->keys())
            ->filter(fn ($key) => Str::startsWith($key, 'switch.'))
            ->values();

        foreach ($switches as $switch) {
            $event = Str::after($switch, 'switch.');
            if (!$settings->get("switch.$event")) continue;

            $template = Template::firstOrNew([
                'user_id' => $user->id,
                'name' => $event,
            ]);

            $template->name = $event;
            $template->msgtext = $settings->get("message.$event");
            $template->save();
        }

        /* Handle Blocked Numbers */
        $blocked = collect($settings->get('blocked.numbers'))
            ->map(fn ($number) => Formatter::pf($number['blocked.numbers.number']));

        Blocked::where('user_id', $user->id)->delete();
        Blocked::insert($blocked->map(fn ($number) => [
            'user_id' => $user->id,
            'mobile' => $number,
        ])->toArray());

        /* Handle Abandoned Cart Delay */
        Setting::where('key', "delay.$merchant")->delete();
        Setting::insert([
            'key' => "delay.$merchant",
            'value' => $settings->get('delay.abandoned.cart'),
        ]);
    }

    /**
     * Install wazone to salla store.
     *
     * @param string $merchant
     * @param ParameterBag $payload
     * @return void
     */
    protected function installApp(string $merchant, ParameterBag $payload): void
    {
        $user = new User();
        $user->merchant_id = $merchant;
        $user->access_token = $payload->get('data')['access_token'];
        $user->refresh_token = $payload->get('data')['refresh_token'];

        $client = new Client([
            'http_errors' => false,
            'headers' => ['Authorization' => "Bearer $user->access_token"],
        ]);

        $request = $client->request('GET', self::USER_API);
        $response = json_decode($request->getBody()->getContents());

        if ($response->status == 200) {
            $user->name = $response->data->name;
            $user->email = $response->data->email;
            $user->phone = $response->data->mobile;
        }

        $password = Str::random(8);
        $user->password = bcrypt($password);

        $user->save();

        $message = sprintf(
            "تم تثبيت وازون بنجاح، يمكنك تسجيل الدخول من خلال البريد البريد الإلكتروني %s وكلمة السر %s",
            $user->email,
            $user->phone
        );

        $this->sendMessage($user, $user->phone, $message);
    }

    /**
     * WebhookController index
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        $payload = $request->json();
        $event = $payload->get('event');
        $merchant = $payload->get('merchant');

        if ($event == 'app.store.authorize' && User::where('merchant_id', $merchant)->doesntExist()) {
            $this->installApp($merchant, $payload);
            return;
        }

        if ($event == 'app.settings.updated') {
            $this->saveSettings($merchant, $payload);
            return;
        }

        if ($event == 'order.payment.updated' && $payload->get('data')['payment_method'] == 'cod') {
            $event = 'order.payment.cod';
        }

        if ($event == 'order.status.updated') {
            $slug = $payload->get('data')['order']['status']['slug'];
            $event = $event . ".$slug";
        }

        $user = User::where('merchant_id', $merchant)->first() or abort(404);
        $template = Template::where('user_id', $user->id)->where('name', $event)->first() or abort(404);

        [ $mobile, $message ] = $this->parseMessage($payload, $template->msgtext);

        if ($event = 'abandoned.cart') {
            $delay = Setting::where('key', "delay.$merchant")->first();
            $delay = ($delay->value * 60) - $payload->get('data')['age_in_minutes'];
            if ($delay > 0) return;
        }

        $delay = $delay ?? 0;
        $this->saveMessage($user, $mobile, $message, $delay);
    }
}
