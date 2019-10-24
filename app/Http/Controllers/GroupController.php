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
                                          ->first();
        if(!empty($generalsaving)) {
            $generalsaving->amount = $request->data['generalsaving'];
            $generalsaving->amount = $request->data['generalsavingwd'];
        } else {

        }
        // LongTerm Saving
        $longsaving = Savinginstallment::where('member_id', $request->data['member_id'])
                                        ->where('savingname_id', 2) // hard coded!
                                        ->first();
        if(!empty($longsaving)) {
            $longsaving->amount = $request->data['longsaving'];
            $longsaving->amount = $request->data['longsavingwd'];
        } else {

        }

        return 'success';
    }
}
