@extends('adminlte::page')

@section('title', 'Loan Names | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Loan Names
      <div class="pull-right">
        <a href="{{ route('dashboard.loannames.create') }}" class="btn btn-primary" title="Add a New Loan Name"><i class="fa fa-plus"></i> Add Loan Name</a>
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
                <th>Default Installment Number</th>
                <th>Default Installment Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($loannames as $loanname)
                <tr>
                  <td>{{ $loanname->name }}</td>
                  <td>{{ $loanname->installment_count }}</td>
                  <td>{{ installment_type($loanname->installment_type) }}</td>
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
    </div>
@stop