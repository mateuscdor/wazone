<?php

namespace App\Http\Controllers;

use App\Models\Outbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutboxController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outbox  $outbox
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $job = Outbox::where('job_id', '=', $request->job_id)->get();
        return view('outbox_show', ['job_id' => $request->job_id, 'job' => $job]);
    }

    public function list()
    {
        $user_id = auth()->user()->id;
        $outbox = Outbox::where('user_id', '=', $user_id)->get();
        $pendingCount = $outbox->where('status', '=', 'PENDING')->count();
        $sentCount = $outbox->where('status', '=', 'SENT')->count();
        $failedCount = $outbox->where('status', '=', 'FAILED')->count();
        $allCount = $pendingCount + $sentCount + $failedCount;

        $jobs = Outbox::select('job_id', DB::raw('count(*) as total'))
            ->groupBy('job_id')
            ->where('user_id', '=', auth()->user()->id)
            ->orderBy('job_id', 'desc')
            ->paginate(20);
        return view('/outbox_list', compact('jobs', 'pendingCount', 'sentCount', 'failedCount', 'allCount'));
    }

    public function search(Request $request)
    {
        $filter = $request->filter;
        $jobs = Outbox::select('job_id', DB::raw('count(*) as total'))
            ->groupBy('job_id')
            ->where('user_id', '=', auth()->user()->id)
            ->orderBy('job_id', 'desc')
            ->where(function($query) use ($filter) {
                $query->where('sender', 'LIKE', '%' . $filter . '%')
                ->orWhere('receiver', 'LIKE', '%' . $filter . '%')
                ->orWhere('rec_name', 'LIKE', '%' . $filter . '%')
                ->orWhere('msgtext', 'LIKE', '%' . $filter . '%');
            })
            ->paginate(20);
        return view('/outbox_list', compact('jobs'));
    }

    public function resendfailed(Request $request)
    {
        if (Outbox::where('user_id', '=', $request->user_id)->where('status', '=', 'FAILED')->count() == 0) {
            return redirect()->back()->with(['danger_alert' => __('You do not have') . ' ' . 'FAILED' . ' ' . __('outbox to resend')]);
        } else {
            Outbox::where('user_id', '=', $request->user_id)->where('status', '=', 'FAILED')->update(['status' => 'PENDING', 'try' => 0]);
            return redirect()->back()->with(['success_alert' => __('Successfully update') . ' ' . 'FAILED' . ' ' . __('Outbox')]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outbox  $outbox
     * @return \Illuminate\Http\Response
     */
    public function destroyjob(Request $request)
    {
        $user_id = auth()->user()->id;
        $job = Outbox::where('job_id', '=', $request->input('job_id'))->get();
        foreach ($job as $outbox) {
            if ($outbox->mediafile != null) {
                if (file_exists(public_path("users/{$user_id}/outbox/{$outbox->mediafile}"))) {
                    unlink(public_path("users/{$user_id}/outbox/{$outbox->mediafile}"));
                }
            }
            $outbox->delete();
        }
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Job ID') . ': ' . $request->input('job_id')]);
    }

    public function destroyobx(Request $request)
    {
        $user_id = auth()->user()->id;
        $outbox = Outbox::where('id', '=', $request->input('outbox_id'))->first();
        if ($outbox->mediafile != null) {
            if (file_exists(public_path("users/{$user_id}/outbox/{$outbox->mediafile}"))) {
                unlink(public_path("users/{$user_id}/outbox/{$outbox->mediafile}"));
            }
        }
        $outbox->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Outbox ID') . ': ' . $request->input('outbox_id')]);
     }

    public function destroyall(Request $request)
    {
        $outbox = Outbox::where('user_id', '=', $request->user_id)->first();
        if (auth()->user()->id != $outbox->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Outbox')]);
        Outbox::where('user_id', '=', $request->user_id)->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Outbox')]);
    }

    public function destroystatus(Request $request)
    {
        $outbox = Outbox::where('user_id', '=', $request->user_id)->first();
        if (auth()->user()->id != $outbox->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Outbox')]);
        if (Outbox::where('user_id', '=', $request->user_id)->where('status', '=', $request->status)->count() == 0) {
            return redirect()->back()->with(['danger_alert' => __('You do not have') . ' ' . $request->status . ' ' . __('outbox to delete')]);
        } else {
            Outbox::where('user_id', '=', $request->user_id)->where('status', '=', $request->status)->delete();
            return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Outbox')]);
        }
    }
}
