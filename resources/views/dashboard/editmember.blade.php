@extends('adminlte::page')

@section('title', 'Killa Consultancy | Add Member')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote-bs3.css') }}">
@stop

@section('content_header')
    <h1>
      Add Member
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-10">
          <div class="box box-success">
            <div class="box-body">
              {!! Form::model($member, ['route' => ['dashboard.member.update', $member->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group no-margin-bottom">
                          <label for="name" class="text-uppercase">Name</label>
                          <input class="form-control" type="text" name="name" id="name" value="{{ $member->name }}" required="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group no-margin-bottom">
                          <label for="email" class="text-uppercase">Email</label>
                          <input class="form-control" type="text" name="email" id="email" value="{{ $member->email }}" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group no-margin-bottom">
                          <label for="phone" class="text-uppercase">Phone</label>
                          <input class="form-control" type="text" name="phone" id="phone" value="{{ $member->phone }}" required="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group no-margin-bottom">
                          <label for="designation" class="text-uppercase"> Designation</label>
                          <input class="form-control" type="text" name="designation" id="designation" value="{{ $member->designation }}" required="">
                      </div>
                    </div>
                  </div>
              
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group no-margin-bottom">
                          <label for="fb" class="text-uppercase">Facebook Url</label>
                          <input class="form-control" type="text" name="fb" id="fb" value="{{ $member->fb }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group no-margin-bottom">
                          <label for="twitter" class="text-uppercase">Twitter Url</label>
                          <input class="form-control" type="text" name="twitter" id="twitter" value="{{ $member->twitter }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group no-margin-bottom">
                          <label for="linkedin" class="text-uppercase">Linkedin Url</label>
                          <input class="form-control" type="text" name="linkedin" id="linkedin" value="{{ $member->linkedin }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-8">
                            <div class="form-group no-margin-bottom">
                                <label><strong>Photo (300 X 300 &amp; 200Kb Max):</strong></label>
                                <input class="form-control" type="file" id="image" name="image">
                            </div>
                        </div>
                        <div class="col-md-4">
                        	@if($member->image != null && file_exists(public_path('images/users/' . $member->image)))
                        		<img src="{{ asset('images/users/' . $member->image) }}" id='img-upload' style="height: 120px; width: auto; padding: 5px;" />
                        	@else
                        		<img src="{{ asset('images/user.png') }}" id='img-upload' style="height: 120px; width: auto; padding: 5px;" />
                        	@endif
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group no-margin-bottom">
                      <label for="bio" class="text-uppercase">Biography</label>
                      <textarea type="text" name="bio" id="bio" class="summernote" required="">{!! $member->bio !!}</textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="bio" class="text-uppercase">Type</label><br/>
                      <label class="radio-inline"><input type="radio" name="type" value="Member" @if($member->type == 'Member') checked @endif>Member</label>
                      <label class="radio-inline"><input type="radio" name="type" value="Employee" @if($member->type == 'Employee') checked @endif>Employee</label>
                      <label class="radio-inline"><input type="radio" name="type" value="Director" @if($member->type == 'Director') checked @endif>Director</label>
                      <label class="radio-inline"><input type="radio" name="type" value="Advisor" @if($member->type == 'Advisor') checked @endif>Advisor</label>
                    </div>
                    <div class="col-md-6">
                      <label for="bio" class="text-uppercase">Admin Role?</label><br/>
                      <label class="radio-inline"><input type="radio" name="adminornot" value="0" @if($member->role != 'admin') checked @endif>NO</label>
                      <label class="radio-inline"><input type="radio" name="adminornot" value="1" @if($member->role == 'admin') checked @endif>YES</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <br/>
                      <div class="form-group no-margin-bottom">
                          <label for="password" class="text-uppercase">Password (If don't want to change password, leave it blank)</label>
                          <input class="form-control" type="password" name="password"  autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-primary" type="submit">Submit</button>
              {!! Form::close() !!}
            </div>
          </div>
      </div>
    </div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
  
  <script>
	  $(document).ready(function(){
	      $('.summernote').summernote({
	          placeholder: 'Write Biography',
	          tabsize: 2,
	          height: 200,
	          dialogsInBody: true
	      });
	      $('div.note-group-select-from-files').remove();

	      setTimeout(
	          function() { $(':password').val(''); 
	      }, 1000);
      });
  </script>
    <script type="text/javascript">
    var _URL = window.URL || window.webkitURL;
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
      });

      $('.btn-file :file').on('fileselect', function(event, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image").change(function(){
        readURL(this);
        var file, img;

        if ((file = this.files[0])) {
          img = new Image();
          img.onload = function() {
            var imagewidth = this.width;
            var imageheight = this.height;
            filesize = parseInt((file.size / 1024));
            if(filesize > 300) {
              $("#image").val('');
              toastr.warning('Filesize: '+filesize+' KB. Please upload within 300KB', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
            console.log(imagewidth/imageheight);
            if(((imagewidth/imageheight) < 0.9375) || ((imagewidth/imageheight) > 1.07142)) {
              $("#image").val('');
              toastr.warning('Raio of the photograph should be 1:1', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
          };
          img.onerror = function() {
            $("#image").val('');
            toastr.warning('Select a photograph please', 'WARNING').css('width', '400px;');
            setTimeout(function() {
              $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
            }, 1000);
          };
          img.src = _URL.createObjectURL(file);
        }
      });
    });
  </script>
@stop