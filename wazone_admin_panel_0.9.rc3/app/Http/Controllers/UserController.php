<?php

namespace App\Http\Controllers;

use App\Helpers\Formatter;
use App\Helpers\Helper;
use App\Http\Controllers\SendmsgController;
use App\Models\Device;
use App\Models\Package;
use App\Models\Phonebook;
use App\Models\Template;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class UserController extends Controller
{
    public function dashboard()
    {
        return redirect()->route('user.show', ['user_id' => auth()->user()->id])->with(['success_alert' => __('WELCOME!')]);
    }

    public function list()
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to view this page')]);
        $users = User::latest()->paginate(20);
        $currentSent = User::sum('current_sent');
        $totalSent = User::sum('total_sent');
        $totalUsers = User::count();
        $totalPhonebooks = Phonebook::count();
        $totalTemplates = Template::count();
        $packages = Package::all();
        $intervals = array('monthly');
        return view('/user_list', compact('packages', 'users', 'currentSent', 'totalSent', 'totalUsers', 'totalPhonebooks', 'totalTemplates', 'intervals'));
    }

    public function search(Request $request)
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to view this page')]);
        $users = User::where('name', 'LIKE', '%' . $request->filter . '%')->orWhere('role', 'LIKE', '%' . $request->filter . '%')->latest()->paginate(20);
        $currentSent = User::sum('current_sent');
        $totalSent = User::sum('total_sent');
        $totalUsers = User::count();
        $totalPhonebooks = Phonebook::count();
        $totalTemplates = Template::count();
        $packages = Package::all();
        $intervals = array('monthly');
        return view('/user_list', compact('packages', 'users', 'currentSent', 'totalSent', 'totalUsers', 'totalPhonebooks', 'totalTemplates', 'intervals'));
    }

    public function show(Request $request)
    {
        if (auth()->user()->id != $request->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to show') . ' ' . __('User')]);
        $status = 'Loading...';
        if (empty(Helper::setting('currencyCode'))) {
            $currencyCode = 'USD';
        } else {
            $currencyCode = Helper::setting('currencyCode');
        }
        $user = User::where('id', '=', $request->user_id)->first();
        $upackage = $user->package;
        $packages = Package::all();
        $daysTotal = round(Carbon::parse($user->billing_start)->diffInSeconds($user->billing_end, false) / 86400);
        $daysUsed = round(Carbon::parse($user->billing_start)->diffInseconds(now()) / 86400);
        $daysRemaining = round(Carbon::now()->diffInseconds($user->billing_end, false) / 86400);
        $percentUsed = $daysTotal <= 0 ? 100 : round($daysUsed / $daysTotal * 100);
        if ($daysRemaining < -0.04 && $user->role !== 'admin' && Helper::isEx()) {
            $status = 'EXPIRED';
            $user->package_id = 2;
            $user->save();
        } else {
            $status = 'ACTIVE';
        }
        $modules = Module::getByStatus(1);
        $topupValues = array_map('intval', explode(',', Helper::setting('topupValues')));
        $intervals = array('monthly');
        $walletBalance = $user->transactions()->sum('amount');//Transaction::where('user_id', '=', $user->id)->sum('amount');
        return view('/user_show', compact('user', 'upackage', 'packages', 'daysTotal', 'daysUsed', 'daysRemaining', 'percentUsed', 'status', 'currencyCode', 'modules', 'topupValues', 'intervals', 'walletBalance'));
    }

    public function store(Request $request)
    {
        $username = str_replace(' ', '_', strtolower($request->input('name')));
        if (User::where('name', '=', $username)->count() > 0) {
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to add') . ': ' . $request->input('name')]);
        }
        if (User::where('email', '=', $request->input('email'))->count() > 0) {
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to add') . ': ' . $request->input('email')]);
        }
        $user = new User();
        $user->name = $username;
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->phone = Formatter::pf($request->input('phone'));
        $user->role = $request->input('role');
        $user->package_id = $request->input('package_id');
        $user->billing_interval = $request->input('billing_interval');
        $user->billing_start = Carbon::now()->startOfMonth();
        $user->billing_end = Carbon::now()->endOfMonth();
        $user->save();

        $num = $user->id % 10;
        $path = public_path('users/' . $user->id);
        $source = public_path('app-assets/images/avatars/' . $num . '.png');
        $target = $path . '/avatar.png';
        File::ensureDirectoryExists($path, 0755, true);
        File::copy($source, $target);
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $user->name]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (auth()->user()->id != $request->input('user_id') && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to update') . ' ' . __('User')]);
        $username = str_replace(' ', '_', strtolower($request->input('name')));
        $user = User::where('id', '=', $request->input('user_id'))->first();
        if (User::where('name', '=', $username)->count() > 0) {
            if ($user->name != $username)
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to edit') . ': ' . $request->input('name')]);
        }
        if ($request->input('password') != null) {
            if (strlen($request->input('password')) > 5 ) {
                $user->password = Hash::make($request->input('password'));
            } else {
                return redirect()->back()->with(['danger_alert' => __('Password minimum 6 characters')]);
            }
        }
        $user->name = $username;
        $user->email = $request->input('email');
        $user->phone = Formatter::pf($request->input('phone'));
        $user->theme = $request->input('theme');
        $user->package_id = $request->input('package_id');
        $user->role = $request->input('role');
        $user->save();
        return redirect()->back()->with(['success_alert' => __('Successfully update') . ' ' . __('User') . ': ' . $user->name]);
    }

    public function changephone(Request $request)
    {
        if (empty($request->input('email_verified_at')) && Helper::setting('waVerification') == "true") {
            $user = User::where('id', '=', $request->input('user_id'))->first();
            $admin = User::where('name', '=', 'admin')->first();
            $adminSender = $admin->devices()->where('status', '=', 'ONLINE')->value('sender');
            if ($adminSender) {
                $user->phone = Formatter::pf($request->input('phone'));
                $user->save();
                $code = base64_encode(mb_substr($user->password, -10));
                $url = url('/user-verifynow/' . $user->id . '/' . $code);
                if (Helper::setting('waVerificationMsg')) {
                    $msgtext = str_replace(['{name}', '{appurl}', '{appname}'], [$user->name, env('APP_URL'), env('APP_NAME')], Helper::setting('waVerificationMsg'));
                } else {
                    $msgtext = 'Hi *' . $user->name . '*! This is a verification process because you have just registered a new account on {appname}. If you did not register an account, please ignore this message. If you did, please click the button below to verify. Thank you, -Admin-';
                }
                $buttons = [['index' => 1, 'urlButton' => ['displayText' => __('Verify NOW'), 'url' => $url]]];
                $response = SendmsgController::sendMessage($user->phone, $msgtext, $adminSender, null, $buttons);
                return redirect()->back()->with(['success_alert' => __('Successfully change phone number') . ' ' . __('User') . ': ' . $user->name]);
            } else {
                return redirect()->route('dashboard')->with(['danger_alert' => __('User already verified') . ': ' . $user->name]);
            }
        }
    }

    public function verify()
    {
        $user = auth()->user();
        if ($user->email_verified_at == null) {
            return view('/user_verify', compact('user'));
        } else {
            return redirect()->route('dashboard')->with(['danger_alert' => __('User already verified') . ': ' . $user->name]);
        }
    }

    public function verifynow($id, $code)
    {
        $user = User::where('id', '=', $id)->first();
        if (base64_decode($code) === mb_substr($user->password, -10)) {
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->save();

            $device = Device::where('sender', '=', $user->phone)->first();
            if (empty($device)) {
                $newDevice = new Device();
                $newDevice->user_id = $user->id;
                $newDevice->name = $user->name;
                $newDevice->sender = $user->phone;
                $newDevice->token = Str::random(20);;
                $newDevice->reset = Str::random(20);;
                $newDevice->status = 'OFFLINE';
                if (!file_exists(public_path("users/{$user->id}/webhook/wh_{$user->phone}.php"))) {
                    File::ensureDirectoryExists(public_path("users/{$user->id}/webhook"), 0755, true);
                    File::copy(base_path("webhook.php"), public_path("users/{$user->id}/webhook/wh_{$user->phone}.php"));
                }
                $newDevice->webhook = url("/users/{$user->id}/webhook/wh_{$user->phone}.php");
                $newDevice->save();
            }
        }
        return redirect()->route('dashboard')->with(['success_alert' => __('Verification successful') . ': ' . $user->name]);
    }

    public function expired()
    {
        $user = auth()->user();
        return view('/user_expired', compact('user'));
    }

    public function impersonate(User $user)
    {
        auth()->user()->impersonate($user);

        return redirect()->route('user.show', ['user_id' => $user->id]);
    }

    public function leaveImpersonate()
    {
        auth()->user()->leaveImpersonation();

        return redirect()->route('user.list');
    }

    public function locale(Request $request)
    {
        session()->put('locale', $request->locale);
        $user = auth()->user();
        $user->lang = $request->locale;
        $user->save();
        return redirect()->back()->with(['success_alert' => __('Successfully change language to') . ': ' . $user->lang]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_name = User::where('id', '=', $request->user_id)->value('name');
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('User')]);
        if ($user_name === 'admin' || $user_name === 'bank') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete super_admin and bank account')]);
        User::where('id', '=', $request->user_id)->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('User')]);
    }
}
