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

class MemberController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }
    
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
          'passbook'              => 'required',
          'name'                  => 'required',
          'fhusband'              => 'required',
          'ishusband'             => 'required',
          'mother'                => 'required',
          'gender'                => 'required',
          // 'marital_status'        => 'required',
          'religion'              => 'required',
          // 'ethnicity'             => 'required',
          // 'guardian'              => 'required',
          // 'guardianrelation'      => 'required',
          'residence_type'        => 'sometimes',
          // 'landlord_name'         => 'sometimes',
          'education'             => 'required',
          'profession'            => 'required',
          // 'dob'                   => 'required',
          'nid'                   => 'required',
          'admission_date'        => 'required',
          'closing_date'          => 'sometimes',
          'closing_date'          => 'sometimes',

          'present_district'      => 'required',
          'present_upazilla'      => 'required',
          'present_union'         => 'required',
          'present_post'          => 'required',
          'present_village'       => 'required',
          // 'present_house'         => 'required',
          'present_phone'         => 'required',

          'permanent_district'    => 'sometimes',
          'permanent_upazilla'    => 'sometimes',
          'permanent_union'       => 'sometimes',
          'permanent_post'        => 'sometimes',
          'permanent_village'     => 'sometimes',
          // 'permanent_house'       => 'sometimes',
          'permanent_phone'       => 'sometimes',
          'shared_deposit'        => 'required',
        ]);

        $member = new Member;
        $member->passbook = $request->passbook;
        $member->name = $request->name;
        $member->fhusband = $request->fhusband;
        $member->ishusband = $request->ishusband;
        $member->mother = $request->mother;
        $member->gender = $request->gender;
        // $member->marital_status = $request->marital_status;
        $member->religion = $request->religion;
        // $member->ethnicity = $request->ethnicity;
        // $member->guardian = $request->guardian;
        // $member->guardianrelation = $request->guardianrelation;
        $member->residence_type = $request->residence_type;
        // $member->landlord_name = $request->landlord_name;
        $member->education = $request->education;
        $member->profession = $request->profession;
        // $member->dob = date('Y-m-d', strtotime($request->dob));
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
        // $member->present_house = $request->present_house;
        $member->present_phone = $request->present_phone;

        $member->permanent_district = $request->permanent_district;
        $member->permanent_upazilla = $request->permanent_upazilla;
        $member->permanent_union = $request->permanent_union;
        $member->permanent_post = $request->permanent_post;
        $member->permanent_village = $request->permanent_village;
        // $member->permanent_house = $request->permanent_house;
        $member->permanent_phone = $request->permanent_phone;
        
        $member->passbook_fee = $request->passbook_fee;
        $member->admission_fee = $request->admission_fee;
        $member->shared_deposit = $request->shared_deposit;

        $member->status = 1; // auto active
        $member->staff_id = $s_id;
        $member->group_id = $g_id;
        $member->save();

        // add a mandatory general account...
        // add a mandatory general account...
        $savingaccount = new Saving;
        $savingaccount->savingname_id = 1; // 1 for general account
        $savingaccount->opening_date = date('Y-m-d', strtotime($request->admission_date));
        
        $savingaccount->meeting_day = 1;
        $savingaccount->installment_type = 2;
        $savingaccount->minimum_deposit = 10;
        $savingaccount->status = 1; // 1 means active/open
        $savingaccount->member_id = $member->id;
        $savingaccount->save();

        Session::flash('success', 'Added successfully (with a default General Saving Account)!'); 
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

      $member = Member::where('id', $m_id)
                      ->where('staff_id', $s_id)
                      ->where('group_id', $g_id)
                      ->first();

      return view('dashboard.groups.members.singlemember')
              ->withStaff($staff)
              ->withGroup($group)
              ->withMember($member);
    }

    // Saving accounts
    // Saving accounts
    public function getMemberSavings($s_id, $g_id, $m_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);

      $member = Member::where('id', $m_id)
                      ->where('staff_id', $s_id)
                      ->where('group_id', $g_id)
                      ->first();

      $savings = Saving::where('member_id', $member->id)->get();

      return view('dashboard.groups.members.savings.index')
              ->withStaff($staff)
              ->withGroup($group)
              ->withMember($member)
              ->withSavings($savings);
    }

    public function createSavingAccount($s_id, $g_id, $m_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);

      $member = Member::where('id', $m_id)
                      ->where('staff_id', $s_id)
                      ->where('group_id', $g_id)
                      ->first();
      $savingnames = Savingname::all();

      return view('dashboard.groups.members.savings.create')
              ->withStaff($staff)
              ->withGroup($group)
              ->withMember($member)
              ->withSavingnames($savingnames);
    }

    public function storeSavingAccount(Request $request, $s_id, $g_id, $m_id)
    {
        $checkacc = Saving::where('member_id', $m_id)
                          ->where('savingname_id', $request->savingname_id)->first();
        
        if(!empty($checkacc)) {
          Session::flash('warning', 'This member already has an account like this type.'); 
          return redirect()->route('dashboard.member.savings', [$s_id, $g_id, $m_id]);
        }

        $this->validate($request, [
          'savingname_id'               => 'required',
          'opening_date'                => 'required',
          'meeting_day'                 => 'sometimes',
          'installment_type'            => 'required',
          'minimum_deposit'             => 'sometimes',
          'closing_date'                => 'sometimes'
        ]);

        $savingaccount = new Saving;
        $savingaccount->savingname_id = $request->savingname_id;
        $savingaccount->opening_date = date('Y-m-d', strtotime($request->opening_date));
        if($request->closing_date != '') {
          $savingaccount->closing_date = date('Y-m-d', strtotime($request->closing_date));
        } else {
          $savingaccount->closing_date = '1970-01-01';
        }
        $savingaccount->meeting_day = $request->meeting_day ? $request->meeting_day : 1;
        $savingaccount->installment_type = $request->installment_type;
        $savingaccount->minimum_deposit = $request->minimum_deposit;
        $savingaccount->status = 1; // 1 means active/open
        $savingaccount->member_id = $m_id;
        $savingaccount->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.member.savings', [$s_id, $g_id, $m_id]);
    }

    // Loans accounts
    // Loans accounts
    public function getMemberLoans($s_id, $g_id, $m_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);

      $member = Member::where('id', $m_id)
                      ->where('staff_id', $s_id)
                      ->where('group_id', $g_id)
                      ->first();

      $loans = Loan::where('member_id', $member->id)->get();

      return view('dashboard.groups.members.loans.index')
              ->withStaff($staff)
              ->withGroup($group)
              ->withMember($member)
              ->withLoans($loans);
    }

    public function createLoanAccount($s_id, $g_id, $m_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);

      $member = Member::where('id', $m_id)
                      ->where('staff_id', $s_id)
                      ->where('group_id', $g_id)
                      ->first();

      $loannames = Loanname::all();
      $schemenames = Schemename::all();

      return view('dashboard.groups.members.loans.create')
      				->withStaff($staff)
      				->withGroup($group)
              ->withMember($member)
              ->withLoannames($loannames)
      				->withSchemenames($schemenames);
    }

    public function storeLoanAccount(Request $request, $s_id, $g_id, $m_id)
    {
        if($request->loanname_id == 1) {
          $checkacc = Loan::where('member_id', $m_id)
                          ->where('loanname_id', 1) // single primary ac, multiple product loan
                          ->where('status', 1) // 1 means disbursed, 0 means closed
                          ->first();
          if(!empty($checkacc)) {
            Session::flash('warning', 'This member already has an ACTIVE primary account.'); 
            return redirect()->route('dashboard.member.loans', [$s_id, $g_id, $m_id]);
          }
        }

        $this->validate($request, [
          'loanname_id'                 => 'required',
          'disburse_date'               => 'required',
          'installment_type'            => 'required',
          'installments'                => 'required',
          'first_installment_date'      => 'required',
          'schemename_id'               => 'required',
          'principal_amount'            => 'required',
          'service_charge'              => 'required',
          'down_payment'                => 'sometimes',
          'total_disbursed'             => 'required',
          'insurance'                   => 'sometimes',
          'processing_fee'              => 'sometimes',
          'closing_date'                => 'sometimes',
          'status'                      => 'sometimes'
        ]);

        $loan = new Loan;
        $loan->loan_new = 1; // 1 means new
        $loan->loanname_id = $request->loanname_id;
        $loan->disburse_date = date('Y-m-d', strtotime($request->disburse_date));
        $loan->installment_type = $request->installment_type;
        $loan->installments = $request->installments;
        $loan->first_installment_date = date('Y-m-d', strtotime($request->first_installment_date));
        $loan->schemename_id = $request->schemename_id;
        $loan->principal_amount = $request->principal_amount ? $request->principal_amount : 0;
        $loan->service_charge = $request->service_charge ? $request->service_charge : 0;
        $loan->down_payment = $request->down_payment ? $request->down_payment : 0;
        $loan->total_disbursed = $request->total_disbursed;
        $loan->total_paid = 0.00; // jodi bole pore tobe down payment add kore deoa hobe
        $loan->total_outstanding = $request->total_disbursed;
        if($request->loanname_id == 1) { // if orimary loan
          $loan->insurance = $request->insurance;
          $loan->processing_fee = $request->processing_fee;
        }
        $loan->status = $request->status; // 1 means disbursed, 0 means closed
        $loan->member_id = $m_id;
        $loan->save();

        // $installments_arr = [];
        // add the installments
        for($i=0; $i<$request->installments; $i++) 
        {
          if($request->installment_type == 1) {
            $dateToPay = $this->addWeekdays(Carbon::parse($request->first_installment_date), $i);
          } else if($request->installment_type == 2) {
            $dateToPay = Carbon::parse($request->first_installment_date)->adddays(7*$i);
          } else if($request->installment_type == 3) {
            $dateToPay = Carbon::parse($request->first_installment_date)->addMonths($i);
            if(date('D', strtotime($dateToPay)) == 'Fri') {
              $dateToPay = Carbon::parse($dateToPay)->adddays(1);
            } else {
              $dateToPay = $dateToPay;
            }
          }
          // $installments_arr[] = date('d-m-Y', strtotime($dateToPay));

          // store the loan installments...
          $loaninstallment = new Loaninstallment;
          $loaninstallment->due_date = date('Y-m-d', strtotime($dateToPay));
          $loaninstallment->installment_no = $i + 1;
          $loaninstallment->installment_principal = ($loan->principal_amount - $loan->down_payment) / $loan->installments;
          $loaninstallment->installment_interest = $loan->service_charge / $loan->installments;
          $loaninstallment->installment_total = $loan->total_disbursed / $loan->installments;

          $loaninstallment->paid_principal = 0.00;
          $loaninstallment->paid_interest = 0.00;
          $loaninstallment->paid_total = 0.00;

          $loaninstallment->outstanding_total = $loan->total_disbursed;

          $loaninstallment->loan_id = $loan->id;
          $loaninstallment->user_id = $s_id;

          $loaninstallment->save();
        }
        // dd($installments_arr);

        // add a mandatory long term account only if the installment type is daily...
        // add a mandatory long term account only if the installment type is daily...
        if($request->installment_type == 1) {
          $checkacc = Saving::where('member_id', $m_id)
                            ->where('savingname_id', 2) // hard coded!
                            ->first();
          
          if(!empty($checkacc)) {
            
          } else {
            $savingaccount = new Saving;
            $savingaccount->savingname_id = 2; // 2 for long term account
            $savingaccount->opening_date = date('Y-m-d', strtotime($request->disburse_date));
            
            $savingaccount->meeting_day = 1;
            $savingaccount->installment_type = 2;
            $savingaccount->minimum_deposit = 10;
            $savingaccount->status = 1; // 1 means active/open
            $savingaccount->member_id = $m_id;
            $savingaccount->save();
          }
        }

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.member.loans', [$s_id, $g_id, $m_id]);
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

    public function updateLoanAccount(Request $request, $s_id, $g_id, $m_id, $l_id)
    {        
        $this->validate($request, [
          'closing_date'       => 'sometimes',
          'status'             => 'sometimes'
        ]);

        $loan = Loan::find($l_id);
        $loan->closing_date = date('Y-m-d', strtotime($request->closing_date ? $request->closing_date : '1970-01-01'));
        // dd($loan->closing_date);
        if(!empty($request->status)) {
          $loan->status = $request->status; // 1 means disbursed, 0 means closed
        }
        $loan->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.member.loans', [$s_id, $g_id, $m_id]);
    }

    public function getMemberLoanSingle($s_id, $g_id, $m_id, $l_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);
      $member = Member::find($m_id);

      $loan = Loan::where('id', $l_id)
                  ->where('member_id', $member->id)
                  ->with(['loaninstallments' => function($query){
                       $query->orderBy('installment_no', 'asc'); // sort by installment_no
                    }])
                  ->first();

      $loannames = Loanname::all();
      $schemenames = Schemename::all();

      return view('dashboard.groups.members.loans.single')
              ->withStaff($staff)
              ->withGroup($group)
              ->withMember($member)
              ->withLoan($loan)
              ->withLoannames($loannames)
              ->withSchemenames($schemenames);
    }

    public function getDailyTransaction($s_id, $g_id, $m_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);
      $loannames = Loanname::all();

      $member = Member::find($m_id);

      return view('dashboard.groups.members.loans.dailytransaction')
              ->withStaff($staff)
              ->withGroup($group)
              ->withMember($member)
              ->withLoannames($loannames);
    }

    public function getDailyTransactionDate($s_id, $g_id, $m_id, $loan_type, $transaction_date)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);
      $loannames = Loanname::all();

      $member = Member::where('id', $m_id)
                      ->where('group_id', $g_id)
                      ->where('staff_id', $s_id)
                      ->where('status', 1) // status 1 means member is Active
                      ->orderBy('passbook', 'asc')
                      ->with(['loans' => function ($query) use($loan_type, $transaction_date) {
                          $query->where('loanname_id', $loan_type)
                                ->where('status', 1) // 1 means active loan
                                ->with(['loaninstallments' => function ($query) use($transaction_date) {
                                    $query->where('due_date', $transaction_date);
                                 }]);
                      }])
                      ->with(['savings' => function ($query) use($transaction_date) {
                          $query->where('status', 1) // 1 means active loan
                                ->with(['savinginstallments' => function ($query) use($transaction_date) {
                                    $query->where('due_date', $transaction_date);
                                 }]);
                      }])
                      ->first();
      // dd($member);
      return view('dashboard.groups.members.loans.dailytransaction')
              ->withStaff($staff)
              ->withGroup($group)
              ->withLoannames($loannames)
              ->withMember($member)
              ->withLoantype($loan_type)
              ->withTransactiondate($transaction_date);
    }

    public function postDailyInstallmentAPI(Request $request)
    {
        // member_id: member_id,
        // loaninstallment_id: loaninstallment_id,
        // transactiondate: transactiondate,
        // loaninstallment: loaninstallment,

        $member = Member::find($request->data['member_id']);
        $installment = Loaninstallment::find($request->data['loaninstallment_id']);

        // calculate outstanding from from loan
        $installment->loan->total_paid = $installment->loan->total_paid - $installment->paid_total + $request->data['loaninstallment'];
        $installment->loan->total_outstanding = $installment->loan->total_disbursed - $installment->loan->total_paid;
        $installment->loan->save();

        // post the installment
        $installment->paid_principal = $installment->installment_principal; 
        $installment->paid_interest = $installment->installment_interest;
        $installment->paid_total = $request->data['loaninstallment']; // assuming the total is paid
        $installment->outstanding_total = $installment->loan->total_outstanding; // from the main loan account table
        $installment->user_id = $member->staff_id;
        $installment->save();

        return $installment;
    }

    public function postOldDailyInstallmentAPI(Request $request)
    {
        // member_id: member_id,
        // loan_id: loan_id,
        // transactiondate: transactiondate,
        // loaninstallment: loaninstallment,

        $member = Member::find($request->data['member_id']);

        $loan = Loan::find($request->data['loan_id']);
        $service_charge_percentage = $loan->service_charge/$loan->principal_amount;

        $installment = new Loaninstallment;
        $installment->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));

        $checkloanlastinstallmentid = Loaninstallment::where('loan_id', $request->data['loan_id'])
                                                     ->orderBy('installment_no', 'desc')
                                                     ->first();
        if(!empty($checkloanlastinstallmentid)) {
          $installment->installment_no = $checkloanlastinstallmentid->installment_no + 1;
        } else {
          $installment->installment_no = 1;
        }
        $installment->installment_principal = $loan->principal_amount / $loan->installments;
        $installment->installment_interest = $loan->service_charge / $loan->installments;
        $installment->installment_total = $installment->installment_principal + $installment->installment_interest;
        
        // calculate outstanding from from loan
        $loan->total_paid = $loan->total_paid + $request->data['loaninstallment'];
        $loan->total_outstanding = $loan->total_disbursed - $loan->total_paid;
        $loan->save();

        $installment->paid_principal = $installment->installment_principal;
        $installment->paid_interest = $installment->installment_interest;
        $installment->paid_total = $request->data['loaninstallment'];
        $installment->outstanding_total = $loan->total_outstanding;
        $installment->loan_id = $loan->id;
        $installment->user_id = $member->staff_id;
        $installment->save();

        $installment->load('loan');
        
        return $installment;
    }

    public function postDailyInstallmentOldSavingAPI(Request $request)
    {
        $member = Member::find($request->data['member_id']);
        $savinginstallment = Savinginstallment::find($request->data['savinginstallment_id']);

        // calculate outstanding from from loan
        $savinginstallment->savingsingle->total_amount = $savinginstallment->savingsingle->total_amount - $savinginstallment->amount + $request->data['old_savinginstallment'];
        $savinginstallment->savingsingle->withdraw = $savinginstallment->savingsingle->withdraw - $savinginstallment->withdraw + $request->data['old_savingwithdraw'];
        $savinginstallment->savingsingle->save();

        // post the installment
        $savinginstallment->amount = $request->data['old_savinginstallment'];
        $savinginstallment->withdraw = $request->data['old_savingwithdraw'];
        $savinginstallment->balance = $savinginstallment->savingsingle->total_amount - $savinginstallment->savingsingle->withdraw;
        $savinginstallment->user_id = $member->staff_id;
        $savinginstallment->save();

        return $savinginstallment;
    }

    public function postDailyInstallmentNewSavingAPI(Request $request)
    {
        $member = Member::find($request->data['member_id']);
        $saving = Saving::find($request->data['saving_id']);

        // calculate outstanding from from loan
        $savinginstallment = new Savinginstallment;
        $savinginstallment->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));
        
        $saving->total_amount = $saving->total_amount + $request->data['new_savinginstallment'];
        $saving->withdraw = $saving->withdraw + $request->data['new_savingwithdraw'];
        $saving->save();

        // post the installment
        $savinginstallment->amount = $request->data['new_savinginstallment'];
        $savinginstallment->withdraw = $request->data['new_savingwithdraw'];
        $savinginstallment->balance = $saving->total_amount - $saving->withdraw;
        $savinginstallment->member_id = $member->id;
        $savinginstallment->savingname_id = $saving->savingname_id;
        $savinginstallment->saving_id = $saving->id;
        $savinginstallment->user_id = $member->staff_id;
        $savinginstallment->save();

        $savinginstallment->load('savingsingle');

        return $savinginstallment;
    }

    public function getMemberSavingSingle($s_id, $g_id, $m_id, $sv_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);
      $member = Member::find($m_id);

      $saving = Saving::where('id', $sv_id)
                  ->where('member_id', $member->id)
                  ->with(['savinginstallments' => function($query){
                       $query->orderBy('due_date', 'asc'); // sort by due_date
                    }])
                  ->first();

      $savingnames = Savingname::all();
      $schemenames = Schemename::all();

      return view('dashboard.groups.members.savings.single')
              ->withStaff($staff)
              ->withGroup($group)
              ->withMember($member)
              ->withSaving($saving)
              ->withSavingnames($savingnames)
              ->withSchemenames($schemenames);
    }

    public function updateSavingAccount(Request $request, $s_id, $g_id, $m_id, $sv_id)
    {        
        $this->validate($request, [
          'closing_date'       => 'sometimes',
          'status'             => 'required'
        ]);

        $saving = Saving::find($sv_id);
        $saving->closing_date = date('Y-m-d', strtotime($request->closing_date ? $request->closing_date : '1970-01-01'));
        $saving->status = $request->status; // 1 means active, 0 means closed
        $saving->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.member.savings', [$s_id, $g_id, $m_id]);
    }

    public function getMembersPassbook($s_id, $g_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);
      
      $members = Member::where('group_id', $g_id)
               ->orderBy('id', 'asc')->get();

      return view('dashboard.groups.members.passbook')
                ->withStaff($staff)
                ->withGroup($group)
                ->withMembers($members);
    }

    public function updatePassBook(Request $request)
    {     
      $member = Member::find($request->data['member_id']);
      if($request->data['member_id'] != null) {
        $member->passbook = $request->data['passbook'];
      }
      $member->save();
      return 'success';
    }

    public function getGroupTransfer($s_id, $g_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);
      $staffs = User::where('role', 'staff')->get();

      return view('dashboard.groups.transfer')
                ->withStaff($staff)
                ->withGroup($group)
                ->withStaffs($staffs);
    }

    public function transferGroup(Request $request, $id)
    { 
      $this->validate($request, [
        'user_id'       => 'required'
      ]);

      $group = Group::find($id);

      foreach ($group->members as $member) {
        $member->staff_id = $request->user_id;
        $member->save();
      }
      $group->user_id = $request->user_id;
      $group->save();

      Session::flash('success', 'Updated successfully!'); 
      return redirect()->route('group.features', [$group->user_id, $group->id]);
    }

    public function getMemberTransger($s_id, $g_id, $m_id)
    {
      $staff = User::find($s_id);
      $group = Group::find($g_id);
      $member = Member::find($m_id);
      $groups = Group::all();

      return view('dashboard.groups.members.transfer')
                ->withStaff($staff)
                ->withGroup($group)
                ->withMember($member)
                ->withGroups($groups);
    }

    public function memberTransfer(Request $request, $id)
    { 
      $this->validate($request, [
        'group_id'       => 'required'
      ]);

      $member = Member::find($id);
      $group = Group::find($request->group_id);
      // dd($group);
      $member->group_id = $request->group_id;
      $member->staff_id = $group->user_id;
      $member->save();

      Session::flash('success', 'Updated successfully!'); 
      return redirect()->route('dashboard.member.single', [$group->user_id, $group->id, $member->id]);
    }

    public function deleteSingleLoan(Request $request, $id)
    { 
      $loan = Loan::find($id);
      foreach ($loan->loaninstallments as $loaninstallment) {
        $loaninstallment->delete();
      }
      $loan->delete();
      
      Session::flash('success', 'Deleted successfully!'); 
      return redirect()->back();
    }

    public function closeMember(Request $request, $id)
    { 
      $member = Member::find($id);
      $member->status = 0;
      $member->closing_date = date('Y-m-d');
      $member->save();

      Session::flash('success', 'Updated successfully!'); 
      return redirect()->route('dashboard.member.archive');
    }

    public function getMembersArchive()
    { 
      $members = Member::where('status', 0)->get();
      
      return view('dashboard.groups.members.archive')
                ->withMembers($members);
    }

    public function activateMember(Request $request, $id)
    { 
      $member = Member::find($id);
      $member->status = 1;
      $member->closing_date = '1970-01-01';
      $member->save();

      Session::flash('success', 'Updated successfully!'); 
      return redirect()->route('dashboard.member.single', [$member->staff_id, $member->group_id, $member->id]);
    }
}
