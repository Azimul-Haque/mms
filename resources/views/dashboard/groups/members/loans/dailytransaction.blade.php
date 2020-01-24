@extends('adminlte::page')

@section('title', 'Daily Transaction | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>Daily Transaction [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $member->name }}-{{ $member->fhusband }}({{ $member->passbook }})</b>]</h1>
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
        <input class="form-control" type="text" name="date_to_load" id="date_to_load" @if(!empty($transactiondate)) value="{{ date('F d, Y', strtotime($transactiondate)) }}" @else value="{{ date('F d, Y') }}" @endif placeholder="Select Date" readonly=""><br/>
      </div>
      <div class="col-md-3">
        <button class="btn btn-success" id="loadTransactions"><i class="fa fa-spinner"></i> Load</button><br/>
      </div>
      <div class="col-md-3">
        <a href="{{ url()->current() }}" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</a><br/>
      </div>
    </div>
    
    <b>Loan Program</b>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered table-striped" id="editable">
            <thead>
              <tr>
                <th>S#</th>
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
              @php
                $loancounter = 1;
              @endphp
              @foreach($member->loans as $loan)
                @foreach($loan->loaninstallments as $loaninstallment)
                  @if(!empty($transactiondate))
                  <tr>
                    <td readonly>{{ $loancounter++ }}</td>
                    <td readonly>{{ $loan->loanname->name }}</td>
                    <td readonly class="for_total_total_disbursed">{{ $loan->total_disbursed }}</td>
                    <td id="loaninstallment{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}', {{ $loan->total_outstanding }})" class="for_total_loaninstallment">{{ $loaninstallment->paid_total }}</td>
                    <td readonly id="total_paid{{ $loaninstallment->id }}" class="for_total_total_paid">{{ $loan->total_paid }}</td>
                    <td readonly id="total_outstanding{{ $loaninstallment->id }}" class="for_total_total_outstanding">{{ $loan->total_outstanding }}</td>
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

              {{-- old data entry and for all now, anyday --}}
              {{-- old data entry and for all now, anyday --}}
              @foreach($member->loans as $loan)
                @if($loan->loan_new == 0 || $loan->loan_new == 1)
                  @if(!empty($transactiondate) && empty($loan->loaninstallments->first()->due_date))
                  <tr>
                    <td readonly>{{ $loancounter++ }}</td>
                    <td readonly>{{ $loan->loanname->name }}</td>
                    <td readonly class="for_total_total_disbursed">{{ $loan->total_disbursed }}</td>
                    @if($loan->total_outstanding <= 0)
                      <td readonly>0</td>
                    @else
                      <td id="old_loaninstallment{{ $loan->id }}" onchange="oldloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}', {{ $loan->total_outstanding }})" class="for_total_loaninstallment">0</td>
                    @endif
                    <td readonly id="old_total_paid{{ $loan->id }}" class="for_total_total_paid">{{ $loan->total_paid }}</td>
                    <td readonly id="old_total_outstanding{{ $loan->id }}" class="for_total_total_outstanding">{{ $loan->total_outstanding }}</td>
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
              <tr>
                <td readonly></td>
                <td readonly align="right">Total</td>
                <td readonly id="print_total_total_disbursed"></td>
                <td readonly id="print_total_loaninstallment"></td>
                <td readonly id="print_total_total_paid"></td>
                <td readonly id="print_total_total_outstanding"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <b>Saving Program</b>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered table-striped " id="editable2">
            <thead>
              <tr>
                <th>S#</th>
                <th>Saving Program</th>
                <th>Balance</th>
                <th>Today's <br/>Deposit</th>
                <th>Today's <br/>Withdrawn</th>
                <th>Total Collection</th>
              </tr>
            </thead>
            <tbody>
              @php
                $savingcounter = 1;
              @endphp
              @foreach($member->savings as $saving)
                @foreach($saving->savinginstallments as $savinginstallment)
                  @if(!empty($transactiondate))
                  <tr>
                    <td readonly>{{ $savingcounter++ }}</td>
                    <td readonly>{{ $saving->savingname->name }}</td>
                    <td readonly id="old_savingbalance{{ $savinginstallment->id }}" class="for_total_savingbalance">{{ $saving->total_amount - $saving->withdraw }}</td>
                    <td id="old_savinginstallment{{ $savinginstallment->id }}" onchange="oldsavingcalcandpost({{ $member->id }}, {{ $savinginstallment->id }}, '{{ $transactiondate }}', 0)" class="for_total_savinginstallment">{{ $savinginstallment->amount }}</td>
                    <td id="old_savingwithdraw{{ $savinginstallment->id }}" onchange="oldsavingcalcandpost({{ $member->id }}, {{ $savinginstallment->id }}, '{{ $transactiondate }}', {{ $saving->total_amount + $saving->interest - $saving->withdraw }})" class="for_total_withdraw">{{ $savinginstallment->withdraw }}</td>
                    <td readonly id="old_savingcollection{{ $savinginstallment->id }}" class="for_total_savingcollection">{{ $savinginstallment->amount - $savinginstallment->withdraw }}</td>
                  </tr>
                  @endif
                @endforeach
              @endforeach

              @foreach($member->savings as $saving)
                @if(!empty($transactiondate) && empty($saving->savinginstallments->first()->due_date))
                <tr>
                  <td readonly>{{ $savingcounter++ }}</td>
                  <td readonly>{{ $saving->savingname->name }}</td>
                  <td readonly id="new_savingbalance{{ $saving->id }}" class="for_total_savingbalance">{{ $saving->total_amount - $saving->withdraw }}</td>
                  <td id="new_savinginstallment{{ $saving->id }}" onchange="newsavingcalcandpost({{ $member->id }}, {{ $saving->id }}, '{{ $transactiondate }}', 0)" class="for_total_savinginstallment">0</td>
                  <td id="new_savingwithdraw{{ $saving->id }}" onchange="newsavingcalcandpost({{ $member->id }}, {{ $saving->id }}, '{{ $transactiondate }}', {{ $saving->total_amount + $saving->interest - $saving->withdraw }})" class="for_total_withdraw">0</td>
                  <td readonly id="new_savingcollection{{ $saving->id }}" class="for_total_savingcollection">0</td>
                </tr>
                @endif
              @endforeach
              <tr>
                <td readonly></td>
                <td readonly align="right">Total</td>
                <td readonly id="print_total_savingbalance"></td>
                <td readonly id="print_total_savinginstallment"></td>
                <td readonly id="print_total_withdraw"></td>
                <td readonly id="print_total_savingcollection"></td>
              </tr>
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
        clearBtn: true,
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
      $('#editable2').editableTableWidget();
      
      $('#editable td.uneditable').on('change', function(evt, newValue) {
        console.log('false clicked!');
        return false;
      });
      $('#editable2 td.uneditable').on('change', function(evt, newValue) {
        console.log('false clicked!');
        return false;
      });
    });
    $('#editable td').on('change', function(evt, newValue) {
      // toastr.success(newValue + ' Added!', 'SUCCESS').css('width', '400px');
    });
    $('#editable2 td').on('change', function(evt, newValue) {
      // toastr.success(newValue + ' Added!', 'SUCCESS').css('width', '400px');
    });

    function loancalcandpost(member_id, loaninstallment_id, transactiondate, total_outstanding) {
      var membername = '{{ $member->name }}';
      var loaninstallment = parseInt($('#loaninstallment' + loaninstallment_id).text()) ? parseInt($('#loaninstallment' + loaninstallment_id).text()) : 0;
      
      if(total_outstanding != 0 && (loaninstallment > total_outstanding)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#loaninstallment' + loaninstallment_id).text(0);
        return false;
      }

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
        // console.log(data.user_id);
        if(status == 'success') {
          toastr.success('Member: <b>' + membername + '</b><br/>Daily Collection: <u>৳ ' + loaninstallment, '</u>SUCCESS').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
        $('#total_paid' + loaninstallment_id).text(data.loan.total_paid);
        $('#total_outstanding' + loaninstallment_id).text(data.loan.total_outstanding);
      });
    }


    function oldloancalcandpost(member_id, loan_id, transactiondate, total_outstanding) {
      var membername = '{{ $member->name }}';
      var loaninstallment = parseInt($('#old_loaninstallment' + loan_id).text()) ? parseInt($('#old_loaninstallment' + loan_id).text()) : 0;
      
      if(total_outstanding != 0 && (loaninstallment > total_outstanding)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#old_loaninstallment' + loan_id).text(0);
        return false;
      }
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
        location.reload();
      });
    }

    function oldsavingcalcandpost(member_id, savinginstallment_id, transactiondate, balance) {
      var membername = '{{ $member->name }}';
      var old_savinginstallment = parseInt($('#old_savinginstallment' + savinginstallment_id).text()) ? parseInt($('#old_savinginstallment' + savinginstallment_id).text()) : 0;
      var old_savingwithdraw = parseInt($('#old_savingwithdraw' + savinginstallment_id).text()) ? parseInt($('#old_savingwithdraw' + savinginstallment_id).text()) : 0;
      
      if(balance != 0 && (old_savingwithdraw > balance)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#old_savingwithdraw' + savinginstallment_id).text(0);
        return false;
      }
      // now post the data
      $.post("/daily/transaction/oldsaving/store/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member_id,
          savinginstallment_id: savinginstallment_id,
          old_savinginstallment: old_savinginstallment,
          old_savingwithdraw: old_savingwithdraw,
          transactiondate: transactiondate,
        }},
        function(data, status){
        console.log(status);
        // console.log(data.loan.total_outstanding);
        if(status == 'success') {
          toastr.success('Member: <b>' + membername + '</b><br/>Daily Collection: <u>৳ ' + old_savinginstallment - old_savingwithdraw, '</u>SUCCESS').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
        collectiontoday = old_savinginstallment - old_savingwithdraw;
        $('#old_savingbalance' + savinginstallment_id).text(data.savingsingle.total_amount - data.savingsingle.withdraw);
        $('#old_savingcollection' + savinginstallment_id).text(collectiontoday);
      });
    }

    function newsavingcalcandpost(member_id, saving_id, transactiondate, balance) {
      var membername = '{{ $member->name }}';
      var new_savinginstallment = parseInt($('#new_savinginstallment' + saving_id).text()) ? parseInt($('#new_savinginstallment' + saving_id).text()) : 0;
      var new_savingwithdraw = parseInt($('#new_savingwithdraw' + saving_id).text()) ? parseInt($('#new_savingwithdraw' + saving_id).text()) : 0;
      
      if(balance != 0 && (new_savingwithdraw > balance)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#new_savingwithdraw' + saving_id).text(0);
        return false;
      }
      // now post the data
      $.post("/daily/transaction/newsaving/store/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member_id,
          saving_id: saving_id,
          new_savinginstallment: new_savinginstallment,
          new_savingwithdraw: new_savingwithdraw,
          transactiondate: transactiondate,
        }},
        function(data, status){
        console.log(status);
        // console.log(data.loan.total_outstanding);
        if(status == 'success') {
          toastr.success('Member: <b>' + membername + '</b><br/>Daily Collection: <u>৳ ' + new_savinginstallment - new_savingwithdraw, '</u>SUCCESS').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
        collectiontoday = new_savinginstallment - new_savingwithdraw;
        $('#new_savingbalance' + saving_id).text(data.savingsingle.total_amount - data.savingsingle.withdraw);
        $('#new_savingcollection' + saving_id).text(collectiontoday);
        location.reload();
      });
    }

    $('td[readonly]').on('click dblclick keydown', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });
  </script>

  {{-- total collection bottom --}}
  {{-- total collection bottom --}}
  <script type="text/javascript">
    // loan
    var print_total_total_disbursed = 0;
    $(".for_total_total_disbursed").each(function() {
        print_total_total_disbursed = print_total_total_disbursed + parseFloat($(this).text());
        $('#print_total_total_disbursed').text(print_total_total_disbursed);
    })
    
    var print_total_loaninstallment = 0;
    $(".for_total_loaninstallment").each(function() {
        print_total_loaninstallment = print_total_loaninstallment + parseFloat($(this).text());
        $('#print_total_loaninstallment').text(print_total_loaninstallment);
    })
    
    var print_total_total_paid = 0;
    $(".for_total_total_paid").each(function() {
        print_total_total_paid = print_total_total_paid + parseFloat($(this).text());
        $('#print_total_total_paid').text(print_total_total_paid);
    })

    var print_total_total_outstanding = 0;
    $(".for_total_total_outstanding").each(function() {
        print_total_total_outstanding = print_total_total_outstanding + parseFloat($(this).text());
        $('#print_total_total_outstanding').text(print_total_total_outstanding);
    })

    // saving
    var print_total_savingbalance = 0;
    $(".for_total_savingbalance").each(function() {
        print_total_savingbalance = print_total_savingbalance + parseFloat($(this).text());
        $('#print_total_savingbalance').text(print_total_savingbalance);
    })

    var print_total_savinginstallment = 0;
    $(".for_total_savinginstallment").each(function() {
        print_total_savinginstallment = print_total_savinginstallment + parseFloat($(this).text());
        $('#print_total_savinginstallment').text(print_total_savinginstallment);
    })

    var print_total_withdraw = 0;
    $(".for_total_withdraw").each(function() {
        print_total_withdraw = print_total_withdraw + parseFloat($(this).text());
        $('#print_total_withdraw').text(print_total_withdraw);
    })

    var print_total_savingcollection = 0;
    $(".for_total_savingcollection").each(function() {
        print_total_savingcollection = print_total_savingcollection + parseFloat($(this).text());
        $('#print_total_savingcollection').text(print_total_savingcollection);
    })
  </script>
  {{-- total collection bottom --}}
  {{-- total collection bottom --}}
@endsection