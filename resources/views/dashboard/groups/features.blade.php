@extends('adminlte::page')

@section('title', 'Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>Group Features [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>]</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.members.create', [$staff->id, $group->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-plus"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Member</span>
              <span class="info-box-number">Admission</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.members', [$staff->id, $group->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Member</span>
              <span class="info-box-number">List</span>
            </div>
          </div>
        </a>
      </div>

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        @php
          $totalprim = 0;
          $totalprod = 0;
          $defaultselected = 1;
          foreach ($group->members as $member) {
            foreach ($member->loans as $loan) {
              if($loan->loanname_id == 1) {
                $totalprim++;
              } elseif($loan->loanname_id == 2) {
                $totalprod++;
              }
            }
          }
          if($totalprim >= $totalprod) {
            $defaultselected = 1;
          } else {
            $defaultselected = 2;
          }
        @endphp
        <a href="{{ route('dashboard.grouptransactions.date', [$staff->id, $group->id, $defaultselected, date('Y-m-d')]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-exchange"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Group</span>
              <span class="info-box-number">Transaction</span>
            </div>
          </div>
        </a>
       
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.members.passbooklist', [$staff->id, $group->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-pencil-square"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Update</span>
              <span class="info-box-number">PassBook</span>
            </div>
          </div>
        </a>
      </div>
    </div>


    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-percent"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Savings</span>
              <span class="info-box-number">Interest</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.group.gertransferpage', [$staff->id, $group->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-paper-plane"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Transfer</span>
              <span class="info-box-number">Group</span>
            </div>
          </div>
        </a>
      </div>
      

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('report.group.loanbalancesheet', [$staff->id, $group->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Loan</span>
              <span class="info-box-number">Balance Sheet</span>
            </div>
          </div>
        </a>
       
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('report.group.savingbalancesheet', [$staff->id, $group->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-database"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Savings</span>
              <span class="info-box-number">Balance Sheet</span>
            </div>
          </div>
        </a>
      </div>
    </div>

@stop