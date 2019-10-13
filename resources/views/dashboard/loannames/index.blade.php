@extends('adminlte::page')

@section('title', 'Groups | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Groups
      <div class="pull-right">
        <a href="{{ route('dashboard.loannames.create') }}" class="btn btn-primary" title="Add a New Group"><i class="fa fa-plus"></i> Add Group</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Staff</th>
                <th>Formation Date</th>
                <th>Meeting Day</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($loannames as $group)
                <tr>
                  <td>{{ $group->name }}</td>
                  <td>{{ $group->user->name }}</td>
                  <td>{{ date('F d, Y', $group->formation) }}</td>
                  <td>{{ meeting_day($group->meeting_day) }}</td>
                  <td><span class="label label-{{ statuscolor($group->status) }}">{{ status($group->status) }}</span></td>
                  <td>
                    <a href="{{ route('dashboard.loannames.edit', $group->id) }}" class="btn btn-success btn-sm" title="Edit Group"><i class="fa fa-pencil"></i> Edit</a>
                    {{-- <button class="btn btn-danger btn-sm" title="Delete Group" disabled><i class="fa fa-trash"></i> Delete</button> --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{ $loannames->links() }}
      </div>
    </div>
@stop