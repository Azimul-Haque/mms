@extends('adminlte::page')

@section('title', 'Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>Group Features: <b>{{ $group->name }}</b></h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.members', [$sid ,$group->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Member</span>
              <span class="info-box-number">List</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-exchange"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Group</span>
              <span class="info-box-number">Transaction</span>
            </div>
          </div>
        </a>
      </div>

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-id-card"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Master</span>
              <span class="info-box-number">Roll</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-address-book-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Member</span>
              <span class="info-box-number">Summary</span>
            </div>
          </div>
        </a>
      </div>
    </div>
@stop