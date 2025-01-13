@extends('frontEnd.layouts.master')
@section('title','My Order')
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
                    <h5 class="account-title">My Order</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Name</th>
                                    <th>Courier</th>
                                    <th>Status</th>
                                    <th>Invoice</th>
                                    <th>Order Cancel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key=>$value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->created_at->format('d-m-y')}}</td>
                                    <td>{{$value->invoice_id}}</td>
                                    <td>৳{{$value->amount}}</td>
                                    <td>{{$value->customer?$value->customer->name:''}}</td>
                                    <td>
                                        <a href="https://merchant.pathao.com/tracking?consignment_id={{$value->consignment_id}}&phone={{$value->shipping?$value->shipping->phone:''}}" target="_blank" class="{{ $value->courier ? 'btn btn-primary' : '' }}">{{ $value->courier ?? 'N/A' }}</a>
                                    </td>
                                    <td>{{$value->status?$value->status->name:''}}</td>
                                    <td><a href="{{route('customer.invoice',['id'=>$value->id])}}" class="invoice_btn"><i class="fa-solid fa-eye"></i></a>
                                    @if($value->admin_note)
                                    <a href="{{route('customer.order_note',['id'=>$value->id])}}" class="invoice_btn bg-primary"><i class="fa-solid fa-pencil"></i></a>
                                    </td>
                                    @endif
                                    @if($value->order_status == 1)
                                    <td>
                                        <form method="post" action="{{route('customer.order_cancel')}}" class="d-inline">
                                            @csrf
                                            <input type="hidden" value="{{$value->id}}" name="hidden_id">
                                            <button type="submit" title="Canceled" class="delete-confirm">
                                                <i class="fa-solid fa-delete-left" style="font-size: 24px; text-align: center;"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total Order Amount:</strong></td>
                                    <td><strong>= ৳{{ $totalOrderAmount }}</strong></td>
                                    <td colspan="4"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="custom-paginate">
                    {{$orders->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection