@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ?? 0;
    $discount = Session::get('discount') ?? 0;

    $shopping = Cart::instance('shopping')->content();
    $advanced_pay = Session::get('advanced_pay') ?? 0;
@endphp
<table class="cart_table table table-bordered table-striped text-center mb-0">
    <thead>
        <tr>
            <th style="width: 20%;">Delete ({{ $advanced_pay }})</th>
            <th style="width: 40%;">Product</th>
            <th style="width: 20%;">Quantity</th>
            <th style="width: 20%;">Price</th>
        </tr>
    </thead>

    <tbody>
        @php
            $wholeselltotal = $reselltotal = $advancetotal = 0;
        @endphp
        @foreach (Cart::instance('shopping')->content() as $value)
            <tr>
                <td>
                    <a class="cart_remove" data-id="{{ $value->rowId }}"><i class="fas fa-trash text-danger"></i></a>
                </td>
                <td class="text-left">
                    <a href="{{ route('product', $value->options->slug) }}"> <img
                            src="{{ asset($value->options->image) }}" style="height:30px;width:30px" />
                        {{ Str::limit($value->name, 20) }}</a>
                    @if ($value->options->product_size)
                        <p>Size: {{ $value->options->product_size }}</p>
                    @endif
                    @if ($value->options->product_color)
                        <p>Color: {{ $value->options->product_color }}</p>
                    @endif
                </td>
                <td class="cart_qty">
                    <div class="qty-cart vcart-qty">
                        <div class="quantity">
                            <button class="minus cart_decrement" data-id="{{ $value->rowId }}">-</button>
                            <input type="text" value="{{ $value->qty }}" readonly />
                            <button class="plus cart_increment" data-id="{{ $value->rowId }}">+</button>
                        </div>
                    </div>
                </td>
                <td>
                    @if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 1)
                        <span class="alinur">৳ </span><strong>{{ $value->options->reseller_price }}</strong>
                    @else
                        <span class="alinur">৳ </span><strong>{{ $value->price }}</strong>
                    @endif
                </td>
            </tr>
            @php

                $wholeselltotal += $value->options->whole_sell_price * $value->qty;
                $advancetotal += $value->options->advance * $value->qty;
                $reselltotal += $value->options->reseller_price * $value->qty;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end px-4">SubTotal</th>
            @if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 1)
                <td>
                    <span id="net_total"><span class="alinur">৳ </span><strong>{{ $reselltotal }}</strong></span>
                </td>
            @else
                <td>
                    <span id="net_total"><span class="alinur">৳ </span><strong>{{ $subtotal }}</strong></span>
                </td>
            @endif
        </tr>
        <tr>
            <th colspan="3" class="text-end px-4">Delivery Charge {{$shipping ?? 0}} </th >
            <td>
                <span id="cart_shipping_cost"><span class="alinur">৳ </span><strong>{{ $shipping }}</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="3" class="text-end px-4">Total</th>
            @if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 1)
                <td>
                    <span id="grand_total"><span class="alinur">৳
                        </span><strong>{{ $reselltotal + $shipping }}</strong></span>
                </td>
            @else
                <td>
                    <span id="grand_total"><span class="alinur">৳
                        </span><strong>{{ $subtotal + $shipping }}</strong></span>
                </td>
            @endif

        </tr>
    </tfoot>
</table>



<!-- cart-summary-start -->
<div class="summary-extra col-sm-7">
    <div class="cart-summary botton-summary">
        <h5>Cart Summary</h5>
        <table class="table">
            <tbody>
                <tr>
                    <td>Items </td>
                    <td>{{ Cart::instance('shopping')->count() }} (qty)</td>
                </tr>
                @if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 1)
                    <tr>
                        <td>Sub Total</td>
                        <td>৳{{ $reselltotal }}</td>
                    </tr>
                @else
                    <tr>
                        <td>Sub Total</td>
                        <td>৳{{ $subtotal }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Shipping</td>

                    <td>৳{{ $shipping }}</td>
                </tr>

                @if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 1)
                    <!-- <tr>
                    <td>Wholesell Total</td>
                    <td>৳{{ $wholeselltotal }}</td>
                </tr> -->
                    <tr>
                        <td>Your Total Earnings</td>
                        <td>৳{{ $reselltotal - $wholeselltotal }}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>৳{{ $reselltotal + $shipping }}</td>
                    </tr>
                    @if ($advanced_pay == 1)
                        <tr>
                            <td>Advanced</td>
                            <td>৳{{ $advancetotal }}</td>
                        </tr>
                        <tr>
                            <td>Due</td>
                            <td>৳{{ $reselltotal + $shipping - $advancetotal }}</td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <td>Total</td>
                        <td>৳{{ $subtotal + $shipping }}</td>
                    </tr>
                    @if ($advanced_pay == 1)
                        <tr>
                            <td>Advanced</td>
                            <td>৳{{ $advancetotal }}</td>
                        </tr>
                        <tr>
                            <td>Due</td>
                            <td>৳{{ $subtotal + $shipping - $advancetotal }}</td>
                        </tr>
                    @endif
                @endif
            </tbody>
        </table>
    </div>
</div>
<!-- cart-summary-end -->



<script src="{{ asset('public/frontEnd/js/jquery-3.6.3.min.js') }}"></script>
<!-- cart js start -->
<script>
    $('.cart_store').on('click', function() {
        var id = $(this).data('id');
        var qty = $(this).parent().find('input').val();
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id,
                    'qty': qty ? qty : 1
                },
                url: "{{ route('cart.store') }}",
                success: function(data) {
                    if (data) {
                        return cart_count();
                    }
                }
            });
        }
    });

    $('.cart_remove').on('click', function() {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.remove') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        return cart_count();
                    }
                }
            });
        }
    });

    $('.cart_increment').on('click', function() {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.increment') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        return cart_count();
                    }
                }
            });
        }
    });

    $('.cart_decrement').on('click', function() {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.decrement') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        return cart_count();
                    }
                }
            });
        }
    });

    function cart_count() {
        $.ajax({
            type: "GET",
            url: "{{ route('cart.count') }}",
            success: function(data) {
                if (data) {
                    $("#cart-qty").html(data);
                } else {
                    $("#cart-qty").empty();
                }
            }
        });
    };
</script>
<script>
    $(document).ready(function() {
        // $(".minus").click(function() {
        //     var $input = $(this).parent().find("input");
        //     var count = parseInt($input.val()) - 1;
        //     count = count < 1 ? 1 : count;
        //     $input.val(count);
        //     $input.change();
        //     return false;
        // });
        // $(".plus").click(function() {
        //     var $input = $(this).parent().find("input");
        //     $input.val(parseInt($input.val()) + 1);
        //     $input.change();
        //     return false;
        // });
    });
</script>
<!-- cart js end -->
