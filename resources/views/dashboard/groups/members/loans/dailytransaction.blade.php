@extends('adminlte::page')

@section('title', 'Daily Transaction | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>Daily Transaction [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>, , Staff: <b>{{ $member->name }}-{{ $member->fhusband }}</b>]</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-2">
        <select class="form-control" name="loan_type_to_load" id="loan_type_to_load" required="">
          <option value="" selected="" disabled="">Select Loan Type</option>
          @foreach($loannames as $loanname)
            <option value="{{ $loanname->id }}" @if(!empty($loantype) && ($loantype == $loanname->id)) selected="" @endif>{{ $loanname->name }}</option>
          @endforeach
        </select><br/>
      </div>
      <div class="col-md-2">
        <input class="form-control" type="text" name="date_to_load" id="date_to_load" @if(!empty($transactiondate)) value="{{ date('F d, Y', strtotime($transactiondate)) }}" @endif placeholder="Select Date" readonly=""><br/>
      </div>
      <div class="col-md-3">
        <button class="btn btn-success" id="loadTransactions"><i class="fa fa-spinner"></i> Load</button><br/>
      </div>
      <div class="col-md-3">
        <a href="{{ url()->current() }}" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</a><br/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered table-striped " id="editable">
            <thead>
              <tr>
                <th>P#</th>
                <th>Loan Program</th>
                <th>Total Disbursed</th>
                <th>Today's <br/>Collection</th>
                <th>Total Paid</th>
                <th>Total Outstanding</th>
                {{-- <th>Long Term<br/> Savings</th>
                <th>Total Collection</th>
                <th>General Savings <br/>Withdraw</th>
                <th>Long Term <br/>Savings Withdraw</th> 
                <th>Net <br/>Collection</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach($member->loans as $loan)
                @foreach($loan->loaninstallments as $loaninstallment)
                  @if(!empty($transactiondate))
                  <tr>
                    <td readonly>{{ $member->passbook }} N</td>
                    <td readonly>{{ $loan->loanname->name }}</td>
                    <td readonly>{{ $loan->total_disbursed }}</td>
                    <td id="loaninstallment{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $loaninstallment->paid_total }}</td>
                    <td readonly id="total_paid{{ $loaninstallment->id }}">{{ $loan->total_paid }}</td>
                    <td readonly id="total_outstanding{{ $loaninstallment->id }}">{{ $loan->total_outstanding }}</td>
                    {{-- @php
                      $generalsaving = 0;
                      if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                        $generalsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->amount;
                      }
                    @endphp
                    <td id="generalsaving{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $generalsaving }}</td> --}}
                  </tr>
                  @endif
                @endforeach
              @endforeach

              {{-- old data entry, anyday --}}
              {{-- old data entry, anyday --}}
              @foreach($member->loans as $loan)
                @if($loan->loan_new == 0)
                  @if(!empty($transactiondate) && empty($loan->loaninstallments->first()->due_date))
                  <tr>
                    <td readonly>{{ $member->passbook }} O</td>
                    <td readonly>{{ $loan->loanname->name }}</td>
                    <td readonly>{{ $loan->total_disbursed }}</td>
                    @if($loan->total_outstanding <= 0)
                      <td title="Payment Completed!" readonly>0</td>
                    @else
                      <td id="old_loaninstallment{{ $loan->id }}" onchange="oldloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}')">0</td>
                    @endif
                    <td readonly id="old_total_paid{{ $loan->id }}">{{ $loan->total_paid }}</td>
                    <td readonly id="old_total_outstanding{{ $loan->id }}">{{ $loan->total_outstanding }}</td>
                    {{-- @php
                      $generalsaving = 0;
                      if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                        $generalsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->amount;
                      }
                    @endphp
                    <td id="generalsaving{{ $loan->id }}" onchange="oldloancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $generalsaving }}</td> --}}
                  </tr>
                  @endif

                  @foreach($loan->loaninstallments as $loaninstallment)
                    
                  @endforeach
                @endif
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
      $("#date_to_load").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#loadTransactions').click(function() {
      // var group_to_load =$('#group_to_load').val();
      var date_to_load =$('#date_to_load').val();
      var loan_type_to_load =$('#loan_type_to_load').val();

      if(isEmptyOrSpaces(loan_type_to_load)) {
        if($(window).width() > 768) {
          toastr.warning('Select Loan Type!', 'WARNING').css('width', '400px');
        } else {
          toastr.warning('Select Loan Type!', 'WARNING').css('width', ($(window).width()-25)+'px');
        }
      } else if(isEmptyOrSpaces(date_to_load)) {
        if($(window).width() > 768) {
          toastr.warning('Select Date!', 'WARNING').css('width', '400px');
        } else {
          toastr.warning('Select Date!', 'WARNING').css('width', ($(window).width()-25)+'px');
        }
      } else {
        window.location.href = '/group/{{ $staff->id }}/{{ $group->id }}/{{ $member->id }}/member/daily/transaction/' + loan_type_to_load + '/'+ moment(date_to_load).format('YYYY-MM-DD');
      }
    })

    // on enter search
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }
  </script>

  <script src="{{ asset('js/mindmup-editabletable.js') }}"></script>
  <!-- <script src="http://mindmup.github.io/editable-table/numeric-input-example.js"></script> -->
  <script>
    $(document).ready(function () {
      $('#editable').editableTableWidget();
      
      $('#editable td.uneditable').on('change', function(evt, newValue) {
        console.log('false clicked!');
        return false;
      });
    });
    $('#editable td').on('change', function(evt, newValue) {
      // toastr.success(newValue + ' Added!', 'SUCCESS').css('width', '400px');
    });

    function loancalcandpost(member_id, loaninstallment_id, transactiondate) {
      var membername = $('#membername' + loaninstallment_id).text();
      var loaninstallment = parseInt($('#loaninstallment' + loaninstallment_id).text()) ? parseInt($('#loaninstallment' + loaninstallment_id).text()) : 0;
      
      // now post the data
      $.post("/daily/transaction/store/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member_id,
          loaninstallment_id: loaninstallment_id,
          transactiondate: transactiondate,
          loaninstallment: loaninstallment,
        }},
        function(data, status){
        console.log(status);
        // console.log(data.loan.total_outstanding);
        if(status == 'success') {
          toastr.success('Member: <b>' + membername + '</b><br/>Daily Collection: <u>৳ ' + loaninstallment, '</u>SUCCESS').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
        $('#total_paid' + loaninstallment_id).text(data.loan.total_paid);
        $('#total_outstanding' + loaninstallment_id).text(data.loan.total_outstanding);
      });
    }

    function oldloancalcandpost(member_id, loan_id, transactiondate) {
      var membername = $('#membername' + loan_id).text();
      var loaninstallment = parseInt($('#old_loaninstallment' + loan_id).text()) ? parseInt($('#old_loaninstallment' + loan_id).text()) : 0;
      
      // now post the data
      $.post("/old/daily/transaction/store/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member_id,
          loan_id: loan_id,
          transactiondate: transactiondate,
          loaninstallment: loaninstallment,
        }},
        function(data, status){
        console.log(status);
        // console.log(data.loan.total_outstanding);
        if(status == 'success') {
          toastr.success('Member: <b>' + membername + '</b><br/>Daily Collection: <u>৳ ' + loaninstallment, '</u>SUCCESS').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
        $('#old_total_paid' + loan_id).text(data.loan.total_paid);
        $('#old_total_outstanding' + loan_id).text(data.loan.total_outstanding);
      });
    }

    $('td[readonly]').on('click dblclick keydown', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });

  </script>
@endsection