<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;
use App\Member;
use App\Saving;
use App\Savingname;
use App\Savinginstallment;
use App\Loan;
use App\Loaninstallment;
use App\Loanname;
use App\Schemename;
use App\Dailyotheramount;
use App\Closeday;

use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;
use Excel;

class ReportController extends Controller
{
	public function __construct()
	{
	    parent::__construct();
	    $this->middleware('auth');
	}

    public function test()
    {
    	$staffs = User::where('role', 'staff')->get();

	    Excel::create('test_file', function($excel) use($staffs) {
	    	$excel->sheet('Sheet1', function($sheet) use($staffs) {

		        $sheet->loadView('dashboard.reports.test')->withStaffs($staffs);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    	$excel->sheet('Sheet2', function($sheet) use($staffs) {

		        $sheet->loadView('dashboard.reports.test')->withStaffs($staffs);

		    });

	    })->export('xlsx');
    }

    public function generateProgramTopSheetPrimary()
    {
    	$staffs = User::where('role', 'staff')->get();

	    Excel::create('Program Top Sheet (Primary)', function($excel) use($staffs) {
	    	$excel->sheet('Sheet1', function($sheet) use($staffs) {

		        $sheet->loadView('dashboard.reports.branchtopsheetprimary')->withStaffs($staffs);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    	// $excel->sheet('Sheet2', function($sheet) use($staffs) {

		    //     $sheet->loadView('dashboard.reports.test')->withStaffs($staffs);

		    // });

	    })->export('xlsx');
    }

    public function generateProgramTopSheetProduct()
    {
    	$staffs = User::where('role', 'staff')->get();

	    Excel::create('Program Top Sheet (Product)', function($excel) use($staffs) {
	    	$excel->sheet('Sheet1', function($sheet) use($staffs) {

		        $sheet->loadView('dashboard.reports.branchtopsheetproduct')->withStaffs($staffs);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    	// $excel->sheet('Sheet2', function($sheet) use($staffs) {

		    //     $sheet->loadView('dashboard.reports.test')->withStaffs($staffs);

		    // });

	    })->export('xlsx');
    }

    public function generateProgramTopSheetsavings()
    {
    	$staffs = User::where('role', 'staff')->get();

	    Excel::create('Program Top Sheet (Savings)', function($excel) use($staffs) {
	    	$excel->sheet('Sheet1', function($sheet) use($staffs) {

		        $sheet->loadView('dashboard.reports.branchtopsheetsavings')->withStaffs($staffs);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    	// $excel->sheet('Sheet2', function($sheet) use($staffs) {

		    //     $sheet->loadView('dashboard.reports.test')->withStaffs($staffs);

		    // });

	    })->export('xlsx');
    }

    public function getTransactionSummaryPage() {
    	return view('dashboard.reports.transactionsummarypage');
    }

    public function generateTransactionSummary(Request $request)
    {
    	$this->validate($request, [
    	  'datetocalc' => 'required'
    	]);

    	$staffs = User::where('role', 'staff')->get();
    	$datetocalc = date('Y-m-d', strtotime($request->datetocalc));
    	$loaninstallments = Loaninstallment::where('due_date', $datetocalc)->get();
    	$savinginstallments = Savinginstallment::where('due_date', $datetocalc)->get();
    	$totalloans = Loan::where('disburse_date', $datetocalc)->get();
    	$totalmembers = Member::where('admission_date', $datetocalc)->get();
    	$totalclosingmembers = Member::where('closing_date', $datetocalc)->get();

	    // return view('dashboard.reports.transactionsummary3')
	    //                 ->withStaffs($staffs)
	    //                 ->withDatetocalc($datetocalc)
	    //                 ->withLoaninstallments($loaninstallments)
	    //                 ->withSavinginstallments($savinginstallments)
	    //                 ->withTotalloans($totalloans)
	    //                 ->withTotalmembers($totalmembers)
	    //                 ->withTotalclosingmembers($totalclosingmembers);


	    Excel::create('Transaction Summary', function($excel) use($staffs, $datetocalc, $loaninstallments, $savinginstallments, $totalloans, $totalmembers, $totalclosingmembers) 
	    {
	    	$excel->sheet('Loan Collection', function($sheet) use($staffs, $datetocalc) 
	    	{
		        $sheet->loadView('dashboard.reports.transactionsummary1')->withStaffs($staffs)
	                    												->withDatetocalc($datetocalc);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    	$excel->sheet('Savings and Others', function($sheet) use($staffs, $datetocalc) 
	    	{
		        $sheet->loadView('dashboard.reports.transactionsummary2')->withStaffs($staffs)
	                    												 ->withDatetocalc($datetocalc);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    	$excel->sheet('Staff Wise', function($sheet) use($staffs, $datetocalc, $loaninstallments, $savinginstallments, $totalloans, $totalmembers, $totalclosingmembers) 
	    	{
		        $sheet->loadView('dashboard.reports.transactionsummary3')->withStaffs($staffs)
													                     ->withDatetocalc($datetocalc)
													                     ->withLoaninstallments($loaninstallments)
													                     ->withSavinginstallments($savinginstallments)
													                     ->withTotalloans($totalloans)
													                     ->withTotalmembers($totalmembers)
													                     ->withTotalclosingmembers($totalclosingmembers);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });

	    })->export('xlsx');
    }

    public function generateGroupLoanBalanceSheet($s_id, $g_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
    	$datetocalc = date('Y-m-d');

	    // return view('dashboard.reports.loanbalancesheet1')
	    //                 ->withStaff($staff)
	    //                 ->withGroup($group)
	    //                 ->withDatetocalc($datetocalc);

	    Excel::create('Loan Balance Sheet', function($excel) use($staff, $group, $datetocalc) 
	    {
	    	$excel->sheet('Primary Loan', function($sheet) use($staff, $group, $datetocalc) 
	    	{
		        $sheet->loadView('dashboard.reports.loanbalancesheet1')->withStaff($staff)
												                      ->withGroup($group)
												                      ->withDatetocalc($datetocalc);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
		    $excel->sheet('Product Loan', function($sheet) use($staff, $group, $datetocalc) 
	    	{
		        $sheet->loadView('dashboard.reports.loanbalancesheet2')->withStaff($staff)
												                      ->withGroup($group)
												                      ->withDatetocalc($datetocalc);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    })->export('xlsx');
    }

    public function generateGroupSavingBalanceSheet($s_id, $g_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
    	$datetocalc = date('Y-m-d');

	    // return view('dashboard.reports.savingbalancesheet1')
	    //                 ->withStaff($staff)
	    //                 ->withGroup($group)
	    //                 ->withDatetocalc($datetocalc);

	    Excel::create('Saving Balance Sheet', function($excel) use($staff, $group, $datetocalc) 
	    {
	    	$excel->sheet('General Saving', function($sheet) use($staff, $group, $datetocalc) 
	    	{
		        $sheet->loadView('dashboard.reports.savingbalancesheet1')->withStaff($staff)
												                      ->withGroup($group)
												                      ->withDatetocalc($datetocalc);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
		    $excel->sheet('Long Term Saving', function($sheet) use($staff, $group, $datetocalc) 
	    	{
		        $sheet->loadView('dashboard.reports.savingbalancesheet2')->withStaff($staff)
												                      ->withGroup($group)
												                      ->withDatetocalc($datetocalc);
		        $sheet->setStyle(array(
		            'font' => array(
		                'name'      =>  'Arial',
		                'size'      =>  10
		            )
		        ));
		    });
	    })->export('xlsx');
    }

    public function generateStaffTopSheet($s_id)
    {
    	$staff = User::find($s_id);

	    // return view('dashboard.reports.stafftopsheet2')
	    //                 ->withStaff($staff);

        Excel::create('Staff Top Sheet', function($excel) use($staff) {
        	$excel->sheet('Sheet1', function($sheet) use($staff) {

    	        $sheet->loadView('dashboard.reports.stafftopsheet1')->withStaff($staff);
    	        $sheet->setStyle(array(
    	            'font' => array(
    	                'name'      =>  'Arial',
    	                'size'      =>  10
    	            )
    	        ));
    	    });
    	    $excel->sheet('Sheet2', function($sheet) use($staff) {

    	        $sheet->loadView('dashboard.reports.stafftopsheet2')->withStaff($staff);
    	        $sheet->setStyle(array(
    	            'font' => array(
    	                'name'      =>  'Arial',
    	                'size'      =>  10
    	            )
    	        ));
    	    });
        	// $excel->sheet('Sheet2', function($sheet) use($staffs) {

    	    //     $sheet->loadView('dashboard.reports.test')->withStaffs($staffs);

    	    // });

        })->export('xlsx');
    }

    public function dailySummary($transactiondate) 
    {
        // loan calculation
        $allloans = Loan::all();
        $primaryloanids = [];
        $productloanids = [];
        foreach ($allloans as $loan) {
        	if($loan->loanname_id == 1) {
        		$primaryloanids[] = $loan->id;
        	} elseif($loan->loanname_id == 2) {
        		$productloanids[] = $loan->id;
        	}
        }

        $dailyotheramounts = Dailyotheramount::where('due_date', date('Y-m-d', strtotime($transactiondate)))->first();

        // collection
        $totalprimaryloancollection = DB::table("loaninstallments")
							      	    ->select(DB::raw("SUM(paid_total) as total"))
							      	    ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
							      	    ->whereIn('loan_id', $primaryloanids)
							      	    ->first();
		$totalproductloancollection = DB::table("loaninstallments")
							      	    ->select(DB::raw("SUM(paid_total) as total"))
							      	    ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
							      	    ->whereIn('loan_id', $productloanids)
							      	    ->first();
		$totalloancollection = DB::table("loaninstallments")
					      	     ->select(DB::raw("SUM(paid_total) as total"))
					      	     ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
					      	     ->first();

		//saving calculation
	    $totalgeneralsavingcollection = DB::table("savinginstallments")
							      	      ->select(DB::raw("SUM(amount) as total"))
							      	      ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
							      	      ->where('savingname_id', 1)
							      	      ->first();
	    $totallongtermsavingcollection = DB::table("savinginstallments")
							      	      ->select(DB::raw("SUM(amount) as total"))
							      	      ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
							      	      ->where('savingname_id', 2)
							      	      ->first();
	    $totalsavingcollection = DB::table("savinginstallments")
					      	     ->select(DB::raw("SUM(amount) as total"))
					      	     ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
					      	     ->first();
		//saving calculation

		$totalinsurance = DB::table("loans")
					      	    ->select(DB::raw("SUM(insurance) as total"))
					      	    ->where('disburse_date', date('Y-m-d', strtotime($transactiondate)))
					      	    ->where('loanname_id', 1)
					      	    ->first();
		$totalprocessingfee = DB::table("loans")
					      	    ->select(DB::raw("SUM(processing_fee) as total"))
					      	    ->where('disburse_date', date('Y-m-d', strtotime($transactiondate)))
					      	    ->where('loanname_id', 1)
					      	    ->first();	
		$totaladmissionfee = DB::table("members")
					      	    ->select(DB::raw("SUM(admission_fee) as total"))
					      	    ->where('admission_date', date('Y-m-d', strtotime($transactiondate)))
					      	    ->first();
		$totalpassbookfee = DB::table("members")
					      	    ->select(DB::raw("SUM(passbook_fee) as total"))
					      	    ->where('admission_date', date('Y-m-d', strtotime($transactiondate)))
					      	    ->first();
		$totalshareddeposit = DB::table("members")
					      	    ->select(DB::raw("SUM(shared_deposit) as total"))
					      	    ->where('admission_date', date('Y-m-d', strtotime($transactiondate)))
					      	    ->first();
		$totaldownpayment = DB::table("loans")
				      	      ->select(DB::raw("SUM(down_payment) as total"))
				      	      ->where('disburse_date', date('Y-m-d', strtotime($transactiondate)))
				      	      ->where('loanname_id', 2)
				      	      ->first();	
        // collection

        // disburse
		$totaldisbursed = DB::table("loans")
					      	    ->select(DB::raw("SUM(total_disbursed) as total"))
					      	    ->where('disburse_date', date('Y-m-d', strtotime($transactiondate)))
					      	    ->first();
	    $totalsavingwithdraw = DB::table("savinginstallments")
					      	     ->select(DB::raw("SUM(withdraw) as total"))
					      	     ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
					      	     ->first();
	    $totalgeneralsavingwithdraw = DB::table("savinginstallments")
							      	     ->select(DB::raw("SUM(withdraw) as total"))
							      	     ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
							      	     ->where('savingname_id', 1)
							      	     ->first();
	    $totallongtermsavingcwithdraw = DB::table("savinginstallments")
							      	      ->select(DB::raw("SUM(withdraw) as total"))
							      	      ->where('due_date', date('Y-m-d', strtotime($transactiondate)))
							      	      ->where('savingname_id', 2)
							      	      ->first();
		$totalshareddepositreturn = DB::table("members")
					      	    	  ->select(DB::raw("SUM(shared_deposit) as total"))
					      	   		  ->where('closing_date', date('Y-m-d', strtotime($transactiondate)))
					      	   		  ->first();
        // disburse

        // dd($totalpassbookfee);

        return view('dashboard.reports.dailyreport')
        					->withTransactiondate($transactiondate)
        					->withDailyotheramounts($dailyotheramounts)
        					->withTotalprimaryloancollection($totalprimaryloancollection)
        					->withTotalproductloancollection($totalproductloancollection)
        					->withTotalloancollection($totalloancollection)
        					->withTotalgeneralsavingcollection($totalgeneralsavingcollection)
        					->withTotallongtermsavingcollection($totallongtermsavingcollection)
        					->withTotalsavingcollection($totalsavingcollection)
        					->withTotalinsurance($totalinsurance)
        					->withTotalprocessingfee($totalprocessingfee)
        					->withTotaladmissionfee($totaladmissionfee)
        					->withTotalpassbookfee($totalpassbookfee)
        					->withTotalshareddeposit($totalshareddeposit)
        					->withTotaldownpayment($totaldownpayment)
        					->withTotaldisbursed($totaldisbursed)
        					->withTotalsavingwithdraw($totalsavingwithdraw)
        					->withTotalgeneralsavingwithdraw($totalgeneralsavingwithdraw)
        					->withTotallongtermsavingcwithdraw($totallongtermsavingcwithdraw)
        					->withTotalshareddepositreturn($totalshareddepositreturn);
    }

    public function postDailyOtherAmounts(Request $request)
    {
    	$dailyotheramounts = Dailyotheramount::where('due_date', $request->data['transactiondate'])->first();

    	if(!empty($dailyotheramounts)) {
    	    $dailyotheramounts->cashinhand = $request->data['cashinhand'];
    	    $dailyotheramounts->collentionothers = $request->data['collentionothers'];
    	    $dailyotheramounts->disburseothers = $request->data['disburseothers'];
    	    $dailyotheramounts->save();
    	} else {
    	    $newdailyotheramounts = new Dailyotheramount;
    	    $newdailyotheramounts->due_date = date('Y-m-d', strtotime($request->data['transactiondate']));
    	    $newdailyotheramounts->cashinhand = $request->data['cashinhand'];
    	    $newdailyotheramounts->collentionothers = $request->data['collentionothers'];
    	    $newdailyotheramounts->disburseothers = $request->data['disburseothers'];
    	    $newdailyotheramounts->save();            
    	}

    	return 'success';
    }
}
