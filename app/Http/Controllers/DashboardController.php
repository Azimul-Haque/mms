<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;

use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index');
    }

    public function getProgramFeatures()
    {
        return view('programs.features');
    }

    public function getStaffsFeatures()
    {
        return view('staffs.features');
    }

    public function getGroupsFeatures()
    {
        return view('groups.features');
    }
}
