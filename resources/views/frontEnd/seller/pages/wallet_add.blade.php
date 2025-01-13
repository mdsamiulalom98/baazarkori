@extends('frontEnd.seller.pages.master')
@section('title', 'Seller wallet Deposit')
@section('content')
<style>
    .my__wallet span {
        font-size: 27px;
        color: green;
    }
.button-container {
    display: flex;
    gap: 20px;
    justify-content: center;
    padding-bottom: 30px;
}

.action-button {
    background-color: #ffd700;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    width: 150px;
    height: 63px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: transform 0.2s;
}

.action-button:hover {
  transform: scale(1.05);
}


.action-button span {
  font-size: 1rem;
  color: #000;
  font-weight: bold;
}
</style>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Seller Wallet Deposit</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="button-container">
                                <a href="{{route('seller.withdraws')}}">
                                    <div class="action-button">
                                      <span><i class="fa-solid fa-print"></i> Withdraw</span>
                                    </div>
                                </a>
                                <a href="{{route('seller.sellerwallet')}}">
                                    <div class="action-button">
                                      <span> <i class="fa-solid fa-list-ul"></i> Transaction</span>
                                    </div>
                                </a>
                                <a href="{{route('seller.sellerwallet_add')}}">
                                    <div class="action-button">
                                      <span><i class="fa-solid fa-wallet"></i> Add Balance</span>
                                    </div>
                                </a>
                             </div>
                            <div class="customer-content checkout-shipping">
                                <h5 class="account-title">Lets Add the Amount in your wallet</h5>
                                <form action="{{route('seller.wallet.save')}}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="">
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
                                   <div class="col-sm-12 mt-3">
                                                    <div class="radio_payment">
                                                        <label id="payment_method">Payment Method</label>
                                                        <div class="payment_option">

                                                        </div>
                                                    </div>
                                                    <div class="payment-methods">
                                                       
                                                        @if ($bkash_gateway)
                                                            <div class="form-check p_bkash mt-2">
                                                                <input class="form-check-input" type="radio" name="payment_method"
                                                                    id="bkashMethod" value="bkash" required />
                                                                <label class="form-check-label" for="bkashMethod">
                                                                    BKash
                                                                </label>
                                                            </div>
                                                        @endif
                                                        

                                                        
                                                    </div>
                                                </div>
                                                <!-------------------->
                                                <div id="paymentCreds"></div>
                                   <!-- new payment end -->




                                    <div class="col-sm-12 mt-3">
                                        <div class="form-group mb-3">
                                            <button type="submit" class="submit-btn">Add Now</button>
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
</script>
@endpush

