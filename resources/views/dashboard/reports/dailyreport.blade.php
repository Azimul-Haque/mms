@extends('adminlte::page')

@section('title', 'Daily Report | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>Daily Report [Date: <b>{{ date('D, d/m/Y', strtotime($transactiondate)) }}</b>]</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-2">
        <input class="form-control" type="text" name="date_to_load" id="date_to_load" @if(!empty($transactiondate)) value="{{ date('F d, Y', strtotime($transactiondate)) }}" @else value="{{ date('F d, Y') }}" @endif placeholder="Select Date" readonly=""><br/>
      </div>
      <div class="col-md-3">
        <button class="btn btn-success" id="loaddailyOtherAmounts"><i class="fa fa fa-balance-scale"></i> Load</button><br/>
      </div>
      <div class="col-md-3">
        <a href="{{ url()->current() }}" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</a><br/>
      </div>
      <div class="col-md-4"></div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <span style="font-size: 20px;">Collection</span>
        <div class="table-responsive">
          <table class="table table-condensed table-bordered">
            <thead>
              <tr>
                <th width="50%">Sector</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Cash in Hand</td>
                <td>৳ <input type="number" style="width: 100px;" min="0" id="cashinhand" onchange="dailyOtherAmountsCal()" @if(!empty($dailyotheramounts->cashinhand)) value="{{ $dailyotheramounts->cashinhand }}" @else value="0" @endif></td>
              </tr>
              
              <tr>
                <td>Loan Collection</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalloancollection->total ? $totalloancollection->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>Primary Loan</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalprimaryloancollection->total ? $totalprimaryloancollection->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>Product Loan</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalproductloancollection->total ? $totalproductloancollection->total : 0 }}</span></td>
              </tr>

              <tr>
                <td>Saving Collection</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalsavingcollection->total ? $totalsavingcollection->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>General Saving</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalgeneralsavingcollection->total ? $totalgeneralsavingcollection->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>Long Term Saving</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totallongtermsavingcollection->total ? $totallongtermsavingcollection->total : 0 }}</span></td>
              </tr>

              <tr>
                <td>Insurance</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalinsurance->total ? $totalinsurance->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>Processing Fee</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalprocessingfee->total ? $totalprocessingfee->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>Admission Fee</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totaladmissionfee->total ? $totaladmissionfee->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>Passbook Fee</td>
                <td>৳ <span class="for_total_collectioncommon">{{ $totalpassbookfee->total ? $totalpassbookfee->total : 0 }}</span></td>
              </tr>
              <tr>
                <td>Others</td>
                <td>৳ <input type="number" style="width: 100px;" min="0" id="collentionothers" onchange="dailyOtherAmountsCal()" @if(!empty($dailyotheramounts->collentionothers)) value="{{ $dailyotheramounts->collentionothers }}" @else value="0" @endif></td>
              </tr>
              <tr>
                <th>Total</th>
                <th>৳ <span id="print_total_collectioncommon"></span></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <span style="font-size: 20px;">Disburse</span>
        <div class="table-responsive">
          <table class="table table-condensed table-bordered">
            <thead>
              <tr>
                <th width="50%">Sector</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Loan Disbursed</td>
                <td>৳ </td>
              </tr>
              <tr>
                <td>Saving Withdrawal</td>
                <td>৳ </td>
              </tr>
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
    function dailyOtherAmountsCal() {
      var cashinhand = parseFloat($('#cashinhand').val()) ? parseFloat($('#cashinhand').val()) : 0;
      var collentionothers = parseFloat($('#collentionothers').val()) ? parseFloat($('#collentionothers').val()) : 0;
      var transactiondate = '{{ $transactiondate }}';

      // now post the data
      $.post("/report/daily/summary/dailyotheramounts", {_token: '{{ csrf_token() }}', _method : 'POST', 
          data: {
          cashinhand: cashinhand,
          collentionothers: collentionothers,
          transactiondate: transactiondate,
      }},
      function(data, status){
        if(status == 'success') {
          toastr.success('SUCCESS').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
      });
    }

    $(function() {
      $("#date_to_load").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#loaddailyOtherAmounts').click(function() {
      var date_to_load =$('#date_to_load').val();

      if(isEmptyOrSpaces(date_to_load)) {
        if($(window).width() > 768) {
          toastr.warning('Select Date!', 'WARNING').css('width', '400px');
        } else {
          toastr.warning('Select Date!', 'WARNING').css('width', ($(window).width()-25)+'px');
        }
      } else {
        window.location.href = '/report/daily/summary/'+ moment(date_to_load).format('YYYY-MM-DD');
      }
    })

    // on enter search
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }

    // total calculation
    var print_total_collectioncommon = 0;
    $(".for_total_collectioncommon").each(function() {
        print_total_collectioncommon = print_total_collectioncommon + parseFloat($(this).text());
        $('#print_total_collectioncommon').text(print_total_collectioncommon);
    })
  </script>
@endsection