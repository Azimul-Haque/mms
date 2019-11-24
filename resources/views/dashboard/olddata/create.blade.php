@extends('adminlte::page')

@section('title', 'Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>Old Data Entry | Add Old Member</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">Add Member</div>
        {!! Form::open(['route' => ['olddata.store'], 'method' => 'POST']) !!}
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              {!! Form::label('group_id', 'Group *') !!}
              <select name="group_id" class="form-control" required>
                <option value="" selected="" disabled="">Select Group</option>
                @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
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
              {!! Form::label('fhusband', 'Fatehr/ Husband Name *') !!}
              {!! Form::text('fhusband', null, array('class' => 'form-control', 'placeholder' => 'Fatehr/ Husband Name', 'required' => '')) !!}
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
          {{--   <div class="col-md-4">
              {!! Form::label('dob', 'Date of Birth *') !!}
              {!! Form::text('dob', null, array('class' => 'form-control', 'placeholder' => 'Date of Birth', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div> --}}
            <div class="col-md-4">
              {!! Form::label('admission_date', 'Admission Date *') !!}
              {!! Form::text('admission_date', null, array('class' => 'form-control', 'placeholder' => 'Admission Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
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
            {{-- <div class="col-md-4">
              {!! Form::label('marital_status', 'Marital Status *') !!}
              <select name="marital_status" class="form-control" required>
                <option selected="" disabled="">Select Marital Status</option>
                <option value="0">Unmarried</option>
                <option value="1">Married</option>
                <option value="2">Divorced</option>
              </select>
            </div> --}}
            {{-- <div class="col-md-4">
              {!! Form::label('ethnicity', 'Ethnicity *') !!}
              <select name="ethnicity" class="form-control" required>
                <option selected="" disabled="">Select Marital Status</option>
                <option value="0">Non-tribal</option>
                <option value="1">Tribal</option>
              </select>
            </div> --}}
          </div>
          <div class="row">
            {{-- <div class="col-md-4">
              {!! Form::label('guardian', 'Guardian *') !!}
              {!! Form::text('guardian', null, array('class' => 'form-control', 'placeholder' => 'Guardian', 'required' => '', 'autocomplete' => 'off')) !!}
            </div>
            <div class="col-md-4">
              {!! Form::label('guardianrelation', 'Guardian Relation *') !!}
              {!! Form::text('guardianrelation', null, array('class' => 'form-control', 'placeholder' => 'Guardian Relation', 'required' => '', 'autocomplete' => 'off')) !!}
            </div> --}}
            
          </div>
          <div class="row">
        {{--     <div class="col-md-4">
              {!! Form::label('landlord_name', 'Landlord Name (Optional)') !!}
              {!! Form::text('landlord_name', null, array('class' => 'form-control', 'placeholder' => 'Landlord Name (Optional)', 'autocomplete' => 'off')) !!}
            </div> --}}
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
              {{-- {!! Form::label('present_house', 'Present House *') !!}
              {!! Form::text('present_house', null, array('class' => 'form-control', 'placeholder' => 'Present House', 'required' => '')) !!} --}}
              {!! Form::label('present_phone', 'Present Phone *') !!}
              {!! Form::text('present_phone', null, array('class' => 'form-control', 'placeholder' => 'Present Phone', 'required' => '')) !!}<br/>
              {!! Form::label('passbook_fee', 'PassBook Fee') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                <input id="passbook_fee" type="text" class="form-control" name="passbook_fee" placeholder="PassBook Fee" value="20">
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
              {{-- {!! Form::label('permanent_house', 'Permanent House') !!}
              {!! Form::text('permanent_house', null, array('class' => 'form-control', 'placeholder' => 'Permanent House')) !!} --}}
              {!! Form::label('permanent_phone', 'Permanent Phone (Optional)') !!}
              {!! Form::text('permanent_phone', null, array('class' => 'form-control', 'placeholder' => 'Permanent Phone (Optional)' )) !!}<br/>
              {!! Form::label('addmission_fee', 'Admission Fee') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                <input id="addmission_fee" type="text" class="form-control" name="addmission_fee" placeholder="Admission Fee" value="30">
              </div>
            </div>
          </div>

          <div class="row">
            <br/><br/>
            
            <div class="col-md-12">
              <h3>Loans & Saving Accounts</h3>
            </div>
            <div class="col-md-3">
              <h4>Primary Loan Account (If Any)</h4>
              {!! Form::label('primary_loanname_id', 'Program') !!}
              <select name="primary_loanname_id" class="form-control">
                <option value="" disabled="">Select Program</option>
                <option value="1" selected="">PRIMARY LOAN</option>
              </select>
              
              {!! Form::label('primary_disburse_date', 'Disburse Date') !!}
              {!! Form::text('primary_disburse_date', null, array('class' => 'form-control', 'placeholder' => 'Disburse Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
              
              {!! Form::label('primary_installment_type', 'Installment Type') !!}
              <select name="primary_installment_type" id="primary_installment_type" class="form-control">
                <option value="" selected="" disabled="">Select Installment Type</option>
                <option value="1">Daily</option>
                <option value="2">Weekly</option>
                <option value="3">Monthly</option>
              </select>

              {!! Form::label('primary_installments', 'Installments (বাকি কিস্তি সংখ্যা)') !!}
              <select name="primary_installments" id="primary_installments" class="form-control">
                <option value="" selected="" disabled="">Select Number of Installments</option>
                @for($i=1;$i<=120;$i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>

              {!! Form::label('primary_first_installment_date', 'First Installment Date from Software') !!}
              {!! Form::text('primary_first_installment_date', null, array('class' => 'form-control', 'placeholder' => 'First Installment Date from Software', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('primary_schemename_id', 'Scheme') !!}
              <select name="primary_schemename_id" id="primary_schemename_id" class="form-control">
                <option value="" selected="" disabled="">Select Program</option>
                @foreach($schemenames as $schemename)
                  <option value="{{ $schemename->id }}">{{ $schemename->name }}</option>
                @endforeach
              </select>
              
              {!! Form::label('primary_principal_amount', 'Principal Amount') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('primary_principal_amount', null, array('class' => 'form-control', 'placeholder' => 'Principal Amount', 'onchange' => 'primaryCalculateTotalDisburse();')) !!}
              </div>

              {!! Form::label('primary_service_charge', 'Service Charge') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('primary_service_charge', null, array('class' => 'form-control', 'placeholder' => 'Service Charge', 'onchange' => 'primaryCalculateTotalDisburse();')) !!}
              </div>

              {!! Form::label('primary_total_disbursed', 'Total Disbursed Amount') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('primary_total_disbursed', null, array('class' => 'form-control', 'placeholder' => 'Total Disbursed Amount', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('primary_total_paid', 'Total Paid') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('primary_total_paid', 0, array('class' => 'form-control', 'placeholder' => 'Total Paid', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('primary_insurance', 'Insurance') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('primary_insurance', 0, array('class' => 'form-control', 'placeholder' => 'Total Paid', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('primary_processing_fee', 'Processing Fee') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('primary_processing_fee', 15, array('class' => 'form-control', 'placeholder' => 'Total Paid', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('primary_closing_date', 'Closing Date (Optional)') !!}
              {!! Form::text('primary_closing_date', null, array('class' => 'form-control', 'placeholder' => 'Closing Date (Optional)', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('primary_status', 'Status') !!}
              <select name="primary_status" class="form-control">
                <option value="" selected="" disabled="">Select Status</option>
                <option value="1">Disbursed</option>
                <option value="0">Closed</option>
              </select>
            </div>
            <div class="col-md-3">
              <h4>Product Loan Account (If Any)</h4>
              {!! Form::label('product_loanname_id', 'Program') !!}
              <select name="product_loanname_id" class="form-control">
                <option value="" disabled="">Select Program</option>
                <option value="2" selected="">PRODUCT LOAN</option>
              </select>
              
              {!! Form::label('product_disburse_date', 'Disburse Date') !!}
              {!! Form::text('product_disburse_date', null, array('class' => 'form-control', 'placeholder' => 'Disburse Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
              
              {!! Form::label('product_installment_type', 'Installment Type') !!}
              <select name="product_installment_type" id="product_installment_type" class="form-control">
                <option value="" selected="" disabled="">Select Installment Type</option>
                <option value="1">Daily</option>
                <option value="2">Weekly</option>
                <option value="3">Monthly</option>
              </select>

              {!! Form::label('product_installments', 'Installments (বাকি কিস্তি সংখ্যা)') !!}
              <select name="product_installments" id="product_installments" class="form-control">
                <option value="" selected="" disabled="">Select Number of Installments</option>
                @for($i=1;$i<=120;$i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>

              {!! Form::label('product_first_installment_date', 'First Installment Date from Software') !!}
              {!! Form::text('product_first_installment_date', null, array('class' => 'form-control', 'placeholder' => 'First Installment Date from Software', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('product_schemename_id', 'Scheme') !!}
              <select name="product_schemename_id" id="product_schemename_id" class="form-control">
                <option value="" selected="" disabled="">Select Program</option>
                @foreach($schemenames as $schemename)
                  <option value="{{ $schemename->id }}">{{ $schemename->name }}</option>
                @endforeach
              </select>
              
              {!! Form::label('product_principal_amount', 'Principal Amount') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('product_principal_amount', null, array('class' => 'form-control', 'placeholder' => 'Principal Amount', 'onchange' => 'productCalculateTotalDisburse();')) !!}
              </div>

              {!! Form::label('product_service_charge', 'Service Charge') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('product_service_charge', null, array('class' => 'form-control', 'placeholder' => 'Service Charge', 'onchange' => 'productCalculateTotalDisburse();')) !!}
              </div>

              {!! Form::label('product_down_payment', 'Down Payment') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('product_down_payment', null, array('class' => 'form-control', 'placeholder' => 'Down Payment (If PRODUCT)', 'autocomplete' => 'off', 'onchange' => 'productCalculateTotalDisburse();')) !!}
              </div>

              {!! Form::label('product_total_disbursed', 'Total Disbursed Amount') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('product_total_disbursed', null, array('class' => 'form-control', 'placeholder' => 'Total Disbursed Amount', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('product_total_paid', 'Total Paid') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('product_total_paid', 0, array('class' => 'form-control', 'placeholder' => 'Total Paid', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('product_closing_date', 'Closing Date (Optional)') !!}
              {!! Form::text('product_closing_date', null, array('class' => 'form-control', 'placeholder' => 'Closing Date (Optional)', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('product_status', 'Status') !!}
              <select name="product_status" class="form-control">
                <option value="" selected="" disabled="">Select Status</option>
                <option value="1">Disbursed</option>
                <option value="0">Closed</option>
              </select>
            </div>
            <div class="col-md-3">
              <h4>General Saving Account *</h4>
              {!! Form::label('general_savingname_id', 'Program *') !!}
              <select name="general_savingname_id" class="form-control" required="">
                <option value="" disabled="">Select Program</option>
                <option value="1" selected="">GENERAL ACCOUNT</option>
              </select>

              {!! Form::label('general_opening_date', 'Opening Date *') !!}
              {!! Form::text('general_opening_date', null, array('class' => 'form-control', 'placeholder' => 'Opening Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('general_installment_type', 'Installment Type *') !!}
              <select name="general_installment_type" class="form-control" required="">
                <option value="" selected="" disabled="">Select Installment Type</option>
                <option value="1">Daily</option>
                <option value="2">Weekly</option>
                <option value="3">Monthly</option>
              </select>

              {{-- {!! Form::label('general_meeting_day', 'Meeeting Day *') !!}
              <select name="general_meeting_day" class="form-control" required="">
                <option value="" selected="" disabled="">Select Meeeting Day</option>
                <option value="1">Saturday</option>
                <option value="2">Sunday</option>
                <option value="3">Monday</option>
                <option value="4">Tuesday</option>
                <option value="5">Wednesday</option>
                <option value="6">Thursday</option>
                <option value="7">Friday</option>
              </select> --}}

              {!! Form::label('general_closing_date', 'Closing Date (Optional)') !!}
              {!! Form::text('general_closing_date', null, array('class' => 'form-control', 'placeholder' => 'Closing Date', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('general_total_amount_so_far', 'Total Amount Saved') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('general_total_amount_so_far', 0, array('class' => 'form-control', 'placeholder' => 'Total Amount Saved', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('general_total_withdraw_so_far', 'Total Amount Withdraw') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('general_total_withdraw_so_far', 0, array('class' => 'form-control', 'placeholder' => 'Total Amount Withdraw', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="col-md-3">
              <h4>Long Term Saving Account (If Any)</h4>
              {!! Form::label('longterm_savingname_id', 'Program') !!}
              <select name="longterm_savingname_id" class="form-control">
                <option value="" disabled="">Select Program</option>
                <option value="2" selected="">LONG TERM ACCOUNT</option>
              </select>

              {!! Form::label('longterm_opening_date', 'Opening Date') !!}
              {!! Form::text('longterm_opening_date', null, array('class' => 'form-control', 'placeholder' => 'Opening Date', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('longterm_installment_type', 'Installment Type') !!}
              <select name="longterm_installment_type" class="form-control">
                <option value="" selected="" disabled="">Select Installment Type</option>
                <option value="1">Daily</option>
                <option value="2">Weekly</option>
                <option value="3">Monthly</option>
              </select>

              {{-- {!! Form::label('longterm_meeting_day', 'Meeeting Day') !!}
              <select name="longterm_meeting_day" class="form-control">
                <option value="" selected="" disabled="">Select Meeeting Day</option>
                <option value="1">Saturday</option>
                <option value="2">Sunday</option>
                <option value="3">Monday</option>
                <option value="4">Tuesday</option>
                <option value="5">Wednesday</option>
                <option value="6">Thursday</option>
                <option value="7">Friday</option>
              </select> --}}

              {!! Form::label('longterm_closing_date', 'Closing Date (Optional)') !!}
              {!! Form::text('longterm_closing_date', null, array('class' => 'form-control', 'placeholder' => 'Closing Date', 'autocomplete' => 'off', 'readonly' => '')) !!}

              {!! Form::label('longterm_total_amount_so_far', 'Total Amount Saved') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('longterm_total_amount_so_far', 0, array('class' => 'form-control', 'placeholder' => 'Total Amount Saved', 'autocomplete' => 'off')) !!}
              </div>

              {!! Form::label('longterm_total_withdraw_so_far', 'Total Amount Withdraw') !!}
              <div class="input-group">
                <span class="input-group-addon">৳</span>
                {!! Form::text('longterm_total_withdraw_so_far', 0, array('class' => 'form-control', 'placeholder' => 'Total Amount Withdraw', 'autocomplete' => 'off')) !!}
              </div>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
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

    $(function() {
      $("#primary_disburse_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#product_disburse_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#primary_first_installment_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#product_first_installment_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#primary_closing_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#product_closing_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#general_opening_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#general_closing_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#longterm_opening_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#longterm_closing_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
    });
    function primaryCalculateTotalDisburse() {
      var primary_principal_amount = $('#primary_principal_amount').val() ? $('#primary_principal_amount').val() : 0; // a ? a : 0;
      var primary_service_charge = primary_principal_amount * 0.20; // 20%
      var primary_total_disbursed = parseFloat(primary_principal_amount) + parseFloat(primary_service_charge);
      $('#primary_service_charge').val(primary_service_charge);
      $('#primary_total_disbursed').val(primary_total_disbursed);
    };
    function productCalculateTotalDisburse() {
      var product_principal_amount = $('#product_principal_amount').val() ? $('#product_principal_amount').val() : 0; // a ? a : 0;
      var product_down_payment = $('#product_down_payment').val() ? $('#product_down_payment').val() : 0; // a ? a : 0;
      var product_left_pricipal_amount = parseFloat(product_principal_amount) - parseFloat(product_down_payment); // if product(!0) or loan(0)
      var product_service_charge = $('#product_service_charge').val() ? $('#product_service_charge').val() : 0; // a ? a : 0;
      var product_total_disbursed = parseFloat(product_left_pricipal_amount) + parseFloat(product_service_charge);
      $('#product_total_disbursed').val(product_total_disbursed);
    };
  </script>
@endsection