@extends('adminlte::page')

@section('title', 'Daily Report | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>Daily Report [Date: <b>{{ date('D, d/m/Y', strtotime($transactiondate)) }}</b>]</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-4">
        <h4>Collection</h4>
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
                <td>৳ {{ $totalloancollection->total }}</td>
              </tr>
              <tr>
                <td>Primary Loan</td>
                <td>৳ {{ $totalprimaryloancollection->total }}</td>
              </tr>
              <tr>
                <td>Product Loan</td>
                <td>৳ {{ $totalproductloancollection->total }}</td>
              </tr>

              <tr>
                <td>Saving Collection</td>
                <td>৳ {{ $totalsavingcollection->total }}</td>
              </tr>
              <tr>
                <td>General Saving</td>
                <td>৳ {{ $totalgeneralsavingcollection->total }}</td>
              </tr>
              <tr>
                <td>Long Term Saving</td>
                <td>৳ {{ $totallongtermsavingcollection->total }}</td>
              </tr>

              <tr>
                <td>Insurance</td>
                <td>৳ {{ $totalinsurance->total }}</td>
              </tr>
              <tr>
                <td>Processing Fee</td>
                <td>৳ {{ $totalprocessingfee->total }}</td>
              </tr>
              <tr>
                <td>Admission Fee</td>
                <td>৳ {{ $totaladmissionfee->total }}</td>
              </tr>
              <tr>
                <td>Passbook Fee</td>
                <td>৳ {{ $totalpassbookfee->total }}</td>
              </tr>
              <tr>
                <td>Others</td>
                <td>৳ <input type="number" style="width: 100px;" min="0" id="collentionothers" onchange="dailyOtherAmountsCal()" @if(!empty($dailyotheramounts->collentionothers)) value="{{ $dailyotheramounts->collentionothers }}" @else value="0" @endif></td>
              </tr>
              <tr>
                <th>Total</th>
                <th>৳ 0</th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <h4>Disburse</h4>
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
  </script>
@endsection