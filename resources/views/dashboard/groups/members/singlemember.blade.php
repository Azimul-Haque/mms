@extends('adminlte::page')

@section('title', $member->name . ' | Microfinance Management')

@section('css')

@stop

@section('content_header')
    <h1>Member: <b>{{ $member->name }}-{{ $member->fhusband }}({{ $member->passbook }})</b>, Group: <b>{{ $group->name }}</b>, Staff: <b>{{ $staff->name }}</b></h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.member.dailytransaction.date', [$staff->id, $group->id, $member->id, 1, date('Y-m-d')]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-exchange"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Daily</span>
              <span class="info-box-number">Transaction</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.member.loans', [$staff->id, $group->id, $member->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Loan</span>
              <span class="info-box-number">Account</span>
            </div>
          </div>
        </a>
      </div>

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.member.savings', [$staff->id, $group->id, $member->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-database"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Saving</span>
              <span class="info-box-number">Accounts</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-address-book-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Member</span>
              <span class="info-box-number">Summary</span>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.member.gettransfer', [$staff->id, $group->id, $member->id]) }}">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-paper-plane"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Transfer</span>
              <span class="info-box-number">Member</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#!" data-toggle="modal" data-target="#closeMemberModal" data-backdrop="static">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-archive"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Close</span>
              <span class="info-box-number">Member</span>
            </div>
          </div>
    	  </a>
        <!-- Close Modal -->
        <!-- Close Modal -->
        <div class="modal fade" id="closeMemberModal" role="dialog">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Close Member</h4>
              </div>
              <div class="modal-body">
                Are you sure to Close this member: <b>{{ $member->name }}-{{ $member->fhusband }}({{ $member->passbook }})</b> ?
              </div>
              <div class="modal-footer">
                {!! Form::model($member, ['route' => ['dashboard.member.close', $member->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                    {!! Form::submit('Submit', array('class' => 'btn btn-danger')) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
        <!-- Close Modal -->
        <!-- Close Modal -->
      </div>

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        {{-- <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-user-times"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Bad</span>
              <span class="info-box-number">Debt</span>
            </div>
          </div>
        </a> --}}
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        {{-- <a href="#!">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-cogs"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Transfer</span>
              <span class="info-box-number">to Bad Debt</span>
            </div>
          </div>
        </a> --}}
      </div>
    </div>
@stop

@section('js')

@endsection