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
        <input class="form-control" type="text" name="date_to_load" id="date_to_load" @if(!empty($transactiondate)) value="{{ date('F d, Y', strtotime($transactiondate)) }}" @endif placeholder="Select Date" readonly=""><br/>
      </div>
      <div class="col-md-3">
        <button class="btn btn-success" id="loadTransactions"><i class="fa fa-users"></i> Load</button><br/>
      </div>
      <div class="col-md-3">
        <button class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button><br/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered" id="editable">
            <thead>
              <tr>
                <th>P#</th>
                <th>Member Name</th>
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
              @foreach($members as $member)
                @foreach($member->loans as $loan)
                  @foreach($loan->loaninstallments as $loaninstallment)
                    @if(!empty($transactiondate))
                    <tr>
                      <td>{{ $member->passbook }}</td>
                      <th>{{ $member->name }}</th>
                      <th>{{ $loan->loanname->name }}</th>
                      <td id="loaninstallment{{ $member->id }}" onchange='loaninstallment({{ $member->id }})'>{{ $loaninstallment->installment_total }}</td>
                      <td id="generalsaving{{ $member->id }}" {{-- onchange='generalsaving({{ $member->id }})' --}}></td>
                      <td id="longsaving{{ $member->id }}" {{-- onchange='longsaving({{ $member->id }})' --}}></td>
                      <td id="totalcollection{{ $member->id }}"></td>
                      <td></td>
                      <td class="uneditable"></td>
                      <th></th>
                    </tr>
                    @endif
                  @endforeach
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
      $('#testt1').text('Test');
      console.log(evt);
      toastr.success(newValue + ' Added!', 'SUCCESS').css('width', '400px');
    });

    // function loaninstallment(id) {
    //   var loaninstallment = $('#loaninstallment' + id).val() ? $('#loaninstallment' + id).val() : 0;
    //   var generalsaving = $('#generalsaving' + id).val() ? $('#generalsaving' + id).val() : 0;
    //   var longsaving = $('#longsaving' + id).val() ? $('#longsaving' + id).val() : 0;
      
    //   var totalcollection = loaninstallment + generalsaving + longsaving;
    //   $('#totalcollection' + id).text(loaninstallment);
    //   console.log(loaninstallment);
    // }

  </script>
@endsection