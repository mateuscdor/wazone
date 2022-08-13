<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = new Package();
        $package->name = $request->input('name');
        $package->description = $request->input('description');
        $package->rate_monthly = $request->input('rate_monthly');
        $package->rate_yearly = 10 * $request->input('rate_monthly');//$request->input('rate_yearly');
        $package->max_outbox = $request->input('max_outbox');
        $package->max_device = $request->input('max_device');
        $package->max_template = $request->input('max_template');
        $package->max_phonebook = $request->input('max_phonebook');
        $package->save();
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $package->name]);
    }

    public function list()
    {
        $packages = Package::all();
        return view('/package_list', compact('packages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to show') . ' ' . __('Package')]);
        $package = Package::where('id', '=', $request->package_id)->first();
        return view('/package_show', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to update') . ' ' . __('Package')]);
        $package = Package::where('id', '=', $request->input('package_id'))->first();
        $package->name = $request->input('name');
        $package->description = $request->input('description');
        $package->rate_monthly = $request->input('rate_monthly');
        $package->rate_yearly = 10 * $request->input('rate_monthly');//$request->input('rate_yearly');
        $package->max_outbox = $request->input('max_outbox');
        $package->max_device = $request->input('max_device');
        $package->max_template = $request->input('max_template');
        $package->max_phonebook = $request->input('max_phonebook');
        $package->save();
        return redirect()->back()->with(['success_alert' => __('Successfully update') . ' ' . __('Package') . ': ' . $package->name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Package')]);
        $package = Package::where('id', '=', $request->package_id)->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Package')]);
    }
}
