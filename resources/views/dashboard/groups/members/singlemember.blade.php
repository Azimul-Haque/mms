@extends('adminlte::page')

@section('title', $member->name . ' | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>Member: <b>{{ $member->name }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b></h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-exchange"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Daily</span>
              <span class="info-box-number">Transaction</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.member.loans', [$staff->id, $group->id, $member->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Loan</span>
              <span class="info-box-number">Account</span>
            </div>
          </div>
        </a>
      </div>

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.member.savings', [$staff->id, $group->id, $member->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-database"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Saving</span>
              <span class="info-box-number">Accounts</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-address-book-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">View</span>
              <span class="info-box-number">Member</span>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        {{-- <a href="#!">
        	<div class="info-box">
        	  <span class="info-box-icon bg-aqua"><i class="fa fa-address-book-o"></i></span>
        	  <div class="info-box-content">
        	    <span class="info-box-text">View</span>
        	    <span class="info-box-number">Member</span>
        	  </div>
        	</div>
        </a> --}}
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
     {{--    <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user-times"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Bad</span>
              <span class="info-box-number">Debt</span>
            </div>
          </div>
    	  </a> --}}
      </div>

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
   {{--      <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-cogs"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Transfer</span>
              <span class="info-box-number">to Bad Debt</span>
            </div>
          </div>
    	  </a> --}}
      </div>
      {{-- <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-address-book-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">At A</span>
              <span class="info-box-number">Glance</span>
            </div>
          </div>
    	  </a>
      </div> --}}
    </div>
@stop

@section('js')

@endsection