@extends('adminlte::page')

@section('title', 'Saving Accounts | '. $member->name .' | Microfinance Management')

@section('css')
  <style type="text/css">
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd;
      }
      .table-responsive > .table {
        margin-bottom: 0;
      }
      .table-responsive > .table > thead > tr > th,
      .table-responsive > .table > tbody > tr > th,
      .table-responsive > .table > tfoot > tr > th,
      .table-responsive > .table > thead > tr > td,
      .table-responsive > .table > tbody > tr > td,
      .table-responsive > .table > tfoot > tr > td {
        white-space: nowrap;
      }
      .table-responsive > .table-bordered {
        border: 0;
      }
      .table-responsive > .table-bordered > thead > tr > th:first-child,
      .table-responsive > .table-bordered > tbody > tr > th:first-child,
      .table-responsive > .table-bordered > tfoot > tr > th:first-child,
      .table-responsive > .table-bordered > thead > tr > td:first-child,
      .table-responsive > .table-bordered > tbody > tr > td:first-child,
      .table-responsive > .table-bordered > tfoot > tr > td:first-child {
        border-left: 0;
      }
      .table-responsive > .table-bordered > thead > tr > th:last-child,
      .table-responsive > .table-bordered > tbody > tr > th:last-child,
      .table-responsive > .table-bordered > tfoot > tr > th:last-child,
      .table-responsive > .table-bordered > thead > tr > td:last-child,
      .table-responsive > .table-bordered > tbody > tr > td:last-child,
      .table-responsive > .table-bordered > tfoot > tr > td:last-child {
        border-right: 0;
      }
      .table-responsive > .table-bordered > tbody > tr:last-child > th,
      .table-responsive > .table-bordered > tfoot > tr:last-child > th,
      .table-responsive > .table-bordered > tbody > tr:last-child > td,
      .table-responsive > .table-bordered > tfoot > tr:last-child > td {
        border-bottom: 0;
      }
  </style>
@stop

@section('content_header')
    <h1>
      Saving Accounts [Member: <b>{{ $member->name }}</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b>]
      <div class="pull-right">
        <a href="{{ route('dashboard.savings.create', [$staff->id, $group->id, $member->id]) }}" class="btn btn-primary" title="Add a New Saving Account"><i class="fa fa-plus"></i> Add Saving Account</a>
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
                <th>Opening Date</th>
                <th>Meting Day</th>
                <th>Minimum Deposit</th>
                <th>Late Fee</th>
                <th>Balance ( ৳)</th>
                <th>Status</th>
                <th>Closing Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($savings as $savingaccount)
                <tr>
                  <td>{{ $savingaccount->savingname->name }}</td>
                  <td>{{ installment_type($savingaccount->installment_type) }}</td>
                  <td>{{ date('D, d/m/Y', strtotime($member->admission_date)) }}</td>
                  <td>{{ meeting_day($savingaccount->meeting_day) }}</td>
                  <td>{{ $savingaccount->minimum_deposit }}</td>
                  <td>{{ $savingaccount->late_fee }}</td>
                  <td>{{ $savingaccount->total_amount }}</td>
                  <td>{{ status($savingaccount->status) }}</td>
                  <td>
                    @if($savingaccount->closing_date != '0000-00-00')
                      {{ date('D, d/m/Y', strtotime($member->closing_date)) }}
                    @endif
                  </td>
                  <td>
                    <a href="#!" class="btn btn-success btn-sm" title="কাজ চলছে!"><i class="fa fa-pencil"></i> Edit</a>
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