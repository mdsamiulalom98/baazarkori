@extends('frontEnd.layouts.master') 
@section('title', 'Customer Checkout') 
@push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
@endpush @section('content')
<section class="chheckout-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
        // Session::forget('advanced_pay');
        $advance_amount = 0;
        foreach(Cart::instance('shopping')->content() as $item){
            $advance_amount += $item->options->advance; 
        }
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-sm-4 cus-order-2">
                <div class="checkout-shipping">
                    <form action="{{ route('customer.ordersave') }}" method="POST" data-parsley-validate="">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h6>To confirm your order, fill in the details and click on the "Order" button </h6>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="name">Enter Your Name *</label>
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->name : old('name') }}"
                                                required />
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="phone">Enter Your Mobile *</label>
                                            <input type="text" minlength="11" id="number" maxlength="11"
                                                pattern="0[0-9]+"
                                                title="please enter number only and 0 must first character"
                                                title="Please enter an 11-digit number." id="phone"
                                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->phone : old('phone') }}"
                                                required />
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="address">Enter Your Address *</label>
                                            <input type="address" id="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address"
                                                value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->address : old('address') }}"
                                                required />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="district2">District *</label>
                                            <select id="district2"
                                                class="form-control select2  @error('district') is-invalid @enderror"
                                                name="district" value="{{ old('district') }}" required>
                                                <option value="">Select...</option>
                                                @foreach ($districts as $key => $district)
                                                    <option value="{{ $district->district }}">
                                                        {{ $district->district }}</option>
                                                @endforeach
                                            </select>
                                            @error('district')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="area">Upazila *</label>
                                            <select id="area"
                                                class="form-control  area select2 @error('area') is-invalid @enderror"
                                                name="area" value="{{ old('area') }}" required>
                                                <option value="">Select...</option>
                                            </select>
                                            @error('upazila')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="radio_payment">
                                            <label id="payment_method">Payment Method</label>
                                            <div class="payment_option">

                                            </div>
                                        </div>
                                        <div class="payment-methods">
                                            @if(!$advance_amount)
                                            <div class="form-check p_cash">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="inlineRadio1" value="Cash On Delivery" checked required />
                                                <label class="form-check-label" for="inlineRadio1">
                                                    Cash On Delivery
                                                </label>
                                            </div>
                                            @endif
                                            @if ($bkash_gateway)
                                                <div class="form-check p_bkash">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="bkashMethod" value="bkash" required />
                                                    <label class="form-check-label" for="bkashMethod">
                                                        BKash
                                                    </label>
                                                </div>
                                            @endif
                                            <div class="form-check p_advanced">
                                                <input class="form-check-input" type="radio" name="payment_method" value="advance"
                                                    id="advancedMethod" />
                                                <label class="form-check-label" for="advancedMethod">
                                                    Advanced Method
                                                </label>
                                            </div>

                                            @if ($shurjopay_gateway)
                                                <div class="form-check p_shurjo">
                                                    <input class="form-check-input" type="radio"
                                                        name="payment_method" id="shurjopayMethod" value="shurjopay"
                                                        required />
                                                    <label class="form-check-label" for="shurjopayMethod">
                                                        Shurjopay
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-------------------->
                                    <div id="paymentCreds"></div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button class="order_place" type="submit"> Order Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card end -->
                    </form>
                </div>
            </div>
            <!-- col end -->
            <div class="col-sm-5 cust-order-1">
                <div class="cart_details table-responsive-sm">
                    <div class="card">
                        <div class="card-header">
                            <h5>Order information</h5>
                        </div>
                        <div class="card-body cartlist">
                            @include('frontEnd.layouts.ajax.cart')
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->

        </div>
    </div>
</section>
@endsection 
@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(".select2").select2();
    });
</script>
{{--
<script>
    $(".district").on("change", function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: {
                id: id
            },
            url: "{{ route('districts') }}",
            success: function(res) {
                if (res) {
                    $(".area").empty();
                    $(".area").append('<option value="">Select..</option>');
                    $.each(res, function(key, value) {
                        $(".area").append('<option value="' + key + '" >' + value +
                            "</option>");
                    });
                } else {
                    $(".area").empty();
                }
            },
        });
    });
</script>
 --}}
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
    // advance payment
    $("#advancedMethod").on("click", function() {
        $.ajax({
            type: "GET",
            url: "{{ route('advanced.payment') }}",
            dataType: "html",
            success: function(response) {
                $(".cartlist").html(response);
                return bkash_method();
            },
        });
    });

    function bkash_method() {
        $.ajax({
            type: "GET",
            url: "{{ route('payment.bkash') }}",
            success: function(response) {
                if (response) {
                    $("#paymentCreds").html(response);
                } else {
                    $("#paymentCreds").empty();
                }
            }
        });
    };

    function forget_advanced() {
        $.ajax({
            type: "GET",
            url: "{{ route('forget.advanced_payment') }}",
            success: function(response) {
                $(".cartlist").html(response);
            }
        });
    }
</script>
<script type="text/javascript">
    dataLayer.push({
        ecommerce: null
    }); // Clear the previous ecommerce object.
    dataLayer.push({
        event: "view_cart",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brand }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
<script type="text/javascript">
    // Clear the previous ecommerce object.
    dataLayer.push({
        ecommerce: null
    });

    // Push the begin_checkout event to dataLayer.
    dataLayer.push({
        event: "begin_checkout",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brands }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
@endpush
