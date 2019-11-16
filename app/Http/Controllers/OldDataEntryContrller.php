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
        if(($request->primary_disburse_date != null || $request->primary_disburse_date != '') && ($request->product_total_disbursed != null || $request->product_total_disbursed != '')) 
        {

        	$checkacc = Loan::where('member_id', $member->id)
        	                ->where('loanname_id', 1) // single primary ac, multiple product loan
        	                ->where('status', 1) // 1 means disbursed, 0 means closed
        	                ->first();
        	if(!empty($checkacc)) {
        	  // Session::flash('warning', 'This member already has an ACTIVE primary account.');
        	} else {
        		$this->validate($request, [
        		  'primary_loanname_id'                 => 'required',
        		  'primary_disburse_date'               => 'required',
        		  'primary_installment_type'            => 'required',
        		  'primary_installments'                => 'required', // baki installment aar ki...
        		  'primary_first_installment_date'      => 'required',
        		  'primary_schemename_id'               => 'required',
        		  'primary_principal_amount'            => 'required',
        		  'primary_service_charge'              => 'required',
        		  'primary_total_disbursed'             => 'required',
        		  'primary_total_paid'                  => 'required', // aage to kichu pay korse...
        		  'primary_closing_date'                => 'sometimes',
        		  'primary_status'                      => 'sometimes'
        		]);

        		$loan = new Loan;
        		$loan->loanname_id = $request->primary_loanname_id;
        		$loan->disburse_date = date('Y-m-d', strtotime($request->primary_disburse_date));
        		$loan->installment_type = $request->primary_installment_type;
        		$loan->installments = $request->primary_installments;
        		$loan->first_installment_date = date('Y-m-d', strtotime($request->primary_first_installment_date));
        		$loan->schemename_id = $request->primary_schemename_id;
        		$loan->principal_amount = $request->primary_principal_amount ? $request->primary_principal_amount : 0;
        		$loan->service_charge = $request->primary_service_charge ? $request->primary_service_charge : 0;
        		$loan->down_payment = 0.00; //$request->primary_down_payment ? $request->primary_down_payment : 0;
        		$loan->total_disbursed = $request->primary_total_disbursed;
        		$loan->total_paid = $request->primary_total_paid;
        		$loan->total_outstanding = $request->primary_total_disbursed - $request->primary_total_paid;
        		$loan->status = $request->primary_status; // 1 means disbursed, 0 means closed
        		$loan->member_id = $member->id;
        		$loan->save();

        		// add the installments of this account
        		for($i=0; $i<$request->primary_installments; $i++) 
        		{
        		  if($request->primary_installment_type == 1) {
        		    $dateToPay = $this->addWeekdays(Carbon::parse($request->primary_first_installment_date), $i);
        		  } else if($request->primary_installment_type == 2) {
        		    $dateToPay = Carbon::parse($request->primary_first_installment_date)->adddays(7*$i);
        		  } else if($request->primary_installment_type == 3) {
        		    $dateToPay = Carbon::parse($request->primary_first_installment_date)->addMonths($i);
        		    if(date('D', strtotime($dateToPay)) == 'Fri') {
        		      $dateToPay = Carbon::parse($dateToPay)->adddays(1);
        		    } else {
        		      $dateToPay = $dateToPay;
        		    }
        		  }
        		  // store the loan installments...
        		  $loaninstallment = new Loaninstallment;
        		  $loaninstallment->due_date = date('Y-m-d', strtotime($dateToPay));
        		  $loaninstallment->installment_no = $i + 1;
        		  $loaninstallment->installment_principal = ($loan->total_outstanding - ($loan->total_outstanding * 0.20)) / $loan->installments;
        		  $loaninstallment->installment_interest = ($loan->total_outstanding * 0.20) / $loan->installments;
        		  $loaninstallment->installment_total = $loan->total_outstanding / $loan->installments;

        		  $loaninstallment->paid_principal = 0.00;
        		  $loaninstallment->paid_interest = 0.00;
        		  $loaninstallment->paid_total = 0.00;

        		  $loaninstallment->outstanding_total = $loan->total_disbursed;

        		  $loaninstallment->loan_id = $loan->id;

        		  $loaninstallment->save();
        		}
        	}
        }
        

        // Session::flash('success', 'Added successfully (with a default General Saving Account)!'); 
        // return redirect()->route('dashboard.members', [$s_id, $g_id]);
    }

    public function addWeekdays($date, $days) {
      $dateToPay = Carbon::parse($date);
      while ($days > 0) {
        $dateToPay = $dateToPay->adddays(1);
        // 5 == Fri, tai 5 baade baki gulake accept korbe
        if (date('N', strtotime($dateToPay)) != 5) {
          $days--;
        }
      }
      return $dateToPay;
    }
}
