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
use App\Borrow;
use App\Baddebt;
use App\Debtpayment;
use App\Dailyotheramount;

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
        $this->middleware('auth')->except('deleteDoubleInstallments', 'runDoubleDelete', 'checkUserIDMissing');
        $this->middleware('admin')->except('index', 'getProgramFeatures', 'deleteDoubleInstallments', 'runDoubleDelete', 'checkUserIDMissing');
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

        // save the CASH IN HAND
        $dailyotheramounts = Dailyotheramount::where('due_date', date('Y-m-d', strtotime($request->close_date)))->first();
        if(!empty($dailyotheramounts)) {
            $thenextday = date('Y-m-d', strtotime($request->close_date . ' + 1 day'));
            $thenextdayamounts = Dailyotheramount::where('due_date', date('Y-m-d', strtotime($thenextday)))->first();

            // collection
            $totalloancollection = DB::table("loaninstallments")
                                     ->select(DB::raw("SUM(paid_total) as total"))
                                     ->where('due_date', date('Y-m-d', strtotime($request->close_date)))
                                     ->first();

            //saving calculation
            $totalsavingcollection = DB::table("savinginstallments")
                                     ->select(DB::raw("SUM(amount) as total"))
                                     ->where('due_date', date('Y-m-d', strtotime($request->close_date)))
                                     ->first();
            //saving calculation

            $totalinsurance = DB::table("loans")
                                ->select(DB::raw("SUM(insurance) as total"))
                                ->where('disburse_date', date('Y-m-d', strtotime($request->close_date)))
                                ->where('loanname_id', 1)
                                ->first();
            $totalprocessingfee = DB::table("loans")
                                    ->select(DB::raw("SUM(processing_fee) as total"))
                                    ->where('disburse_date', date('Y-m-d', strtotime($request->close_date)))
                                    ->where('loanname_id', 1)
                                    ->first();  
            $totaladmissionfee = DB::table("members")
                                    ->select(DB::raw("SUM(admission_fee) as total"))
                                    ->where('admission_date', date('Y-m-d', strtotime($request->close_date)))
                                    ->first();
            $totalpassbookfee = DB::table("members")
                                    ->select(DB::raw("SUM(passbook_fee) as total"))
                                    ->where('admission_date', date('Y-m-d', strtotime($request->close_date)))
                                    ->first();
            $totalshareddeposit = DB::table("members")
                                    ->select(DB::raw("SUM(shared_deposit) as total"))
                                    ->where('admission_date', date('Y-m-d', strtotime($request->close_date)))
                                    ->first();
            $totaldownpayment = DB::table("loans")
                                  ->select(DB::raw("SUM(down_payment) as total"))
                                  ->where('disburse_date', date('Y-m-d', strtotime($request->close_date)))
                                  ->where('loanname_id', 2)
                                  ->first();

            $totalborrowcollection = DB::table("borrows")
                                       ->select(DB::raw("SUM(amount) as total"))
                                       ->where('borrow_date', date('Y-m-d', strtotime($request->close_date)))
                                       ->where('borrow_type', 2)
                                       ->first();
            // collection

            // disburse
            $totaldisbursed = DB::table("loans")
                                    ->select(DB::raw("SUM(principal_amount) as total"))
                                    ->where('disburse_date', date('Y-m-d', strtotime($request->close_date)))
                                    ->first();
            $totalsavingwithdraw = DB::table("savinginstallments")
                                     ->select(DB::raw("SUM(withdraw) as total"))
                                     ->where('due_date', date('Y-m-d', strtotime($request->close_date)))
                                     ->first();
            $totalshareddepositreturn = DB::table("members")
                                          ->select(DB::raw("SUM(shared_deposit) as total"))
                                          ->where('closing_date', date('Y-m-d', strtotime($request->close_date)))
                                          ->first();
            $totalborrowdisbursed = DB::table("borrows")
                                       ->select(DB::raw("SUM(amount) as total"))
                                       ->where('borrow_date', date('Y-m-d', strtotime($request->close_date)))
                                       ->where('borrow_type', 1)
                                       ->first();
            // disburse

            if(!empty($thenextdayamounts)) {
                $thenextdayamounts->cashinhand = 
                    $dailyotheramounts->cashinhand 
                    + ($totalsavingcollection->total ? $totalsavingcollection->total : 0)
                    + ($totalloancollection->total ? $totalloancollection->total : 0)
                    + ($totalinsurance->total ? $totalinsurance->total : 0)
                    + ($totalprocessingfee->total ? $totalprocessingfee->total : 0)
                    + ($totaladmissionfee->total ? $totaladmissionfee->total : 0)
                    + ($totalpassbookfee->total ? $totalpassbookfee->total : 0)
                    + ($totalshareddeposit->total ? $totalshareddeposit->total : 0)
                    + ($totaldownpayment->total ? $totaldownpayment->total : 0)
                    + ($totalborrowcollection->total ? $totalborrowcollection->total : 0)
                    + $dailyotheramounts->collentionothers

                    - ($totaldisbursed->total ? $totaldisbursed->total : 0)
                    - ($totalsavingwithdraw->total ? $totalsavingwithdraw->total : 0)
                    - ($totalshareddepositreturn->total ? $totalshareddepositreturn->total : 0)
                    - ($totalborrowdisbursed->total ? $totalborrowdisbursed->total : 0) 
                    - $dailyotheramounts->disburseothers;

                $thenextdayamounts->save();

            } else {
                $newdailyotheramounts = new Dailyotheramount;
                $newdailyotheramounts->due_date = date('Y-m-d', strtotime($thenextday));
                $newdailyotheramounts->cashinhand = 
                    $dailyotheramounts->cashinhand 
                    + ($totalsavingcollection->total ? $totalsavingcollection->total : 0)
                    + ($totalloancollection->total ? $totalloancollection->total : 0)
                    + ($totalinsurance->total ? $totalinsurance->total : 0)
                    + ($totalprocessingfee->total ? $totalprocessingfee->total : 0)
                    + ($totaladmissionfee->total ? $totaladmissionfee->total : 0)
                    + ($totalpassbookfee->total ? $totalpassbookfee->total : 0)
                    + ($totalshareddeposit->total ? $totalshareddeposit->total : 0)
                    + ($totaldownpayment->total ? $totaldownpayment->total : 0)
                    + ($totalborrowcollection->total ? $totalborrowcollection->total : 0)
                    + $dailyotheramounts->collentionothers

                    - ($totaldisbursed->total ? $totaldisbursed->total : 0)
                    - ($totalsavingwithdraw->total ? $totalsavingwithdraw->total : 0)
                    - ($totalshareddepositreturn->total ? $totalshareddepositreturn->total : 0)
                    - ($totalborrowdisbursed->total ? $totalborrowdisbursed->total : 0) 
                    - $dailyotheramounts->disburseothers;
                    
                $newdailyotheramounts->save();            
            }
        }
        // save the CASH IN HAND

        return redirect()->route('programs.day.close');
    }

    public function deleteDayClose($id)
    {
        try {
            $closeday = Closeday::find($id);
            $closeday->delete();
        } catch(Exception $e) {

        }

        Session::flash('success', 'Day opened successfully!');
        return redirect()->route('programs.day.close');
    }



    public function getBorrows($borrow_date)
    {
        $staffs = User::where('role', 'staff')->get();
        $borrows = Borrow::where('borrow_date', $borrow_date)->orderBy('borrow_date', 'desc')->get();

        return view('dashboard.staffs.borrows')
                            ->withBorrows($borrows)
                            ->withStaffs($staffs)
                            ->withBorrowdate($borrow_date);
    }

    public function storeBorrow(Request $request)
    {
        $this->validate($request, [
          'user_id'         => 'required',
          'borrow_date'     => 'required',
          'borrow_type'     => 'required',
          'amount'          => 'required',
        ]);

        $borrow = new Borrow;
        $borrow->user_id = $request->user_id;
        $borrow->borrow_date = date('Y-m-d', strtotime($request->borrow_date));
        $borrow->borrow_type = $request->borrow_type; // 1 means disburse, 2 means collection
        $borrow->amount = $request->amount;
        $borrow->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.borrows', date('Y-m-d', strtotime($request->borrow_date)));
    }

    public function updateBorrow(Request $request, $id)
    {
        $borrow = Borrow::find($id);
        $this->validate($request, [
          'user_id'         => 'required',
          'borrow_date'     => 'required',
          'borrow_type'     => 'required',
          'amount'          => 'required',
        ]);

        $borrow->user_id = $request->user_id;
        $borrow->borrow_date = date('Y-m-d', strtotime($request->borrow_date));
        $borrow->borrow_type = $request->borrow_type; // 1 means disburse, 2 means collection
        $borrow->amount = $request->amount;
        $borrow->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.borrows', date('Y-m-d', strtotime($request->borrow_date)));
    }

    public function deleteBorrow($id)
    {
        $borrow = Borrow::find($id);
        $borrow->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->back();
    }

    public function getSingleBorrow($id)
    {
        $staff = User::find($id);
        $borrows = Borrow::where('user_id', $staff->id)->orderBy('borrow_date', 'desc')->paginate(10);
        $staffs = User::where('role', 'staff')->get();

        return view('dashboard.staffs.singleborrow')
                                    ->withStaff($staff)
                                    ->withBorrows($borrows)
                                    ->withStaffs($staffs);
    }

    public function getBadDebts()
    {
        $groups = Group::all();
        // $staffs = User::where('role', 'staff')->get();

        $baddebts = Baddebt::all();
        return view('dashboard.programs.baddebts')
                                    ->withGroups($groups)
                                    ->withBaddebts($baddebts);
    }

    public function storeBadDebt(Request $request)
    {
        $this->validate($request, [
          'name'         => 'required',
          'fhusband'     => 'required',
          'groupname'    => 'required',
          'staffname'    => 'required',
          'debt'       => 'required',
        ]);

        $baddebt = new Baddebt;
        $baddebt->name = $request->name;
        $baddebt->fhusband = $request->fhusband;
        $baddebt->groupname = $request->groupname;
        $baddebt->staffname = $request->staffname;
        $baddebt->debt = $request->debt;
        $baddebt->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('bad.debts');
    }

    public function updateBadDebt(Request $request, $id)
    {
        $baddebt = Baddebt::find($id);
        $this->validate($request, [
          'name'         => 'required',
          'fhusband'     => 'required',
          'groupname'    => 'required',
          'staffname'    => 'required',
          'debt'       => 'required',
        ]);

        $baddebt->name = $request->name;
        $baddebt->fhusband = $request->fhusband;
        $baddebt->groupname = $request->groupname;
        $baddebt->staffname = $request->staffname;
        $baddebt->debt = $request->debt;
        $baddebt->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('bad.debts');
    }

    public function deleteBadDebt($id)
    {
        $baddebt = Baddebt::find($id);
        foreach ($baddebt->debtpayments as $debtpayment) {
            $debtpayment->delete();
        }
        $baddebt->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->route('bad.debts');
    }

    public function getSingleBadDebt($id)
    {
        $baddebt = Baddebt::find($id);
        return view('dashboard.programs.singlebaddebt')->withBaddebt($baddebt);
    }

    public function storeDebtPayment(Request $request)
    {
        $this->validate($request, [
          'baddebt_id'    => 'required',
          'pay_date'      => 'required',
          'amount'        => 'required',
        ]);

        $payment = new Debtpayment;
        $payment->baddebt_id = $request->baddebt_id;
        $payment->pay_date = date('Y-m-d', strtotime($request->pay_date));
        $payment->amount = $request->amount;
        $payment->save();

        Session::flash('success', 'Paid successfully!'); 
        return redirect()->route('bad.debts');
    }

    public function updateDebtPayment(Request $request, $id)
    {
        $payment = Debtpayment::find($id);

        $this->validate($request, [
          'pay_date'      => 'required',
          'amount'        => 'required',
        ]);

        $payment->pay_date = date('Y-m-d', strtotime($request->pay_date));
        $payment->amount = $request->amount;
        $payment->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('bad.debt.single', $payment->baddebt->id);
    }    

    public function deleteDebtPayment($id)
    {
        $payment = Debtpayment::find($id);
        $payment->delete();

        Session::flash('success', 'Deleted successfully!');
        return redirect()->back();
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

    public function deleteGroup($id)
    {
        $group = Group::find($id);

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

    public function deleteDoubleInstallments($datetodel, $loanorsavings, $type)
    {
        if($loanorsavings == 1) {
            $loans = Loan::where('loanname_id', $type)->get();
            foreach ($loans as $loan) {
               if($loan->loaninstallments->where('due_date', date('Y-m-d', strtotime($datetodel)))->count() > 1) {
                foreach ($loan->loaninstallments->where('due_date', date('Y-m-d', strtotime($datetodel))) as $loaninstallment) {
                    $loaninstallment->delete();
                    break;
                }
                // echo $loan->loaninstallments->where('due_date', date('Y-m-d', strtotime($datetodel)))->count();
               } else {
                // echo 1;
               }
            }
        } elseif($loanorsavings == 2) {
            $savings = Saving::where('savingname_id', $type)->get();
            foreach ($savings as $saving) {
                if($saving->savinginstallments->where('due_date', date('Y-m-d', strtotime($datetodel)))->count() > 1) {
                 foreach ($saving->savinginstallments->where('due_date', date('Y-m-d', strtotime($datetodel))) as $savinginstallment) {
                     $savinginstallment->delete();
                     break;
                 }
                 // echo $saving->savinginstallments->where('due_date', date('Y-m-d', strtotime($datetodel)))->count();
                } else {
                 // echo 1;
                }
            }
        } 
    }

    public function runDoubleDelete($datetodel)
    {
        for($i = 10; $i > 0; $i--) {
            for($j = 2; $j > 0; $j--) {
                for($k = 2; $k > 0; $k--) {
                    $this->deleteDoubleInstallments(date('Y-m-d', strtotime($datetodel)), $j, $k);
                } 
            }
        } 
    }

    public function checkUserIDMissing() {
        $loans = Loan::all();
        foreach ($loans as $loan) {
            foreach ($loan->loaninstallments as $loaninstallment) {
                if($loaninstallment->user_id == 0) {
                    $loaninstallment->user_id = $loan->member->group->user->id;
                    $loaninstallment->save();
                }
                echo $loan->member->group->user->id;
            }
        }
        echo '<br/><br/>';
        $savings = Saving::all();
        foreach ($savings as $saving) {
            foreach ($saving->savinginstallments as $savinginstallment) {
                if($savinginstallment->user_id == 0) {
                    $savinginstallment->user_id = $saving->member->group->user->id;
                    $savinginstallment->save();
                }
                echo $saving->member->group->user->id;
            }
        }
    }

    public function changeDebenLoanAndSaving() {
        $members = Member::where('staff_id', 13)->get();

        foreach ($members as $member) {
            foreach ($member->loans as $loan) {
                if($loan->closing_date == '2020-02-04') {
                    $loan->closing_date = date('Y-m-d', strtotime('2020-01-15'));
                    $loan->save();
                    echo 'Loan Done';
                }
            }
        }
        echo '<br/><br/>';

        foreach ($members as $member) {
            foreach ($member->savings as $saving) {
                if($saving->closing_date == '2020-02-04') {
                    $saving->closing_date = date('Y-m-d', strtotime('2020-01-15'));
                    $saving->save();
                    echo 'Saving Done';
                }
            }
        }
    }
}
