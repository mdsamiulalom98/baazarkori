@extends('backEnd.layouts.master')
@section('title','Package Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('packages.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Package Edit</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('packages.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$edit_data->id}}" name="id">
                    
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="package_name" class="form-label">Package Name (Optional)</label>
                            <input type="text" class="form-control @error('package_name') is-invalid @enderror" name="package_name" value="{{$edit_data->package_name}}" id="package_name" >
                            @error('package_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- end-col -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="amount" class="form-label">Amount *</label>
                            <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{$edit_data->amount}}" id="amount" required="">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Package Category</label>
                             <select class="form-control select2-multiple @error('link') is-invalid @enderror" name="category_id" data-toggle="select2"  data-placeholder="Choose ...">
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
                    <div class="col-sm-12 mb-3">
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
@endsection