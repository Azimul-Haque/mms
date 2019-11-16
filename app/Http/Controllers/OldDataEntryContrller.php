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
        		$loan->status = $request->primary_status ? $request->primary_status : 1; // 1 means disbursed, 0 means closed
        		$loan->member_id = $member->id;
        		$loan->save();

        		// add the accumulated paid amount as an installment
        		$accugenloaninstallment = new Loaninstallment;
        		$accugenloaninstallment->due_date = date('Y-m-d');
        		$accugenloaninstallment->installment_no = 0; // for being the for being the first one 
        		$accugenloaninstallment->installment_principal = ($loan->primary_total_paid - ($loan->primary_total_paid * 0.20));
        		$accugenloaninstallment->installment_interest = ($loan->primary_total_paid * 0.20);
        		$accugenloaninstallment->installment_total = $loan->primary_total_paid;

        		// same as above
        		$accugenloaninstallment->paid_principal = ($loan->primary_total_paid - ($loan->primary_total_paid * 0.20));
        		$accugenloaninstallment->paid_interest = ($loan->primary_total_paid * 0.20);
        		$accugenloaninstallment->paid_total = $loan->primary_total_paid;

        		$accugenloaninstallment->outstanding_total = $loan->total_outstanding;
        		$accugenloaninstallment->loan_id = $loan->id;
        		$accugenloaninstallment->save();

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

        		  $loaninstallment->outstanding_total = $loan->total_outstanding;
        		  $loaninstallment->loan_id = $loan->id;
        		  $loaninstallment->save();
        		}
        	}
        }

        // add product account if any...
        // add product account if any...
        if(($request->product_disburse_date != null || $request->product_disburse_date != '') && ($request->product_total_disbursed != null || $request->product_total_disbursed != '')) 
        {
        	$this->validate($request, [
        	  'product_loanname_id'                 => 'required',
        	  'product_disburse_date'               => 'required',
        	  'product_installment_type'            => 'required',
        	  'product_installments'                => 'required', // baki installment aar ki...
        	  'product_first_installment_date'      => 'required',
        	  'product_schemename_id'               => 'required',
        	  'product_principal_amount'            => 'required',
        	  'product_service_charge'              => 'required',
        	  'product_total_disbursed'             => 'required',
        	  'product_total_paid'                  => 'required', // aage to kichu pay korse...
        	  'product_closing_date'                => 'sometimes',
        	  'product_status'                      => 'sometimes'
        	]);

        	$loan = new Loan;
        	$loan->loanname_id = $request->product_loanname_id;
        	$loan->disburse_date = date('Y-m-d', strtotime($request->product_disburse_date));
        	$loan->installment_type = $request->product_installment_type;
        	$loan->installments = $request->product_installments;
        	$loan->first_installment_date = date('Y-m-d', strtotime($request->product_first_installment_date));
        	$loan->schemename_id = $request->product_schemename_id;
        	$loan->principal_amount = $request->product_principal_amount ? $request->product_principal_amount : 0;
        	$loan->service_charge = $request->product_service_charge ? $request->product_service_charge : 0;
        	// for the installments, here we nee service charge percentage
        	$product_service_charge_percent = $loan->service_charge / $loan->principal_amount;
        	// for the installments, here we nee service charge percentage
        	$loan->down_payment = $request->product_down_payment ? $request->product_down_payment : 0;
        	$loan->total_disbursed = $request->product_total_disbursed; // already deduced by down payment in view form
        	$loan->total_paid = $request->product_total_paid;
        	$loan->total_outstanding = $request->product_total_disbursed - $request->product_total_paid;
        	$loan->status = $request->product_status ? $request->product_status : 1; // 1 means disbursed, 0 means closed
        	$loan->member_id = $member->id;
        	$loan->save();

        	// add the accumulated paid amount as an installment
        	$acculongtloaninstallment = new Loaninstallment;
        	$acculongtloaninstallment->due_date = date('Y-m-d');
        	$acculongtloaninstallment->installment_no = 0; // for being the for being the first one 
        	$acculongtloaninstallment->installment_principal = ($loan->product_total_paid - ($loan->product_total_paid * $product_service_charge_percent));
        	$acculongtloaninstallment->installment_interest = ($loan->product_total_paid * $product_service_charge_percent);
        	$acculongtloaninstallment->installment_total = $loan->product_total_paid;

        	// same as above
        	$acculongtloaninstallment->paid_principal = ($loan->product_total_paid - ($loan->product_total_paid * $product_service_charge_percent));
        	$acculongtloaninstallment->paid_interest = ($loan->product_total_paid * $product_service_charge_percent);
        	$acculongtloaninstallment->paid_total = $loan->product_total_paid;

        	$acculongtloaninstallment->outstanding_total = $loan->total_outstanding;
        	$acculongtloaninstallment->loan_id = $loan->id;
        	$acculongtloaninstallment->save();

        	// add the installments of this account
        	for($i=0; $i<$request->product_installments; $i++) 
        	{
        	  if($request->product_installment_type == 1) {
        	    $dateToPay = $this->addWeekdays(Carbon::parse($request->product_first_installment_date), $i);
        	  } else if($request->product_installment_type == 2) {
        	    $dateToPay = Carbon::parse($request->product_first_installment_date)->adddays(7*$i);
        	  } else if($request->product_installment_type == 3) {
        	    $dateToPay = Carbon::parse($request->product_first_installment_date)->addMonths($i);
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
        	  $loaninstallment->installment_principal = ($loan->total_outstanding - ($loan->total_outstanding * $product_service_charge_percent)) / $loan->installments;
        	  $loaninstallment->installment_interest = ($loan->total_outstanding * $product_service_charge_percent) / $loan->installments;
        	  $loaninstallment->installment_total = $loan->total_outstanding / $loan->installments;

        	  $loaninstallment->paid_principal = 0.00;
        	  $loaninstallment->paid_interest = 0.00;
        	  $loaninstallment->paid_total = 0.00;

        	  $loaninstallment->outstanding_total = $loan->total_outstanding;
        	  $loaninstallment->loan_id = $loan->id;
        	  $loaninstallment->save();
        	}
        }
        
        // add general saving account if any...
        // add general saving account if any...
        if(($request->general_opening_date != null || $request->general_opening_date != '') && ($request->general_installment_type != null || $request->general_installment_type != '')) 
        {
        	$checkacc = Saving::where('member_id', $member->id)
        	                  ->where('savingname_id', $request->general_savingname_id)->first();
        	
        	if(!empty($checkacc)) {
        	  // Session::flash('warning', 'This member already has an account like this type.');
        	} else {
        		$this->validate($request, [
        		  'general_savingname_id'               => 'required',
        		  'general_opening_date'                => 'required',
        		  'general_meeting_day'                 => 'required',
        		  'general_installment_type'            => 'required',
        		  'general_minimum_deposit'             => 'sometimes',
        		  'general_closing_date'                => 'sometimes',
        		  'general_total_amount_so_far'         => 'sometimes',
        		  'general_total_withdraw_so_far'       => 'sometimes'
        		]);

        		$savingaccount = new Saving;
        		$savingaccount->savingname_id = $request->general_savingname_id;
        		$savingaccount->opening_date = date('Y-m-d', strtotime($request->general_opening_date));
        		if($request->general_closing_date != '') {
        		  $savingaccount->closing_date = date('Y-m-d', strtotime($request->general_closing_date));
        		} else {
        		  $savingaccount->closing_date = '1970-01-01';
        		}
        		$savingaccount->meeting_day = $request->general_meeting_day;
        		$savingaccount->installment_type = $request->general_installment_type;
        		$savingaccount->minimum_deposit = 0.00;
        		$savingaccount->total_amount = $request->general_total_amount_so_far;
        		$savingaccount->withdraw = $request->general_total_withdraw_so_far;
        		$savingaccount->status = 1; // 1 means active/open
        		$savingaccount->member_id = $member->id;
        		$savingaccount->save();

        		// deposit for the first time, the total amount so far...
        		$oldsaving = new Savinginstallment;
        		$oldsaving->due_date = date('Y-m-d');
        		$oldsaving->amount = $request->general_total_amount_so_far;
        		$oldsaving->withdraw = $request->general_total_withdraw_so_far;
        		$oldsaving->balance = $request->general_total_amount_so_far - $request->general_total_withdraw_so_far;
        		$oldsaving->member_id = $member->id;
        		$oldsaving->savingname_id = 1; // hard coded, 1 is for general saving!
        		$oldsaving->saving_id = $savingaccount->id;
        		$oldsaving->save();
        	}
        }

        // add long term saving account if any...
        // add long term saving account if any...
        if(($request->longterm_opening_date != null || $request->longterm_opening_date != '') && ($request->longterm_installment_type != null || $request->longterm_installment_type != '')) 
        {
        	$this->validate($request, [
        	  'longterm_savingname_id'               => 'required',
        	  'longterm_opening_date'                => 'required',
        	  'longterm_meeting_day'                 => 'required',
        	  'longterm_installment_type'            => 'required',
        	  'longterm_minimum_deposit'             => 'sometimes',
        	  'longterm_closing_date'                => 'sometimes',
        	  'longterm_total_amount_so_far'         => 'sometimes',
        	  'longterm_total_withdraw_so_far'       => 'sometimes'
        	]);

        	$savingaccount = new Saving;
        	$savingaccount->savingname_id = $request->longterm_savingname_id;
        	$savingaccount->opening_date = date('Y-m-d', strtotime($request->longterm_opening_date));
        	if($request->longterm_closing_date != '') {
        	  $savingaccount->closing_date = date('Y-m-d', strtotime($request->longterm_closing_date));
        	} else {
        	  $savingaccount->closing_date = '1970-01-01';
        	}
        	$savingaccount->meeting_day = $request->longterm_meeting_day;
        	$savingaccount->installment_type = $request->longterm_installment_type;
        	$savingaccount->minimum_deposit = 0.00;
        	$savingaccount->total_amount = $request->longterm_total_amount_so_far;
        	$savingaccount->withdraw = $request->longterm_total_withdraw_so_far;
        	$savingaccount->status = 1; // 1 means active/open
        	$savingaccount->member_id = $member->id;
        	$savingaccount->save();

        	// deposit for the first time, the total amount so far...
        	$oldsaving = new Savinginstallment;
        	$oldsaving->due_date = date('Y-m-d');
        	$oldsaving->amount = $request->longterm_total_amount_so_far;
        	$oldsaving->withdraw = $request->longterm_total_withdraw_so_far;
        	$oldsaving->balance = $request->longterm_total_amount_so_far - $request->longterm_total_withdraw_so_far;
        	$oldsaving->member_id = $member->id;
        	$oldsaving->savingname_id = 2; // hard coded, 2 is for long term saving!
        	$oldsaving->saving_id = $savingaccount->id;
        	$oldsaving->save();
        }

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('olddata.index');
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
