<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
use App\Group;
use App\Loanname;
use App\Savingname;
use App\Schemename;
use App\Loan;
use App\Loaninstallment;
use App\Saving;
use App\Savinginstallment;
use App\Member;
use App\Closeday;

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
          'father'           => 'required',
          'nid'              => 'required',
          'bank'             => 'required',
          'acno'             => 'required',
          'checkno'          => 'required',
          'password'         => 'required|confirmed|min:6'
        ]);

        $staff = new User;
        $staff->name = $request->name;
        $staff->unique_key = generate_token(10);
        $staff->role = 'staff';
        $staff->type = 'Member';
        $staff->email = $request->phone . '@surjosomobay.com';
        $staff->phone = $request->phone;
        $staff->father = $request->father;
        $staff->nid = $request->nid;
        $staff->bank = $request->bank;
        $staff->acno = $request->acno;
        $staff->checkno = $request->checkno;
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
          'father'           => 'required',
          'nid'              => 'required',
          'bank'             => 'required',
          'acno'             => 'required',
          'checkno'          => 'required',
          'password'         => 'sometimes|confirmed|min:6'
        ]);
        
        $staff->name = $request->name;
        $staff->phone = $request->phone;
        $staff->father = $request->father;
        $staff->nid = $request->nid;
        $staff->bank = $request->bank;
        $staff->acno = $request->acno;
        $staff->checkno = $request->checkno;
        $staff->password = bcrypt($request->password);
        $staff->save();
        
        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.staffs');
    }

    public function getAddGroupToStaff($id, $routeto)
    {
        $staff = User::find($id);
        return view('dashboard.staffs.addgroup')
                                ->withStaff($staff)
                                ->withRouteto($routeto);
    }

    public function addGroupToStaff(Request $request)
    {
        $this->validate($request, [
          'name'               => 'required',
          'formation'          => 'required',
          'meeting_day'        => 'required',
          'village'            => 'required',
          'min_savings_dep'    => 'sometimes',
          'min_security_dep'   => 'sometimes',
          'status'             => 'required',
          'user_id'            => 'required',
        ]);

        $group = new Group;
        $group->name = $request->name;
        $group->formation = strtotime($request->formation);
        $group->meeting_day = $request->meeting_day;
        $group->village = $request->village;
        // $group->min_savings_dep = $request->min_savings_dep;
        // $group->min_security_dep = $request->min_security_dep;
        $group->status = $request->status;
        $group->status = $request->status;
        $group->user_id = $request->user_id;
        $group->save();

        Session::flash('success', 'Added successfully!');
        if($request->routeto == 'staffslist') {
            return redirect()->route('dashboard.staffs');
        } elseif($request->routeto == 'stafffeature') {
            return redirect()->route('staff.features', $request->user_id);
        }
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
          'min_savings_dep'    => 'sometimes',
          'min_security_dep'   => 'sometimes',
          'status'             => 'required',
          'user_id'            => 'required',
        ]);

        $group = new Group;
        $group->name = $request->name;
        $group->formation = strtotime($request->formation);
        $group->meeting_day = $request->meeting_day;
        $group->village = $request->village;
        // $group->min_savings_dep = $request->min_savings_dep;
        // $group->min_security_dep = $request->min_security_dep;
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
        $schemenames = Schemename::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.loanandsavingnames.index')
                                    ->withLoannames($loannames)
                                    ->withSavingnames($savingnames)
                                    ->withSchemenames($schemenames);
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

    public function createSchemeName()
    {
        return view('dashboard.loanandsavingnames.createschemename');
    }

    public function storeSchemeName(Request $request)
    {
        $this->validate($request, [
          'name'                  => 'required',
        ]);

        $schemename = new Schemename;
        $schemename->name = $request->name;
        $schemename->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.loanandsavingnames');
    }

    public function editSchemeName($id)
    {
        $schemename = Schemename::find($id);
        return view('dashboard.loanandsavingnames.editschemename')->withSchemename($schemename);
    }

    public function updateSchemeName(Request $request, $id)
    {
        $schemename = Schemename::find($id);
        $this->validate($request, [
          'name'                  => 'required',
        ]);

        $schemename->name = $request->name;
        $schemename->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.loanandsavingnames');
    }

    public function getProgramFeatures()
    {
        return view('dashboard.programs.features');
    }

    public function getDayClose()
    {
        $closedays = Closeday::orderBy('close_date', 'desc')->paginate(10);

        return view('dashboard.programs.dayclose')->withClosedays($closedays);
    }



    public function postDayClose(Request $request)
    {
        $this->validate($request, [
          'close_date'       => 'required',
          'checkbox'         => 'required',
        ]);
        $checkcloseday = Closeday::where('close_date', date('Y-m-d', strtotime($request->close_date)))->first();

        if(!empty($checkcloseday)) 
        {
            Session::flash('warning', 'Already closed!');
        } else {
            $closeday = new Closeday;
            $closeday->close_date = date('Y-m-d', strtotime($request->close_date));
            $closeday->save();

            Session::flash('success', 'Submitted successfully!'); 
        }

        return redirect()->route('programs.day.close');
    }

    public function deleteMember($id)
    {
        $member = Member::find($id);

        foreach ($member->loans as $loan) {
            foreach ($loan->loaninstallments as $loaninstallment) {
                $loaninstallment->delete();
            }
            $loan->delete();
        }
        foreach ($member->savings as $saving) {
            foreach ($saving->savinginstallments as $savinginstallment) {
                $savinginstallment->delete();
            }
            $saving->delete();
        }
        $member->delete();

        return 'Successful!';
    }

    public function deleteStaff($id)
    {
        $staff = User::find($id);

        foreach ($staff->groups as $group) {
            foreach ($group->members as $member) {
                foreach ($member->loans as $loan) {
                    foreach ($loan->loaninstallments as $loaninstallment) {
                        $loaninstallment->delete();
                    }
                    $loan->delete();
                }
                foreach ($member->savings as $saving) {
                    foreach ($saving->savinginstallments as $savinginstallment) {
                        $savinginstallment->delete();
                    }
                    $saving->delete();
                }
                $member->delete();
            }
            $group->delete();
        }
        $staff->delete();

        return 'Successful!';
    }

    public function checkMissingSavings()
    {
        $members = Member::all();
        
        foreach ($members as $member) 
        {
            $checkgensaving = Saving::where('member_id', $member->id)
                                    ->where('savingname_id', 1)
                                    ->first();
            if(empty($checkgensaving)) {
                $savingaccount = new Saving;
                $savingaccount->savingname_id = 1;
                $savingaccount->opening_date = date('Y-m-d', strtotime($member->admission_date));
                $savingaccount->closing_date = '1970-01-01';
                // $savingaccount->meeting_day = $request->general_meeting_day;
                $savingaccount->installment_type = 1;
                $savingaccount->minimum_deposit = 0.00;
                $savingaccount->total_amount = 0.00;
                $savingaccount->withdraw = 0.00;
                $savingaccount->status = 1; // 1 means active/open
                $savingaccount->member_id = $member->id;
                $savingaccount->save();
            }
        }

        $savings = Saving::where('savingname_id', 1)->count();
        return "Members: " . $members->count() . " : General Savings: " . $savings;
    }
}
