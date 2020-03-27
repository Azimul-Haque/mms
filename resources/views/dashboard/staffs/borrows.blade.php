@extends('adminlte::page')

@section('title', 'Staff Borrows | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Staff Borrows
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-5">
      <div class="panel panel-primary">
        <div class="panel-heading">Add/ Pay Borrow</div>
        {!! Form::open(['route' => 'dashboard.storeborrow', 'method' => 'POST']) !!}
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6">
              {!! Form::label('user_id', 'Staff') !!}
              <select name="user_id" class="form-control" required="">
                <option value="" selected="" disabled="">Select Staff</option>
                @foreach()

                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              {!! Form::label('address', 'Address') !!}
              {!! Form::text('address', null, array('class' => 'form-control', 'required' => '')) !!}
            </div>
          </div><br/>
          <div class="row">
            <div class="col-md-6">
              {!! Form::label('phone', 'Phone') !!}
              {!! Form::text('phone', null, array('class' => 'form-control', 'required' => '')) !!}
            </div>
            <div class="col-md-6">
              {!! Form::label('amount', 'Amount') !!}
              {!! Form::text('amount', 0, array('class' => 'form-control', 'required' => '')) !!}
            </div>
          </div>          
        </div>
        <div class="panel-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
    <div class="col-md-7">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Conatct Info</th>
            <th>Donation Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($borrows as $borrow)
          <tr>
            <td>{{ $borrow->name }}</td>
            <td>{{ $borrow->phone }}<br/>{{ $borrow->address }}</td>
            <td>{{ $borrow->amount }}</td>

            <td>
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPartnerModal{{ $borrow->id }}" data-backdrop="static" title="Edit Partner"><i class="fa fa-pencil"></i></button>
              <!-- Edit Modal -->
              <!-- Edit Modal -->
              <div class="modal fade" id="editPartnerModal{{ $borrow->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit Partner</h4>
                    </div>
                    {!! Form::model($borrow, ['route' => ['dashboard.partner.update', $borrow->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
                          </div>
                          <div class="col-md-6">
                            {!! Form::label('address', 'Address') !!}
                            {!! Form::text('address', null, array('class' => 'form-control', 'required' => '')) !!}
                          </div>
                        </div><br/>
                        <div class="row">
                          <div class="col-md-6">
                            {!! Form::label('phone', 'Phone') !!}
                            {!! Form::text('phone', null, array('class' => 'form-control', 'required' => '')) !!}
                          </div>
                          <div class="col-md-6">
                            {!! Form::label('amount', 'Amount') !!}
                            {!! Form::text('amount', null, array('class' => 'form-control', 'required' => '')) !!}
                          </div>
                        </div> 
                      </div>
                      <div class="modal-footer">
                          {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
              <!-- Edit Modal -->
              <!-- Edit Modal -->
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>  
@stop

@section('js')

@stop