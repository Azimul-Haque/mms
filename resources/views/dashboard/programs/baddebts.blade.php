@extends('adminlte::page')

@section('title', 'Bad Debts | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Bad Debts
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-5">
      <div class="panel panel-primary">
        <div class="panel-heading">Add/ Pay Bad Debt</div>
        
        <div class="panel-body">
          <label for="debt_type">Debt Type</label>
          <select id="debt_type" class="form-control" required="">
            <option value="" selected="" disabled="">Select Debt Type</option>
            <option value="1">Bad Debt</option>
            <option value="2">Debt Payment</option>
          </select>

          <div id="bad_debt_div">
            <br/>
            {!! Form::open(['route' => 'bad.debt.store', 'method' => 'POST']) !!}
              <div class="row">
                <div class="col-md-6">
                  {!! Form::label('name', 'Name') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Name', 'required' => '')) !!}
                </div>
                <div class="col-md-6">
                  {!! Form::label('fhusband', 'Father/ Husband') !!}
                  {!! Form::text('fhusband', null, array('class' => 'form-control', 'placeholder' => 'Father/ Husband', 'required' => '')) !!}
                </div>
              </div><br/>
              <div class="row">
                <div class="col-md-6">
                  {!! Form::label('debt', 'Debt Amount') !!}
                  {!! Form::text('debt', null, array('class' => 'form-control', 'placeholder' => 'Debt Amount', 'required' => '')) !!}
                </div>
                <div class="col-md-6">
                </div>
              </div>
              <br/>
              <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
            {!! Form::close() !!} 
          </div>      
          <div id="debt_payment_div">
            <br/>
            {!! Form::open(['route' => 'debt.payment.store', 'method' => 'POST']) !!}
              <div class="row">
                <div class="col-md-12">
                  {!! Form::label('baddebt_id', 'Debtor Name') !!}
                  <select name="baddebt_id" class="form-control" required="" onchange="badDebtSelectChange()">
                    <option value="" selected="" disabled="">Select Debtor Name</option>
                    @foreach($baddebts as $baddebt)
                      <option value="{{ $baddebt->id }}">{{ $baddebt->name }}-{{ $baddebt->fhusband }}</option>
                    @endforeach
                  </select>
                </div>
              </div><br/>
              <div class="row">
                <div class="col-md-6">
                  {!! Form::label('pay_date', 'Father/ Husband') !!}
                  {!! Form::text('pay_date', date('F d, Y'), array('class' => 'form-control', 'placeholder' => 'Payment Date', 'required' => '', 'readonly' => '')) !!}
                </div>
                <div class="col-md-6">
                  {!! Form::label('amount', 'Payment Amount') !!}
                  {!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Payment Amount', 'required' => '')) !!}
                </div>
              </div>
              <br/>
              <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
            {!! Form::close() !!} 
          </div>      
        </div>
        {{-- <div class="panel-footer"></div> --}}
      </div>
    </div>
    <div class="col-md-7">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Name-Gurdian</th>
              <th>Total Debts</th>
              <th>Total Debts Paid</th>
              <th>Current Debt</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($baddebts as $baddebt)
              @php
                $totaldebtpayment = 0;

                foreach ($baddebt->debtpayments as $debtpayment) {
                  $totaldebtpayment = $totaldebtpayment + $debtpayment->amount;
                }
              @endphp
            <tr>
              <td><a href="{{ route('bad.debt.single', $baddebt->id) }}">{{ $baddebt->name }}-{{ $baddebt->fhusband }}</a></td>
              <td>৳ {{ $baddebt->debt }}</td>
              <td>৳ {{ $totaldebtpayment }}</td>
              <td>৳ {{ $baddebt->debt - $totaldebtpayment }}</td>
              <td>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editBadDebtModal{{ $baddebt->id }}" data-backdrop="static" title="Edit Bad Debt"><i class="fa fa-pencil"></i></button>
                <!-- Edit Modal -->
                <!-- Edit Modal -->
                <div class="modal fade" id="editBadDebtModal{{ $baddebt->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Bad Debt</h4>
                      </div>
                      {!! Form::model($baddebt, ['route' => ['bad.debt.update', $baddebt->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              {!! Form::label('name', 'Name') !!}
                              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Name', 'required' => '')) !!}
                            </div>
                            <div class="col-md-6">
                              {!! Form::label('fhusband', 'Father/ Husband') !!}
                              {!! Form::text('fhusband', null, array('class' => 'form-control', 'placeholder' => 'Father/ Husband', 'required' => '')) !!}
                            </div>
                          </div><br/>
                          <div class="row">
                            <div class="col-md-6">
                              {!! Form::label('debt', 'Debt Amount') !!}
                              {!! Form::text('debt', null, array('class' => 'form-control', 'placeholder' => 'Debt Amount', 'required' => '')) !!}
                            </div>
                            <div class="col-md-6">
                            </div>
                          </div>
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

                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteBadDebt{{ $baddebt->id }}" data-backdrop="static" title="Delete Borrow"><i class="fa fa-trash"></i></button>
                <!-- Delete Modal -->
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteBadDebt{{ $baddebt->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Bad Debt</h4>
                      </div>
                      <div class="modal-body">
                        Are you sure to delete this bad debt? <br/>
                        <big><b>{{ $baddebt->name }}-{{ $baddebt->fhusband }}, Total Debt: ৳ {{ $baddebt->debt }}</b></big> 
                      </div>
                      <div class="modal-footer">
                        {!! Form::model($baddebt, ['route' => ['bad.debt.delete', $baddebt->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
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

    $('#bad_debt_div').hide();
    $('#debt_payment_div').hide();

    $('#debt_type').change(function() {
      if($('#debt_type').val() == 1) {
        $('#bad_debt_div').show();
        $('#debt_payment_div').hide();
      } else if($('#debt_type').val() == 2) {
        $('#bad_debt_div').hide();
        $('#debt_payment_div').show();
      }
    })

    function badDebtSelectChange($id, $debt) {

    }

    // on enter search
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }
  </script>
@stop