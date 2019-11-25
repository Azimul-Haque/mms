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
    public function test()
    {
    	$staffs = User::where('role', 'staff')->get();

	    Excel::create('test_file', function($excel) use($staffs) {
	    	$excel->sheet('New sheet', function($sheet) use($staffs) {

		        $sheet->loadView('dashboard.reports.test')->withStaffs($staffs);

		    });

	    })->export('xlsx');
    }
}
