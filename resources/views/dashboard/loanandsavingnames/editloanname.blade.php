@extends('adminlte::page')

@section('title', 'Edit Loan Name | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Edit Loan Name
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Edit Loan Name</div>
          {!! Form::model($loanname, ['route' => ['dashboard.loannames.update', $loanname->id], 'method' => 'PUT']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                {!! Form::label('name', 'Loan Name *') !!}
                {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
              </div>
            </div><br/>
            {{-- <div class="row">
              <div class="col-md-6">
                <select name="installment_type" class="form-control" required>
                  <option selected="" disabled="">Default Installment Type *</option>
                  <option value="1" @if($loanname->installment_type == 1) selected="" @endif>Weekly</option>
                  <option value="2" @if($loanname->installment_type == 2) selected="" @endif>Fortnightly</option>
                  <option value="3" @if($loanname->installment_type == 3) selected="" @endif>Monthly</option>
                </select>
              </div>
            </div> --}}
            {{-- <div class="row">
              <div class="col-md-6">
                {!! Form::label('meeting_day', 'Meeting Day *') !!}
                <select name="meeting_day" class="form-control" required>
                  <option selected="" disabled="">Select Meeting Day</option>
                  <option value="1">Saturday</option>
                  <option value="2">Sunday</option>
                  <option value="3">Monday</option>
                  <option value="4">Tuesday</option>
                  <option value="5">Wednesday</option>
                  <option value="6">Thursday</option>
                  <option value="7">Friday</option>
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('village', 'Village *') !!}
                {!! Form::text('village', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('min_savings_dep', 'Minimum Savings Deposit *') !!}
                {!! Form::number('min_savings_dep', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('min_security_dep', 'Minimum Security Deposit *') !!}
                {!! Form::number('min_security_dep', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
            </div><br/>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('status', 'Status *') !!}<br/>
                <label class="radio-inline">
                  <input type="radio" name="status" id="status" value="1" checked> Active
                </label>
                <label class="radio-inline">
                  <input type="radio" name="status" id="status" value="0"> Inactive
                </label>
              </div>
            </div>--}}
            
            
          </div>
          <div class="panel-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="col-md-4">

      </div>
    </div>
@stop

@section('js')

@endsection