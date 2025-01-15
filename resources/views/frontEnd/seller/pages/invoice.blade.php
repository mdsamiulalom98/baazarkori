@extends('frontEnd.seller.pages.master')
@section('title','Order Manage')

@section('content')
<style>
    .customer-invoice {
        margin: 25px 0;
    }
    .invoice_btn{
        margin-bottom: 15px;
    }
    p{
        margin:0;
    }
    td{
        font-size: 16px;
    }
   @page {
    margin:0px;
    }
   @media print {
    .invoice-innter{
        margin-left: -120px !important;
    }
    .invoice_btn{
        margin-bottom: 0 !important;
    }
    td{
        font-size: 18px;
    }
    p{
        margin:0;
    }
    header,footer,.no-print,.left-side-menu,.navbar-custom {
      display: none !important;
    }
  }
</style>

        <div class="row">
            <div class="col-sm-6">
                <a href="" class="no-print"><strong><i class="fe-arrow-left"></i> Back To Order</strong></a>
            </div>
            <div class="col-sm-6">
                <button onclick="printFunction()"class="no-print btn btn-xs btn-success waves-effect waves-light"><i class="fa fa-print"></i></button>
            </div>
            <div class="col-sm-12 mt-3">
                <div class="invoice-innter" style="width:760px;margin: 0 auto;background: #fff;overflow: hidden;padding: 30px;padding-top: 0;">
                    <table style="width:100%">
                        <tr>
                            <td style="width: 40%; float: left; padding-top: 15px;">
                                <img src="{{asset($generalsetting->white_logo)}}" width="190px" style="margin-top:25px !important" alt="">
                                <p style="font-size: 14px; color: #222; margin: 20px 0;"><strong>Payment Method:</strong> <span style="text-transform: uppercase;">{{$order->payment?$order->payment->payment_method:''}}</span></p>
                                <div class="invoice_form">
                                    <p style="font-size:16px;line-height:1.8;color:#222"><strong>Invoice From:</strong></p>
                                    <p style="font-size:16px;line-height:1.8;color:#222">{{$generalsetting->name}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222">{{$contact->phone}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222">{{$contact->email}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222">{{$contact->address}}</p>
                                </div>
                            </td>
                            <td  style="width:60%;float: left;">
                                <div class="invoice-bar" style=" background: #4DBC60; transform: skew(38deg); width: 100%; margin-left: 65px; padding: 20px 60px; ">
                                    <p style="font-size: 30px; color: #fff; transform: skew(-38deg); text-transform: uppercase; text-align: right; font-weight: bold;">Invoice</p>
                                </div>
                                <div class="invoice-bar" style="background: #fff; transform: skew(36deg); width: 72%; margin-left: 182px; padding: 12px 32px; margin-top: 6px;">
                                    <p style="font-size: 15px; color: #222;font-weight:bold; transform: skew(-36deg); text-align: right; padding-right: 18px">Invoice ID : <strong>#{{$order->invoice_id}}</strong></p>
                                    <p style="font-size: 15px; color: #222;font-weight:bold; transform: skew(-36deg); text-align: right; padding-right: 32px">Invoice Date: <strong>{{$order->created_at->format('d-m-y')}}</strong></p>
                                </div>
                                <div class="invoice_to" style="padding-top: 20px;">
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;"><strong>Invoice To:</strong></p>
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;">{{$order->shipping?$order->shipping->name:''}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;">
                                        @if($order->reseller_id == NULL)
                                         {{$order->shipping?$order->shipping->phone:''}}
                                        @else
                                         01X XXXX XXXX
                                        @endif

                                    </p>

                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;">{{$order->shipping?$order->shipping->district:''}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;">{{$order->shipping?$order->shipping->area:''}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;">{{$order->shipping?$order->shipping->address:''}}</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table" style="margin-top: 30px;margin-bottom: 0;">
                        <thead style="background: #4DBC60; color: #fff;">
                            <tr>
                                <th>SL</th>
                                <th style="width: 50px">Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderdetails as $key=>$value)
                            @php
                                $sellertotal = ($value->sale_price ?? 0) - ($value->commission ?? 0);
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><img src="{{ asset($value->image ? $value->image->image : '') }}" height="50" width="50" alt=""></td>
                                <td>{{$value->product_name}} <br> @if($value->product_size) <small>Size: {{$value->product_size}}</small> @endif   @if($value->product_color) <small>Color: {{$value->product_color}}</small> @endif </td>

                                <td>৳ {{ $sellertotal }}</td>
                                <td>{{$value->qty}}</td>
                                <td>৳{{($sellertotal)*$value->qty}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="invoice-bottom">

                        <table class="table" style="width: 300px; float: right;    margin-bottom: 30px;">
                            <tbody style="background:#f1f9f8">
                                <tr>
                                    <td><strong>SubTotal</strong></td>
                                    <td><strong>৳{{ $order->amount - ($order->shipping_charge + $order->commission) }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Shipping(+)</strong></td>
                                    <td><strong>৳{{$order->shipping_charge}}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Discount(-)</strong></td>
                                    <td><strong>৳{{$order->discount}}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Seller Commision(-)</strong></td>
                                    <td><strong>৳{{$order->seller_commission}}</strong></td>
                                </tr>
                                @if($order->advance != 0)
                                <tr>
                                    <td><strong>Advance(-)</strong></td>
                                    <td><strong>৳{{$order->advance}}</strong></td>
                                </tr>
                                @endif
                                <tr style="background:#4DBC60;color:#fff">
                                    <td><strong>Final Total</strong></td>
                                    <td><strong>৳{{ (($order->amount ?? 0) - ($order->commission ?? 0) - ($order->seller_commission ?? 0)) - ($order->advance ?? 0) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="terms-condition" style="overflow: hidden; width: 100%; text-align: center; padding: 20px 0; border-top: 1px solid #ddd;">
                            <h5 style="font-style: italic;"><a href="{{route('page',['slug'=>'terms-condition'])}}">Terms & Conditions</a></h5>
                            <p style="text-align: center; font-style: italic; font-size: 15px; margin-top: 10px;">* This is a computer generated invoice, does not require any signature.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
