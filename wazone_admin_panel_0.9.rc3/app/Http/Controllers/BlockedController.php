<?php

namespace App\Http\Controllers;

use App\Models\Blocked;
use Illuminate\Http\Request;

class BlockedController extends Controller
{

    public function store()
    {
        $user = auth()->user();
        $blocked = new Blocked();
        $blocked->user_id = $user->id;
        $blocked->mobile = request()->input('mobile');
        $blocked->save();

        return redirect()->back()->with(['success_alert' => 'Successfully blocked: ' . $blocked->mobile]);
    }

    public function list()
    {
        $blocked = auth()->user()->blocked()->paginate(20);
        return view('blocked_list', compact('blocked'));
    }

    public function search(Request $request)
    {
        $filter = $request->filter;
        $blocked = auth()->user()->blocked()
            ->where('mobile', 'LIKE', '%' . $filter . '%')
            ->paginate(20);
        return view('/blocked_list', compact('blocked'));
    }

    public function destroy() {
        $blocked = Blocked::where('id', '=', request()->input('blocked_id'))->first();
        if (auth()->user()->id != $blocked->user_id && auth()->user()->role !== 'admin') {
            return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ': ' . $blocked->mobile]);
        }

        $blocked->delete();
        return redirect()->back()->with(['success_alert' => 'Successfully unblocked: ' . $blocked->mobile]);
    }
}
