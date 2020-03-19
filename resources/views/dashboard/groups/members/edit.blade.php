@extends('adminlte::page')

@section('title', 'Edit Member | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Edit Member [<b>{{ $member->name }}-{{ $member->fhusband }} ({{ $member->passbook }})</b></b>]
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">Edit Member</div>
        {!! Form::model($member, ['route' => ['dashboard.members.update', $member->id], 'method' => 'PUT']) !!}
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              {!! Form::label('passbook', 'Passbook No *') !!}
              {!! Form::number('passbook', null, array('class' => 'form-control', 'placeholder' => 'Passbook No', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('name', 'Member Name *') !!}
              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Member Name', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('fhusband', 'Father/ Husband Name *') !!}
              {!! Form::text('fhusband', null, array('class' => 'form-control', 'placeholder' => 'Father/ Husband Name', 'required' => '')) !!}
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {!! Form::label('admission_date', 'Admission Date *') !!}
              {!! Form::text('admission_date', date('F d, Y', strtotime($member->admission_date)), array('class' => 'form-control', 'placeholder' => 'Admission Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('closing_date', 'Closing Date (Optional)') !!}
              @if($member->closing_date == '1970-01-01')
                {!! Form::text('closing_date', '', array('class' => 'form-control', 'placeholder' => 'Closing Date (Optional)', 'autocomplete' => 'off', 'readonly' => '')) !!}
              @else
                {!! Form::text('closing_date', date('F d, Y', strtotime($member->closing_date)), array('class' => 'form-control', 'placeholder' => 'Closing Date (Optional)', 'autocomplete' => 'off', 'readonly' => '')) !!}
              @endif
              
            </div>
            <div class="col-md-4">
              {!! Form::label('ishusband', 'Is Husband *') !!}<br/>
              <label class="radio-inline">
                <input type="radio" name="ishusband" id="ishusband" value="1" checked> Yes
              </label>
              <label class="radio-inline">
                <input type="radio" name="ishusband" id="ishusband" value="0"> No
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12"><br/>
              <big><b><u>Present Address</u></b></big><br/>
            </div>
            <div class="col-md-4">
              {!! Form::label('present_district', 'Present District *') !!}
              {!! Form::text('present_district', 'Thakurgaon', array('class' => 'form-control', 'placeholder' => 'Present District', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('present_upazilla', 'Present Upazilla *') !!}
              {!! Form::text('present_upazilla', 'Thakurgaon Sadar', array('class' => 'form-control', 'placeholder' => 'Present Upazilla', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('present_village', 'Present Village *') !!}
              {!! Form::text('present_village', null, array('class' => 'form-control', 'placeholder' => 'Present Village', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('present_phone', 'Present Phone *') !!}
              {!! Form::text('present_phone', null, array('class' => 'form-control', 'placeholder' => 'Present Phone', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('passbook_fee', 'PassBook Fee') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {{-- <input id="passbook_fee" type="text" class="form-control" name="passbook_fee" placeholder="PassBook Fee" value="20"> --}}
                {!! Form::text('passbook_fee', null, array('class' => 'form-control', 'placeholder' => 'PassBook Fee', 'required' => '')) !!}
              </div>
            </div>
            <div class="col-md-4">
              {!! Form::label('admission_fee', 'Admission Fee') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {{-- <input id="admission_fee" type="text" class="form-control" name="admission_fee" placeholder="Admission Fee" value="30"> --}}
                {!! Form::text('admission_fee', null, array('class' => 'form-control', 'placeholder' => 'Admission Fee', 'required' => '')) !!}
              </div>
            </div>
            <div class="col-md-4">
              {!! Form::label('shared_deposit', 'Shared Deposit *') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {{-- <input id="shared_deposit" type="text" class="form-control" name="shared_deposit" placeholder="Shared Deposit" required=""> --}}
                {!! Form::text('shared_deposit', null, array('class' => 'form-control', 'placeholder' => 'Shared Deposit', 'required' => '')) !!}
              </div>
            </div>
          </div>

            
          {{-- <div class="row">
            <div class="col-md-4">
              {!! Form::label('passbook', 'Passbook No *') !!}
              {!! Form::number('passbook', null, array('class' => 'form-control', 'placeholder' => 'Passbook No', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('name', 'Member Name *') !!}
              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Member Name', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('fhusband', 'Father/ Husband Name *') !!}
              {!! Form::text('fhusband', null, array('class' => 'form-control', 'placeholder' => 'Father/ Husband Name', 'required' => '')) !!}
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {!! Form::label('ishusband', 'Is Husband *') !!}<br/>
              <label class="radio-inline">
                <input type="radio" name="ishusband" id="ishusband" value="1" checked> Yes
              </label>
              <label class="radio-inline">
                <input type="radio" name="ishusband" id="ishusband" value="0"> No
              </label>
            </div>
            <div class="col-md-4">
              {!! Form::label('mother', 'Mother Name *') !!}
              {!! Form::text('mother', null, array('class' => 'form-control', 'placeholder' => 'Mother Name', 'required' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('gender', 'Gender *') !!}
              <select name="gender" class="form-control" required="">
                <option value="" selected="" disabled="">Select Gender</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
                <option value="0">Other</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {!! Form::label('admission_date', 'Admission Date *') !!}
              {!! Form::text('admission_date', date('F d, Y'), array('class' => 'form-control', 'placeholder' => 'Admission Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('closing_date', 'Closing Date (Optional)') !!}
              {!! Form::text('closing_date', null, array('class' => 'form-control', 'placeholder' => 'Closing Date (Optional)', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
              {!! Form::label('residence_type', 'Residence Type (Optional)') !!}
              {!! Form::text('residence_type', null, array('class' => 'form-control', 'placeholder' => 'Residence Type (Optional)', 'autocomplete' => 'off')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('education', 'Education *') !!}
              {!! Form::text('education', null, array('class' => 'form-control', 'placeholder' => 'Education', 'required' => '', 'autocomplete' => 'off')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('profession', 'Profession *') !!}
              {!! Form::text('profession', null, array('class' => 'form-control', 'placeholder' => 'Profession', 'required' => '', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {!! Form::label('nid', 'National ID No *') !!}
              {!! Form::text('nid', null, array('class' => 'form-control', 'placeholder' => 'National ID No', 'required' => '', 'autocomplete' => 'off', 'onkeypress' => 'if(this.value.length==17) return false;')) !!}
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <big><b><u>Present Address</u></b></big><br/>
              {!! Form::label('present_district', 'Present District *') !!}
              {!! Form::text('present_district', 'Thakurgaon', array('class' => 'form-control', 'placeholder' => 'Present District', 'required' => '')) !!}
              {!! Form::label('present_upazilla', 'Present Upazilla *') !!}
              {!! Form::text('present_upazilla', null, array('class' => 'form-control', 'placeholder' => 'Present Upazilla', 'required' => '')) !!}
              {!! Form::label('present_union', 'Present Union *') !!}
              {!! Form::text('present_union', null, array('class' => 'form-control', 'placeholder' => 'Present Union', 'required' => '')) !!}
              {!! Form::label('present_post', 'Present Post Office *') !!}
              {!! Form::text('present_post', null, array('class' => 'form-control', 'placeholder' => 'Present Post Office', 'required' => '')) !!}
              {!! Form::label('present_village', 'Present Village *') !!}
              {!! Form::text('present_village', null, array('class' => 'form-control', 'placeholder' => 'Present Village', 'required' => '')) !!}
              {!! Form::label('present_phone', 'Present Phone *') !!}
              {!! Form::text('present_phone', null, array('class' => 'form-control', 'placeholder' => 'Present Phone', 'required' => '')) !!}<br/>
              {!! Form::label('passbook_fee', 'PassBook Fee') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                <input id="passbook_fee" type="text" class="form-control" name="passbook_fee" placeholder="PassBook Fee" value="20">
              </div><br/>
              {!! Form::label('shared_deposit', 'Shared Deposit *') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                <input id="shared_deposit" type="text" class="form-control" name="shared_deposit" placeholder="Shared Deposit" required="">
              </div>
            </div>
            <div class="col-md-6">
              <big><b><u>Permanent Address (Optional)</u></b></big><br/>
              {!! Form::label('permanent_district', 'Permanent District') !!}
              {!! Form::text('permanent_district', 'Thakurgaon', array('class' => 'form-control', 'placeholder' => 'Permanent District')) !!}
              {!! Form::label('permanent_upazilla', 'Permanent Upazilla') !!}
              {!! Form::text('permanent_upazilla', null, array('class' => 'form-control', 'placeholder' => 'Permanent Upazilla')) !!}
              {!! Form::label('permanent_union', 'Permanent Union') !!}
              {!! Form::text('permanent_union', null, array('class' => 'form-control', 'placeholder' => 'Permanent Union')) !!}
              {!! Form::label('permanent_post', 'Permanent Post Office') !!}
              {!! Form::text('permanent_post', null, array('class' => 'form-control', 'placeholder' => 'Permanent Post Office')) !!}
              {!! Form::label('permanent_village', 'Permanent Village') !!}
              {!! Form::text('permanent_village', null, array('class' => 'form-control', 'placeholder' => 'Permanent Village ')) !!}
              {!! Form::label('permanent_phone', 'Permanent Phone (Optional)') !!}
              {!! Form::text('permanent_phone', null, array('class' => 'form-control', 'placeholder' => 'Permanent Phone (Optional)' )) !!}<br/>
              {!! Form::label('admission_fee', 'Admission Fee') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                <input id="admission_fee" type="text" class="form-control" name="admission_fee" placeholder="Admission Fee" value="30">
              </div>
            </div>
          </div> --}}
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
        clearBtn: true,
      });
      $("#dob").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#closing_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
    });

    $('#user_id').select2();
  </script>
@endsection