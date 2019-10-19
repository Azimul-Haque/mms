@extends('adminlte::page')

@section('title', 'Members | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
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
                  <td><a href="{{ route('dashboard.member.single', [$staff->id, $group->id, $member->id]) }}"><i class="fa fa-user"></i> {{ $member->name }} </a></td>
                  <td>{{ $member->fhusband }}</td>
                  <td>{{ ishusband($member->ishusband) }}</td>
                  <td><span class="label label-{{ statuscolor($member->status) }}">{{ status($member->status) }}</span></td>
                  <td>{{ date('D, d/m/Y', strtotime($member->dob)) }}, <b>{{ Carbon::createFromTimestampUTC(strtotime($member->dob))->diff(Carbon::now())->format('%y years') }}</b></td>
                  <td>{{ date('D, d/m/Y', strtotime($member->admission_date)) }}</td>
                  <td>{{ date('D, d/m/Y', strtotime($member->closing)) }}</td>
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