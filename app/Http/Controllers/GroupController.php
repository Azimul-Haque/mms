<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;
use App\Member;
use App\Loan;
use App\Loanname;
use App\Loaninstallment;
use App\Saving;
use App\Savingname;
use App\Savinginstallment;

use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;

class GroupController extends Controller
{

	public function __construct()
	{
	    parent::__construct();
	    $this->middleware('auth');
	}
    
    public function getGroupFeatures($s_id, $g_id)
    {
        $group = Group::find($g_id);
        $staff = User::find($s_id);

        return view('dashboard.groups.features')
                        ->withGroup($group)
                        ->withStaff($staff);                        
    }
    
    public function getGroupTransactions($s_id, $g_id)
    {
        $groups = Group::all();
        $group = Group::find($g_id);
        $staff = User::find($s_id);
        $loannames = Loanname::all();

        $members = Member::where('staff_id', $s_id)
                         ->where('group_id', $g_id)
                         ->where('status', 1) // status 1 means member is Active
                         ->orderBy('passbook', 'asc')
                         ->get();

        return view('dashboard.groups.group_transactions.index')
                        ->withGroups($groups)
                        ->withGroup($group)
                        ->withStaff($staff)
                        ->withMembers($members)
                        ->withLoannames($loannames);;
    }
    
    public function getGroupTransactionsDate($s_id, $g_id, $loan_type, $transaction_date)
    {
        $groups = Group::all();
        $group = Group::find($g_id);
        $staff = User::find($s_id);
        $loannames = Loanname::all();

        $members = Member::where('staff_id', $s_id)
                         ->where('group_id', $g_id)
                         ->where('status', 1) // status 1 means member is Active
                         ->orderBy('passbook', 'asc')
                         ->with(['loans' => function ($query) use($loan_type, $transaction_date) {
                             $query->where('loanname_id', $loan_type)
                                   ->where('status', 1) // 1 means active loan
                                   ->with(['loaninstallments' => function ($query) use($transaction_date) {
                                       $query->where('due_date', $transaction_date);
                                    }]);
                         }])
                         ->get();
        // dd($members);
        return view('dashboard.groups.group_transactions.index')
                        ->withGroups($groups)
                        ->withGroup($group)
                        ->withStaff($staff)
                        ->withMembers($members)
                        ->withLoannames($loannames)
                        ->withLoantype($loan_type)
                        ->withTransactiondate($transaction_date);
    }
  
    public function postGroupInstallmentAPI(Request $request)
    {
        $member = Member::find($request->data['member_id']);
        $installment = Loaninstallment::where('id', $request->data['loaninstallment_id'])
                                      ->where('installment_no', $request->data['installment_no'])
                                      ->first();

        // calculate outstanding from from loan
        $installment->loan->total_paid = $installment->loan->total_paid - $installment->paid_total + $request->data['loaninstallment'];
        $installment->loan->total_outstanding = $installment->loan->total_disbursed - $installment->loan->total_paid;
        $installment->loan->save();

        // post the installment
        $installment->paid_principal = $installment->installment_principal; 
        $installment->paid_interest = $installment->installment_interest;
        $installment->paid_total = $request->data['loaninstallment']; // assuming the total is paid
        // $installment->outstanding_total = $installment->loan->total_outstanding; // from the main loan account table
        $installment->user_id = $member->staff_id; // pore change o hoite paare taar staff ejonno
        $installment->save();
        
        // save the deposits(General and LongTerm)
        // General Saving
        if($request->data['generalsaving'] > -1 || $request->data['generalsavingwd'] > -1) {
          $generalsaving = Savinginstallment::where('member_id', $request->data['member_id'])
                                            ->where('savingname_id', 1) // hard coded!
                                            ->where('due_date', $request->data['transactiondate'])
                                            ->first();
          if(!empty($generalsaving)) {
              // balance calculation in saving acc
              $gensavingac = Saving::where('member_id', $request->data['member_id'])
                                ->where('savingname_id', 1) // hard coded!
                                ->first();
              $gensavingac->total_amount = $gensavingac->total_amount - $generalsaving->amount + $request->data['generalsaving'];
              $gensavingac->withdraw = $gensavingac->withdraw - $generalsaving->withdraw + $request->data['generalsavingwd'];
              $gensavingac->save();

              $generalsaving->amount = $request->data['generalsaving'];
              $generalsaving->withdraw = $request->data['generalsavingwd'];
              $generalsaving->balance = $gensavingac->total_amount - $gensavingac->withdraw;
              $generalsaving->user_id = $member->staff_id;
              $generalsaving->save();
          } else {
              // balance calculation
              $gensavingac = Saving::where('member_id', $request->data['member_id'])
                                ->where('savingname_id', 1) // hard coded!
                                ->first();
              $gensavingac->total_amount = $gensavingac->total_amount + $request->data['generalsaving'];
              $gensavingac->withdraw = $gensavingac->withdraw + $request->data['generalsavingwd'];
              // balance is considered total_amount - withdraw
              $gensavingac->save();

              $newgeneralsaving = new Savinginstallment;
              $newgeneralsaving->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));
              $newgeneralsaving->amount = $request->data['generalsaving'];
              $newgeneralsaving->withdraw = $request->data['generalsavingwd'];
              $newgeneralsaving->balance = $gensavingac->total_amount - $gensavingac->withdraw;
              $newgeneralsaving->member_id = $request->data['member_id'];
              $newgeneralsaving->savingname_id = 1; // hard coded!
              $newgeneralsaving->saving_id = $gensavingac->id;
              $newgeneralsaving->user_id = $member->staff_id;
              $newgeneralsaving->save();            
          }
        }
        // General Saving

        // LongTerm Saving
        if(!empty($request->data['longsaving']) || !empty($request->data['longsavingwd'])) { // eta karo karo nao thakte paare...
          if($request->data['longsaving'] > -1 || $request->data['longsavingwd'] > -1) {
            $longsaving = Savinginstallment::where('member_id', $request->data['member_id'])
                                              ->where('savingname_id', 2) // hard coded!
                                              ->where('due_date', $request->data['transactiondate'])
                                              ->first();
            if(!empty($longsaving)) {
                // balance calculation in saving acc
                $longsavingac = Saving::where('member_id', $request->data['member_id'])
                                  ->where('savingname_id', 2) // hard coded!
                                  ->first();
                $longsavingac->total_amount = $longsavingac->total_amount - $longsaving->amount + $request->data['longsaving'];
                $longsavingac->withdraw = $longsavingac->withdraw - $longsaving->withdraw + $request->data['longsavingwd'];
                $longsavingac->save();

                $longsaving->amount = $request->data['longsaving'];
                $longsaving->withdraw = $request->data['longsavingwd'];
                $longsaving->balance = $longsavingac->total_amount - $longsavingac->withdraw;
                $longsaving->user_id = $member->staff_id;
                $longsaving->save();
            } else {
                // balance calculation
                $longsavingac = Saving::where('member_id', $request->data['member_id'])
                                  ->where('savingname_id', 2) // hard coded!
                                  ->first();
                $longsavingac->total_amount = $longsavingac->total_amount + $request->data['longsaving'];
                $longsavingac->withdraw = $longsavingac->withdraw + $request->data['longsavingwd'];
                $longsavingac->save();

                $newlongsaving = new Savinginstallment;
                $newlongsaving->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));
                $newlongsaving->amount = $request->data['longsaving'];
                $newlongsaving->withdraw = $request->data['longsavingwd'];
                $newlongsaving->balance = $longsavingac->total_amount - $longsavingac->withdraw;
                $newlongsaving->member_id = $request->data['member_id'];
                $newlongsaving->savingname_id = 2; // hard coded!
                $newlongsaving->saving_id = $longsavingac->id;
                $newlongsaving->user_id = $member->staff_id;
                $newlongsaving->save();            
            }
          }
        }
        // LongTerm Saving

        return 'success';
    }
	
    public function postGroupBrandNewInstallmentAPI(Request $request)
    {
        $member = Member::find($request->data['member_id']);
        $loan = Loan::find($request->data['loan_id']);
        // save the new installment
        if($request->data['loaninstallment'] > -1) 
        {
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
        }
        
        // save the deposits(General and LongTerm)
        // General Saving
        if($request->data['generalsaving'] > -1 || $request->data['generalsavingwd'] > -1) {
          $generalsaving = Savinginstallment::where('member_id', $request->data['member_id'])
                                            ->where('savingname_id', 1) // hard coded!
                                            ->where('due_date', $request->data['transactiondate'])
                                            ->first();
          if(!empty($generalsaving)) {
              // balance calculation in saving acc
              $gensavingac = Saving::where('member_id', $request->data['member_id'])
                                ->where('savingname_id', 1) // hard coded!
                                ->first();
              $gensavingac->total_amount = $gensavingac->total_amount - $generalsaving->amount + $request->data['generalsaving'];
              $gensavingac->withdraw = $gensavingac->withdraw - $generalsaving->withdraw + $request->data['generalsavingwd'];
              $gensavingac->save();

              $generalsaving->amount = $request->data['generalsaving'];
              $generalsaving->withdraw = $request->data['generalsavingwd'];
              $generalsaving->balance = $gensavingac->total_amount - $gensavingac->withdraw;
              $generalsaving->user_id = $member->staff_id;
              $generalsaving->save();
          } else {
              // balance calculation
              $gensavingac = Saving::where('member_id', $request->data['member_id'])
                                ->where('savingname_id', 1) // hard coded!
                                ->first();
              $gensavingac->total_amount = $gensavingac->total_amount + $request->data['generalsaving'];
              $gensavingac->withdraw = $gensavingac->withdraw + $request->data['generalsavingwd'];
              // balance is considered total_amount - withdraw
              $gensavingac->save();

              $newgeneralsaving = new Savinginstallment;
              $newgeneralsaving->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));
              $newgeneralsaving->amount = $request->data['generalsaving'];
              $newgeneralsaving->withdraw = $request->data['generalsavingwd'];
              $newgeneralsaving->balance = $gensavingac->total_amount - $gensavingac->withdraw;
              $newgeneralsaving->member_id = $request->data['member_id'];
              $newgeneralsaving->savingname_id = 1; // hard coded!
              $newgeneralsaving->saving_id = $gensavingac->id;
              $newgeneralsaving->user_id = $member->staff_id;
              $newgeneralsaving->save();            
          }
        }
        // General Saving

        // LongTerm Saving
        if(!empty($request->data['longsaving']) || !empty($request->data['longsavingwd'])) { // eta karo karo nao thakte paare...
          if($request->data['longsaving'] > -1 || $request->data['longsavingwd'] > -1) {
            $longsaving = Savinginstallment::where('member_id', $request->data['member_id'])
                                              ->where('savingname_id', 2) // hard coded!
                                              ->where('due_date', $request->data['transactiondate'])
                                              ->first();
            if(!empty($longsaving)) {
                // balance calculation in saving acc
                $longsavingac = Saving::where('member_id', $request->data['member_id'])
                                  ->where('savingname_id', 2) // hard coded!
                                  ->first();
                $longsavingac->total_amount = $longsavingac->total_amount - $longsaving->amount + $request->data['longsaving'];
                $longsavingac->withdraw = $longsavingac->withdraw - $longsaving->withdraw + $request->data['longsavingwd'];
                $longsavingac->save();

                $longsaving->amount = $request->data['longsaving'];
                $longsaving->withdraw = $request->data['longsavingwd'];
                $longsaving->balance = $longsavingac->total_amount - $longsavingac->withdraw;
                $longsaving->user_id = $member->staff_id;
                $longsaving->save();
            } else {
                // balance calculation
                $longsavingac = Saving::where('member_id', $request->data['member_id'])
                                  ->where('savingname_id', 2) // hard coded!
                                  ->first();
                $longsavingac->total_amount = $longsavingac->total_amount + $request->data['longsaving'];
                $longsavingac->withdraw = $longsavingac->withdraw + $request->data['longsavingwd'];
                $longsavingac->save();

                $newlongsaving = new Savinginstallment;
                $newlongsaving->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));
                $newlongsaving->amount = $request->data['longsaving'];
                $newlongsaving->withdraw = $request->data['longsavingwd'];
                $newlongsaving->balance = $longsavingac->total_amount - $longsavingac->withdraw;
                $newlongsaving->member_id = $request->data['member_id'];
                $newlongsaving->savingname_id = 2; // hard coded!
                $newlongsaving->saving_id = $longsavingac->id;
                $newlongsaving->user_id = $member->staff_id;
                $newlongsaving->save();            
            }
          }
        }
        // LongTerm Saving

        return 'success';
    }
}
