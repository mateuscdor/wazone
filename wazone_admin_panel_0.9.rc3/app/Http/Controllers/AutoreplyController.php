<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Autoreply;
use Illuminate\Http\Request;

class AutoreplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'mediafile' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,xls,xlsx,mp3,ogg,mp4',
        ]);
        $user_id = auth()->user()->id;
        if (empty(Helper::setting('numOfButtons'))) {
            $numOfButtons = 2;
        } else {
            $numOfButtons = Helper::setting('numOfButtons');
        }
        if ($request->mediafile != null) {
            //$media_ext = $request->mediafile->getClientOriginalExtension();
            $mediafile = str_replace(' ', '_', $request->mediafile->getClientOriginalName());
            $mediaurl = url("/users/{$user_id}/autoreply/{$mediafile}");
            $media_upload = $request->mediafile->move(public_path("users/{$user_id}/autoreply"), $mediafile);
        } else {
            $mediafile = '';
            $mediaurl = '';
        }
        $autoreply = new Autoreply();
        $autoreply->user_id = $user_id;
        $autoreply->sender = $request->input('sender');
        $autoreply->keyword = $request->input('keyword');
        if (Autoreply::where('user_id', '=', $user_id)->where('keyword', '=', $autoreply->keyword)->count() > 0) {
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to add') . ': ' . $autoreply->keyword]);
        }
        $autoreply->match_percent = $request->input('match_percent');
        $autoreply->response = $request->input('response');
        $autoreply->mediafile = $mediafile;
        $autoreply->mediaurl = $mediaurl;
        $autoreply->save();

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
        $autoreply->data = $data;
        $autoreply->save();

        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $autoreply->keyword]);
    }

    public function list()
    {
        $devices = auth()->user()->devices;
        $autoreplies = auth()->user()->autoreplies()->orderBy('id', 'asc')->paginate(20);
        if (empty(Helper::setting('numOfButtons'))) {
            $numOfButtons = 2;
        } else {
            $numOfButtons = Helper::setting('numOfButtons');
        }
        return view('/autoreply_list', compact('devices', 'autoreplies', 'numOfButtons'));
    }

    public function search(Request $request)
    {
        $devices = auth()->user()->devices;
        $filter = $request->filter;
        $autoreplies = auth()->user()->autoreplies()
            ->orderBy('id', 'asc')
            ->where(function($query) use ($filter) {
                $query->where('sender', 'LIKE', '%' . $filter . '%')
                ->orWhere('keyword', 'LIKE', '%' . $filter . '%')
                ->orWhere('response', 'LIKE', '%' . $filter . '%');
            })
            ->paginate(20);
        if (empty(Helper::setting('numOfButtons'))) {
            $numOfButtons = 2;
        } else {
            $numOfButtons = Helper::setting('numOfButtons');
        }
        return view('/autoreply_list', compact('devices', 'autoreplies', 'numOfButtons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autoreply  $autoreply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Autoreply $autoreply)
    {
        $request->validate([
            'mediafile' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,xls,xlsx,mp3,ogg,mp4',
        ]);
        $user_id = auth()->user()->id;
        if (empty(Helper::setting('numOfButtons'))) {
            $numOfButtons = 2;
        } else {
            $numOfButtons = Helper::setting('numOfButtons');
        }
        if ($request->mediafile != null) {
            if ($request->input('prev_mediafile') != null && file_exists(public_path("users/{$user_id}/autoreply/{$request->input('prev_mediafile')}"))) {
                unlink(public_path("users/{$user_id}/autoreply/{$request->input('prev_mediafile')}"));
            }
            //$media_ext = $request->mediafile->getClientOriginalExtension();
            $mediafile = str_replace(' ', '_', $request->mediafile->getClientOriginalName());
            $mediaurl = url("/users/{$user_id}/autoreply/{$mediafile}");
            $media_upload = $request->mediafile->move(public_path("users/{$user_id}/autoreply"), $mediafile);
        } else {
            $mediafile = $request->input('prev_mediafile');
            $mediaurl = $request->input('prev_mediaurl');
        }
        $autoreply = Autoreply::where('id', '=', $request->input('autoreply_id'))->first();
        if ($user_id != $autoreply->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to update') . ' ' . __('Autoreply')]);
        $autoreply->sender = $request->input('sender');
        $autoreply->keyword = $request->input('keyword');
        if (Autoreply::where('user_id', '=', $user_id)->where('keyword', '=', $request->input('keyword'))->count() > 0) {
            if ($request->input('keyword') != $request->input('prev_keyword'))
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to edit') . ': ' . $request->input('keyword')]);
        }
        $autoreply->match_percent = $request->input('match_percent');
        $autoreply->response = $request->input('response');
        $autoreply->mediafile = $mediafile;
        $autoreply->mediaurl = $mediaurl;
        $autoreply->save();

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
        $autoreply->data = $data;
        $autoreply->save();

        return redirect()->back()->with(['success_alert' => __('Successfully edit') . ': ' . $autoreply->keyword]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Autoreply  $autoreply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $autoreply = Autoreply::where('id', '=', $request->autoreply_id)->first();
        if (auth()->user()->id != $autoreply->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Autoreply')]);
        if ($autoreply->mediafile != null) {
            if (file_exists(public_path("users/{$autoreply->user_id}/autoreply/{$autoreply->mediafile}"))) {
                unlink(public_path("users/{$autoreply->user_id}/autoreply/{$autoreply->mediafile}"));
            }
        }
        $autoreply->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Autoreply')]);
    }
}
