@extends('adminlte::page')

@section('title', 'Loan Names | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Loan & Saving Names
      {{-- <div class="pull-right">
        <a href="{{ route('dashboard.loannames.create') }}" class="btn btn-primary" title="Add a New Loan Name"><i class="fa fa-plus"></i> Add Loan Name</a>
      </div> --}}
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="pull-right" style="padding: 5px;">
          <a href="{{ route('dashboard.loannames.create') }}" class="btn btn-primary btn-sm" title="Add a New Loan Name"><i class="fa fa-plus"></i> Add Loan Name</a>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Loan Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($loannames as $loanname)
                <tr>
                  <td>{{ $loanname->name }}</td>
                  <td>
                    <a href="{{ route('dashboard.loannames.edit', $loanname->id) }}" class="btn btn-success btn-sm" title="Edit Loan Name"><i class="fa fa-pencil"></i> Edit</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{ $loannames->links() }}
      </div>
      <div class="col-md-6">
        <div class="pull-right" style="padding: 5px;">
          <a href="{{ route('dashboard.savingnames.create') }}" class="btn btn-success btn-sm" title="Add a New Loan Name"><i class="fa fa-plus"></i> Add Saving Name</a>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Saving Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($savingnames as $savingname)
                <tr>
                  <td>{{ $savingname->name }}</td>
                  <td>
                    <a href="{{ route('dashboard.savingnames.edit', $savingname->id) }}" class="btn btn-success btn-sm" title="Edit Loan Name"><i class="fa fa-pencil"></i> Edit</a>
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