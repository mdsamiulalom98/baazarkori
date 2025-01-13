@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal=str_replace(',','',$subtotal);
    $subtotal=str_replace('.00', '',$subtotal);
    view()->share('subtotal',$subtotal);
    $shipping = Session::get('shipping')?Session::get('shipping'):0;
    $discount = Session::get('discount')?Session::get('discount'):0;
@endphp

<div class="cart-summary">
    <h5>Cart Summary</h5>
    <table class="table">
        <tbody>
               <tr>
                <td>Items</td>
                <td>{{Cart::instance('shopping')->count()}} (qty)</td>
               </tr>
               @if(Auth::guard('customer')->user()?Auth::guard('customer')->user()->seller_type == 2 : 0)
               <tr>
                <td>Sub Total</td>
                <td>৳{{$reselltotal}}</td>
               </tr>
               @else
               <tr>
                <td>Sub Total</td>
                <td>৳{{$subtotal}}</td>
               </tr>
               @endif
               <tr>
                <td>Shipping</td>
                <td>৳{{$shipping}}</td>
               </tr>

               @if(Auth::guard('customer')->user()?Auth::guard('customer')->user()->seller_type == 2 : 0)
               <!-- <tr>
                <td>Wholesell Total</td>
                <td>৳{{$wholeselltotal}}</td>
               </tr> -->
               <tr>
                <td>Your Total Earnings</td>
                <td>৳{{$reselltotal - $wholeselltotal}}</td>
               </tr>
               <tr>
                <td>Total</td>
                <td>৳{{($reselltotal+$shipping)}}</td>
               </tr>
               @else
               <tr>
                <td>Total</td>
                <td>৳{{($subtotal+$shipping)}}</td>
               </tr>
               @endif
        </tbody>
    </table>
</div>