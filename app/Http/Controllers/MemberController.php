<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;
use App\Member;

use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;

class MemberController extends Controller
{
    public function getMembers($s_id, $g_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
        $members = Member::where('group_id', $g_id)
        				 ->orderBy('id', 'asc')->get();
        return view('dashboard.groups.members.index')
        					->withStaff($staff)
        					->withGroup($group)
        					->withMembers($members);
    }

    public function createMember($s_id, $g_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
      return view('dashboard.groups.members.create')
      					->withStaff($staff)
      					->withGroup($group);
    }

    public function storeMember(Request $request, $s_id, $g_id)
    {
        $this->validate($request, [
          'default_program'       => 'sometimes',
          'passbook'              => 'sometimes',
          'name'                  => 'required',
          'fhusband'              => 'required',
          'ishusband'             => 'required',
          'mother'                => 'required',
          'admission_date'        => 'required',
          'education'             => 'required',
          'dob'                   => 'required',
          'marital_status'        => 'required',
          'religion'              => 'required',
          'ethnicity'             => 'required',
          'guardian'              => 'required',
          'nid'                   => 'required',
        ]);

        $member = new Member;
        $member->name = $request->name;
        $member->fhusband = $request->fhusband;
        $member->ishusband = $request->ishusband;
        $member->mother = $request->mother;
        $member->admission_date = strtotime($request->admission_date);
        $member->dob = strtotime($request->dob);
        $member->education = $request->education;
        $member->marital_status = $request->marital_status;
        $member->religion = $request->religion;
        $member->ethnicity = $request->ethnicity;
        $member->guardian = $request->guardian;
        $member->nid = $request->nid;
        $member->status = 1; // auto active

        $member->group_id = $g_id;
        $member->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.members', [$s_id, $g_id]);
    }

    public function editMember($s_id, $g_id, $id)
    {
        // $group = Group::find($id);
        // return view('dashboard.groups.edit')->withMember($group);
    }    

    public function updateMember(Request $request, $s_id, $g_id, $id)
    {
        $group = Group::find($id);
        $this->validate($request, [
          'name'               => 'required',
          'formation'          => 'required',
          'meeting_day'        => 'required',
          'village'            => 'required',
          'min_savings_dep'    => 'required',
          'min_security_dep'   => 'required',
          'status'             => 'required',
          'user_id'            => 'required',
        ]);
        
        $group->name = $request->name;
        $group->formation = strtotime($request->formation);
        $group->meeting_day = $request->meeting_day;
        $group->village = $request->village;
        $group->min_savings_dep = $request->min_savings_dep;
        $group->min_security_dep = $request->min_security_dep;
        $group->status = $request->status;
        $group->status = $request->status;
        $group->user_id = $request->user_id;
        $group->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.members');
    }

    public function getSingleMember($s_id, $g_id, $m_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
        $member = Member::find($m_id);
        return view('dashboard.groups.members.singlemember')
        				->withStaff($staff)
        				->withGroup($group)
        				->withMember($member);
    }
}
