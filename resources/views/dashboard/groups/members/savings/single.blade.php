@extends('adminlte::page')

@section('title', 'Saving Account | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Saving Account [Member: <b>{{ $member->name }}-{{ $member->fhusband }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Saving Account</div>
          {!! Form::model($saving, ['route' => ['dashboard.savings.update', $staff->id, $group->id, $member->id, $saving->id], 'method' => 'PUT']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('savingname_id', 'Program *') !!}
                <select name="savingname_id" class="form-control" disabled="">
                  <option value="" selected="" disabled="">Select Program</option>
                  @foreach($savingnames as $savingname)
                    <option value="{{ $savingname->id }}" @if($saving->savingname_id == $savingname->id) selected="" @endif>{{ $savingname->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('opening_date', 'Opening Date *') !!}
                {!! Form::text('opening_date', date('F d, Y', strtotime($saving->opening_date)), array('class' => 'form-control', 'placeholder' => 'Opening Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('installment_type', 'Installment Type *') !!}
                <select name="installment_type" class="form-control" disabled="">
                  <option value="" selected="" disabled="">Select Installment Type</option>
                  <option value="1" @if($saving->installment_type == 1) selected="" @endif>Daily</option>
                  <option value="2" @if($saving->installment_type == 2) selected="" @endif>Weekly</option>
                  <option value="3" @if($saving->installment_type == 3) selected="" @endif>Monthly</option>
                </select>
              </div>
              {{-- <div class="col-md-6">
                {!! Form::label('meeting_day', 'Meeeting Day *') !!}
                <select name="meeting_day" class="form-control">
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
                @if($saving->closing_date == '1970-01-01')
                  {!! Form::text('closing_date', '', array('class' => 'form-control', 'placeholder' => 'Closing Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
                @else
                  {!! Form::text('closing_date', date('F d, Y', strtotime($saving->closing_date)), array('class' => 'form-control', 'placeholder' => 'Closing Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('minimum_deposit', 'Minimum Deposit') !!}
                {!! Form::text('minimum_deposit', null, array('class' => 'form-control', 'placeholder' => 'Minimum Diposit Amount', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('status', 'Installment Type *') !!}
                <select name="status" class="form-control">
                  <option value="" selected="" disabled="">Select Status</option>
                  <option value="1" @if($saving->status == 1) selected="" @endif>Active</option>
                  <option value="0" @if($saving->status == 0) selected="" @endif>Closed</option>
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
      <div class="col-md-6">
        <div class="table-responsive" style="height: 550px; overflow-y: auto; display: block;">
          <table class="table table-condensed" id="installmentsTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Saving Installment <br/>Amount</th>
                <th>Withdraw Installment <br/>Amount</th>
                <th>Total<br/>Collection</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>
              @php
                $savingcounter = 1;
                $balanceaccu = 0;
              @endphp
              @foreach($saving->savinginstallments as $savinginstallment)
              <tr>
                <td>{{ $savingcounter++ }}</td>
                <td>{{ date('D, d/m/Y', strtotime($savinginstallment->due_date)) }}</td>
                <td>{{ $savinginstallment->amount }}</td>
                <td>{{ $savinginstallment->withdraw }}</td>
                <td>{{ $savinginstallment->amount - $savinginstallment->withdraw }}</td>
                @php
                  $balanceaccu = $balanceaccu + $savinginstallment->amount - $savinginstallment->withdraw;
                @endphp
                <td>{{ $balanceaccu }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
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