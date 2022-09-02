<?php

namespace App\Http\Controllers;

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

    protected function parseMessage(ParameterBag $payload, string $message): string
    {
        $map = [
            'رقم الطلب' => '',
            'اسم العميل' => '',
        ];

        $event = $payload->get('event');

        switch ($event) {
            case 'order.created':
            case 'order.updated':
            case 'order.refunded':
                $map['رقم الطلب'] = $payload->get('data')['reference_id'];
                $map['اسم العميل'] = $payload->get('data')['customer']['first_name'];
                break;
            // ...
        }

        $keys = array_map(fn($e) => '{{' . $e . '}}', array_keys($map));
        return str_replace($keys, array_values($map), $message);
    }

    protected function saveMessage(User $user, string $message): void
    {
        // ...
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

    public function index(Request $request): string
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

        $message = $this->parseMessage($payload, $template->msgtext);
        $this->saveMessage($user, $message);

        return $message;
    }
}
