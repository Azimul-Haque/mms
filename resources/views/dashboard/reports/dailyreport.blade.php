@extends('adminlte::page')

@section('title', 'Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>Dailt Report</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-4">
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
                <td></td>
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
                <td>৳ {{ $totalloancollection->total }}</td>
              </tr>
              <tr>
                <td>General Saving</td>
                <td>৳ {{ $totalgeneralsavingcollection->total }}</td>
              </tr>
              <tr>
                <td>Long Term Saving</td>
                <td>৳ {{ $totallongtermsavingcollection->total }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop