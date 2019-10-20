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
        $members = Member::where('staff_id', $s_id)
                         ->where('group_id', $g_id)
                         ->where('status', 1) // status 1 means member is Active
                         ->orderBy('passbook', 'asc')
                         ->get();

        return view('dashboard.groups.group_transactions.index')
                        ->withGroups($groups)
        				->withGroup($group)
                        ->withStaff($staff)
                        ->withMembers($members);
    }
}
