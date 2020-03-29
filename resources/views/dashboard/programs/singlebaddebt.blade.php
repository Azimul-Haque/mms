@extends('adminlte::page')

@section('title', 'Single Bad Debt | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Single Bad Debt
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              @php
                $totaldebtpayments = 0;

                foreach ($baddebt->debtpayments as $debtpayment) {
                  $totaldebtpayments += $debtpayment->amount;
                }
              @endphp
              <h3>৳ {{ $baddebt->debt }}</h3>
              <p>Total Debt</p>
            </div>
            <div class="icon">
              <i class="fa fa-arrow-circle-o-up"></i>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>৳ {{ $totaldebtpayments }}</h3>
              <p>Total Debt Paid</p>
            </div>
            <div class="icon">
              <i class="fa fa-arrow-circle-o-down"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-7">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Debt Payment Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($baddebt->debtpayments as $debtpayment)
            <tr>
              <td>{{ date('D, d/m/Y', strtotime($debtpayment->pay_date)) }}</td>
              <td>৳ {{ $debtpayment->amount }}</td>
              <td>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editDebtPaymentModal{{ $debtpayment->id }}" data-backdrop="static" title="Edit Debt Payment"><i class="fa fa-pencil"></i></button>
                <!-- Edit Modal -->
                <!-- Edit Modal -->
                <div class="modal fade" id="editDebtPaymentModal{{ $debtpayment->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Debt Payment</h4>
                      </div>
                      {!! Form::model($debtpayment, ['route' => ['debt.payment.update', $debtpayment->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              {!! Form::label('pay_date', 'Payment Date') !!}
                              {!! Form::text('pay_date', date('F d, Y', strtotime($debtpayment->pay_date)), array('class' => 'form-control', 'placeholder' => 'Select Date', 'required' => '', 'readonly' => '')) !!}
                            </div>
                            <div class="col-md-6">
                              {!! Form::label('amount', 'Amount') !!}
                              {!! Form::text('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' => '')) !!}
                            </div>
                          </div><br/> 
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
                <!-- Edit Modal -->
                <!-- Edit Modal -->

                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteDebtPayment{{ $debtpayment->id }}" data-backdrop="static" title="Delete Debt Payment"><i class="fa fa-trash"></i></button>
                <!-- Delete Modal -->
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteDebtPayment{{ $debtpayment->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Debt Payment</h4>
                      </div>
                      <div class="modal-body">
                        Are you sure to delete this payment? <br/>
                        <big><b>৳ {{ $debtpayment->amount }}, {{ date('D, d/m/Y', strtotime($debtpayment->pay_date)) }}</b></big> 
                      </div>
                      <div class="modal-footer">
                        {!! Form::model($debtpayment, ['route' => ['debt.payment.delete', $debtpayment->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                          {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        {!! Form::close() !!}
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Delete Modal -->
                <!-- Delete Modal -->
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $("#pay_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $(function() {
      $("#date_to_load").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#loadBorrowsBtn').click(function() {
      var date_to_load =$('#date_to_load').val();

      if(isEmptyOrSpaces(date_to_load))
      {
        if($(window).width() > 768) {
          toastr.warning('Select Date!', 'WARNING').css('width', '400px');
        } else {
          toastr.warning('Select Date!', 'WARNING').css('width', ($(window).width()-25)+'px');
        }
      } else {
        window.location.href = '/dashboard/staffs/borrows/'+ moment(date_to_load).format('YYYY-MM-DD');
      }
    })

    // on enter search
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }
  </script>
@stop