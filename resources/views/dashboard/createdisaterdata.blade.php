@extends('adminlte::page')

@section('title', 'Killa Consultancy | Add Disaster Data')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      Add Disaster Data
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-10">
          <div class="box box-success">
            <div class="box-body">
              <form action="{{ route('dashboard.disasterdata.store') }}" method="post" enctype='multipart/form-data' data-parsley-validate="">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="member_id">Disaster Category</label><br/>
                    <select class="form-control select" name="discategory_id" id="discategory_id" data-placeholder="Select Disaster Category">
                      <option value="" disabled="" selected="">Select Disaster Category</option>
                      @foreach($discategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="member_id">Districts</label><br/>
                    <select class="form-control multiple" name="districtscords[]" id="districtscords" multiple="" data-placeholder="Select Districts">
                      <option disabled>Select Districts</option>
                      @foreach($districtscords as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <button class="btn btn-primary" type="submit">Submit</button>
              </form>
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