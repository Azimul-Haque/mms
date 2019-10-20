@extends('adminlte::page')

@section('title', 'Loan Accounts | '. $member->name .' | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>
      Loan Accounts [Member: <b>{{ $member->name }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
      <div class="pull-right">
        <a href="{{ route('dashboard.loans.create', [$staff->id, $group->id, $member->id]) }}" class="btn btn-primary" title="Add a New Loan Account"><i class="fa fa-plus"></i> Add Loan Account</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Program</th>
                <th>Installment Type</th>
                <th>Disburse Date</th>
                <th>Total Installments</th>
                <th>Disbursed</th>
                <th>Status</th>
                <th>Closing Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($loans as $loan)
                <tr>
                  <td>
                    <a href="{{ route('dashboard.loans.single', [$staff->id, $group->id, $member->id, $loan->id]) }}">{{ $loan->loanname->name }}</a>
                  </td>
                  <td>{{ installment_type($loan->installment_type) }}</td>
                  <td>{{ date('D, d/m/Y', strtotime($loan->disburse_date)) }}</td>
                  <td>{{ $loan->installments }}</td>
                  <td>{{ $loan->total_disbursed }}</td>
                  <td>{{ status($loan->status) }}</td>
                  <td>
                    @if($loan->closing_date != '0000-00-00')
                      {{ date('D, d/m/Y', strtotime($member->closing_date)) }}
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('dashboard.loans.single', [$staff->id, $group->id, $member->id, $loan->id]) }}" class="btn btn-success btn-sm" title="কাজ চলছে!"><i class="fa fa-pencil"></i> Edit</a>
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