@extends('adminlte::page')

@section('title', 'Staffs | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Staffs
      <div class="pull-right">
        <a href="{{ route('dashboard.staffs.create') }}" class="btn btn-primary" title="Add a New Staff"><i class="fa fa-plus"></i> Add Staff</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-condensed table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Mobile</th>
              <th>Father</th>
              <th>Bank Details</th>
              <th>Groups</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($staffs as $staff)
              <tr>
                <td>{{ $staff->name }}<br/><small>NID: {{ $staff->nid }}</small></td>
                <td>{{ $staff->phone }}</td>
                <td>{{ $staff->father }}</td>
                <td>
                  {{ $staff->bank }}<br/>
                  Ac No: {{ $staff->acno }}, Check: {{ $staff->checkno }}
                </td>
                <td>
                  @foreach($staff->groups as $group)
                  <span class="label label-warning">{{ $group->name }}</span>
                  @endforeach
                </td>
                <td>
                  <a href="{{ route('dashboard.staffs.edit', $staff->id) }}" class="btn btn-success btn-sm" title="Edit User"><i class="fa fa-pencil"></i> Edit</a> 
                  <a href="{{ route('dashboard.staffs.getaddgroup', [$staff->id, 'staffslist']) }}" class="btn btn-primary btn-sm" title="Add New Group"><i class="fa fa-plus"></i> Add Group</a>
                  {{-- <button class="btn btn-danger btn-sm" title="Delete User" disabled><i class="fa fa-trash"></i> Delete</button> --}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $staffs->links() }}
    </div>
  </div>
@stop