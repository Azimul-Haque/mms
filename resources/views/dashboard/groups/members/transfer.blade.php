@extends('adminlte::page')

@section('title', 'Transfer Member | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>
      Transfer Member
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Transfer Member</div>
          {!! Form::model($member, ['route' => ['dashboard.member.transfer', $member->id], 'method' => 'PUT']) !!}
          <div class="panel-body">
            {!! Form::label('name', 'Member Name') !!}
            {!! Form::text('name', $member->name, array('class' => 'form-control', 'readonly' => '')) !!}
            
            <br/>
            {!! Form::label('group_id', 'Transfer Group *') !!}
            <select name="group_id" id="group_id" class="form-control" required>
              <option disabled="">Select Group</option>
              @foreach($groups as $groupselect)
                <option value="{{ $groupselect->id }}" @if($groupselect->id == $member->group_id) selected="" @endif>{{ $groupselect->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="panel-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="col-md-4">

      </div>
    </div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript">
    $(function() {
      $("#formation").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
      });
    });

    $('#group_id').select2();
  </script>
@endsection