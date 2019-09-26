@extends('adminlte::page')

@section('title', 'Killa Consultancy | Add Disaster Data')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      Edit Disaster Data
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-10">
          <div class="box box-success">
            <div class="box-body">
              {{-- <form action="{{ route('dashboard.disasterdata.update', $disasterdata->id) }}" method="POST" enctype='multipart/form-data' data-parsley-validate=""> --}}
              {!! Form::model($disasterdata, ['route' => ['dashboard.disasterdata.update', $disasterdata->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '']) !!}
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="member_id">Disaster Category</label><br/>
                    <select class="form-control select" name="discategory_id" id="discategory_id" data-placeholder="Select Disaster Category" disabled="">
                      <option value="" disabled="" selected="">Select Disaster Category</option>
                      @foreach($discategories as $category)
                        <option value="{{ $category->id }}" @if($disasterdata->discategory_id == $category->id) selected="" @endif>{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="member_id">Districts</label><br/>
                    <select class="form-control multiple" name="districtscords[]" id="districtscords" multiple="" data-placeholder="Select Districts">
                      <option disabled>Select Districts</option>
                      @php
                        $associateddistricts = [];
                        foreach($disasterdata->districtscords as $district) {
                          $associateddistricts[] = $district->id;
                        }
                      @endphp
                      @foreach($districtscords as $district)
                        <option value="{{ $district->id }}"
                          @if(in_array($district->id, $associateddistricts)) selected="" @endif
                          >{{ $district->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <button class="btn btn-primary" type="submit">Submit</button>
              {!! Form::close() !!}
            </div>
          </div>
      </div>
    </div>

@stop

@section('js')
  {!!Html::script('js/parsley.min.js')!!}
  <script>
    $(document).ready(function(){
      $('.select').select2();
      $('.multiple').select2();
    });
  </script>
@stop