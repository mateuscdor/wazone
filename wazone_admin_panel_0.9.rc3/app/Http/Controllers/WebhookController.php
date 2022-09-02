<?php

namespace App\Http\Controllers;

use App\Models\Outbox;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Blocked;
use App\Models\Template;
use App\Helpers\Formatter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class WebhookController extends Controller
{

    const USER_API = 'https://api.salla.dev/admin/v2/oauth2/user/info';

    public function parseMessage(ParameterBag $payload, string $message): array
    {
        $map = [];
        $event = $payload->get('event');

        switch ($event) {
            case 'order.created':
            case 'order.payment.updated';
                $customer_mobile =  $payload->get('data')['customer']["mobile"];
                $map['اسم العميل'] = $payload->get('data')['customer']["first_name"];
                $map['اسم المنتج'] = $payload->get('data')['items'][0]['name'];
                $map['رقم الطلب'] = $payload->get('data')['reference_id'];
                $map['رابط معلومات الطلب'] = $payload->get('data')['urls']['admin'];
                $map['قيمة الطلب'] = $payload->get('data')['items'][0]['amounts']['total']['amount'];
                $map['العملة'] = $payload->get('data')['currency'];
                $map['حالة الطلب'] = $payload->get('data')['status']['customized']['name'];
                $map['شركة الشحن'] = $payload->get('data')['shipping']['company'];
                $map['رقم التتبع'] = $payload->get('data')['shipping']['id'];
                $map['رابط التتبع'] = $payload->get('data')['shipping']['shipment']['tracking_link'];
                $map['طريقة الدفع'] = $payload->get('data')['payment_method'];
            break;
            case 'order.status.updated':
                $customer_mobile =  $payload->get('data')['order']['customer']["mobile"];
                $map['اسم العميل'] = $payload->get('data')['order']['customer']["name"];
                $map['اسم المنتج'] = implode(",", array_column($payload->get('data')['order']['items'],"name"));
                $map['رقم الطلب'] = $payload->get('data')['order']['reference_id'];
                $map['رابط معلومات الطلب'] = $payload->get('data')['order']['urls']['admin'];
                $map['قيمة الطلب'] = $payload->get('data')['order']['amounts']['total']['amount'];
                $map['العملة'] = $payload->get('data')['order']['currency'];
                $map['حالة الطلب'] = $payload->get('data')['status'];
                $map['شركة الشحن'] = $payload->get('data')['order']['shipping']['company'];
                $map['رقم التتبع'] = $payload->get('data')['order']['shipping']['id'];
                $map['رابط التتبع'] = $payload->get('data')['order']['shipping']['shipment']['tracking_link'];
                $map['طريقة الدفع'] = $payload->get('data')['order']['payment_method'];
            break;
            case 'abandoned.cart':
                $customer_mobile =  $payload->get('data')['customer']["mobile"];
                $map['اسم العميل'] = $payload->get('data')['customer']["name"];
                $map['اسم المنتج'] = implode(",", array_column($payload->get('data')['items'],"product_id"));
                $map['رقم الطلب'] = '';
                $map['رابط معلومات الطلب'] = '';
                $map['قيمة الطلب'] = $payload->get('data')['total']['amount'];
                $map['العملة'] = $payload->get('data')['total']['currency'];
                $map['حالة الطلب'] = '';
                $map['شركة الشحن'] = '';
                $map['رقم التتبع'] = '';
                $map['رابط التتبع'] ='';
                $map['طريقة الدفع'] = '';
            break;
        }

        $keys = array_map(fn($e) => '{{' . $e . '}}', array_keys($map));
        return [$customer_mobile, str_replace($keys, array_values($map), $message)];
    }

    protected function saveMessage(User $user, int $mobile, string $message): void
    {
        $blocked = Blocked::where('mobile', $mobile)->where('user_id', $user->id)->first();

        if (!$blocked)
        {
            $out_box = new Outbox();
            $out_box->user_id = $user->id;
            $out_box->sender = $user->phone;
            $out_box->receiver = $mobile;
            $out_box->msgtext = $message;
            $out_box->schedule = time() + 300;
            $out_box->save();
        }
    }

    protected function saveSettings(int $merchant, ParameterBag $payload): string
    {
        $user = User::where('merchant_id', $merchant)->first();
        $settings = new ParameterBag($payload->get('data')['settings']);

        /* Handle Templates */
        $switches = collect($settings->keys())
            ->filter(fn($key) => Str::startsWith($key, 'switch.'))
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
            ->map(fn($number) => Formatter::pf($number['blocked.numbers.number']));

        Blocked::where('user_id', $user->id)->delete();
        Blocked::insert($blocked->map(fn($number) => [
            'user_id' => $user->id,
            'mobile' => $number,
        ])->toArray());

        return 'settings.saved';
    }

    protected function installApp(int $merchant, ParameterBag $payload): string
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
        return $user->toJson();
    }

    public function index(Request $request): array
    {
        $payload = $request->json();
        $event = $payload->get('event');
        $merchant = $payload->get('merchant');

        if ($event == 'app.store.authorize' && User::where('merchant_id', $merchant)->doesntExist()) {
            return $this->installApp($merchant, $payload);
        }

        if ($event == 'app.settings.updated') {
            return $this->saveSettings($merchant, $payload);
        }

        $user = User::where('merchant_id', $merchant)->first() or abort(404);
        $template = Template::where('user_id', $user->id)->where('name', $event)->first() or abort(404);

        $data_message = $this->parseMessage($payload, $template->msgtext);
        $this->saveMessage($user, $data_message[0], $data_message[1]);

        return $data_message;
    }
}
