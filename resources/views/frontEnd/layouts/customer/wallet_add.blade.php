@extends('frontEnd.layouts.master')
@section('title','Customer Account')
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
                <div class="button-container">
                    <a href="{{route('customer.wallet')}}">
                        <div class="action-button">
                          <span> <i class="fa-solid fa-list-ul"></i> Transaction</span>
                        </div>
                    </a>
                    <a href="{{route('customer.withdraw')}}">
                        <div class="action-button">
                          <span><i class="fa-solid fa-print"></i> Withdraw</span>
                        </div>
                    </a>
                    <a href="{{route('customer.wallet_add')}}">
                        <div class="action-button extra-active">
                          <span><i class="fa-solid fa-wallet"></i> Add Balance</span>
                        </div>
                    </a>
                  </div>
                <div class="customer-content checkout-shipping">
                    <h5 class="account-title">Lets Add the Amount in your wallet</h5>
                    <form action="{{route('wallet.save')}}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Enter Your Amount <span>*</span></label>
                                <input type="number" id="amount" class="form-control" name="amount" placeholder="Enter Your Amount" required>
                            </div>
                        </div>

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

                       <!-- new payment start -->
                       <div class="col-sm-12">
                                        <div class="radio_payment">
                                            <label id="payment_method">Payment Method</label>
                                            <div class="payment_option">

                                            </div>
                                        </div>
                                        <div class="payment-methods">
                                           
                                            @if ($bkash_gateway)
                                                <div class="form-check p_bkash">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="bkashMethod" value="bkash" required />
                                                    <label class="form-check-label" for="bkashMethod">
                                                        BKash
                                                    </label>
                                                </div>
                                            @endif

                                            <div class="form-check p_nagad">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="nagadMethod" value="nagad" required />
                                                <label class="form-check-label" for="nagadMethod">
                                                    Nagad
                                                </label>
                                            </div>

                                            <div class="form-check p_rocket">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="rocketMethod" value="rocket" required />
                                                <label class="form-check-label" for="rocketMethod">
                                                    Rocket
                                                </label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-------------------->
                                    <div id="paymentCreds"></div>
                       <!-- new payment end -->




                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <button type="submit" class="submit-btn">Add Now</button>
                            </div>
                        </div>
                        <!-- col-end -->
                    </form>
                </div>
                
                <div class="pending-request">
                    <div class="customer-content table-responsive">
                         <h5 class="account-title text-center">Your Wallet</h5>
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
    
    
                            <tbody>
                                @foreach($wallet as $key=>$value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{ $value->created_at->format('h:i A') }}</td>
                                    <td>{{ $value->created_at->format('d-m-Y') }}</td>
                                    <td>{{$value->phone}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->payment_method}}</td>
                                    <td style="font-weight: 800; color: 
                                        @if($value->status == 'pending') red 
                                        @elseif($value->status == 'paid') green 
                                        @else black @endif">
                                        {{ $value->status }}
                                    </td>
                                </tr>
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
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/select2.min.js"></script>
<script>
    // shurjopay method
    $("#shurjopayMethod").on("click", function() {
        $.ajax({
            type: "GET",
            url: "{{ route('payment.shurjopay') }}",
            dataType: "html",
            success: function(response) {
                $("#paymentCreds").html(response);
                return forget_advanced();
            },
        });
    });
    // bkash method
    $("#bkashMethod").on("click", function() {
        $.ajax({
            type: "GET",
            url: "{{ route('payment.bkash') }}",
            dataType: "html",
            success: function(response) {
                $("#paymentCreds").html(response);
                return forget_advanced();
            },
        });
    });
    // nagad method
    $("#nagadMethod").on("click", function() {
        $.ajax({
            type: "GET",
            url: "{{ route('payment.nagad') }}",
            dataType: "html",
            success: function(response) {
                $("#paymentCreds").html(response);
                return forget_advanced();
            },
        });
    });
    // nagad method
    $("#rocketMethod").on("click", function() {
        $.ajax({
            type: "GET",
            url: "{{ route('payment.rocket') }}",
            dataType: "html",
            success: function(response) {
                $("#paymentCreds").html(response);
                return forget_advanced();
            },
        });
    });
</script>
@endpush
