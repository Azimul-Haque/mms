<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;

use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;

class StaffController extends Controller
{
	public function __construct()
	{
	    parent::__construct();
	    $this->middleware('auth');
	}
	
    public function getStaffFeatures($id)
    {
        $staff = User::find($id);
        return view('dashboard.staffs.features')->withStaff($staff);
    }
}
