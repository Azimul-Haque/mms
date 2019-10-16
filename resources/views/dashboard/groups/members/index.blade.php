@extends('adminlte::page')

@section('title', 'Members | Microfinance Management')

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
      Members [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>]
      <div class="pull-right">
        <a href="{{ route('dashboard.members.create', [$staff->id, $group->id]) }}" class="btn btn-primary" title="Add a New Member"><i class="fa fa-plus"></i> Add Member</a>
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
                <th>Passbook</th>
                <th>Name</th>
                <th>Father/Husband</th>
                <th>Is Husband</th>
                <th>Status</th>
                <th>Date of Birth</th>
                <th>Admission Date</th>
                <th>Closing Date</th>
                <th>Marital Status</th>
                <th>Religion</th>
                <th>Ethnicity</th>
                <th>NID</th>
                <th>Education</th>
                <th>Profession</th>
                <th>Group Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)
                <tr>
                  <td>{{ $member->passbook }}</td>
                  <td>{{ $member->name }}</td>
                  <td>{{ $member->fhusband }}</td>
                  <td>{{ ishusband($member->ishusband) }}</td>
                  <td><span class="label label-{{ statuscolor($member->status) }}">{{ status($member->status) }}</span></td>
                  <td>{{ date('F d, Y', strtotime($member->dob)) }}, <b>{{ Carbon::createFromTimestampUTC(strtotime($member->dob))->diff(Carbon::now())->format('%y years') }}</b></td>
                  <td>{{ date('F d, Y', strtotime($member->admission_date)) }}</td>
                  <td>{{ date('F d, Y', strtotime($member->closing)) }}</td>
                  <td>{{ marital_status($member->marital_status) }}</td>
                  <td>{{ religion($member->religion) }}</td>
                  <td>{{ ethnicity($member->ethnicity) }}</td>
                  <td>{{ $member->nid }}</td>
                  <td>{{ $member->ecuation }}</td>
                  <td>{{ $member->profession }}</td>
                  <td>{{ $member->group->name }}</td>
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