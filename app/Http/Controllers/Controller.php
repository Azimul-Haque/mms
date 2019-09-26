<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\User;
use Auth;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    public function __construct() {
      $staffs = User::where('role', 'staff')->orderBy('id', 'asc')->get();

      // $due_orders = '';
      // if(Auth::check() && Auth::user()->role == 'admin') {
      //   $due_orders = Order::where('paymentstatus', '=', 'not-paid')->count();
      //   $completed_orders = Order::where('paymentstatus', '=', 'paid')->count();
      // } 
      // else {
      //   $due_orders = collect(new Order);
      //   $completed_orders = collect(new Order);
      // }

      // share with all view
      View::share('staffs', $staffs);
      // View::share('due_orders', $due_orders);
      // View::share('completed_orders', $completed_orders);
    }
}
