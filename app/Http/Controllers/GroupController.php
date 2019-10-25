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
	
    public function postInstallmentAPI(Request $request)
    {
        // member_id: member_id,
        // loaninstallment_id: loaninstallment_id,
        // transactiondate: transactiondate,

        // loaninstallment: loaninstallment,

        // generalsaving: generalsaving,
        // longsaving: longsaving,
        // generalsavingwd: generalsavingwd,
        // longsavingwd: longsavingwd
        $member = Member::find($request->data['member_id']);
        $installment = Loaninstallment::find($request->data['loaninstallment_id']);

        // post the installment
        $installment->paid_principal = $installment->installment_principal; 
        $installment->paid_interest = $installment->installment_interest;
        $installment->paid_total = $request->data['loaninstallment']; // assuming the total is paid
        $installment->save();

        // save the deposits(General and LongTerm)
        // General Saving
        $generalsaving = Savinginstallment::where('member_id', $request->data['member_id'])
                                          ->where('savingname_id', 1) // hard coded!
                                          ->where('due_date', $request->data['transactiondate'])
                                          ->first();
        if(!empty($generalsaving)) {
            // balance calculation in saving acc
            $gensavingac = Saving::where('member_id', $request->data['member_id'])
                              ->where('savingname_id', 1) // hard coded!
                              ->first();
            $gensavingac->total_amount = $gensavingac->total_amount - $generalsaving->amount + $request->data['generalsaving'];;
            $gensavingac->withdraw = $gensavingac->withdraw - $generalsaving->withdraw + $request->data['generalsavingwd'];
            $gensavingac->save();

            $generalsaving->amount = $request->data['generalsaving'];
            $generalsaving->withdraw = $request->data['generalsavingwd'];
            $generalsaving->balance = $gensavingac->total_amount - $gensavingac->withdraw;
            $generalsaving->save();
        } else {
            // balance calculation
            $gensavingac = Saving::where('member_id', $request->data['member_id'])
                              ->where('savingname_id', 1) // hard coded!
                              ->first();
            $gensavingac->total_amount = $gensavingac->total_amount + $request->data['generalsaving'];;
            $gensavingac->withdraw = $gensavingac->withdraw + $request->data['generalsavingwd'];
            $gensavingac->save();

            $newgeneralsaving = new Savinginstallment;
            $newgeneralsaving->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));
            $newgeneralsaving->amount = $request->data['generalsaving'];
            $newgeneralsaving->withdraw = $request->data['generalsavingwd'];
            $newgeneralsaving->balance = $gensavingac->total_amount - $gensavingac->withdraw;
            $newgeneralsaving->member_id = $request->data['member_id'];
            $newgeneralsaving->savingname_id = 1; // hard coded!
            $newgeneralsaving->saving_id = $gensavingac->id;
            $newgeneralsaving->save();            
        }
        // LongTerm Saving
        // General Saving
        $longsaving = Savinginstallment::where('member_id', $request->data['member_id'])
                                          ->where('savingname_id', 2) // hard coded!
                                          ->where('due_date', $request->data['transactiondate'])
                                          ->first();
        if(!empty($longsaving)) {
            // balance calculation in saving acc
            $longsavingac = Saving::where('member_id', $request->data['member_id'])
                              ->where('savingname_id', 2) // hard coded!
                              ->first();
            $longsavingac->total_amount = $longsavingac->total_amount - $longsaving->amount + $request->data['longsaving'];;
            $longsavingac->withdraw = $longsavingac->withdraw - $longsaving->withdraw + $request->data['longsavingwd'];
            $longsavingac->save();

            $longsaving->amount = $request->data['longsaving'];
            $longsaving->withdraw = $request->data['longsavingwd'];
            $longsaving->balance = $longsavingac->total_amount - $longsavingac->withdraw;
            $longsaving->save();
        } else {
            // balance calculation
            $longsavingac = Saving::where('member_id', $request->data['member_id'])
                              ->where('savingname_id', 2) // hard coded!
                              ->first();
            $longsavingac->total_amount = $longsavingac->total_amount + $request->data['longsaving'];;
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
            $newlongsaving->save();            
        }

        return 'success';
    }
}
