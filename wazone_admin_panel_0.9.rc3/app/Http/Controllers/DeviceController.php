<?php

namespace App\Http\Controllers;

use App\Helpers\Formatter;
use App\Models\Device;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $package = $user->package;
        $count_device = $user->devices()->count();
        if (\Helper::isEx() && $package->max_device <= $count_device && $package->max_device != 0) return redirect()->back()->with('danger_alert', __('Device reached max limit!') . ' ' . __('Max') . ': ' . $package->max_device);
        $device = new Device();
        $device->user_id = $user->id;
        $device->name = $request->input('name');
        $device->sender = Formatter::pf($request->input('sender'));
        if (Device::where('sender', '=', $device->sender)->count() > 0) {
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to add') . ': ' . $device->name]);
        }
        $device->token = Str::random(20);
        $device->reset = Str::random(20);
        $device->status = 'OFFLINE';
        if (empty($request->input('webhook'))) {
            if (!file_exists(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"))) {
                File::ensureDirectoryExists(public_path("users/{$device->user_id}/webhook"), 0755, true);
                File::copy(base_path("webhook.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"));
                File::copy(base_path("webhook.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php"));
            }
            $device->webhook = url("/users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php");
        } else {
            $device->webhook = $request->input('webhook');
        }
        $device->save();
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $device->name]);
    }

    public function list()
    {
        $user = auth()->user();
        $devices = $user->devices()->paginate(20);
        $totalDevices = $user->devices()->count();
        $totalPhonebooks = $user->phonebooks()->count();
        $totalTemplates = $user->templates()->count();
        return view('/device_list', compact('devices', 'user', 'totalDevices', 'totalPhonebooks', 'totalTemplates'));
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $filter = $request->filter;
        $devices = Device::where('user_id', '=', $user->id)
            ->where(function($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('sender', 'LIKE', '%' . $filter . '%');
            })
            ->paginate(20);
        $totalDevices = $user->devices()->count();
        $totalPhonebooks = $user->phonebooks()->count();
        $totalTemplates = $user->templates()->count();
        return view('/device_list', compact('devices', 'user', 'totalDevices', 'totalPhonebooks', 'totalTemplates'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $device = Device::where('id', '=', $request->device_id)->first();
        if (auth()->user()->id != $device->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to show') . ' ' . __('Device')]);
        return view('/device_show', compact('device'));
    }

    public function showContacts(Request $request)
    {
        $device = Device::where('id', '=', $request->device_id)->first();
        $contactGroups = $device->contact_groups;
        if (auth()->user()->id != $device->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to show') . ' ' . __('Device')]);
        return view('/device_showcontacts', compact('device', 'contactGroups'));
    }

    public function webhook(Request $request)
    {
        $device = Device::where('id', '=', $request->device_id)->first();
        if (auth()->user()->id != $device->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to show') . ' ' . __('Webhook')]);
        if ($device->webhook === url("/users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php")) {
            $content = file_get_contents(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"));
        } else {
            $content = 'Custom webhook url is not editable.' . "\n" .
                'If you want it to be editable:' . "\n" .
                '1. Go to menu devices' . "\n" .
                '2. Click "edit" button.' . "\n" .
                '3. Delete the custom webhook url. Use the default webhook url (EMPTY). "Save"' . "\n" .
                '4. Copy your custom webhook code. Paste the code inside this window' . "\n" .
                '5. Save';
        }
        return view('/device_webhook', compact('device', 'content'));
    }

    public function webhookedit(Request $request)
    {
        $device = Device::where('id', '=', $request->input('device_id'))->first();
        if (auth()->user()->id != $device->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to edit') . ' ' . __('Webhook')]);
        if (empty($request->input('webhook'))) {
            if (!file_exists(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"))) {
                File::ensureDirectoryExists(public_path("users/{$device->user_id}/webhook"), 0755, true);
                File::copy(base_path("webhook.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"));
                File::copy(base_path("webhook.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php"));
            }
            $device->webhook = url("/users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php");
        } else {
            $device->webhook = $request->input('webhook');
        }
        $device->save();
        return redirect()->back()->with(['success_alert' => __('Successfully edit') . ': ' . $device->sender]);
    }

    public function webhookupdate(Request $request)
    {
        $device = Device::where('id', '=', $request->input('device_id'))->first();
        if (auth()->user()->id != $device->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to update') . ' ' . __('Webhook')]);
        file_put_contents(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"), $request->input('content'));
        file_put_contents(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php"), $request->input('content'));
        return redirect()->back()->with(['success_alert' => __('Successfully update') . ': ' . $device->sender]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $device = Device::where('id', '=', $request->device_id)->first();
        if (auth()->user()->id != $device->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Device')]);
        $url = env('NODE_URL') . '/delauth';
        $data = [ 'sender' => $device->sender, 'token' => $device->token, 'logout' => true ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = json_decode(curl_exec($ch), true);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) return redirect()->back()->with(['danger_alert' => __('Delete failed') . ' ' . '<br>' . json_encode($err)]);
        if (empty($response['success'])) {
            return redirect()->back()->with(['danger_alert' => __('Delete failed') . ' ' . '<br>' . $response['message']]);
        } else {
            if (file_exists(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"))) {
                File::delete(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"));
            }
            if (file_exists(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php"))) {
                File::delete(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}_" . Config::get('app.enc_key') . ".php"));
            }

            $device->delete();
            return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . '<br>' . $response['message']]);
        }
    }
}
