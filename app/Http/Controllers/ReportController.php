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

    public function generateTransactionSummary()
    {
    	$staffs = User::where('role', 'staff')->get();
    	$datetocalc = date('Y-m-d');

	    // return view('dashboard.reports.transactionsummary1')
	    //                 ->withStaffs($staffs)
	    //                 ->withDatetocalc($datetocalc);

	    // return view('dashboard.reports.transactionsummary2')
	    //                 ->withStaffs($staffs)
	    //                 ->withDatetocalc($datetocalc);

	    Excel::create('Transaction Summary', function($excel) use($staffs, $datetocalc) 
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
}
