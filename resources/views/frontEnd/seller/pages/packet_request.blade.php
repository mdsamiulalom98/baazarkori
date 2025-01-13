@extends('frontEnd.seller.pages.master')
@section('title', 'Seller Packagin Poly')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('seller.packet') }}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Packet Request</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('seller.packet_store')}}" method="POST" data-parsley-validate="" class="row">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Package *</label>
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                    name="category_id" value="{{ old('category_id') }}" id="category_id" required>
                                    <option value="">Select Our Any Package.......</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->package_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="shop_name" class="form-label">Shop Name</label>
                                <input class="form-control @error('shop_name') is-invalid @enderror" type="text" name="shop_name" id="shop_name" value="{{ Auth('seller')->user()->name ?? old('shop_name') }}" placeholder="Enter shop name" readonly />
                                @error('shop_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- form group end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="number" name="phone" id="phone" value="{{Auth('seller')->user()->phone ?? old('phone') }}" placeholder="Enter phone number" required />
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- form group end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <label for="district">District *</label>
                                <select id="district"
                                    class="form-control select2 district @error('district') is-invalid @enderror"
                                    name="district" value="{{ old('district') }}" required>
                                    <option value="">Select...</option>
                                    @foreach ($districts as $key => $district)
                                        <option value="{{ $district->district }}">
                                            {{ $district->district }}</option>
                                    @endforeach
                                </select>
                                @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group my-1">
                                <label for="area">Upazila *</label>
                                <select id="area"
                                    class="form-control area select2 @error('area') is-invalid @enderror"
                                    name="area" value="{{ old('area') }}" required>
                                    <option value="">Select...</option>
                                </select>
                                @error('upazila')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group my-2">
                                 <button type="submit" class="btn btn-success"> Submit Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/selectize/js/standalone/selectize.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            flatpickr(".flatdate", {});
        });
    </script>
    <script>
        $("#area").on("change", function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: {
                id: id
            },
            url: "{{ route('shipping.charge') }}",
            dataType: "html",
            success: function(response) {
                $(".cartlist").html(response);
            },
        });
    });
    </script>
@endpush
