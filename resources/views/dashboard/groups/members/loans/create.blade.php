@extends('adminlte::page')

@section('title', 'Add Saving Account | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Add Saving Account [Member: <b>{{ $member->name }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Add Saving Account</div>
          {!! Form::open(['route' => ['dashboard.savings.store', $staff->id, $group->id, $member->id], 'method' => 'POST']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('savingname_id', 'Program *') !!}
                <select name="savingname_id" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Program</option>
                  @foreach($loannames as $loanname)
                    <option value="{{ $loanname->id }}">{{ $loanname->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('disburse_date', 'Disburse Date *') !!}
                {!! Form::text('disburse_date', null, array('class' => 'form-control', 'placeholder' => 'Disburse Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('installment_type', 'Installment Type *') !!}
                <select name="installment_type" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Installment Type</option>
                  <option value="1">Daily</option>
                  <option value="2">Weekly</option>
                  <option value="3">Monthly</option>
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('installments', 'Installments *') !!}
                <select name="installments" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Number of Installments</option>
                  @for($i=1;$i<=100;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('first_installment_date', 'First Installment Date *') !!}
                {!! Form::text('first_installment_date', null, array('class' => 'form-control', 'placeholder' => 'First Installment Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('schemename_id', 'Scheme *') !!}
                <select name="schemename_id" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Program</option>
                  @foreach($schemenames as $schemename)
                    <option value="{{ $schemename->id }}">{{ $schemename->name }}</option>
                  @endforeach
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
      $("#disburse_date").datepicker({
        format: 'D, dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
      });
      $("#first_installment_date").datepicker({
        format: 'D, dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
      });
      $("#closing_date").datepicker({
        format: 'D, dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#user_id').select2();
  </script>
@endsection