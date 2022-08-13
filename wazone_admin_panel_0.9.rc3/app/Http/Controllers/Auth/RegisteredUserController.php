<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = 'user';
        $lang = 'us';
        $theme = 'light-layout';
        $package_id = 2;
        $trial_period = Helper::setting('trialPeriod');
        $billing_interval = 'monthly';
        $billing_start = Carbon::now();
        $billing_end = Carbon::now()->addDay($trial_period);

        $user = User::create([
            'name' => str_replace(' ', '_', strtolower($request->name)),
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $role,
            'lang' => $lang,
            'theme' => $theme,
            'package_id' => $package_id,
            'trial_period' => $trial_period,
            'billing_interval' => $billing_interval,
            'billing_start' => $billing_start,
            'billing_end' => $billing_end,
        ]);

        $num = $user->id % 10;
        $path = public_path('users/' . $user->id);
        $source = public_path('app-assets/images/avatars/' . $num . '.png');
        $target = $path . '/avatar.png';
        File::ensureDirectoryExists($path, 0755, true);
        File::copy($source, $target);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
