@extends('backEnd.layouts.master')
@section('title','Dashboard')
@section('css')
<!-- Plugins css -->
<link href="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd/')}}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<style>
    a.canvasjs-chart-credit {
    display: none !important;
}
.graph-pie{
    background:#fff;
    margin-bottom:20px;
}
.des-item h5 {
    color: #979797;
}
.des-item h2 {
    font-weight: 800;
    color: #6a6a6a;
}
.chart-des {
    padding-top: 50px;
}
.inner-chart {
    position: absolute;
    top: 25%;
    left: 34%;
    opacity: 1;
    z-index: 999;
    text-align: center;
}
.inner-chart h5 {
    text-transform: capitalize;
}
.main-Pie{
    position:relative;
}
.ex-pro {
    margin-top: 14px;
    margin-left: 8px;
}
</style>
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    
    <div class="row">
        <div class="col-sm-12 text-start">
            <form class="no-print mb-2">
                <div class="row">  
                    <div class="col-sm-4">
                        <div class="form-group">
                           <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" value="{{request()->get('start_date')}}"  class="form-control flatdate" name="start_date">
                        </div>
                    </div>
                    <!--col-sm-3--> 
                    <div class="col-sm-4">
                        <div class="form-group">
                           <label for="end_date" class="form-label">End Date</label>
                            <input type="date" value="{{request()->get('end_date')}}" class="form-control flatdate" name="end_date">
                        </div>
                    </div>
                    <!--col-sm-3-->
                    <div class="col-sm-4 text-start">
                        <div class="form-group mt-3">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <!-- col end -->
                </div>  
            </form>
        </div>
    </div>
    <!--graph chart start -->
    <div class="graph-pie">
        <div class="row">
            <div class="col-sm-3 main-Pie">
                   <div id="chartContainer" style="height: 200px; width: 100%;"></div>
                <a href="{{route('admin.orders','all')}}">
                <div class="inner-chart">
                    <h5>total value</h5>
                    <h3> ৳ {{ number_format($total_amount)}}</h3>
                    <p>{{$total_order}} Orders</p>
                </div>
                </a>
            </div>
            <!--end-col-->
            <div class="col-sm-9">
                <div class="chart-des">
                    <!--new-row-start-->
                    <div class="row">
                        <div class="col-sm-4">  
                          <a href="{{route('admin.orders','completed')}}">
                            <div class="des-item" style="border-left:6px solid #21c624; padding-left:20px;">
                                <h5>Delivered</h5>
                                <h2>@if($total_complete > 0) {{number_format(($total_complete*100)/$total_order,2)}} @else 0 @endif%</h2>
                                <h5>{{$total_complete}} orders | ৳ {{$delivery_amount}}</h5>
                            </div>
                            </a>
                        </div>
                        <!--end-col-->
                        <div class="col-sm-4">
                          <a href="{{route('admin.orders','in-courier')}}">
                            <div class="des-item" style="border-left:6px solid #ffcd00; padding-left:20px;">
                                <h5>Delivery Processing</h5>
                                <h2>@if($total_process > 0) {{number_format(($total_process*100)/$total_order,2)}} @else 0 @endif%</h2>
                                <h5>{{$total_process}} orders | ৳ {{$process_amount}}</h5>
                            </div>
                           </a>
                        </div>
                        <!--end-col-->
                        <div class="col-sm-4">
                          <a href="{{route('admin.orders','returned')}}">
                            <div class="des-item" style="border-left:6px solid #ff4c49;padding-left:20px;">
                                <h5>Returned</h5>
                                <h2>@if($total_return > 0) {{number_format(($total_return*100)/$total_order,2)}} @else 0 @endif%</h2>
                                <h5>{{$total_return}} orders | ৳ {{$return_amount}}</h5>
                            </div>
                          </a>
                        </div>
                        <!--end-col-->
                    </div>
                    <!--new-row-end-->
                </div>
            </div>
            <!--end-col-->
        </div>
        <!--end-row-->
    </div>
    
    <!--graph chart end -->
        
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{route('admin.orders','all')}}">
                        <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-shopping-cart font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$total_order}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Order</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{route('admin.orders','pending')}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                <i class="fe-shopping-bag font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$today_order}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Today's Order</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{route('products.index')}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                <i class="fe-database font-22 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$total_product}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Products</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{route('customers.index')}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                <i class="fe-user font-22 avatar-title text-warning"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$total_customer}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Customer</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
        
        
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{ route('customers.index', ['status' => 'pending', 'type' => 1]) }}">
                        <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-users font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$total_re_request}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Reseller Request</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
        
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{route('admin.withdraw','paid')}}">
                        <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-shopping-bag font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">৳<span data-plugin="counterup">{{$total_withdraw}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Reseller Payment</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
        
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{route('admin.reseller_cash_report')}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                <i class="fe-database font-22 avatar-title text-warning"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$reseller_cash}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Reseller Cash</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
        
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{route('admin.loss_profit')}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                
                                <i class="fa fa-cog fa-spin fa-3x fa-fw ex-pro" aria-hidden="true"></i>
                                   <span class="sr-only">Saving. Hang tight!</span>
                                
                                
                                
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ number_format(($total_sales + $total_income) - ($total_purchase + $total_expense)) }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Net Profit</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->


        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="{{ route('sellers.index', ['status' => 'active']) }}">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                <i class="fe-activity font-22 avatar-title text-warning"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$seller_cash}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Seller Cash</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <a href="">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                <i class="fe-dollar-sign font-22 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$seller_earning}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Seller Earning</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    </a>
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
        
        
        
    </div>
    <!-- end row-->


    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Latest 5 Orders</h4>

                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">

                            <thead class="table-light">
                                <tr>
                                    <th colspan="2">Id</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_order as $order)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style="width: 36px;">
                                        <img src="{{asset($order->product?$order->product->image->image:'')}}" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm" />
                                    </td>
                                    <td>
                                        {{$order->invoice_id}}
                                    </td>

                                    <td>
                                        {{$order->amount}}
                                    </td>

                                    <td>
                                        {{$order->customer?$order->customer->name:''}}
                                    </td>
                                    <td>
                                        {{$order->status?$order->status->name:''}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mb-3">Latest Customers</h4>

                    <div class="table-responsive">
                        <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                            <thead class="table-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_customer as $customer)
                                <tr>
                                    <td>
                                        <h5 class="m-0 fw-normal">{{$loop->iteration}}</h5>
                                    </td>

                                    <td>
                                        {{$customer->name}}
                                    </td>

                                    <td>
                                        {{$customer->phone}}
                                    </td>

                                    <td>
                                        {{$customer->created_at->format('d-m-Y')}}
                                    </td>

                                    <td>
                                        {{$customer->status}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end .table-responsive-->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    
    
</div> <!-- container -->
@endsection
@section('script')
 <!-- Plugins js-->
        <script src="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="{{asset('public/backEnd/')}}/assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="{{asset('public/backEnd/')}}/assets/libs/selectize/js/standalone/selectize.min.js"></script>
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script>
        window.onload = function () {
        
        var options = {
        	animationEnabled: true,
        	title: {
        		text: ""
        	},
        	data: [{
        		type: "doughnut",
        		innerRadius: "80%",
        		dataPoints: [
        			{ label: "", y: {{$delivery_amount}} ,color: "#21c624"},
        			{ label: "", y: {{$process_amount}} , color : "#ffcd00"},
        			{ label: "", y: {{$return_amount}} , color : "#ff4c49"},
        			
        		]
        	}]
        };
        $("#chartContainer").CanvasJSChart(options);
        
        }
        </script>
            <script type="text/javascript">
        $(document).ready(function () {
            flatpickr(".flatdate", {});
        });
    </script>

@endsection