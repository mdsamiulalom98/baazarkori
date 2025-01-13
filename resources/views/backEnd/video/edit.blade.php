@extends('backEnd.layouts.master')
@section('title','Register Video Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('video.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Register Video Edit</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <form action="{{route('video.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data" name="editForm">
                    @csrf
                    <input type="hidden" value="{{$edit_data->id}}" name="hidden_id">
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Banner Category</label>
                             <select class="form-control select2-multiple @error('link') is-invalid @enderror" name="category_id" data-toggle=""  data-placeholder="Choose ...">
                                <optgroup>
                                    <option value="">Select..</option>
                                    @foreach($categories as $value)
                                    <option  value="{{$value->id}}" @if($edit_data->category_id==$value->id)selected @endif>{{$value->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <!-- col end -->
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Video Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $edit_data->title}}"  id="title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="video" class="form-label">Video </label>
                            <input type="text" class="form-control @error('video') is-invalid @enderror" name="video" value="{{ $edit_data->video }}"  id="video">
                            @error('video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->

                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="status" class="d-block">Status</label>
                            <label class="switch">
                                <input type="checkbox" value="1" name="status" @if($edit_data->status==1)checked @endif>
                                <span class="slider round"></span>
                            </label>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>

                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>
@endsection



@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-pickers.init.js"></script>
<!-- Plugins js -->
<script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
  $(".summernote").summernote({
    placeholder: "Enter Your Text Here",
  });
</script>
<script type="text/javascript">
    document.forms['editForm'].elements['product_id'].value="{{$edit_data->product_id}}"
    $('.select2').select2();
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-increment").click(function () {
            var html = $(".clone").html();
            $(".increment").after(html);
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".control-group").remove();
        });
        $('.select2').select2();
    });
</script>
@endsection