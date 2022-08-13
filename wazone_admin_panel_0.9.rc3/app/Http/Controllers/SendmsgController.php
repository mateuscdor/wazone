<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Outbox;
use App\Helpers\Formatter;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class SendmsgController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $devices = $user->devices;
        $phonebooks = $user->phonebooks;
        $templates = $user->templates;
        if (empty(Helper::setting('numOfButtons'))) {
            $numOfButtons = 2;
        } else {
            $numOfButtons = Helper::setting('numOfButtons');
        }
        return view('/sendmsg', compact('devices', 'phonebooks', 'templates', 'numOfButtons'));
    }

    public function store(Request $request)
    {
        $alertMsg = '';
        if (empty(Helper::setting('numOfButtons'))) {
            $numOfButtons = 2;
        } else {
            $numOfButtons = Helper::setting('numOfButtons');
        }
        if ($request->mediafile != null) {
            $user_id = auth()->user()->id;
            //$media_ext = $request->mediafile->getClientOriginalExtension();
            $mediafile = str_replace(' ', '_', $request->mediafile->getClientOriginalName());
            $mediaurl = url("/users/{$user_id}/outbox/{$mediafile}");
            $media_upload = $request->mediafile->move(public_path("/users/{$user_id}/outbox"), $mediafile);
        } else {
            $mediafile = '';
            $mediaurl = '';
        }
        if ($request->input('single_receiver') != null) {
            $phones = explode(',', $request->input('single_receiver'));
            $receivers = array();
            foreach ($phones as $phone) {
                array_push($receivers, array('phone' => $phone, 'name' => 'Sir/Madam'));
            }
            foreach($receivers as $receiver) {
                $this->saveToDb($request, $receiver, $mediafile, $mediaurl, $numOfButtons, true);
            }
        }
        if ($request->input('phonebook') != null) {
            $receivers = json_decode($request->input('phonebook'), true);
            foreach ($receivers as $receiver) {
                $this->saveToDb($request, $receiver, $mediafile, $mediaurl, $numOfButtons, false);
            }
        }
        $request->session()->flash('success_alert', $alertMsg . __('Successfully add message to outbox'));
        return redirect()->route('sendmsg.index');
    }

    private function saveToDb($request, $receiver, $mediafile, $mediaurl, $numOfButtons, $isSendNow)
    {
        $outbox = new Outbox();
        $outbox->user_id = $request->input('user_id');
        $outbox->job_id = $request->input('job_id');
        $outbox->sender = $request->input('sender');
        if (strlen($receiver['phone']) > 20) {
            $outbox->receiver = $receiver['phone'];
        } else {
            $outbox->receiver = Formatter::pf($receiver['phone']);
        }
        $outbox->rec_name = $receiver['name'];
        $outbox->mediafile = $mediafile;
        $outbox->mediaurl = $mediaurl;
        $outbox->msgtext = str_replace('{name}', $receiver['name'], $request->input('msgtext'));
        $outbox->schedule = $request->input('schedule');
        $outbox->save();

        $data = array(); // $data == null
        for ($i=1; $i<=$numOfButtons; $i++) {
            if ($request->input('displayText' . $i) != null) {
                if (strpos($request->input('responseText' . $i), 'http') === 0) {
                    $restype[$i] = 'url'; $buttype[$i] = 'urlButton';
                } else if (strpos($request->input('responseText' . $i), '+') === 0) {
                    $restype[$i] = 'phoneNumber'; $buttype[$i] = 'callButton';
                } else {
                    $restype[$i] = 'id'; $buttype[$i] = 'quickReplyButton';
                }
                $arr = array('index' => $i, $buttype[$i] => ['displayText' => $request->input('displayText' . $i), $restype[$i] => $request->input('responseText' . $i)]);
                array_push($data, $arr);
            }
        }
        $outbox->data = $data;
        $outbox->save();

        if ($outbox->schedule == null && $isSendNow) {
            $outbox->try += 1;
            $response = Self::sendMessage($outbox->receiver, $outbox->msgtext, $outbox->sender, $outbox->mediaurl, $outbox->data);
            if (!empty($response['success'])) {
                if ($response['success'] == true) {
                    $outbox->status = 'SENT';
                    $alertMsg = __('Single receiver send job SENT') .'<br>';
                } else {
                    $outbox->status = 'FAILED';
                    $alertMsg =  __('Single receiver send job FAILED') .'<br>';
                }
            }
        $outbox->save();
        }
}

    public static function sendMessage($receiver, $msgtext, $sender, $mediaurl=null, $buttons=null)
    {
        $appurl = env('APP_URL');
        $apiurl = env('NODE_URL') . '/send';
        if (strlen($receiver) > 20) {
            $receiverWa = $receiver;
        } else {
            $receiverWa = Formatter::pf($receiver);
        }
        $device = Device::where('sender', '=', $sender)->first();
        $token = $device->token;
        $data = [
            'receiver'  => $receiverWa,
            'msgtext'   => $msgtext,
            'sender'    => $sender,
            'token'     => $token,
            'appurl'    => $appurl,
            'mediaurl'  => $mediaurl,
            'buttons'   => $buttons,
            'skipsave'  => true,
        ];
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = json_decode(curl_exec($ch), true);
        $err = curl_error($ch);
        curl_close($ch);
        if (!empty($response['success'])) {
            if ($response['success'] == true) {
                $response['msg'] = 'Message sent successfully!';
            } else {
                $response['msg'] = 'Send message failed!';
            }
            return $response;
        }
    }

    public function scheduledMessages()
    {
        if (empty(Helper::setting('bulkMsgDelay'))) {
            $bulkMsgDelay = 0;
        } else {
            $bulkMsgDelay = Helper::setting('bulkMsgDelay');
        }
        $maxPerSender = 10;
        $count = 0;
        $sender = '';
        $timeNow = date("Y-m-d H:i:s");
        $outboxes = Outbox::where('status', '=', 'PENDING')->orderBy('sender')->get();
        foreach ($outboxes as $outbox) {
            if ($sender == $outbox->sender && $count >= $maxPerSender) {
                continue;
            } else {
                $count = 0;
            }
            $count += 1;
            if ($timeNow < $outbox->schedule) continue;
            if ($outbox->try < 3) {
                $outbox->try += 1;
                $outbox->save();
                $response = Self::sendMessage($outbox->receiver, $outbox->msgtext, $outbox->sender, $outbox->mediaurl, json_decode($outbox->data));
                sleep($bulkMsgDelay); // this will delay x seconds each message. Use below if want to randomize the delay.
                //sleep(rand(0, $bulkMsgDelay)); // each msg will be sent between 0-x seconds delay.
                //sleep(rand(0, 5)); // each msg will be sent between 0-5 seconds delay.
                //sleep(rand($bulkMsgDelay, $bulkMsgDelay + 3)); // if $bulkMsgDelay = '2', then each msg will be sent between 2-5 seconds delay.
            } else {
                $outbox->status = 'FAILED';
                $outbox->save();
            }
            if (!empty($response['success'])) {
                if ($response['success'] == true) {
                    $outbox->status = 'SENT';
                } else {
                    $outbox->status = 'FAILED';
                }
                $outbox->save();
            }
        }
    }
}