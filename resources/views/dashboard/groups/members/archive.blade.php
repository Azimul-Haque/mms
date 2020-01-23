@extends('adminlte::page')

@section('title', 'Members | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>
      Closed Members
      <div class="pull-right">
        
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
                <th>Passbook #</th>
                <th>Name</th>
                <th>Is Husband</th>
                <th>Status</th>
                {{-- <th>Date of Birth</th> --}}
                <th>Admission Date</th>
                <th>Closing Date</th>
                {{-- <th>Marital Status</th> --}}
                <th>Religion</th>
                {{-- <th>Ethnicity</th> --}}
                <th>NID</th>
                {{-- <th>Education</th> --}}
                {{-- <th>Profession</th> --}}
                <th>Group Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)
                <tr>
                  <td>{{ $member->passbook }}</td>
                  <td><i class="fa fa-user"></i> {{ $member->name }}-{{ $member->fhusband }}</td>
                  <td>{{ ishusband($member->ishusband) }}</td>
                  <td><span class="label label-{{ statuscolor($member->status) }}">{{ status($member->status) }}</span></td>
                  {{-- <td>{{ date('D, d/m/Y', strtotime($member->dob)) }}, <b>{{ Carbon::createFromTimestampUTC(strtotime($member->dob))->diff(Carbon::now())->format('%y years') }}</b></td> --}}
                  <td>{{ date('D, d/m/Y', strtotime($member->admission_date)) }}</td>
                  <td>
                    @if($member->closing_date == '1970-01-01')

                    @else
                      {{ date('D, d/m/Y', strtotime($member->closing_date)) }}
                    @endif
                    
                  </td>
                  {{-- <td>{{ marital_status($member->marital_status) }}</td> --}}
                  <td>{{ religion($member->religion) }}</td>
                  {{-- <td>{{ ethnicity($member->ethnicity) }}</td> --}}
                  <td>{{ $member->nid }}</td>
                  {{-- <td>{{ $member->ecuation }}</td> --}}
                  {{-- <td>{{ $member->profession }}</td> --}}
                  <td>{{ $member->group->name }}</td>
                  <td>
                    <a href="#!" class="btn btn-success btn-sm" title="Activate Member" data-toggle="modal" data-target="#activateMemberModal" data-backdrop="static"><i class="fa fa-flash"></i> Activate Member</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop