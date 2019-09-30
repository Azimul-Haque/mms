@extends('adminlte::page')

@section('title', 'Edit Staff | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>
      Edit Staff
      {{-- <div class="pull-right">
        <a href="{{ route('dashboard.staffs.create') }}" class="btn btn-primary" title="Add a New Staff"><i class="fa fa-plus"></i> Add Staff</a>
      </div> --}}
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Edit Staff</div>
          {!! Form::model($staff, ['route' => ['dashboard.staffs.update', $staff->id], 'method' => 'PUT']) !!}
          <div class="panel-body">
            {!! Form::label('name', 'Staff Name *') !!}
            {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}<br/>

            {!! Form::label('phone', 'Mobile Number (11 Digit) *') !!}
            {!! Form::text('phone', null, array('class' => 'form-control', 'onkeypress' => 'if(this.value.length==11) return false;', 'required' => '', 'autocomplete' => 'off')) !!}<br/>


            {!! Form::label('password', 'Password *') !!}
            {!! Form::password('password', array('class' => 'form-control', 'required' => '', 'autocomplete' => 'off')) !!}<br/>

            {!! Form::label('password_confirmation', 'Confirm Password *') !!}
            {!! Form::password('password_confirmation' , array('class' => 'form-control', 'required' => '')) !!}
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
      $('#password').val('');
    }, 500);
  </script>
@endsection