@extends('backEnd.layouts.master')
@section('title','Whole Seller Customer Profile')
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
                    <a href="{{route('wholesellercustomers.index')}}" class="btn btn-primary rounded-pill">Whole Seller Customer List</a>
                    
                </div>
                <h4 class="page-title">Whole Seller Customer Profile</h4>
            </div>
        </div>
    </div>  
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{asset($profile->image)}}" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">

                    <h4 class="mb-0">{{$profile->name}}</h4>

                    <a href="tel:{{$profile->phone}}" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Call</a>
                    <a href="mailto:{{$profile->email}}" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Email</a>

                    <div class="text-start mt-3">
                        <h4 class="font-13 text-uppercase">About Me :</h4>
                        <table class="table">
                            <tbody>
                            <tr class="text-muted mb-2 font-13">
                                <td>Full Name </td>
                                <td class="ms-2">{{$profile->name}}</td>
                            </tr>

                            <tr class="text-muted mb-2 font-13">
                                <td>Mobile </td>
                                <td class="ms-2">{{$profile->phone}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Package name </td>
                                <td class="ms-2">{{$profile->wholesell->package->title ?? ''}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Package Date</td>
                                <td class="ms-2">{{$profile->wholesell->package->days ?? ''}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Package Amount</td>
                                <td class="ms-2">{{$profile->wholesell->package->charge ?? ''}} Tk</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Payment Type </td> 
                                <td class="ms-2">{{$profile->wholesell ? $profile->wholesell->payment_method : ''}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Sender Number </td> 
                                <td class="ms-2">{{$profile->wholesell ? $profile->wholesell->sender_number : ''}}</td>
                            </tr>

                            <tr class="text-muted mb-2 font-13">
                                <td>Transaction </td> 
                                <td class="ms-2">{{$profile->wholesell ? $profile->wholesell->transaction : ''}}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end card -->

        </div> <!-- end col-->

        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills nav-fill navtab-bg">
                        
                        <li class="nav-item mt-2">
                            <a href="#order" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                               Order
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a href="#withdraw" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                               Withdraw
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="order">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Invoice</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($profile->orders as $key=>$value)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$value->invoice_id}}</td>
                                        <td>{{$value->shipping?$value->shipping->name:''}}</td>
                                        <td>{{date('d-m-Y', strtotime($value->created_at))}} ,{{date('h:i a', strtotime($value->created_at))}}</td>
                                        <td>৳{{$value->amount}}</td>
                                         <td>{{$value->status?$value->status->name:''}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end  item-->
                        <!-- end  item-->
                    </div> <!-- end tab-content -->
                    <div class="tab-pane" id="withdraw">
                        <h4>Withdraw List</h4>
                        <table class="table table-striped dt-responsive nowrap w-100 datatable2 mt-2">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdraws as $key=>$value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->created_at->format('d-m-Y H:m a')}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>@if($value->status=='pending')<span class="badge bg-soft-danger text-danger">{{$value->status}}</span> @else <span class="badge bg-soft-success text-success">{{$value->status}}</span> @endif</td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                            
                        </table>
                    </div>
                    <!-- end tab-pane -->
                </div>
            </div> <!-- end card-->

        </div> <!-- end col -->
        
        
        
    </div>
    <!-- end row-->

</div> <!-- container -->

</div> <!-- content -->
@endsection


@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
@endsection