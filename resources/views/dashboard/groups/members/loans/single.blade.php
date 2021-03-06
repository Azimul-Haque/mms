@extends('adminlte::page')

@section('title', 'Loan Account | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>
      Loan Account [Member: <b>{{ $member->name }}-{{ $member->fhusband }}({{ $member->passbook }})</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Loan Account ({{ $loan->loanname->name }})</div>
          {!! Form::model($loan, ['route' => ['dashboard.loans.update', $staff->id, $group->id, $member->id, $loan->id], 'method' => 'PUT']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('loanname_id', 'Program *') !!}
                <select name="loanname_id" class="form-control" disabled="">
                  <option value="" selected="" disabled="">Select Program</option>
                  @foreach($loannames as $loanname)
                    <option value="{{ $loanname->id }}" @if($loan->loanname_id == $loanname->id) selected="" @endif>{{ $loanname->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('disburse_date', 'Disburse Date *') !!}
                {!! Form::text('disburse_date', date('F d, Y', strtotime($loan->disburse_date)), array('class' => 'form-control', 'placeholder' => 'Disburse Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('installment_type', 'Installment Type *') !!}
                <select name="installment_type" id="installment_type" class="form-control" disabled="">
                  <option value="" selected="" disabled="">Select Installment Type</option>
                  <option value="1" @if($loan->installment_type == 0) selected="" @endif>Daily</option>
                  <option value="2" @if($loan->installment_type == 1) selected="" @endif>Weekly</option>
                  <option value="3" @if($loan->installment_type == 2) selected="" @endif>Monthly</option>
                </select>
              </div>
              <div class="col-md-6">
                {!! Form::label('installments', 'Installments *') !!}
                <select name="installments" id="installments" class="form-control" disabled="">
                  <option value="" selected="" disabled="">Select Number of Installments</option>
                  @for($i=1;$i<=120;$i++)
                    <option value="{{ $i }}" @if($loan->installments == $i) selected="" @endif>{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('first_installment_date', 'First Installment Date *') !!}
                {!! Form::text('first_installment_date', date('F d, Y', strtotime($loan->first_installment_date)), array('class' => 'form-control', 'placeholder' => 'First Installment Date', 'required' => '', 'autocomplete' => 'off', 'readonly' => '')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('schemename_id', 'Scheme *') !!}
                <select name="schemename_id" id="schemename_id" class="form-control" disabled="">
                  <option value="" selected="" disabled="">Select Program</option>
                  @foreach($schemenames as $schemename)
                    <option value="{{ $schemename->id }}" @if($loan->schemename_id == $schemename->id) selected="" @endif>{{ $schemename->name }}</option>
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
                  {!! Form::text('principal_amount', null, array('class' => 'form-control', 'placeholder' => 'Principal Amount', 'readonly' => '', 'onchange' => 'calculateTotalDisburse();')) !!}
                </div>
              </div>
              <div class="col-md-6">
                <br/>
                {!! Form::label('service_charge', 'Service Charge *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('service_charge', null, array('class' => 'form-control', 'placeholder' => 'Service Charge', 'readonly' => '', 'onchange' => 'calculateTotalDisburse();')) !!}
                </div>
              </div>
            </div>
            <div class="row">
              <br/>
              <div class="col-md-6">
                {!! Form::label('down_payment', 'Down Payment (If PRODUCT) *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('down_payment', null, array('class' => 'form-control', 'placeholder' => 'Down Payment (If PRODUCT)', 'autocomplete' => 'off', 'onchange' => 'calculateTotalDisburse();', 'readonly' => '')) !!}
                </div>
              </div>
              <div class="col-md-6">
                {!! Form::label('total_disbursed', 'Total Disbursed Amount *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('total_disbursed', null, array('class' => 'form-control', 'placeholder' => 'Total Disbursed Amount', 'readonly' => '', 'autocomplete' => 'off')) !!}
                </div>
              </div>
            </div>

            @if(Auth::user()->role == 'admin')
            <div class="row">
              <br/>
              <div class="col-md-6">
                {!! Form::label('total_paid', 'Total Paid') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('total_paid', null, array('class' => 'form-control', 'placeholder' => 'Total Paid', 'autocomplete' => 'off', 'onchange' => 'calculateTotalPaid();')) !!}
                </div>
              </div>
              <div class="col-md-6">
                {!! Form::label('total_outstanding', 'Total Outstanding') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('total_outstanding', null, array('class' => 'form-control', 'placeholder' => 'Total Outstanding', 'autocomplete' => 'off')) !!}
                </div>
              </div>
            </div>
            @endif

            @if($loan->schemename_id == 1)
            <div class="row">
              <br/>
              <div class="col-md-6">
                {!! Form::label('insurance', 'Insurance (If PRIMARY LOAN) *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('insurance', null, array('class' => 'form-control', 'placeholder' => 'Insurance (If PRIMARY LOAN) ', 'readonly' => '', 'autocomplete' => 'off')) !!}
                </div>
              </div>
              <div class="col-md-6">
                {!! Form::label('processing_fee', 'Processing Fee (If PRIMARY LOAN) *') !!}
                <div class="input-group">
                  <span class="input-group-addon">৳</span>
                  {!! Form::text('processing_fee', 15, array('class' => 'form-control', 'placeholder' => 'Total Disbursed Amount', 'readonly' => '', 'autocomplete' => 'off')) !!}
                </div>
              </div>
            </div>
            @endif
            <div class="row">
              <br/>
              <div class="col-md-6">
                {!! Form::label('closing_date', 'Closing Date (Optional)') !!}
                @if($loan->closing_date == '1970-01-01')
                  {!! Form::text('closing_date', '', array('class' => 'form-control', 'placeholder' => 'Closing Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
                @else
                  {!! Form::text('closing_date', date('F d, Y', strtotime($loan->closing_date)), array('class' => 'form-control', 'placeholder' => 'Closing Date', 'autocomplete' => 'off', 'readonly' => '')) !!}
                @endif
              </div>
              <div class="col-md-6">
                {!! Form::label('status', 'Status *') !!}
                <select name="status" class="form-control" required="" {{-- @if($loan->total_disbursed > $loan->total_paid) disabled="" @endif --}}>
                  <option value="" selected="" disabled="">Select Status</option>
                  <option value="1" @if($loan->status == 1) selected="" @endif>Disbursed</option>
                  <option value="0" @if($loan->status == 0) selected="" @endif>Closed</option>
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
                <th>Installment Amount<br/>(Principal)</th>
                <th>Installment Amount<br/>(Interest)</th>
                <th>Installment Amount<br/>(Total)</th>
                {{-- <th>Paid Amount<br/>(Principal)</th>
                <th>Paid Amount<br/>(Interest)</th> --}}
                <th>Paid Amount<br/>(Total)</th>
                <th>Outstanding Amount<br/>(Total)</th>
                <th>Overdue<br/>Amount</th>
                <th>Advanced<br/>Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $tempoutstandingpaid = 0;
                $totaloverdue = 0;
                $tempadvanced = 0;
              @endphp
              @foreach($loan->loaninstallments as $loaninstallment)
              <tr>
                <td>{{ $loaninstallment->installment_no }}</td>
                <td>{{ date('D, d/m/Y', strtotime($loaninstallment->due_date)) }}</td>
                <td>{{ $loaninstallment->installment_principal }}</td>
                <td>{{ $loaninstallment->installment_interest }}</td>
                <td>{{ $loaninstallment->installment_total }}</td>
                {{-- <td>{{ $loaninstallment->paid_principal }}</td>
                <td>{{ $loaninstallment->paid_interest }}</td> --}}
                <td>{{ $loaninstallment->paid_total }}</td>
                <td>
                  @php
                    $tempoutstandingpaid = $tempoutstandingpaid + $loaninstallment->paid_total;
                    $tempoutstanding = $loaninstallment->loan->total_disbursed - $tempoutstandingpaid;
                  @endphp
                  {{ $tempoutstanding }}
                </td>
                <td>
                  @php
                    if(($loaninstallment->installment_total - $loaninstallment->paid_total > 0)  && (date('Y-m-d', strtotime($loaninstallment->due_date)) <= date('Y-m-d') )) {
                      $totaloverdue = $loaninstallment->installment_total - $loaninstallment->paid_total;
                    } else {
                      $totaloverdue = 0;
                    }
                  @endphp
                  {{ $totaloverdue }}
                </td>
                <td>
                  @php
                    if(($loaninstallment->paid_total - $loaninstallment->installment_total > 0)  && (date('Y-m-d', strtotime($loaninstallment->due_date)) <= date('Y-m-d') )) {
                      $tempadvanced = $loaninstallment->paid_total - $loaninstallment->installment_total;
                    } else {
                      $tempadvanced = 0;
                    }
                  @endphp
                  {{ $tempadvanced }}
                </td>
                <td>
                  @if(Auth::user()->role == 'admin')
                  <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteInstallment{{ $loaninstallment->id }}" data-backdrop="static"><i class="fa fa-trash"></i></button>
                  <!-- Delete Modal -->
                  <!-- Delete Modal -->
                  <div class="modal fade" id="deleteInstallment{{ $loaninstallment->id }}" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Delete Installment</h4>
                        </div>
                        <div class="modal-body">
                          Are you sure to delete this inslallment: <b>{{ date('D, d/m/Y', strtotime($loaninstallment->due_date)) }}, Tk. {{ $loaninstallment->paid_total }}/-</b>?<br/>
                        </div>
                        <div class="modal-footer">
                          {!! Form::model($loaninstallment, ['route' => ['dashboard.loaninstallment.delete', $loaninstallment->id], 'method' => 'DELETE', 'class' => 'form-default']) !!}
                              {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Delete Modal -->
                  <!-- Delete Modal -->
                  @endif
                </td>
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
      var service_charge = $('#service_charge').val() ? $('#service_charge').val() : 0; // a ? a : 0;
      var total_disbursed = parseFloat(left_pricipal_amount) + parseFloat(service_charge);
      $('#total_disbursed').val(total_disbursed);
    };
    function calculateTotalPaid() {
      var total_disbursed = $('#total_disbursed').val() ? $('#total_disbursed').val() : 0; // a ? a : 0;
      var total_paid = $('#total_paid').val() ? $('#total_paid').val() : 0; // a ? a : 0;
      $('#total_outstanding').val(total_disbursed - total_paid);
    };
  </script>
@endsection