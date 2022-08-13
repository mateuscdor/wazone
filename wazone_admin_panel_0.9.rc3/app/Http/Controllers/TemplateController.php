<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
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
        $countTemplate = $user->templates()->count();
        if (\Helper::isEx() && $package->max_template <= $countTemplate && $package->max_template != 0) return redirect()->back()->with('danger_alert', __('Template reached max limit!') . ' ' . __('Max') . ': ' . $package->max_template);
        $template = new Template();
        $template->user_id = $user->id;
        $template->name = $request->input('name');
        if (Template::where('user_id', '=', $user->id)->where('name', '=', $template->name)->count() > 0) {
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to add') . ': ' . $template->name]);
        }
        $template->msgtext = $request->input('msgtext');
        $template->save();
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $template->name]);
    }

    public function list()
    {
        $templates = auth()->user()->templates()->paginate(20);
        return view('/template_list', compact('templates'));
    }

    public function search(Request $request)
    {
        $filter = $request->filter;
        $templates = auth()->user()->templates()
            ->where(function($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('msgtext', 'LIKE', '%' . $filter . '%');
            })
            ->paginate(20);
        return view('/template_list', compact('templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        $template = Template::where('id', '=', $request->input('template_id'))->first();
        if (auth()->user()->id != $template->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to update') . ' ' . __('Template')]);
        $template->name = $request->input('name');
        $template->msgtext = $request->input('msgtext');
        $template->save();
        return redirect()->back()->with(['success_alert' => __('Successfully update') . ' ' . __('Template') . ': ' . $template->name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $template = Template::where('id', '=', $request->template_id)->first();
        if (auth()->user()->id != $template->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Template')]);
        $template->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Template')]);
    }
}
