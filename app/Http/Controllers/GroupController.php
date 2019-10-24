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
}
