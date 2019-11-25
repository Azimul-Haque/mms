@extends('adminlte::page')

@section('title', 'Update PassBook | Microfinance Management')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plain-table.css') }}">
@stop

@section('content_header')
    <h1>
      Update PassBook [Staff: <b>{{ $staff->name }}</b>, Group: <b>{{ $group->name }}</b>]
      <div class="pull-right">
       
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-condensed table-bordered" id="editable">
            <thead>
              <tr>
                <th width="100px">Passbook #</th>
                <th>Name</th>
                <th>Father/Husband</th>
                <th>Is Husband</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)
                <tr>
                  <td id="passbook{{ $member->id }}" onchange="updatepassbook({{ $member }})">{{ $member->passbook }}</td>
                  <td readonly>
                    <a href="{{ route('dashboard.member.single', [$staff->id, $group->id, $member->id]) }}" @if($member->loans->count() > 0) style="color: #DD4B39;" @else style="color: #000000;" @endif><i class="fa fa-user"></i> {{ $member->name }}</a>
                  </td>
                  <td readonly>{{ $member->fhusband }}</td>
                  <td readonly>{{ ishusband($member->ishusband) }}</td>
                  <td readonly><span class="label label-{{ statuscolor($member->status) }}">{{ status($member->status) }}</span></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop

@section('js')
  <script src="{{ asset('js/mindmup-editabletable.js') }}"></script>
  <script>
    $(document).ready(function () {
      $('#editable').editableTableWidget();
      
      $('#editable td.uneditable').on('change', function(evt, newValue) {
        console.log('false clicked!');
        return false;
      });
    });
    $('#editable td').on('change', function(evt, newValue) {
      // toastr.success(newValue + ' Added!', 'SUCCESS').css('width', '400px');
    });

    function updatepassbook(member) {
      var passbook = parseInt($('#passbook' + member.id).text()) ? parseInt($('#passbook' + member.id).text()) : null;
      console.log(passbook);
      // now post the data
      $.post("/group/members/update/passbook/api", {_token: '{{ csrf_token() }}', _method : 'POST', 
        data: {
          member_id: member.id,
          passbook: passbook
        }},
        function(data, status){
        console.log(status);
        console.log(data);
        if(status == 'success') {
          toastr.success('Member: <b>' + member.name + '</b><br/>PassBook no updated!').css('width', '400px');
        } else {
          toastr.warning('Error!').css('width', '400px');
        }
      });
      
    }

    $('td[readonly]').on('click dblclick keydown', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });

  </script>
@stop