@extends('adminlte::page')

@section('title', 'Add Staff | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Add Staff
      {{-- <div class="pull-right">
        <a href="{{ route('dashboard.staffs.create') }}" class="btn btn-primary" title="Add a New Staff"><i class="fa fa-plus"></i> Add Staff</a>
      </div> --}}
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Add Staff</div>
          {!! Form::open(['route' => 'dashboard.staffs.store', 'method' => 'POST']) !!}
          <div class="panel-body">
            {!! Form::label('name', 'Staff Name *') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Staff Name', 'required' => '')) !!}<br/>

            {!! Form::label('phone', 'Mobile Number (11 Digit) *') !!}
            {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Mobile Number (11 Digit)', 'onkeypress' => 'if(this.value.length==11) return false;', 'required' => '', 'autocomplete' => 'off')) !!}<br/>


            {!! Form::label('password', 'Password *') !!}
            {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required' => '', 'autocomplete' => 'off')) !!}<br/>

            {!! Form::label('password_confirmation', 'Confirm Password *') !!}
            {!! Form::password('password_confirmation' , array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'required' => '')) !!}
          </div>
          <div class="panel-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="col-md-6">

      </div>
    </div>
@stop

@section('js')
  <script type="text/javascript">
    setTimeout(function(){ 
      $('#phone').val('');
    }, 500);
    setTimeout(function(){ 
      $('#password').val('');
    }, 500);
  </script>
@endsection