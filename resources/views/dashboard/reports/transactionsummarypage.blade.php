@extends('adminlte::page')

@section('title', 'Generate Transaction Summary | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>Generate Transaction Summary</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-primary">
          <div class="panel-heading">Generate Transaction Summary</div>

          {!! Form::open(['route' => 'report.program.transactionsummary', 'method' => 'POST']) !!}
          <div class="panel-body">
              {!! Form::label('datetocalc', 'Select Date *') !!}
              <input class="form-control" type="text" name="datetocalc" id="datetocalc" value="" placeholder="Select Date" readonly="">
          </div>
          <div class="panel-footer">
            <button type="submit" class="btn btn-primary">দাখিল করুন</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript">
    $(function() {
      $("#datetocalc").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });
  </script>
@endsection