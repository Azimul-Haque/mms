@extends('adminlte::page')

@section('title', 'Daily Transaction | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>Daily Transaction [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>, , Staff: <b>{{ $member->name }}</b>]</h1>
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
        <button class="btn btn-success" id="loadTransactions"><i class="fa fa-users"></i> Load</button><br/>
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
                <th>Loan <br/>Installment</th>
                <th>General Savings<br/> Deposit</th>
                <th>Long Term<br/> Savings</th>
                <th>Total Collection</th>
                <th>General Savings <br/>Withdraw</th>
                <th>Long Term <br/>Savings Withdraw</th>
                <th>Net <br/>Collection</th>
              </tr>
            </thead>
            <tbody>
              @foreach($member->loans as $loan)
                @foreach($loan->loaninstallments as $loaninstallment)
                  @if(!empty($transactiondate))
                  <tr>
                    <td readonly>{{ $member->passbook }}</td>
                    <td readonly>{{ $loan->loanname->name }}</td>
                    <td id="loaninstallment{{ $member->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $loaninstallment->paid_total }}</td>
                    @php
                      $generalsaving = 0;
                      if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                        $generalsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->amount;
                      }
                    @endphp
                    <td id="generalsaving{{ $member->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $generalsaving }}</td>
                    @php
                      $longsaving = 0;
                      if(!empty($member->savinginstallments->where('savingname_id', 2)->where('due_date', $transactiondate)->first())) {
                        $longsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 2)->where('due_date', $transactiondate)->first()->amount;
                      }
                    @endphp
                    <td id="longsaving{{ $member->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $longsaving }}</td>
                    <td id="totalcollection{{ $member->id }}" readonly>{{ $loaninstallment->paid_total + $generalsaving + $longsaving }}</td>
                    @php
                      $generalsavingwd = 0;
                      if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                        $generalsavingwd = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->withdraw;
                      }
                    @endphp
                    <td id="generalsavingwd{{ $member->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $generalsavingwd }}</td>
                    @php
                      $longsavingwd = 0;
                      if(!empty($member->savinginstallments->where('savingname_id', 2)->where('due_date', $transactiondate)->first())) {
                        $longsavingwd = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 2)->where('due_date', $transactiondate)->first()->withdraw;
                      }
                    @endphp
                    <td id="longsavingwd{{ $member->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}')">{{ $longsavingwd }}</td>
                    <td id="netcollection{{ $member->id }}" readonly>{{ $loaninstallment->paid_total + $generalsaving + $longsaving - $generalsavingwd - $longsavingwd }}</td>
                  </tr>
                  @endif
                @endforeach
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
      var group_to_load =$('#group_to_load').val();
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
        window.location.href = '/group/{{ $staff->id }}/{{ $group->id }}/transactions/' + loan_type_to_load + '/'+ moment(date_to_load).format('YYYY-MM-DD');
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
      // console.log(evt);
      // console.log($('#'+evt.target.id).attr('member_id'));
      // var member_id = $(this).attr('member_id');

      // var loaninstallment = parseInt($('#loaninstallment' + member_id).text()) ? parseInt($('#loaninstallment' + member_id).text()) : 0;
      // var generalsaving = parseInt($('#generalsaving' + member_id).text()) ? parseInt($('#generalsaving' + member_id).text()) : 0;
      // var longsaving = parseInt($('#longsaving' + member_id).text()) ? parseInt($('#longsaving' + member_id).text()) : 0;
      
      // var totalcollection = loaninstallment + generalsaving + longsaving;
      // $('#totalcollection' + member_id).text(totalcollection);
      // console.log(totalcollection);

      // toastr.success(newValue + ' Added!', 'SUCCESS').css('width', '400px');
    });

    function loancalcandpost(member_id, loaninstallment_id, transactiondate) {
      var membername = $('#membername' + member_id).text();
      var loaninstallment = parseInt($('#loaninstallment' + member_id).text()) ? parseInt($('#loaninstallment' + member_id).text()) : 0;
      var generalsaving = parseInt($('#generalsaving' + member_id).text()) ? parseInt($('#generalsaving' + member_id).text()) : 0;
      var longsaving = parseInt($('#longsaving' + member_id).text()) ? parseInt($('#longsaving' + member_id).text()) : 0;
      var generalsavingwd = parseInt($('#generalsavingwd' + member_id).text()) ? parseInt($('#generalsavingwd' + member_id).text()) : 0;
      var longsavingwd = parseInt($('#longsavingwd' + member_id).text()) ? parseInt($('#longsavingwd' + member_id).text()) : 0;
      
      var totalcollection = loaninstallment + generalsaving + longsaving;
      var netcollection = totalcollection - generalsavingwd - longsavingwd;
      $('#totalcollection' + member_id).text(totalcollection);
      $('#netcollection' + member_id).text(netcollection);

      // now post the data
      $.post("/transaction/store/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member_id,
          loaninstallment_id: loaninstallment_id,
          transactiondate: transactiondate,

          loaninstallment: loaninstallment,

          generalsaving: generalsaving,
          longsaving: longsaving,
          generalsavingwd: generalsavingwd,
          longsavingwd: longsavingwd
        }},
        function(data, status){
        console.log(status);
        console.log(data);
        if(status == 'success') {
          toastr.success('Member: <b>' + membername + '</b><br/>Total Collection: <u>৳ ' + totalcollection + '</u>, Net Collection: <u>৳ ' + netcollection , '</u>SUCCESS').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
        
      });
      console.log(totalcollection);
      console.log(member_id);
      
    }

    $('td[readonly]').on('click dblclick keydown', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });

  </script>
@endsection