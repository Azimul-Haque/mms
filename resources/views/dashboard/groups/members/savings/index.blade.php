@extends('adminlte::page')

@section('title', 'Saving Accounts | '. $member->name .' | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>
      Saving Accounts [Member: <b>{{ $member->name }}-{{ $member->fhusband }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
      <div class="pull-right">
        <a href="{{ route('dashboard.savings.create', [$staff->id, $group->id, $member->id]) }}" class="btn btn-primary" title="Add a New Saving Account"><i class="fa fa-plus"></i> Add Saving Account</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-condensed table-bordered">
            <thead>
              <tr>
                <th>Program</th>
                <th>Installment Type</th>
                <th>Opening Date</th>
                {{-- <th>Meting Day</th> --}}
                {{-- <th>Minimum Deposit</th>
                <th>Late Fee</th> --}}
                <th>Total Amount (৳)</th>
                <th>Total Withdraw (৳)</th>
                <th>Balance (৳)</th>
                <th>Interest (৳)</th>
                <th>Status</th>
                <th>Closing Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($savings as $savingaccount)
                <tr>
                  <td>
                    <a href="{{ route('dashboard.savings.single', [$staff->id, $group->id, $member->id, $savingaccount->id]) }}">
                      {{ $savingaccount->savingname->name }}
                    </a>
                  </td>
                  <td>{{ installment_type($savingaccount->installment_type) }}</td>
                  <td>{{ date('D, d/m/Y', strtotime($savingaccount->opening_date)) }}</td>
                  {{-- <td>{{ meeting_day($savingaccount->meeting_day) }}</td> --}}
                  {{-- <td>{{ $savingaccount->minimum_deposit }}</td>
                  <td>{{ $savingaccount->late_fee }}</td> --}}
                  <td>{{ $savingaccount->total_amount }}</td>
                  <td>{{ $savingaccount->withdraw }}</td>
                  <td>{{ $savingaccount->total_amount - $savingaccount->withdraw }}</td>
                  <td>{{ $savingaccount->interest }}</td>
                  <td>{{ status($savingaccount->status) }}</td>
                  <td>
                    @if($savingaccount->closing_date != '1970-01-01')
                      {{ date('D, d/m/Y', strtotime($savingaccount->closing_date)) }}
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('dashboard.savings.single', [$staff->id, $group->id, $member->id, $savingaccount->id]) }}" class="btn btn-success btn-sm" title="See Saving Account"><i class="fa fa-pencil"></i> Edit</a>
                    {{-- <button class="btn btn-danger btn-sm" title="Delete Member" disabled><i class="fa fa-trash"></i> Delete</button> --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop