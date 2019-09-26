@extends('adminlte::page')

@section('title', 'Killa Consultancy | Research Expertises')

@section('css')

@stop

@section('content_header')
    <h1>
      Research Expertises
      <div class="pull-right">
        <a href="{{ route('dashboard.expertise.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Expertise</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="25%">Title</th>
          <th>Description</th>
          <th width="30%">Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $addmodalflag = 0; $editmodalflag = 0; @endphp
        @foreach($expertises as $expertise)
        <tr>
          <td>{{ $expertise->title }}</td>
          <td><span class="">{{ substr(strip_tags($expertise->description), 0, 100) }}...</span></td>
          <td>
            @if($expertise->image != null)
            <img src="{{ asset('images/expertises/'.$expertise->image)}}" style="height: 120px; width: auto;" />
            @else
            <img src="{{ asset('images/abc.png')}}" style="height: 120px; width: auto;" />
            @endif
          </td>
          <td>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $expertise->id }}" data-backdrop="static" title="Delete Application" disabled=""><i class="fa fa-trash-o"></i></button>
            <!-- Delete Expertise Modal -->
            <!-- Delete Expertise Modal -->
            <div class="modal fade" id="deleteMemberModal{{ $expertise->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Member</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete the member of <b>{{ $expertise->name }}</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($expertise, ['route' => ['dashboard.deletemember', $expertise->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Expertise Modal -->
            <!-- Delete Expertise Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div>
    {{ $expertises->links() }}
  </div>    
@stop

@section('js')

@stop