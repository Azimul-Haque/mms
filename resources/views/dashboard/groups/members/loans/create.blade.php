@extends('adminlte::page')

@section('title', 'Add Loan Account | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>
      Add Loan Account [Member: <b>{{ $member->name }}-{{ $member->fhusband }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Add Loan Account</div>
          {!! Form::open(['route' => ['dashboard.loans.store', $staff->id, $group->id, $member->id], 'method' => 'POST']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('loanname_id', 'Program *') !!}
                <select name="loanname_id" id="loanname_id" class="form-control" required="">
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
                <select name="installment_type" id="installment_type" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Installment Type</option>
                  <option value="1">Daily</option>
                  <option value="2">Weekly</option>
                  <option value="3">Monthly</option>
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('installments', 'Installments *') !!}
                <select name="installments" id="installments" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Number of Installments</option>
                  @for($i=1;$i<=120;$i++)
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
                <select name="schemename_id" id="schemename_id" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Program</option>
                  @foreach($schemenames as $schemename)
                    <option value="{{ $schemename->id }}">{{ $schemename->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <br/>
                {!! Form::label('principal_amount', 'Principal Amount *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('principal_amount', null, array('class' => 'form-control', 'placeholder' => 'Principal Amount', 'required' => '', 'onchange' => 'calculateTotalDisburse();')) !!}
                </div>
              </div>
              <div class="col-md-6">
                <br/>
                {!! Form::label('service_charge', 'Service Charge *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('service_charge', null, array('class' => 'form-control', 'placeholder' => 'Service Charge', 'required' => '', 'onchange' => 'calculateTotalDisburse();')) !!}
                </div>
              </div>
            </div>
            <div class="row">
              <br/>
              <div class="col-md-6">
                {!! Form::label('down_payment', 'Down Payment (If PRODUCT) *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('down_payment', null, array('class' => 'form-control', 'placeholder' => 'Down Payment (If PRODUCT)', 'autocomplete' => 'off', 'onchange' => 'calculateTotalDisburse();')) !!}
                </div>
              </div>
              <div class="col-md-6">
                {!! Form::label('total_disbursed', 'Total Disbursed Amount *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('total_disbursed', null, array('class' => 'form-control', 'placeholder' => 'Total Disbursed Amount', 'required' => '', 'autocomplete' => 'off')) !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('closing_date', 'Closing Date (Optional)') !!}
                {!! Form::text('closing_date', null, array('class' => 'form-control', 'placeholder' => 'Closing Date (Optional)', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('status', 'Status *') !!}
                <select name="status" class="form-control" required="">
                  <option value="" selected="" disabled="">Select Status</option>
                  <option value="1">Disbursed</option>
                  <option value="0">Closed</option>
                </select>
              </div>
            </div>
          </div>
          <div class="panel-footer">
            <button type="submit" class="btn btn-primary" title="Disburse Loan" onclick="previewTable();"><i class="fa fa-floppy-o"></i> Save</button> {{-- submit --}}
            <button type="button" class="btn btn-success" id="loadInstallments" onclick="previewTable();"><i class="fa fa-refresh"></i> Load Installments</button>
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
                <th>Installment Amount<br/>(Principal)</th>
                <th>Installment Amount<br/>(Interest)</th>
                <th>Installment Amount<br/>(Total)</th>
                <th>Paid Amount<br/>(Principal)</th>
                <th>Paid Amount<br/>(Interest)</th>
                <th>Paid Amount<br/>(Total)</th>
                <th>Outstanding Amount<br/>(Principal)</th>
                <th>Outstanding Amount<br/>(Interest)</th>
                <th>Outstanding Amount<br/>(Total)</th>
                {{-- <th>Overdue Amount<br/>(Principal)</th>
                <th>Overdue Amount<br/>(Interest)</th>
                <th>Overdue Amount<br/>(Total)</th> --}}
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  {{-- <script type="text/javascript" src="{{ asset('js/dateformat.js') }}"></script> --}}
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $("#disburse_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      });
      $("#first_installment_date").datepicker({
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
    function calculateTotalDisburse() {
      var principal_amount = $('#principal_amount').val() ? $('#principal_amount').val() : 0; // a ? a : 0;
      var down_payment = $('#down_payment').val() ? $('#down_payment').val() : 0; // a ? a : 0;
      var left_pricipal_amount = parseFloat(principal_amount) - parseFloat(down_payment); // if product(!0) or loan(0)

      if($('#loanname_id').val() && $('#loanname_id').val() == 1) {
        var service_charge = principal_amount * 0.20; // 20%
        $('#service_charge').val(service_charge);
      } else {
        var service_charge = $('#service_charge').val() ? $('#service_charge').val() : 0; // a ? a : 0;
      }
      
      var total_disbursed = parseFloat(left_pricipal_amount) + parseFloat(service_charge);
      $('#total_disbursed').val(total_disbursed);
    };

    function previewTable() {
      var installment_type = $('#installment_type').val();
      var installments = $('#installments').val();
      var first_installment_date = $('#first_installment_date').val();
      var principal_amount = $('#principal_amount').val() ? $('#principal_amount').val() : 0; // a ? a : 0;
      var down_payment = $('#down_payment').val() ? $('#down_payment').val() : 0; // a ? a : 0;
      var left_pricipal_amount = parseFloat(principal_amount) - parseFloat(down_payment); // if product(!0) or loan(0)
      var service_charge = $('#service_charge').val() ? $('#service_charge').val() : 0; // a ? a : 0;
      var total_disbursed = parseFloat(left_pricipal_amount) + parseFloat(service_charge);
      $('#total_disbursed').val(total_disbursed);
      $('#installmentsTable > tbody').empty();
      
      for(var i=0; i<installments;i++) {
        var tablerow = '<tr>';
        if(installment_type == 1) {
          var dateToPay = addWeekdays(moment(first_installment_date), i).format('ddd, DD/MM/YYYY');
        } else if(installment_type == 2) {
          var dateToPay = moment(first_installment_date).add(i, 'weeks').format('ddd, DD/MM/YYYY');
        } else if(installment_type == 3) {
          var dateToPay = moment(first_installment_date).add(i*1, 'months').format('ddd, DD/MM/YYYY');
          if(dateToPay.includes('Fri')) {
            dateToPay = moment(first_installment_date).add(i*1, 'months').add(1, 'days').format('ddd, DD/MM/YYYY');
          } else {
            dateToPay = dateToPay;
          }
        }
        tablerow += '<td>'+ (i+1) +'</td>';
        tablerow += '<td>'+ dateToPay +'</td>';
        tablerow += '<td>'+ (left_pricipal_amount/installments).toFixed(2) +'</td>';
        tablerow += '<td>'+ (service_charge/installments).toFixed(2) +'</td>';
        tablerow += '<td>'+ total_disbursed/installments +'</td>';
        tablerow += '<td>'+ 0.00 +'</td>';
        tablerow += '<td>'+ 0.00 +'</td>';
        tablerow += '<td>'+ 0.00 +'</td>';
        tablerow += '<td>'+ left_pricipal_amount +'</td>';
        tablerow += '<td>'+ service_charge +'</td>';
        tablerow += '<td>'+ total_disbursed +'</td>';
        // tablerow += '<td>0.00</td><td>0.00</td><td>0.00</td>'; // overdue
        tablerow += '</tr>';
        
        
        $('#installmentsTable > tbody').append(tablerow);
      }
    };

    function addWeekdays(date, days) {
      date = moment(date);
      while (days > 0) {
        date = date.add(1, 'days');
        // 5 == Fri
        if (date.isoWeekday() !== 5) {
          days -= 1;
        }
      }
      return date;
    }
  </script>
@endsection