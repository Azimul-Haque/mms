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
        return view('dashboard.groups.features')
        				->withGroup($group)
        				->withsid($s_id);
    }
}
