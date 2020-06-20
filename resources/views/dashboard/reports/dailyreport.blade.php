@extends('adminlte::page')

@section('title', 'Daily Report | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>Daily Report [Date: <b>{{ date('D, d/m/Y', strtotime($transactiondate)) }}</b>]</h1>
@stop

@section('content')
    @if(Auth::user()->role == 'admin')
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
                  <td>৳ 
                    {{-- <input type="number" style="width: 100px;" min="0" id="cashinhand" onchange="dailyOtherAmountsCal()" @if(!empty($dailyotheramounts->cashinhand)) value="{{ $dailyotheramounts->cashinhand }}" @else value="0" @endif> --}}
                    <span id="cashinhand">@if(!empty($dailyotheramounts->cashinhand)) {{ $dailyotheramounts->cashinhand ? $dailyotheramounts->cashinhand : 0 }} @else 0.00 @endif</span>
                  </td>
                </tr>
                
                {{-- <tr>
                  <td>Loan Collection</td>
                  <td>৳ <span class="">{{ $totalloancollection->total ? $totalloancollection->total : 0 }}</span></td>
                </tr> --}}
                <tr>
                  <td>Primary Loan</td>
                  <td>৳ <span class="for_total_collectioncommon">{{ $totalprimaryloancollection->total ? $totalprimaryloancollection->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Product Loan</td>
                  <td>৳ <span class="for_total_collectioncommon">{{ $totalproductloancollection->total ? $totalproductloancollection->total : 0 }}</span></td>
                </tr>

                {{-- <tr>
                  <td>Saving Collection</td>
                  <td>৳ <span class="">{{ $totalsavingcollection->total ? $totalsavingcollection->total : 0 }}</span></td>
                </tr> --}}
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
                  <td>Shared Deposit</td>
                  <td>৳ <span class="for_total_collectioncommon">{{ $totalshareddeposit->total ? $totalshareddeposit->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Down Payment</td>
                  <td>৳ <span class="for_total_collectioncommon">{{ $totaldownpayment->total ? $totaldownpayment->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Staff Borrows In</td>
                  <td>৳ <span class="for_total_collectioncommon">{{ $totalborrowcollection->total ? $totalborrowcollection->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Others</td>
                  <td>৳ <input type="number" style="width: 100px;" min="0" id="collentionothers" onchange="dailyOtherAmountsCal()" @if(!empty($dailyotheramounts->collentionothers)) value="{{ $dailyotheramounts->collentionothers }}" @else value="0" @endif></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>Total</th>
                  <th>৳ <span id="print_total_collectioncommon"></span></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="col-md-4">
          <span style="font-size: 20px;">Disbursement</span>
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
                  <td>৳ <span class="for_total_disbursecommon">{{ $totaldisbursed->total ? $totaldisbursed->total : 0 }}</span></td>
                </tr>
               {{--  <tr>
                  <td>Saving Withdrawal</td>
                  <td>৳ <span class="">{{ $totalsavingwithdraw->total ? $totalsavingwithdraw->total : 0 }}</span></td>
                </tr> --}}
                <tr>
                  <td>General Saving Withdrawal</td>
                  <td>৳ <span class="for_total_disbursecommon">{{ $totalgeneralsavingwithdraw->total ? $totalgeneralsavingwithdraw->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Long Term Saving Withdrawal</td>
                  <td>৳ <span class="for_total_disbursecommon">{{ $totallongtermsavingcwithdraw->total ? $totallongtermsavingcwithdraw->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Shared Deposit Return</td>
                  <td>৳ <span class="for_total_disbursecommon">{{ $totalshareddepositreturn->total ? $totalshareddepositreturn->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Staff Borrows Out</td>
                  <td>৳ <span class="for_total_disbursecommon">{{ $totalborrowdisbursed->total ? $totalborrowdisbursed->total : 0 }}</span></td>
                </tr>
                <tr>
                  <td>Others</td>
                  <td>৳ <input type="number" style="width: 100px;" min="0" id="disburseothers" onchange="dailyOtherAmountsCal()" @if(!empty($dailyotheramounts->disburseothers)) value="{{ $dailyotheramounts->disburseothers }}" @else value="0" @endif></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>Total</th>
                  <th>৳ <span id="print_total_disbursecommon">0</span></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div>
            <br/><br/>
            <big>
              <b>Total Collection - Total Disbursement = ৳ <span id="print_grand_total_calc">0</span></b>
            </big>
          </div>
        </div>
      </div>
    @endif
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script type="text/javascript">
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

    function dailyOtherAmountsCal() {
      // var cashinhand = parseFloat($('#cashinhand').text()) ? parseFloat($('#cashinhand').text()) : 0;
      var collentionothers = parseFloat($('#collentionothers').val()) ? parseFloat($('#collentionothers').val()) : 0;
      var disburseothers = parseFloat($('#disburseothers').val()) ? parseFloat($('#disburseothers').val()) : 0;
      var transactiondate = '{{ $transactiondate }}';

      // now post the data
      $.post("/report/daily/summary/dailyotheramounts", {_token: '{{ csrf_token() }}', _method : 'POST', 
          data: {
          // cashinhand: cashinhand,
          collentionothers: collentionothers,
          disburseothers: disburseothers,
          transactiondate: transactiondate,
      }},
      function(data, status){
        if(status == 'success') {
          toastr.success('SUCCESS').css('width', '400px');
          collectionCommonCal();
          disburseCommonCal();
          grandTotalCalc();
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
      });
    }

    // total collection calculation
    function collectionCommonCal() {
      var print_total_collectioncommon = 0;
      $(".for_total_collectioncommon").each(function() {
          print_total_collectioncommon = print_total_collectioncommon + parseFloat($(this).text());

          var cashinhand = parseFloat($('#cashinhand').text()) ? parseFloat($('#cashinhand').text()) : 0;
          var collentionothers = parseFloat($('#collentionothers').val()) ? parseFloat($('#collentionothers').val()) : 0;

          $('#print_total_collectioncommon').text(print_total_collectioncommon + cashinhand + collentionothers);
      })
    }
    collectionCommonCal();

    // total disburse calculation
    function disburseCommonCal() {
      var print_total_disbursecommon = 0;
      $(".for_total_disbursecommon").each(function() {
          print_total_disbursecommon = print_total_disbursecommon + parseFloat($(this).text());

          var disburseothers = parseFloat($('#disburseothers').val()) ? parseFloat($('#disburseothers').val()) : 0;

          $('#print_total_disbursecommon').text(print_total_disbursecommon + disburseothers);
      })
    }
    disburseCommonCal();

    // total collection - total disburse calculation
    function grandTotalCalc() {
      var grand_total_collection = parseFloat($('#print_total_collectioncommon').text());
      var grand_total_disburse = parseFloat($('#print_total_disbursecommon').text());
      
      $('#print_grand_total_calc').text(grand_total_collection - grand_total_disburse);

    }
    grandTotalCalc();



    // on enter search
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }
  </script>
@endsection