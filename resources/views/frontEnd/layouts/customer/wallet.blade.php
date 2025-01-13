@extends('frontEnd.layouts.master')
@section('title','Customer Wallet')
@section('content')
<style>
    

</style>
<section class="customer-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="customer-sidebar">
                    @include('frontEnd.layouts.customer.sidebar')
                </div>
            </div>
            <div class="col-sm-9">
                <!-- <div class="customer-content">
                     <h5 class="account-title text-center">Direct Admin Add Amount</h5>
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Note</th>
                                <th>Amount</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach($addseller as $key=>$value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value->note}}</td>
                                <td>{{$value->amount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> -->
                  <div class="button-container">
                    <a href="">
                        <div class="action-button extra-active">
                          <span> <i class="fa-solid fa-list-ul"></i> Transaction</span>
                        </div>
                    </a>
                    <a href="{{route('customer.withdraw')}}">
                        <div class="action-button">
                          <span><i class="fa-solid fa-print"></i> Withdraw</span>
                        </div>
                    </a>
                    <a href="{{route('customer.wallet_add')}}">
                        <div class="action-button">
                          <span><i class="fa-solid fa-wallet"></i> Add Balance</span>
                        </div>
                    </a>
                  </div>
                <div class="customer-content">
                 <div class="wallet__header">
                     <div class="my__wallet">
                         <div class="text-left"><h5>My Balance</h5> </div>
                       <h5 class="account-title text-center"> BDT : <span>{{Auth::guard('customer')->user()->balance}}৳ </span></h5>
                     </div>
                 </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Charge</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Amount Type</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($wallet as $key=>$value)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td >{{$value->note}}</td>
                                        <td>{{ $value->updated_at->format('Y-m-d') }}</td> <!-- তারিখ -->
                                        <td>{{ $value->updated_at->format('H:i') }}</td>  <!-- সময় -->
                                        <td style="font-weight:600; color: {{ $value->amount_type == 'debit' ? 'red' : 'green' }}">{{$value->amount_type}}</td>
                                        <td style="font-weight:900; color: {{ $value->amount_type == 'debit' ? 'red' : 'green' }}">
                                            {{ $value->amount_type == 'debit' ? '-' : '+' }}{{ $value->amount }}
                                        </td>
                                        <td>{{$value->balance }}</td>
                                    <tr>
                                    @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    $(".deposit__p").on("click", function () {
        $(".deposit__p.act").removeClass("act");
        $(this).addClass("act");
    });
</script>
@endpush