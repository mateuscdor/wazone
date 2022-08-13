<?php

namespace App\Http\Controllers;

use App\Helpers\Formatter;
use App\Imports\PbImport;
use App\Models\ContactGroup;
use App\Models\PbTemp;
use App\Models\Phonebook;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PhonebookController extends Controller
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
        $countPhonebook = $user->phonebooks()->count();
        if (\Helper::isEx() && $package->max_phonebook <= $countPhonebook && $package->max_phonebook != 0) return redirect()->back()->with('danger_alert', __('Phonebook reached max limit!') . ' ' . __('Max') . ': ' . $package->max_phonebook);
        PbTemp::truncate();
        if ($request->file('filename') != null) {
            Excel::import(new PbImport, request()->file('filename'));
        }
        $contacts = PbTemp::all();
        foreach($contacts as $contact) {
            if ($contact->phone) {
                $contact->phone = Formatter::pf($contact->phone);
                $contact->save();
            }
        }
        $phonebook = new Phonebook();
        $phonebook->user_id = $user->id;
        $phonebook->name = $request->input('name');
        if (Phonebook::where('user_id', '=', $user->id)->where('name', '=', $phonebook->name)->count() > 0) {
            return redirect()->back()->with(['danger_alert' => __('Duplicate found. Failed to add') . ': ' . $phonebook->name]);
        }
        $phonebook->data = json_encode(PbTemp::where('phone', '!=', 'NULL')->get());
        $phonebook->save();
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $phonebook->name]);
    }

    public function storeGroups (Request $request)
    {
        $user = auth()->user();
        $package = $user->package;
        $countPhonebook = $user->phonebooks()->count();
        if (\Helper::isEx() && $package->max_phonebook <= $countPhonebook && $package->max_phonebook != 0) return redirect()->back()->with('danger_alert', __('Phonebook reached max limit!') . ' ' . __('Max') . ': ' . $package->max_phonebook);

        $groups = ContactGroup::all();
        $data = [];
        $i = 0;
        foreach ($groups as $group) {
            $i += 1;
            $arr = ['id' => $i, 'name' => $group->subject, 'phone' => $group->groupId];
            array_push($data, $arr);
        }
        Phonebook::updateOrInsert(['user_id' => $user->id, 'name' => "All groups"], ['data' => json_encode($data)]);
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': All groups']);
    }

    public function storeParticipants (Request $request)
    {
        $user = auth()->user();
        $package = $user->package;
        $countPhonebook = $user->phonebooks()->count();
        if (\Helper::isEx() && $package->max_phonebook <= $countPhonebook && $package->max_phonebook != 0) return redirect()->back()->with('danger_alert', __('Phonebook reached max limit!') . ' ' . __('Max') . ': ' . $package->max_phonebook);

        $contactGroup = ContactGroup::where('id', '=' , $request->id)->first();
        $data = [];
        $i = 0;
        $participants = json_decode($contactGroup->participants);
        foreach ($participants as $participant) {
            $i += 1;
            $arr = ['id' => $i, 'name' => 'Sir/Madam', 'phone' => $participant->id];
            array_push($data, $arr);
        }
        Phonebook::updateOrInsert(['user_id' => $user->id, 'name' => $contactGroup->subject], ['data' => json_encode($data)]);
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ': ' . $contactGroup->subject]);
    }

    public function list()
    {
        $phonebooks = auth()->user()->phonebooks()->paginate(20);
        return view('/phonebook_list', compact('phonebooks'));
    }

    public function search(Request $request)
    {
        $filter = $request->filter;
        $phonebooks = auth()->user()->phonebooks()
            ->where(function($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('data', 'LIKE', '%' . $filter . '%');
            })
            ->paginate(20);
        return view('/phonebook_list', compact('phonebooks'));
    }

    public function show(Request $request)
    {
        $phonebook = Phonebook::where('id', '=', $request->phonebook_id)->first();
        if (auth()->user()->id != $phonebook->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to show') . ' ' . __('Phonebook')]);
        return view('/phonebook_show', compact('phonebook'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phonebook  $phonebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phonebook $phonebook)
    {
        $phonebook = Phonebook::where('id', '=', $request->input('phonebook_id'))->first();
        if (auth()->user()->id != $phonebook->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to update') . ' ' . __('Phonebook')]);
        $phonebook->name = $request->input('name');
        PbTemp::truncate();
        if ($request->file('filename') != '' || $request->file('filename') != null) {
            Excel::import(new PbImport, request()->file('filename'));
            $phonebook->data = json_encode(PbTemp::where('phone', '!=', 'NULL')->get());
        }
        $phonebook->save();
        return redirect()->back()->with(['success_alert' => __('Successfully update') . ' ' . __('Phonebook') . ': ' . $phonebook->name]);
    }

    public function addcontact(Request $request)
    {
        $contact_id = $request->contact_id;
        $phonebook = Phonebook::where('id', '=', $request->phonebook_id)->first();
        if (auth()->user()->id != $phonebook->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Phonebook')]);
        $contacts = json_decode($phonebook->data, true);
        array_push($contacts, array('id' => $contact_id + 1, 'name' => $request->contact_name, 'phone' => $request->contact_phone));
        $phonebook->data = json_encode(array_values($contacts));
        $phonebook->save();
        return redirect()->back()->with(['success_alert' => __('Successfully add') . ' ' . __('Contact')]);
    }

    public function editcontact(Request $request)
    {
        $contact_id = $request->contact_id;
        $phonebook = Phonebook::where('id', '=', $request->phonebook_id)->first();
        if (auth()->user()->id != $phonebook->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Phonebook')]);
        $contacts = json_decode($phonebook->data, true);
        foreach($contacts as $key => $val) {
            if ($val['id'] == $contact_id) {
                $contacts[$key]['name'] = $request->contact_name;
                $contacts[$key]['phone'] = $request->contact_phone;
                $phonebook->data = json_encode(array_values($contacts));
                $phonebook->save();
                break;
            }
        }
        return redirect()->back()->with(['success_alert' => __('Successfully edit') . ' ' . __('Contact')]);
    }

    public function destroycontact(Request $request)
    {
        $contact_id = $request->contact_id;
        $phonebook = Phonebook::where('id', '=', $request->phonebook_id)->first();
        if (auth()->user()->id != $phonebook->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Phonebook')]);
        $contacts = json_decode($phonebook->data, true);
        foreach($contacts as $key => $val) {
            if ($val['id'] == $contact_id) {
                unset($contacts[$key]);
                $phonebook->data = json_encode(array_values($contacts));
                $phonebook->save();
                break;
            }
        }
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Contact')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phonebook  $phonebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $phonebook = Phonebook::where('id', '=', $request->phonebook_id)->first();
        if (auth()->user()->id != $phonebook->user_id && auth()->user()->role !== 'admin') return redirect()->back()->with(['danger_alert' => __('You are not allowed to delete') . ' ' . __('Phonebook')]);
        $phonebook->delete();
        return redirect()->back()->with(['success_alert' => __('Successfully delete') . ' ' . __('Phonebook')]);
    }
}
