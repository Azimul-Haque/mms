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
      <div class="col-md-8">
        <div class="panel panel-primary">
          <div class="panel-heading">Edit Staff</div>
          {!! Form::model($staff, ['route' => ['dashboard.staffs.update', $staff->id], 'method' => 'PUT']) !!}
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('name', 'Staff Name *') !!}
                {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Staff Name', 'required' => '')) !!}<br/>
              </div>
              <div class="col-md-6">
                {!! Form::label('phone', 'Mobile Number (11 Digit) *') !!}
                {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Mobile Number (11 Digit)', 'onkeypress' => 'if(this.value.length==11) return false;', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {!! Form::label('father', 'Father *') !!}
                {!! Form::text('father', null, array('class' => 'form-control', 'placeholder' => 'Name of Father', 'required' => '')) !!}<br/>
              </div>
              <div class="col-md-6">
                {!! Form::label('nid', 'NID *') !!}
                {!! Form::text('nid', null, array('class' => 'form-control', 'placeholder' => 'NID', 'onkeypress' => 'if(this.value.length==17) return false;', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                {!! Form::label('bank', 'Bank Name *') !!}
                {!! Form::text('bank', null, array('class' => 'form-control', 'placeholder' => 'Bank Name', 'required' => '')) !!}<br/>
              </div>
              <div class="col-md-4">
                {!! Form::label('acno', 'Bank Account No *') !!}
                {!! Form::text('acno', null, array('class' => 'form-control', 'placeholder' => 'Bank Account No', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
              <div class="col-md-4">
                {!! Form::label('checkno', 'Check No *') !!}
                {!! Form::text('checkno', null, array('class' => 'form-control', 'placeholder' => 'Check No', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                {!! Form::label('password', 'Password *') !!}
                {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required' => '', 'autocomplete' => 'off')) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('password_confirmation', 'Confirm Password *') !!}
                {!! Form::password('password_confirmation' , array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'required' => '')) !!}</div>
            </div>
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