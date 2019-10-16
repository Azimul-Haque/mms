@extends('adminlte::page')

@section('title', 'Add Member | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Add Member [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>]
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-10">
        <div class="panel panel-primary">
          <div class="panel-heading">Add Member</div>
          {!! Form::open(['route' => ['dashboard.members.store', $staff->id, $group->id], 'method' => 'POST']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('name', 'Member Name *') !!}
                {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('fhusband', 'Fatehr/ Husband Name *') !!}
                {!! Form::text('fhusband', null, array('class' => 'form-control', 'required' => '')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('ishusband', 'Is Husband *') !!}<br/>
                <label class="radio-inline">
                  <input type="radio" name="ishusband" id="ishusband" value="1" checked> Yes
                </label>
                <label class="radio-inline">
                  <input type="radio" name="ishusband" id="ishusband" value="0"> No
                </label>
              </div>
              <div class="col-md-6">
                {!! Form::label('mother', 'Mother Name *') !!}
                {!! Form::text('mother', null, array('class' => 'form-control', 'required' => '')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('admission_date', 'Admission Date *') !!}
                {!! Form::text('admission_date', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('dob', 'Date of Birth *') !!}
                {!! Form::text('dob', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('marital_status', 'Marital Status *') !!}
                <select name="marital_status" class="form-control" required>
                  <option selected="" disabled="">Select Marital Status</option>
                  <option value="0">Unmarried</option>
                  <option value="1">Married</option>
                  <option value="2">Divorced</option>
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('religion', 'Religion *') !!}
                <select name="religion" class="form-control" required>
                  <option selected="" disabled="">Select Religion</option>
                  <option value="0">Islam</option>
                  <option value="1">Hinduism</option>
                  <option value="2">Christianity</option>
                  <option value="3">Buddhism</option>
                  <option value="4">Others</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('ethnicity', 'Ethnicity *') !!}
                <select name="ethnicity" class="form-control" required>
                  <option selected="" disabled="">Select Marital Status</option>
                  <option value="0">Non-tribal</option>
                  <option value="1">Tribal</option>
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('guardian', 'Guardian *') !!}
                {!! Form::text('guardian', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('nid', 'National ID No *') !!}
                {!! Form::text('nid', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off', 'onkeypress' => 'if(this.value.length==17) return false;')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('education', 'Education *') !!}
                {!! Form::text('education', null, array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}
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
      $("#admission_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
      $("#dob").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#user_id').select2();
  </script>
@endsection