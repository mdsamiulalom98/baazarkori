@extends('frontEnd.seller.pages.master')
@section('title', 'Seller Report Sms')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Seller Report Sms</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="customer-content checkout-shipping">
                                <form action="{{route('seller.smsreport.save')}}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="">
                                    @csrf

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="report" class="form-label">Report Note *</label>
                                    <input type="text" class="form-control @error('report') is-invalid @enderror" name="report" value="{{ old('report') }}" id="report" required="">
                                    @error('report')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->


                                   <!-- <div class="col-sm-12 mt-3">
                                       <label class="form-label">Payment Method <span>*</span></label>
                                       <div class="select_method">
                                             <div class="form-check p_cash payment_method" data-id="cod">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                id="inlineRadio1" value="bkash" checked required />
                                                <label class="form-check-label" for="inlineRadio1">
                                                    Bkash
                                                </label>
                                            </div>
                                       </div>
                                   </div> -->

                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="image" class="form-label">Image *</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"  id="image" required="">
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col end -->


                                    <div class="col-sm-12">
                                        <div class="form-group mb-3 text-center">
                                            <button type="submit" class="submit-btn btn btn-success">Submit Now</button>
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                </form>
                            </div>
                        </div>
                    </div>



                     <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection


@push('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/select2.min.js"></script>
@endpush

