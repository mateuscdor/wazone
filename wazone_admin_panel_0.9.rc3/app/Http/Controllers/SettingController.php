<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = new Setting();
        $setting->key = $request->input('key');
        if (Setting::where('key', '=', $setting->key)->count() > 0) {
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to add') . ': ' . $setting->key]);
        }
        $setting->value = $request->input('value');
        $setting->save();
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $setting->key]);
    }

    public function list()
    {
        $settings = Setting::orderBy('key')->paginate(20);
        return view('/setting_list', compact('settings'));
    }

    public function search(Request $request)
    {
        $settings = Setting::orderBy('key')
            ->where('key', 'LIKE', '%' . $request->filter . '%')
            ->orWhere('value', 'LIKE', '%' . $request->filter . '%')
            ->paginate(20);
        return view('/setting_list', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to update') . ' ' . __('Settings')]);
        $setting = Setting::where('id', '=', $request->input('setting_id'))->first();
        $setting->key = $request->input('key');
        $setting->value = $request->input('value');
        $setting->save();
        return redirect()->back()->with(['success_alert' => __('Successfully update') . ' ' . __('Settings') . ': ' . $setting->key]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Settings')]);
        Setting::where('id', '=', $request->setting_id)->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Settings')]);
    }

    public function clearcache()
    {
        if (file_exists(storage_path('logs/laravel.log'))) {
            unlink(storage_path('logs/laravel.log'));
        }
        Artisan::call('optimize:clear');
        return redirect()->back()->with(['success_alert' => __('Successfully clear cache')]);
    }
}
