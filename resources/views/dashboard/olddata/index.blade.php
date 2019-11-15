@extends('adminlte::page')

@section('title', 'Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Old Data Entry
      <div class="pull-right">
        <a href="{{ route('olddata.create') }}" class="btn btn-success"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Member</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3">
      
    </div>
  </div>
@stop