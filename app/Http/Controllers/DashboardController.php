<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
use App\Group;
use App\Loanname;
use App\Savingname;

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
        $this->middleware('admin')->except('index', 'getProgramFeatures');
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

    public function getStaffs()
    {
        $staffs = User::where('role', 'staff')->paginate(10);
        return view('dashboard.staffs.index')->withStaffs($staffs);
    }

    public function createStaff()
    {
        return view('dashboard.staffs.create');
    }

    public function storeStaff(Request $request)
    {
        $this->validate($request, [
          'name'             => 'required',
          'phone'            => 'required|unique:users',
          'password'         => 'required|confirmed|min:6'
        ]);

        $staff = new User;
        $staff->name = $request->name;
        $staff->unique_key = generate_token(10);
        $staff->role = 'staff';
        $staff->type = 'Member';
        $staff->email = $request->phone . '@surjosomobay.com';
        $staff->phone = $request->phone;
        $staff->password = bcrypt($request->password);
        $staff->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.staffs');
    }

    public function editStaff($id)
    {
        $staff = User::find($id);
        return view('dashboard.staffs.edit')->withStaff($staff);
    }

    public function updateStaff(Request $request, $id)
    {
        $staff = User::find($id);
        $this->validate($request, [
          'name'             => 'required',
          'phone'            => 'required|unique:users,phone,'.$staff->id,
          'password'         => 'required|confirmed|min:6'
        ]);
        
        $staff->name = $request->name;
        $staff->phone = $request->phone;
        $staff->password = bcrypt($request->password);
        $staff->save();
        
        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.staffs');
    }

    public function getGroups()
    {
        $groups = Group::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.groups.index')->withGroups($groups);
    }

    public function createGroup()
    {
        $staffs = User::where('role', 'staff')->get();
        return view('dashboard.groups.create')->withStaffs($staffs);
    }

    public function storeGroup(Request $request)
    {
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

        $group = new Group;
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

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.groups');
    }

    public function editGroup($id)
    {
        $group = Group::find($id);
        return view('dashboard.groups.edit')->withGroup($group);
    }

    public function updateGroup(Request $request, $id)
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
        return redirect()->route('dashboard.groups');
    }

    public function getLoanAndNames()
    {
        $loannames = Loanname::orderBy('id', 'desc')->paginate(10);
        $savingnames = Savingname::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.loanandsavingnames.index')
                                    ->withLoannames($loannames)
                                    ->withSavingnames($savingnames);
    }

    public function createLoanName()
    {
        return view('dashboard.loanandsavingnames.createloanname');
    }

    public function storeLoanName(Request $request)
    {
        $this->validate($request, [
          'name'                  => 'required',
        ]);

        $loanname = new Loanname;
        $loanname->name = $request->name;
        $loanname->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.loanandsavingnames');
    }

    public function editLoanName($id)
    {
        $loanname = Loanname::find($id);
        return view('dashboard.loanandsavingnames.editloanname')->withLoanname($loanname);
    }

    public function updateLoanName(Request $request, $id)
    {
        $loanname = Loanname::find($id);
        $this->validate($request, [
          'name'                  => 'required',
        ]);

        $loanname->name = $request->name;
        $loanname->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.loanandsavingnames');
    }

    public function createSavingName()
    {
        return view('dashboard.loanandsavingnames.createsavingname');
    }

    public function storeSavingName(Request $request)
    {
        $this->validate($request, [
          'name'                  => 'required',
        ]);

        $savingname = new Savingname;
        $savingname->name = $request->name;
        $savingname->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.loanandsavingnames');
    }

    public function editSavingName($id)
    {
        $savingname = Savingname::find($id);
        return view('dashboard.loanandsavingnames.editsavingname')->withSavingname($savingname);
    }

    public function updateSavingName(Request $request, $id)
    {
        $savingname = Savingname::find($id);
        $this->validate($request, [
          'name'                  => 'required',
        ]);

        $savingname->name = $request->name;
        $savingname->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.loanandsavingnames');
    }

    public function getProgramFeatures()
    {
        return view('programs.features');
    }
}
