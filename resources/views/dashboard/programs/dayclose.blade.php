@extends('adminlte::page')

@section('title', 'Day Close | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
@stop

@section('content_header')
    <h1>Day Close</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-primary">
          <div class="panel-heading">Close a Day</div>

          {!! Form::open(['route' => 'programs.store.day.close', 'method' => 'POST']) !!}
          <div class="panel-body">
              {!! Form::label('close_date', 'Select Date *') !!}
              <input class="form-control" type="text" name="close_date" id="close_date" value="" placeholder="Select Date" readonly="">
              <br/>
              <label>
                <input type="checkbox" name="checkbox" class="icheck" required="">
                <span>নিশ্চিত করুন <small>(দাখিলের পর এই তারিখে আর তথ্য দেওয়া যাবে না)</small></span>
              </label>
          </div>
          <div class="panel-footer">
            <button type="submit" class="btn btn-primary">দাখিল করুন</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="col-md-6">
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($closedays as $closeday)
                <tr>
                  <td>{{ date('D, d/m/Y', strtotime($closeday->close_date)) }}</td>
                  <td>Closed</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{ $closedays->links() }}
      </div>
    </div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.js') }}"></script>
  <script type="text/javascript">
    $(function() {
      $("#close_date").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });
  </script>
  <script>
    $(document).ready(function(){
      $('.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
@endsection