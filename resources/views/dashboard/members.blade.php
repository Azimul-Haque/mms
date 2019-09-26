@extends('adminlte::page')

@section('title', 'Killa Consultancy | People')

@section('css')

@stop

@section('content_header')
    <h1>
      People
      <div class="pull-right">
        <a href="{{ route('dashboard.member.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add People</a>
      </div>
    </h1>
@stop

@section('content')
  {{-- Table of Directors --}}
  {{-- Table of Directors --}}
  <div class="table-responsive">
    <span style="padding: 10px; font-size: 20px; font-weight: bold;">Directors</span>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email & Phone</th>
          <th>Designation</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $addmodalflag = 0; $editmodalflag = 0; @endphp
        @foreach($directors as $member)
        <tr>
          <td>
            {{ $member->name }}
            @if($member->role == 'admin')
              <span class="label label-success" title="This user is an Admin">Admin</span>
            @endif
          </td>
          <td>{{ $member->email }}<br/>{{ $member->phone }}</td>
          <td>{{ $member->designation }}</td>
          <td>
            @if($member->image != null)
            <img src="{{ asset('images/users/'.$member->image)}}" style="height: 40px; width: auto;" />
            @else
            <img src="{{ asset('images/user.png')}}" style="height: 40px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('dashboard.member.edit', $member->id) }}" title="Edit this Profile"><i class="fa fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $member->id }}" data-backdrop="static" title="Delete this Profile" disabled=""><i class="fa fa-trash-o"></i></button>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
            <div class="modal fade" id="deleteMemberModal{{ $member->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Member</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete the member of <b>{{ $member->name }}</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($member, ['route' => ['dashboard.deletemember', $member->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{-- Table of Directors --}}
  {{-- Table of Directors --}}


  {{-- Table of Advisors --}}
  {{-- Table of Advisors --}}
  <div class="table-responsive">
    <span style="padding: 10px; font-size: 20px; font-weight: bold;">Advisors</span>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email & Phone</th>
          <th>Designation</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $addmodalflag = 0; $editmodalflag = 0; @endphp
        @foreach($advisors as $member)
        <tr>
          <td>
            {{ $member->name }}
            @if($member->role == 'admin')
              <span class="label label-success" title="This user is an Admin">Admin</span>
            @endif
          </td>
          <td>{{ $member->email }}<br/>{{ $member->phone }}</td>
          <td>{{ $member->designation }}</td>
          <td>
            @if($member->image != null)
            <img src="{{ asset('images/users/'.$member->image)}}" style="height: 40px; width: auto;" />
            @else
            <img src="{{ asset('images/user.png')}}" style="height: 40px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('dashboard.member.edit', $member->id) }}" title="Edit this Profile"><i class="fa fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $member->id }}" data-backdrop="static" title="Delete this Profile" disabled=""><i class="fa fa-trash-o"></i></button>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
            <div class="modal fade" id="deleteMemberModal{{ $member->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Member</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete the member of <b>{{ $member->name }}</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($member, ['route' => ['dashboard.deletemember', $member->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{-- Table of Advisors --}}
  {{-- Table of Advisors --}}

  {{-- Table of Employees --}}
  {{-- Table of Employees --}}
  <div class="table-responsive">
    <span style="padding: 10px; font-size: 20px; font-weight: bold;">Employees</span>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email & Phone</th>
          <th>Designation</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $addmodalflag = 0; $editmodalflag = 0; @endphp
        @foreach($employees as $member)
        <tr>
          <td>
            {{ $member->name }}
            @if($member->role == 'admin')
              <span class="label label-success" title="This user is an Admin">Admin</span>
            @endif
          </td>
          <td>{{ $member->email }}<br/>{{ $member->phone }}</td>
          <td>{{ $member->designation }}</td>
          <td>
            @if($member->image != null)
            <img src="{{ asset('images/users/'.$member->image)}}" style="height: 40px; width: auto;" />
            @else
            <img src="{{ asset('images/user.png')}}" style="height: 40px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('dashboard.member.edit', $member->id) }}" title="Edit this Profile"><i class="fa fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $member->id }}" data-backdrop="static" title="Delete this Profile" disabled=""><i class="fa fa-trash-o"></i></button>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
            <div class="modal fade" id="deleteMemberModal{{ $member->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Member</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete the member of <b>{{ $member->name }}</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($member, ['route' => ['dashboard.deletemember', $member->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{-- Table of Employees --}}
  {{-- Table of Employees --}}

  {{-- Table of Members --}}
  {{-- Table of Members --}}
  <div class="table-responsive">
    <span style="padding: 10px; font-size: 20px; font-weight: bold;">Members</span>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email & Phone</th>
          <th>Designation</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $addmodalflag = 0; $editmodalflag = 0; @endphp
        @foreach($members as $member)
        <tr>
          <td>
            {{ $member->name }}
            @if($member->role == 'admin')
              <span class="label label-success" title="This user is an Admin">Admin</span>
            @endif
          </td>
          <td>{{ $member->email }}<br/>{{ $member->phone }}</td>
          <td>{{ $member->designation }}</td>
          <td>
            @if($member->image != null)
            <img src="{{ asset('images/users/'.$member->image)}}" style="height: 40px; width: auto;" />
            @else
            <img src="{{ asset('images/user.png')}}" style="height: 40px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('dashboard.member.edit', $member->id) }}" title="Edit this Profile"><i class="fa fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $member->id }}" data-backdrop="static" title="Delete this Profile" disabled=""><i class="fa fa-trash-o"></i></button>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
            <div class="modal fade" id="deleteMemberModal{{ $member->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Member</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete the member of <b>{{ $member->name }}</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($member, ['route' => ['dashboard.deletemember', $member->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div>
    {{ $members->links() }}
  </div>
  {{-- Table of Members --}}
  {{-- Table of Members --}} 
@stop

@section('js')

@stop