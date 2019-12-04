@extends('adminlte::page')

@section('title', 'Add Saving Account | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Add Saving Account [Member: <b>{{ $member->name }}-{{ $member->fhusband }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">Add Saving Account</div>
          {!! Form::open(['route' => ['dashboard.savings.store', $staff->id, $group->id, $member->id], 'method' => 'POST']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('savingname_id', 'Program *') !!}
                <select name="savingname_id" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Program</option>
                  @foreach($savingnames as $savingname)
                    <option value="{{ $savingname->id }}">{{ $savingname->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('opening_date', 'Opening Date *') !!}
                {!! Form::text('opening_date', date('F d, Y'), array('class' => 'form-control', 'placeholder' => 'Opening Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
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
              {{-- <div class="col-md-6">
                {!! Form::label('meeting_day', 'Meeeting Day *') !!}
                <select name="meeting_day" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Meeeting Day</option>
                  <option value="1">Saturday</option>
                  <option value="2">Sunday</option>
                  <option value="3">Monday</option>
                  <option value="4">Tuesday</option>
                  <option value="5">Wednesday</option>
                  <option value="6">Thursday</option>
                  <option value="7">Friday</option>
                </select>
              </div> --}}
              <div class="col-md-6">
                {!! Form::label('closing_date', 'Closing Date (Optional)') !!}
                {!! Form::text('closing_date', null, array('class' => 'form-control', 'placeholder' => 'Closing Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('minimum_deposit', 'Minimum Deposit') !!}
                {!! Form::text('minimum_deposit', null, array('class' => 'form-control', 'placeholder' => 'Minimum Diposit Amount', 'autocomplete' => 'off')) !!}
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
      $("#opening_date").datepicker({
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