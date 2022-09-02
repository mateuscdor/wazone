<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Template;
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

        return '...';
    }

    protected function installApp(int $merchant, ParameterBag $payload): string
    {
        $user = new User();
        $user->merchant_id = $merchant;
        $user->access_token = $payload->get('data')['access_token'];
        $user->refresh_token = $payload->get('data')['refresh_token'];

        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $user->access_token,
            ],
        ]);

        $request = $client->request('GET', self::USER_API);
        $response = json_decode($request->getBody()->getContents());

        $user->name = $response->data->name;
        $user->email = $response->data->email;
        $user->phone = $response->data->mobile;

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
