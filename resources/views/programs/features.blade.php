@extends('adminlte::page')

@section('title', 'Microfinance Management')

@section('content_header')
    <h1>Program Features</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#!">
          	<div class="info-box">
          	  <span class="info-box-icon bg-aqua"><i class="fa fa-file-text-o"></i></span>

          	  <div class="info-box-content">
          	    <span class="info-box-text">Monthly</span>
          	    <span class="info-box-number">Report</span>
          	  </div>
          	</div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#!">
	          <div class="info-box">
	            <span class="info-box-icon bg-red"><i class="fa fa-exchange"></i></span>

	            <div class="info-box-content">
	              <span class="info-box-text">Transaction</span>
	              <span class="info-box-number">Summary</span>
	            </div>
	          </div>
      	  </a>
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#!">
	          <div class="info-box">
	            <span class="info-box-icon bg-green"><i class="fa fa-user-times"></i></span>

	            <div class="info-box-content">
	              <span class="info-box-text">Bad Debt</span>
	              <span class="info-box-number">Report</span>
	            </div>
	          </div>
      	  </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#!">
	          <div class="info-box">
	            <span class="info-box-icon bg-yellow"><i class="fa fa-address-book-o"></i></span>

	            <div class="info-box-content">
	              <span class="info-box-text">At A</span>
	              <span class="info-box-number">Glance</span>
	            </div>
	          </div>
      	  </a>
        </div>
      </div>
@stop