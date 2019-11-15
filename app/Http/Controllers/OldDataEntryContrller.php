<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;
use App\Member;
use App\Saving;
use App\Savingname;
use App\Savinginstallment;
use App\Loan;
use App\Loaninstallment;
use App\Loanname;
use App\Schemename;

use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;

class OldDataEntryContrller extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getIndex()
    {
      return view('dashboard.olddata.index');
    }

    public function getCreate()
    {
      	$groups = Group::all();
      	$loannames = Loanname::all();
      	$savingnames = Savingname::all();
      	$schemenames = Schemename::all();
        
      	return view('dashboard.olddata.create')
        					->withGroups($groups)
        					->withLoannames($loannames)
        					->withSavingnames($savingnames)
        					->withSchemenames($schemenames);
    }

    public function storeOldMember(Request $request)
    {
        $this->validate($request, [
          'group_id'              => 'required',
          'passbook'              => 'required',
          'name'                  => 'required',
          'fhusband'              => 'required',
          'ishusband'             => 'required',
          'mother'                => 'required',
          'gender'                => 'required',
          'marital_status'        => 'required',
          'religion'              => 'required',
          'ethnicity'             => 'required',
          'guardian'              => 'required',
          'guardianrelation'      => 'required',
          'residence_type'        => 'sometimes',
          'landlord_name'         => 'sometimes',
          'education'             => 'required',
          'profession'            => 'required',
          'dob'                   => 'required',
          'nid'                   => 'required',
          'admission_date'        => 'required',
          'closing_date'          => 'sometimes',

          'present_district'      => 'required',
          'present_upazilla'      => 'required',
          'present_union'         => 'required',
          'present_post'          => 'required',
          'present_village'       => 'required',
          'present_house'         => 'required',
          'present_phone'         => 'required',

          'permanent_district'    => 'sometimes',
          'permanent_upazilla'    => 'sometimes',
          'permanent_union'       => 'sometimes',
          'permanent_post'        => 'sometimes',
          'permanent_village'     => 'sometimes',
          'permanent_house'       => 'sometimes',
          'permanent_phone'       => 'sometimes',
        ]);

        $member = new Member;
        $member->passbook = $request->passbook;
        $member->name = $request->name;
        $member->fhusband = $request->fhusband;
        $member->ishusband = $request->ishusband;
        $member->mother = $request->mother;
        $member->gender = $request->gender;
        $member->marital_status = $request->marital_status;
        $member->religion = $request->religion;
        $member->ethnicity = $request->ethnicity;
        $member->guardian = $request->guardian;
        $member->guardianrelation = $request->guardianrelation;
        $member->residence_type = $request->residence_type;
        $member->landlord_name = $request->landlord_name;
        $member->education = $request->education;
        $member->profession = $request->profession;
        $member->dob = date('Y-m-d', strtotime($request->dob));
        $member->nid = $request->nid;
        $member->admission_date = date('Y-m-d', strtotime($request->admission_date));
        if($request->closing_date) {
          $member->closing_date = date('Y-m-d', strtotime($request->closing_date));
        } else {
          $member->closing_date = '1970-01-01';
        }
        $member->present_district = $request->present_district;
        $member->present_upazilla = $request->present_upazilla;
        $member->present_union = $request->present_union;
        $member->present_post = $request->present_post;
        $member->present_village = $request->present_village;
        $member->present_house = $request->present_house;
        $member->present_phone = $request->present_phone;

        $member->permanent_district = $request->permanent_district;
        $member->permanent_upazilla = $request->permanent_upazilla;
        $member->permanent_union = $request->permanent_union;
        $member->permanent_post = $request->permanent_post;
        $member->permanent_village = $request->permanent_village;
        $member->permanent_house = $request->permanent_house;
        $member->permanent_phone = $request->permanent_phone;

        $member->status = 1; // auto active
        $groupforstaff = Group::find($request->group_id);
        $member->staff_id = $groupforstaff->user->id;
        $member->group_id = $request->group_id;
        $member->save();

        // add general account if any...
        // add general account if any...
        if($request->loanname_id == 1) {
        

        // Session::flash('success', 'Added successfully (with a default General Saving Account)!'); 
        // return redirect()->route('dashboard.members', [$s_id, $g_id]);
    }
}
