@extends('frontEnd.layouts.master')
@section('title','Expense')
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
                <div class="customer-content">
                     <h5 class="account-title text-center">Direct Admin Expense</h5>
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Note</th>
                                <th>Amount</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach($dueseller as $key=>$value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value->note}}</td>
                                <td>{{$value->amount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="customer-content">
                    <h5 class="account-title text-center">Expense</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Expense</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expense as $key=>$value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->customer?$value->customer->name:''}}</td>
                                    <td>{{$value->created_at->format('d-m-y')}}</td>
                                    <td>{{$value->invoice_id}}</td>
                                    <td>৳{{$value->shipping_charge}}</td>
                                </tr>
                                @endforeach
                            {{-- <tr>
                                <td colspan="4" class="text-right"><strong>Total Expense:</strong></td>
                                <td><strong>৳{{ $totalexpense }}</strong></td>
                            </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="custom-paginate">
                    {{$expense->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection