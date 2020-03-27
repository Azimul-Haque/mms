@extends('adminlte::page')

@section('title', 'Staff Borrows | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
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
                @foreach($staffs as $staff)
                  <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              {!! Form::label('borrow_date', 'Date') !!}
              {!! Form::text('borrow_date', null, array('class' => 'form-control', 'placeholder' => 'Select Date', 'required' => '', 'readonly' => '')) !!}
            </div>
          </div><br/>
          <div class="row">
            <div class="col-md-6">
              {!! Form::label('borrow_type', 'Borrow Type (ধরণ)') !!}
              <select name="borrow_type" class="form-control" required="">
                <option value="" selected="" disabled="">Select Borrow Type (ধরণ)</option>
                <option value="1">Borrow Disburse (বিতরণ)</option>
                <option value="2">Borrow Collection (আদায়)</option>
              </select>
            </div>
            <div class="col-md-6">
              {!! Form::label('amount', 'Amount') !!}
              {!! Form::text('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' => '')) !!}
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
      <div class="row">
        <div class="col-md-4">
          <input type="text" id="date_to_load" class="form-control" value="{{ date('F d, Y', strtotime($borrowdate)) }}" placeholder="Select Date" readonly="">
        </div>
        <div class="col-md-4">
          <button class="btn btn-success" id="loadBorrowsBtn"><i class="fa fa-users"></i> Load</button><br/>
        </div>
      </div>
      <br/>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name</th>
              <th>Type</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php
              $totaldisburse = 0;
              $totalcollection = 0;
            @endphp
            @foreach($borrows as $borrow)
              @php
                if($borrow->borrow_type == 1) {
                  $totaldisburse = $totaldisburse + $borrow->amount;
                } elseif ($borrow->borrow_type == 2) {
                  $totalcollection = $totalcollection + $borrow->amount;
                }
              @endphp
            <tr>
              <td>{{ date('D, d/m/Y', strtotime($borrow->borrow_date)) }}</td>
              <td>{{ $borrow->user->name }}</td>
              <td>
                @if($borrow->borrow_type == 1)
                  বিতরণ
                @elseif($borrow->borrow_type == 2)
                  আদায়
                @endif
              </td>
              <td>৳ {{ $borrow->amount }}</td>
              <td>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editBorrow1Modal{{ $borrow->id }}" data-backdrop="static" title="Edit Borrow"><i class="fa fa-pencil"></i></button>
                <!-- Edit Modal -->
                <!-- Edit Modal -->
                <div class="modal fade" id="editBorrow1Modal{{ $borrow->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Borrow</h4>
                      </div>
                      {!! Form::model($borrow, ['route' => ['dashboard.updateborrow', $borrow->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              {!! Form::label('user_id', 'Staff') !!}
                              <select name="user_id" class="form-control" required="">
                                <option value="" selected="" disabled="">Select Staff</option>
                                @foreach($staffs as $staff)
                                  <option value="{{ $staff->id }}" @if($borrow->user_id == $staff->id) selected="" @endif>{{ $staff->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-6">
                              {!! Form::label('borrow_date', 'Date') !!}
                              {!! Form::text('borrow_date', date('F d, Y', strtotime($borrow->borrow_date)), array('class' => 'form-control', 'placeholder' => 'Select Date', 'required' => '', 'readonly' => '')) !!}
                            </div>
                          </div><br/>
                          <div class="row">
                            <div class="col-md-6">
                              {!! Form::label('borrow_type', 'Borrow Type (ধরণ)') !!}
                              <select name="borrow_type" class="form-control" required="">
                                <option value="" selected="" disabled="">Select Borrow Type (ধরণ)</option>
                                <option value="1" @if($borrow->borrow_type == 1) selected="" @endif>Borrow Disburse (বিতরণ)</option>
                                <option value="2" @if($borrow->borrow_type == 2) selected="" @endif>Borrow Collection (আদায়)</option>
                              </select>
                            </div>
                            <div class="col-md-6">
                              {!! Form::label('amount', 'Amount') !!}
                              {!! Form::text('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' => '')) !!}
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

                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteBorrow1Modal{{ $borrow->id }}" data-backdrop="static" title="Delete Borrow"><i class="fa fa-trash"></i></button>
                <!-- Delete Modal -->
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteBorrow1Modal{{ $borrow->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Borrow</h4>
                      </div>
                      <div class="modal-body">
                        Are you sure to delete this borrow? <br/>
                        <big><b>{{ $borrow->user->name }}, ৳ {{ $borrow->amount }}, {{ date('D, d/m/Y', strtotime($borrow->borrow_date)) }}</b></big> 
                      </div>
                      <div class="modal-footer">
                        {!! Form::model($borrow, ['route' => ['dashboard.deleteborrow', $borrow->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                          {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        {!! Form::close() !!}
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Delete Modal -->
                <!-- Delete Modal -->
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>মোট বিতরণ</th>
              <th>৳ {{ $totaldisburse }}</th>
              <th>মোট আদায়</th>
              <th>৳ {{ $totalcollection }}</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>  
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $("#borrow_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $(function() {
      $("#date_to_load").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#loadBorrowsBtn').click(function() {
      var date_to_load =$('#date_to_load').val();

      if(isEmptyOrSpaces(date_to_load))
      {
        if($(window).width() > 768) {
          toastr.warning('Select Date!', 'WARNING').css('width', '400px');
        } else {
          toastr.warning('Select Date!', 'WARNING').css('width', ($(window).width()-25)+'px');
        }
      } else {
        window.location.href = '/dashboard/staffs/borrows/'+ moment(date_to_load).format('YYYY-MM-DD');
      }
    })

    // on enter search
    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }
  </script>
@stop