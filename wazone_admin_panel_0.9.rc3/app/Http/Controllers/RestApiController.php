<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

class RestApiController extends Controller
{
    public function index(Request $request)
    {
        $authed = Helper::authuserid();
        $receiver = '34644975414';
        $msgtext = 'Testing sending message through API';
        $msgtext2 = 'Testing+sending+message+through+API';
        $device = auth()->user()->devices()->first();
        if (empty($device->sender)) {
            $sender = 'PLEASE_ADD_SENDER_FIRST';
            $token = 'PLEASE_ADD_SENDER_FIRST';
        } else {
            $sender = $device->sender;
            $token = $device->token;
        }
        $mediaurl = url('/') . '/users/1/avatar.png';
        return view('restapi', compact('authed', 'receiver', 'msgtext', 'msgtext2', 'sender', 'token', 'mediaurl'));
    }
}
