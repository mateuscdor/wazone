<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class ModuleController extends Controller
{
    public function store(Request $request)
    {
        $ext = $request->file->getClientOriginalExtension();
        $size = $request->file->getSize();
        $name = $request->file->getClientOriginalName();
        $path = public_path('app-assets/data/');
        File::ensureDirectoryExists($path, 0755, true);
        if ($ext !== 'zip') {
            return redirect()->back()->with(['danger_alert' => __('Failed. Only ZIP Files are allowed')]);
        } elseif ($size > 20000000) {
            return redirect()->back()->with(['danger_alert' => __('Failed. ZIP file should not be more than 20MB')]);
        } else {
            $zip = new ZipArchive;
            $request->file->move($path, $name);
            $res = $zip->open($path . $name);
            if ($res == TRUE)
            {
                $zip->extractTo(base_path('Modules/'));
                $zip->close();
                File::delete($path . $name);

                return redirect()->back()->with(['success_alert' => __('Successfully install') . ' ' . __('Module')]);
            } else {
                return redirect()->back()->with(['danger_alert' => __('Failed. ZIP could not be extracted. Try again')]);
            }
        }
    }

    public function list()
    {
        $checkZipExtension = extension_loaded('zip');
        $modules = Module::all();
        return view('/module_list', compact('modules', 'checkZipExtension'));
    }

    public function enable(Request $request) 
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to enable') . ' ' . __('Module')]);
        Module::find($request->module_name)->enable();
        return redirect()->back()->with(['success_alert' => __('Successfully enable') . ' ' . __('Module')]);
    }

    public function disable(Request $request) 
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to disable') . ' ' . __('Module')]);
        Module::find($request->module_name)->disable();
        return redirect()->back()->with(['success_alert' => __('Successfully disable') . ' ' . __('Module')]);
    }

    public function destroy(Request $request)
    {
        if (auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Module')]);
        Module::find($request->module_name)->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Module')]);
    }
}
