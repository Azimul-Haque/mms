@extends('adminlte::page')

@section('title', 'Daily Report | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>Daily Report [Date: <b>{{ date('D, d/m/Y') }}</b>]</h1>
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
                <td>৳ </td>
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
                <th>Total</th>
                <th>৳ </th>
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