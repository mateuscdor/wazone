<?php

namespace App\Http\Middleware;

use App\Helpers\Formatter;
use App\Helpers\Helper;
use App\Http\Controllers\SendmsgController;
use App\Models\User;
use Carbon\Carbon;
use Closure;

class WaVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty($request->user()->email_verified_at) && Helper::setting('waVerification') == "true") {
            $admin = User::where('name', '=', 'admin')->first();
            $adminSender = $admin->devices()->where('status', '=', 'ONLINE')->value('sender');
            if ($adminSender) {
                $receiver = Formatter::pf($request->user()->phone);
                $code = base64_encode(mb_substr($request->user()->password, -10));
                $url = url('/user-verifynow/' . $request->user()->id . '/' . $code);
                if (Helper::setting('waVerificationMsg')) {
                    $msgtext = str_replace(['{name}', '{appurl}', '{appname}'], [$request->user()->name, env('APP_URL'), env('APP_NAME')], Helper::setting('waVerificationMsg'));
                } else {
                    $msgtext = 'Hi *' . $request->user()->name . '*! This is a verification process because you have just registered a new account on {appname}. If you did not register an account, please ignore this message. If you did, please click the button below to verify. Thank you, -Admin-';
                }
                $buttons = [['index' => 1, 'urlButton' => ['displayText' => __('Verify NOW'), 'url' => $url]]];
                $response = SendmsgController::sendMessage($receiver, $msgtext, $adminSender, null, $buttons);
                return redirect()->route('user.verify');
            }
        }
        return $next($request);
    }
}
