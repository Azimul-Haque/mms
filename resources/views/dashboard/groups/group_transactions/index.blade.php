@extends('adminlte::page')

@section('title', 'Group Transaction | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>Group Transaction [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>]</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-2">
        <select class="form-control" name="group_to_load" id="group_to_load" required="">
          <option value="" selected="" disabled="">Select Group</option>
          @if(Auth::user()->role == 'admin')
            @foreach($groups as $groupforselect)
              <option value="{{ $groupforselect->id }}" @if($group->id == $groupforselect->id) selected="" @endif>{{ $groupforselect->name }}</option>
            @endforeach
          @else
            @foreach($staff->groups as $groupforselect)
              <option value="{{ $groupforselect->id }}" @if($group->id == $groupforselect->id) selected="" @endif>{{ $groupforselect->name }}</option>
            @endforeach
          @endif
        </select><br/>
      </div>
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
                <th>Member Name</th>
                <th>Loan <br/>Installment</th>
                @if(!empty($loantype) && $loantype == 1) {{-- if primary then show savings only --}}
                  <th>General Savings<br/> Deposit</th>
                  <th>Long Term<br/> Savings</th>
                @endif
                
                <th>Realisable (Loan Program)</th>
                <th>Loan Program</th>
                <th>Total Collection</th>
                
                @if(!empty($loantype) && $loantype == 1) {{-- if primary then show savings only --}}
                  <th>General Savings <br/>Withdraw</th>
                  <th>Long Term <br/>Savings Withdraw</th>
                @endif
                <th>Net <br/>Collection</th>
              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)
                @foreach($member->loans as $loan)
                  @foreach($loan->loaninstallments as $loaninstallment)
                    @if(!empty($transactiondate))
                    <tr>
                      <td readonly>{{ $member->passbook }}</td>
                      <td id="membername{{ $loaninstallment->id }}" readonly>{{ $member->name }}-{{ $member->fhusband }}</td>
                      <td readonly>{{ $loan->loanname->name }} (Scheme: {{ $loan->schemename->name }})</td>
                      

                      @if(!empty($loantype) && $loantype == 1) {{-- if primary then show savings only --}}
                        @php
                          $generalsaving = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                            $generalsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->amount;
                          }
                        @endphp
                        <td id="generalsaving{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}', {{ $loaninstallment->installment_no }}, 0, 0, 0)" class="for_total_generalsaving">{{ $generalsaving }}</td>
                        @php
                          $longsaving = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 2)->where('due_date', $transactiondate)->first())) {
                            $longsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 2)->where('due_date', $transactiondate)->first()->amount;
                          }
                        @endphp
                        @if(!empty($member->savings->where('savingname_id', 2)->first()))
                          <td id="longsaving{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}', {{ $loaninstallment->installment_no }}, 0, 0, 0)" class="for_total_longsaving">{{ $longsaving }}</td>
                        @else
                          <td readonly>N/A</td>
                        @endif
                        <td id="loaninstallmentrealisable{{ $loaninstallment->id }}" readonly class="for_total_loaninstallmentrealisable">{{ $loaninstallment->installment_total }}</td>
                        <td id="loaninstallment{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}', {{ $loaninstallment->installment_no }}, 0, 0, {{ $loaninstallment->installment_total }})" class="for_total_loaninstallment">{{ $loaninstallment->paid_total }}</td>
                        <td id="totalcollection{{ $loaninstallment->id }}" readonly class="for_total_totalcollection">{{ $loaninstallment->paid_total + $generalsaving + $longsaving }}</td>

                        @php
                          $generalsavingwd = 0;
                          $general_saving_balance = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                            $generalsavingwd = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->withdraw;
                          }
                          if(!empty($member->savinginstallments->where('savingname_id', 1)->first()->total_amount)) {
                            
                          }
                          $general_saving_balance = $member->savings->where('savingname_id', 1)->first()->total_amount - $member->savings->where('savingname_id', 1)->first()->withdraw;
                        @endphp
                        <td id="generalsavingwd{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}', {{ $loaninstallment->installment_no }}, {{ $general_saving_balance }}, 1, 0)" class="for_total_generalsavingwd">{{ $generalsavingwd }}</td>
                        @php
                          $longsavingwd = 0;
                          $long_saving_balance = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 2)->where('due_date', $transactiondate)->first())) {
                            $longsavingwd = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 2)->where('due_date', $transactiondate)->first()->withdraw;
                          }
                          if(!empty($member->savinginstallments->where('savingname_id', 2)->first()->total_amount)) {
                            $long_saving_balance = $member->savings->where('savingname_id', 2)->first()->total_amount - $member->savings->where('savingname_id', 2)->first()->withdraw;
                          }
                        @endphp
                        @if(!empty($member->savings->where('savingname_id', 2)->first()))
                        <td id="longsavingwd{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}', {{ $loaninstallment->installment_no }}, {{ $long_saving_balance }}, 2, 0)" class="for_total_longsavingwd">{{ $longsavingwd }}</td>
                        @else
                        <td readonly>N/A</td>
                        @endif
                        <td id="netcollection{{ $loaninstallment->id }}" class="for_total_netcollection" readonly>{{ $loaninstallment->paid_total + $generalsaving + $longsaving - $generalsavingwd - $longsavingwd }}</td>
                      @else
                        <td id="loaninstallmentrealisable{{ $loaninstallment->id }}" readonly class="for_total_loaninstallmentrealisable">{{ $loaninstallment->installment_total }}</td>
                        <td id="loaninstallment{{ $loaninstallment->id }}" onchange="loancalcandpost({{ $member->id }}, {{ $loaninstallment->id }}, '{{ $transactiondate }}', {{ $loaninstallment->installment_no }}, 0, 0, {{ $loaninstallment->installment_total }})" class="for_total_loaninstallment">{{ $loaninstallment->paid_total }}</td>
                        <td id="totalcollection{{ $loaninstallment->id }}" class="for_total_totalcollection" readonly>{{ $loaninstallment->paid_total }}</td>
                        <td id="netcollection{{ $loaninstallment->id }}" class="for_total_netcollection" readonly>{{ $loaninstallment->paid_total }}</td>
                      @endif
                    </tr>
                    @endif
                  @endforeach
                  
                  {{-- jader installment oidin nai, tao dekhabe --}}
                  {{-- jader installment oidin nai, tao dekhabe --}}
                  {{-- jader installment oidin nai, tao dekhabe --}}
                  @if(empty($loan->loaninstallments) || $loan->loaninstallments->count() == 0) 
                  <tr>
                    <td readonly>{{ $member->passbook }}</td>
                    <td id="membername{{ $loan->id }}" readonly>{{ $member->name }}-{{ $member->fhusband }}</td>
                    <td readonly>{{ $loan->loanname->name }} (Scheme: {{ $loan->schemename->name }})</td>

                    @if(!empty($loantype) && $loantype == 1) {{-- if primary then show savings only --}}
                        @php
                          $generalsaving = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                            $generalsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->amount;
                          }
                        @endphp
                        <td id="generalsaving{{ $loan->id }}{{ $member->id }}" onchange="brandnewloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}', 0, 0, 0)" class="for_total_generalsaving">{{ $generalsaving }}</td>
                        @php
                          $longsaving = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 2)->where('due_date', $transactiondate)->first())) {
                            $longsaving = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 2)->where('due_date', $transactiondate)->first()->amount;
                          }
                        @endphp
                        @if(!empty($member->savings->where('savingname_id', 2)->first()))
                          <td id="longsaving{{ $loan->id }}{{ $member->id }}" onchange="brandnewloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}', 0, 0, 0)" class="for_total_longsaving">{{ $longsaving }}</td>
                        @else
                          <td readonly>N/A</td>
                        @endif
                        <td id="loaninstallmentrealisable{{ $member->id }}" readonly>N/A</td>
                        <td id="loaninstallment{{ $loan->id }}{{ $member->id }}" onchange="brandnewloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}', 0, 0, 0)" class="for_total_loaninstallment">0</td>
                        <td id="brandnewtotalcollection{{ $loan->id }}" class="for_total_totalcollection" readonly>{{ $generalsaving + $longsaving }}</td>

                        @php
                          $generalsavingwd = 0;
                          $general_saving_balance = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 1)->where('due_date', $transactiondate)->first())) {
                            $generalsavingwd = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 1)->where('due_date', $transactiondate)->first()->withdraw;
                          }
                          if(!empty($member->savinginstallments->where('savingname_id', 1)->first()->total_amount)) {
                            $general_saving_balance = $member->savings->where('savingname_id', 1)->first()->total_amount - $member->savings->where('savingname_id', 1)->first()->withdraw;
                          }
                        @endphp
                        <td id="generalsavingwd{{ $loan->id }}{{ $member->id }}" onchange="brandnewloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}', {{ $general_saving_balance }}, 1, 0, 0)" class="for_total_generalsavingwd">{{ $generalsavingwd }}</td>
                        @php
                          $longsavingwd = 0;
                          $long_saving_balance = 0;
                          if(!empty($member->savinginstallments->where('savingname_id', 2)->where('due_date', $transactiondate)->first())) {
                            $longsavingwd = $member->savinginstallments->where('member_id', $member->id)->where('savingname_id', 2)->where('due_date', $transactiondate)->first()->withdraw;
                          }
                          if(!empty($member->savinginstallments->where('savingname_id', 2)->first()->total_amount)) {
                            $long_saving_balance = $member->savings->where('savingname_id', 2)->first()->total_amount - $member->savings->where('savingname_id', 2)->first()->withdraw;
                          }
                        @endphp
                        
                        @if(!empty($member->savings->where('savingname_id', 2)->first()))
                        <td id="longsavingwd{{ $loan->id }}{{ $member->id }}" onchange="brandnewloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}', {{ $long_saving_balance }}, 2, 0, 0)" class="for_total_longsavingwd">{{ $longsavingwd }}</td>
                        @else
                        <td readonly>N/A</td>
                        @endif
                        <td id="brandnewnetcollection{{ $loan->id }}" class="for_total_netcollection" readonly>{{ $generalsaving + $longsaving - $generalsavingwd - $longsavingwd }}</td>
                      @else
                        <td id="loaninstallmentrealisable{{ $member->id }}" readonly>N/A</td>
                        <td id="loaninstallment{{ $loan->id }}{{ $member->id }}" onchange="brandnewloancalcandpost({{ $member->id }}, {{ $loan->id }}, '{{ $transactiondate }}', 0, 0, 0)" class="for_total_loaninstallment">0</td>
                        <td id="brandnewtotalcollection{{ $loan->id }}" class="for_total_totalcollection" readonly>0</td>
                        <td id="brandnewnetcollection{{ $loan->id }}" class="for_total_netcollection" readonly>0</td>
                      @endif
                  </tr>
                  @endif
                  {{-- jader installment oidin nai, tao dekhabe --}}
                  {{-- jader installment oidin nai, tao dekhabe --}}
                  {{-- jader installment oidin nai, tao dekhabe --}}
                  
                @endforeach
              @endforeach
              <tr>
                <td readonly></td>
                <td readonly></td>
                <td readonly align="right">Total</td>
                @if(!empty($loantype) && $loantype == 1)
                  <td readonly id="print_total_generalsaving"></td>
                  <td readonly id="print_total_longsaving"></td>
                  <td readonly id="print_total_loaninstallmentrealisable"></td>
                  <td readonly id="print_total_loaninstallment"></td>
                  <td readonly id="print_total_totalcollection"></td>
                  <td readonly id="print_total_generalsavingwd"></td>
                  <td readonly id="print_total_longsavingwd"></td>
                  <td readonly id="print_total_netcollection"></td>
                @else
                  <td readonly id="print_total_loaninstallmentrealisable"></td>
                  <td readonly id="print_total_loaninstallment"></td>
                  <td readonly id="print_total_totalcollection"></td>
                  <td readonly id="print_total_netcollection"></td>
                @endif
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
        window.location.href = '/group/{{ $staff->id }}/'+ group_to_load +'/transactions/' + loan_type_to_load + '/'+ moment(date_to_load).format('YYYY-MM-DD');
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

    function loancalcandpost(member_id, loaninstallment_id, transactiondate, installment_no, balance, saving_type, installment_total) {
      var membername = $('#membername' + loaninstallment_id).text();
      var loaninstallment = parseInt($('#loaninstallment' + loaninstallment_id).text()) ? parseInt($('#loaninstallment' + loaninstallment_id).text()) : 0;
      var generalsaving = parseInt($('#generalsaving' + loaninstallment_id).text()) ? parseInt($('#generalsaving' + loaninstallment_id).text()) : 0;
      var longsaving = parseInt($('#longsaving' + loaninstallment_id).text()) ? parseInt($('#longsaving' + loaninstallment_id).text()) : 0;
      var generalsavingwd = parseInt($('#generalsavingwd' + loaninstallment_id).text()) ? parseInt($('#generalsavingwd' + loaninstallment_id).text()) : 0;
      var longsavingwd = parseInt($('#longsavingwd' + loaninstallment_id).text()) ? parseInt($('#longsavingwd' + loaninstallment_id).text()) : 0;
      
      if((installment_total > 0) && (installment_total > loaninstallment)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#loaninstallment' + loaninstallment_id).text(0);
        return false;
      }
      if(saving_type == 1 && (generalsavingwd > balance)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#generalsavingwd' + loaninstallment_id).text(0);
        return false;
      }
      if(saving_type == 2 && (longsavingwd > balance)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#longsavingwd' + loaninstallment_id).text(0);
        return false;
      }

      var totalcollection = loaninstallment + generalsaving + longsaving;
      var netcollection = totalcollection - generalsavingwd - longsavingwd;
      $('#totalcollection' + loaninstallment_id).text(totalcollection);
      $('#netcollection' + loaninstallment_id).text(netcollection);

      
      // now post the data
      $.post("/group/transaction/store/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member_id,
          loaninstallment_id: loaninstallment_id,
          transactiondate: transactiondate,
          installment_no: installment_no,

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

    function brandnewloancalcandpost(member_id, loan_id, transactiondate, balance, saving_type, installment_total) {
      var membername = $('#membername' + loan_id).text();
      var loaninstallment = parseInt($('#loaninstallment' + loan_id + member_id).text()) ? parseInt($('#loaninstallment' + loan_id + member_id).text()) : 0;
      var generalsaving = parseInt($('#generalsaving' + loan_id + member_id).text()) ? parseInt($('#generalsaving' + loan_id + member_id).text()) : 0;
      var longsaving = parseInt($('#longsaving' + loan_id + member_id).text()) ? parseInt($('#longsaving' + loan_id + member_id).text()) : 0;
      var generalsavingwd = parseInt($('#generalsavingwd' + loan_id + member_id).text()) ? parseInt($('#generalsavingwd' + loan_id + member_id).text()) : 0;
      var longsavingwd = parseInt($('#longsavingwd' + loan_id + member_id).text()) ? parseInt($('#longsavingwd' + loan_id + member_id).text()) : 0;
      
      if((installment_total > 0) && (installment_total > loaninstallment)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#loaninstallment' + loan_id + member_id).text(0);
        return false;
      }
      if(saving_type == 1 && (generalsavingwd > balance)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#generalsavingwd' + loan_id + member_id).text(0);
        return false;
      }
      if(saving_type == 2 && (longsavingwd > balance)) {
        toastr.warning('Invalid amount!').css('width', '400px');
        $('#longsavingwd' + loan_id + member_id).text(0);
        return false;
      }

      var totalcollection = loaninstallment + generalsaving + longsaving;
      var netcollection = totalcollection - generalsavingwd - longsavingwd;
      $('#brandnewtotalcollection' + loan_id).text(totalcollection);
      $('#brandnewnetcollection' + loan_id).text(netcollection);   

      // console.log(generalsavingwd);
      // now post the data
      $.post("/group/brand/new/transaction/store/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member_id,
          loan_id: loan_id,
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
      location.reload();
    }

    $('td[readonly]').on('click dblclick keydown', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });
  </script>
  <script type="text/javascript">
    var print_total_generalsaving = 0;
    $(".for_total_generalsaving").each(function() {
        print_total_generalsaving = print_total_generalsaving + parseFloat($(this).text());
        $('#print_total_generalsaving').text(print_total_generalsaving);
    })
    
    var print_total_longsaving = 0;
    $(".for_total_longsaving").each(function() {
        print_total_longsaving = print_total_longsaving + parseFloat($(this).text());
        $('#print_total_longsaving').text(print_total_longsaving);
    })
    
    var print_total_loaninstallmentrealisable = 0;
    $(".for_total_loaninstallmentrealisable").each(function() {
        print_total_loaninstallmentrealisable = print_total_loaninstallmentrealisable + parseFloat($(this).text());
        $('#print_total_loaninstallmentrealisable').text(print_total_loaninstallmentrealisable);
    })
    
    var print_total_loaninstallment = 0;
    $(".for_total_loaninstallment").each(function() {
        print_total_loaninstallment = print_total_loaninstallment + parseFloat($(this).text());
        $('#print_total_loaninstallment').text(print_total_loaninstallment);
    })
    
    var print_total_totalcollection = 0;
    $(".for_total_totalcollection").each(function() {
        print_total_totalcollection = print_total_totalcollection + parseFloat($(this).text());
        $('#print_total_totalcollection').text(print_total_totalcollection);
    })
    
    var print_total_generalsavingwd = 0;
    $(".for_total_generalsavingwd").each(function() {
        print_total_generalsavingwd = print_total_generalsavingwd + parseFloat($(this).text());
        $('#print_total_generalsavingwd').text(print_total_generalsavingwd);
    })
    
    var print_total_longsavingwd = 0;
    $(".for_total_longsavingwd").each(function() {
        print_total_longsavingwd = print_total_longsavingwd + parseFloat($(this).text());
        $('#print_total_longsavingwd').text(print_total_longsavingwd);
    })

    var print_total_netcollection = 0;
    $(".for_total_netcollection").each(function() {
        print_total_netcollection = print_total_netcollection + parseFloat($(this).text());
        $('#print_total_netcollection').text(print_total_netcollection);
    })
  </script>
@endsection