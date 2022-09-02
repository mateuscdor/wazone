<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Template;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class WebhookController extends Controller
{
    protected function parseMessage(ParameterBag $payload, string $message): string
    {
        $map = [
            'رقم الطلب' => '',
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
        // ...
        return 'settings.saved';
    }

    protected function installApp(int $merchant, ParameterBag $payload): string
    {
        // ...
        return 'app.installed';
    }

    public function index(Request $request): string
    {
        $payload = $request->json();
        $event = $payload->get('event');
        $merchant = $payload->get('merchant');

        if ($event == 'app.settings.updated') {
            return $this->saveSettings($merchant, $payload);
        }

        if ($event == 'app.installed') {
            return $this->installApp($merchant, $payload);
        }

        $user = User::where('merchant_id', $merchant)->first() or abort(404);
        $template = Template::where('user_id', $user->id)->where('name', $event)->first() or abort(404);

        $message = $this->parseMessage($payload, $template->msgtext);
        $this->saveMessage($user, $message);

        return $message;
    }
}
