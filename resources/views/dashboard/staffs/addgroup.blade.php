@extends('adminlte::page')

@section('title', 'Add Group | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Add Group
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-8">
        <div class="panel panel-primary">
          <div class="panel-heading">Add Group</div>
          {!! Form::open(['route' => 'dashboard.staffs.addgroup', 'method' => 'POST']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">


                {!! Form::label('name', 'Group Name *') !!}
                {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
                {!! Form::hidden('routeto', $routeto) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('formation', 'Formation Date *') !!}
                {!! Form::text('formation', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
            </div>
            <div class="row">
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
            {{-- <div class="row">
              <div class="col-md-6">
                {!! Form::label('min_savings_dep', 'Minimum Savings Deposit *') !!}
                {!! Form::number('min_savings_dep', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('min_security_dep', 'Minimum Security Deposit *') !!}
                {!! Form::number('min_security_dep', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
            </div> --}}
            <br/>
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
              <div class="col-md-6">
                {!! Form::label('user_id', 'Assign Staff *') !!}
                <select name="user_id" id="user_id" class="form-control" required>
                  <option disabled="">Select Staff</option>
                  <option value="{{ $staff->id }}" selected="">{{ $staff->name }}</option>
                </select>
              </div>
            </div>
            
            
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
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript">
    $(function() {
      $("#formation").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#user_id').select2();
  </script>
@endsection