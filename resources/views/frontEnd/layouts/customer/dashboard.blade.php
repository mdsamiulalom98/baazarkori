@extends('frontEnd.layouts.master')
@section('title','Customer Dashboard')
@section('css')
<!-- Plugins css -->
<link href="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd/')}}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<section class="customer-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="customer-sidebar">
                    @include('frontEnd.layouts.customer.sidebar')
                </div>
            </div>
            <div class="col-sm-9">
                @if(Auth::guard('customer')->user()->seller_type == 1)
                 <div class="customer-content mb-3">
                    <h5 class="account-title">Refer Link</h5>
                    <div class="referral-program-referral">
                        <form class="reffer_form">
                            <div class="form-copy-input-cont d-flex align-items-center flex-grow-1">
                            <input type="text" id="aff-link" value="{{url('?r='.Auth::guard('customer')->user()->refferal_id)}}" readonly="" />
                            </div>
                            <button type="button" class="btn btn-with-icon form-copy-btn copylink" value="{{url('?r='.Auth::guard('customer')->user()->refferal_id)}}" data-toggle="tooltip" data-placement="right" title="Copy to Clipboard"><i class="far fa-copy"></i></button>
                        </form>
                    </div>
                </div>
                @endif
                <div class="customer-content">
                    <h5 class="account-title">Dashboard</h5>
                    <!--dashboard-short-view-start-->
                    @php
                        $orderCount = $orders->count();
                        $withdrawsCount = $withdraws->count();
                    @endphp
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="short-dashboard card">
                                <div class="card-body">
                                    <a href="{{route('customer.orders','all')}}">
                                        <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg dash-round front-dash bg-primary bg-gradient bg-opacity-25 border-primary border">
                                                <i class="fa-solid fa-cart-shopping text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$orderCount}}</span></h3>
                                                <p class="text-end mb-1 dashborad-text">My Order</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                    </a>
                                </div>
                            </div> <!-- end short-dashboard-->
                        </div>
                        <!-- end col-->
                        <div class="col-md-6 col-xl-4">
                            <div class="short-dashboard card">
                                <div class="card-body">
                                    <a href="{{route('customer.wallet')}}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg dash-round front-dash bg-success bg-gradient bg-opacity-25 border-success border">
                                                <i class="fa-solid fa-coins text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{Auth::guard('customer')->user()->balance}}৳</span></h3>
                                                <p class="text-end mb-1 dashborad-text">Balance</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                    </a>
                                </div>
                            </div> <!-- end short-dashboard-->
                        </div>
                        <!-- end col-->
                        <div class="col-md-6 col-xl-4">
                            <div class="short-dashboard card">
                                <div class="card-body">
                                    <a href="{{route('customer.withdraw')}}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg dash-round front-dash bg-warning bg-secondary bg-gradient bg-opacity-25 border-bg-secondary">
                                                <i class="fa-solid fa-list text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$withdrawsCount}}</span></h3>
                                                <p class="text-end mb-1 dashborad-text">Withdraw</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                    </a>
                                </div>
                            </div> <!-- end short-dashboard-->
                        </div>
                        <!-- end col-->
                        <div class="col-md-6 col-xl-4">
                            <div class="short-dashboard card">
                                <div class="card-body">
                                    <a href="{{route('customer.orders','all')}}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg dash-round front-dash bg-danger  bg-danger  bg-gradient bg-opacity-25 border-bg-danger">
                                                <i class="fa-brands fa-sellcast text-danger "></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$totalOrderAmount}}৳</span></h3>
                                                <p class="text-end mb-1 dashborad-text">Total sell</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                    </a>
                                </div>
                            </div> <!-- end short-dashboard-->
                        </div>
                        <!-- end col-->
                        <div class="col-md-6 col-xl-4">
                            <div class="short-dashboard card">
                                <div class="card-body">
                                    <a href="{{route('customer.commissions')}}">
                                        <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg dash-round front-dash bg-primary bg-gradient bg-opacity-25 border-primary border">
                                                <i class="fa-solid fa-arrow-up-wide-short text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$totalCommission}}৳</span></h3>
                                                <p class="text-end mb-1 dashborad-text">Total Earn</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                    </a>
                                </div>
                            </div> <!-- end short-dashboard-->
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row-->
                    <!--dashboard-short-view-end-->
                    <!--dashboard-section-start-->
                     <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Orders</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Customer</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $key => $value)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$value->created_at->format('d-m-y')}}</td>
                                                    <td>৳{{$value->amount}}</td>
                                                    <td>{{$value->customer?$value->customer->name:''}}</td>
                                                    <td>{{$value->status ? $value->status->name : ''}}</td>
                                                    <td>
                                                        <a href="{{ route('customer.invoice', ['id' => $value->id]) }}" class="invoice_btn"><i class="fa-solid fa-eye"></i></a>
                                                        @if($value->admin_note)
                                                        <a href="{{ route('customer.order_note', ['id' => $value->id]) }}" class="invoice_btn bg-primary"><i class="fa-solid fa-pencil"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="custom-paginate">
                                        {{$orders->links('pagination::bootstrap-4')}}
                                        </div>
                                        <!-- <div class="text-center mt-3">
                                            <button id="show-more-btn" class="btn btn-primary">Show More</button>
                                            <button id="show-less-btn" class="btn btn-secondary" style="display:none;">Show Less</button>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title mb-3">My Commissions</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                            <thead class="table-light">
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Invoice</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($commissions as $key => $value)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$value->customer ? $value->customer->name : ''}}</td>
                                                    <td>{{$value->created_at->format('d-m-y')}}</td>
                                                    <td>{{$value->invoice_id}}</td>
                                                    <td>৳{{$value->commission}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="custom-paginate">
                                        {{$commissions->links('pagination::bootstrap-4')}}
                                        </div>
                                        <!-- <div class="text-center mt-3">
                                            <button id="show-more-btn-c" class="btn btn-primary">Show More</button>
                                            <button id="show-less-btn-c" class="btn btn-secondary" style="display:none;">Show Less</button>
                                        </div> -->
                                    </div> <!-- end .table-responsive-->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                    </div>
                    <!-- end row -->
                    <!--dashboard-section-end-->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>

<script>
         $(".copylink").on("click", function () {
            var copyText = $(this).val();
            var el = document.createElement('textarea');
            el.value = copyText;
            el.setAttribute('readonly', '');
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
             toastr.success('Refer link copy success');
        });
    </script>
    <!-- <script>
        document.getElementById('show-more-btn').addEventListener('click', function() {
            document.querySelectorAll('.more-orders').forEach(function(row) {
                row.style.display = '';
            });
            document.getElementById('show-more-btn').style.display = 'none';
            document.getElementById('show-less-btn').style.display = 'inline-block';
        });

        document.getElementById('show-less-btn').addEventListener('click', function() {
            document.querySelectorAll('.more-orders').forEach(function(row) {
                row.style.display = 'none';
            });
            document.getElementById('show-more-btn').style.display = 'inline-block';
            document.getElementById('show-less-btn').style.display = 'none';
        });

    </script>
    <script>
        document.getElementById('show-more-btn-c').addEventListener('click', function() {
        document.querySelectorAll('.extra-commissions').forEach(function(row) {
            row.style.display = '';
        });
        document.getElementById('show-more-btn-c').style.display = 'none';
        document.getElementById('show-less-btn-c').style.display = 'inline-block';
    });

    document.getElementById('show-less-btn-c').addEventListener('click', function() {
        document.querySelectorAll('.extra-commissions').forEach(function(row) {
            row.style.display = 'none';
        });
        document.getElementById('show-more-btn-c').style.display = 'inline-block';
        document.getElementById('show-less-btn-c').style.display = 'none';
    });


    </script> -->
@endpush
