@php 
 $subtotal = Cart::instance('shopping')->subtotal(); 
 $subtotal=str_replace(',','',$subtotal); 
 $subtotal=str_replace('.00', '',$subtotal); 
 view()->share('subtotal',$subtotal); 
 $shipping = Session::get('shipping')?Session::get('shipping'):0; 
 $discount = Session::get('discount')?Session::get('discount'):0; 
 @endphp
 <div class="container">
  <div class="row" id="cartlist">
   <div class="col-sm-9">
    <div class="vcart-inner">
     <div class="cart-title">
      <h4>Shopping Cart</h4>
     </div>
     <div class="vcart-content">
      <div class="table-responsive">
       <table class="table">
        <thead>
         <tr>
          <th>Image</th>
          <th>Product</th>
          <th>Price</th>
          @if(Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0)
          <th>Resller Price</th>
          @endif
          <th>Qty</th>
          <th>Total</th>
          <th>Remove</th>
         </tr>
        </thead>
         @csrf
        <tbody>
          @php 
          $wholeselltotal = 0;
          $reselltotal = 0;
          @endphp

         @foreach (Cart::instance('shopping')->content() as $value)
         <tr>
          <td><img height="30" src="{{asset($value->options->image)}}" alt="" /></td>
          <td class="cart_name">{{ Str::limit($value->name, 50) }}</td>
          <td>{{$value->price}} ৳</td>
          @if(Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0)
          <td>
            <form action="{{route('reseller.update')}}" method="POST" class="price_reseller">
                @csrf
                <input type="hidden" name="rowId" value="{{$value->rowId}}">
                <input type="number" name="resellamount" min="{{$value->options->whole_sell_price}}" value="{{$value->options->reseller_price}}" class="resell-box">
                <button class="price_place" type="submit"> Update</button>  
            </form>
          </td>
           @elseif(Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 2)
          <td>
              {{$value->options->whole_sell_price}}
          </td>
          @endif
          <td>
           <div class="qty-cart vcart-qty">
            <div class="quantity">
             <button class="minus cart_decrement_pg" data-id="{{$value->rowId}}">-</button>
             <input type="text" value="{{$value->qty}}" readonly />
             <button class="plus cart_increment_pg" data-id="{{$value->rowId}}">+</button>
            </div>
           </div>
          </td>
          @if(Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 1)
          <td>{{$value->options->reseller_price*$value->qty}} ৳</td>
          @elseif(Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type == 2)
          <td>{{$value->options->reseller_price*$value->qty}} ৳</td>
          @else
          <td>{{$value->price*$value->qty}} ৳</td>
          @endif
          <td>
           <button class="remove-cart cart_remove_pg" data-id="{{$value->rowId}}"><i data-feather="x"></i></button>
          </td>
         </tr>

         @php  
         $wholeselltotal += $value->options->whole_sell_price*$value->qty;
         $reselltotal += $value->options->reseller_price*$value->qty;
         @endphp
         @endforeach
        </tbody>


       </table>
      </div>
     </div>
    </div>
    <div class="coupon-form">
     <form action="">
      <input type="text" placeholder="apply coupon" />
      <button>Apply</button>
     </form>
    </div>
   </div>
   <div class="col-sm-3">
    <div class="cart-summary">
     <h5>Cart Summary</h5>
     <table class="table">
      <tbody>
       <tr>
        <td>Items</td>
        <td>{{Cart::instance('shopping')->count()}} (qty)</td>
       </tr>
       @if(Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0)
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
       <tr>
        <td>Discount</td>
        <td>৳{{$discount}}</td>
       </tr>

       @if(Auth::guard('customer')->user() && Auth::guard('customer')->user()->seller_type != 0)
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
        <td>৳{{($reselltotal+$shipping) - $discount}}</td>
       </tr>
       @else
       <tr>
        <td>Total</td>
        <td>৳{{($subtotal+$shipping) - $discount}}</td>
       </tr>
       @endif
      </tbody>
     </table>
     <a href="{{route('customer.checkout')}}" class="go_cart">PROCESS TO CHECKOUT</a>
    </div>
   </div>
  </div>
 </div>






 <script src="{{asset('public/frontEnd/js/jquery-3.6.3.min.js')}}"></script>
<!-- cart js start -->
<script>
    $('.cart_store').on('click',function(){
    var id = $(this).data('id'); 
    var qty = $(this).parent().find('input').val();
    if(id){
        $.ajax({
           type:"GET",
           data:{'id':id,'qty':qty?qty:1},
           url:"{{route('cart.store')}}",
           success:function(data){               
            if(data){
                return cart_count();
            }
           }
        });
     }  
   });

    $('.cart_remove_pg').on('click',function(){
    var id = $(this).data('id');   
    if(id){
        $.ajax({
           type:"GET",
           data:{'id':id},
           url:"{{route('cart.remove_pg')}}",
           success:function(data){               
            if(data){
                $(".vcart-section").html(data);
                return cart_count();
            }
           }
        });
     }  
   });

    $('.cart_increment_pg').on('click',function(){
    var id = $(this).data('id');  
    if(id){
        $.ajax({
           type:"GET",
           data:{'id':id},
           url:"{{route('cart.increment_pg')}}",
           success:function(data){               
            if(data){
                $(".vcart-section").html(data);
                return cart_count();
            }
           }
        });
     }  
   });

    $('.cart_decrement_pg').on('click',function(){
    var id = $(this).data('id');  
    if(id){
        $.ajax({
           type:"GET",
           data:{'id':id},
           url:"{{route('cart.decrement_pg')}}",
           success:function(data){               
            if(data){
                $(".vcart-section").html(data);
                return cart_count();
            }
           }
        });
     }  
   });

    function cart_count(){
        $.ajax({
           type:"GET",
           url:"{{route('cart.count')}}",
           success:function(data){               
            if(data){
                $("#cart-qty").html(data);
            }else{
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