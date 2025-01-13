<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $generalsetting->name }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}" type="image/x-icon" />
        <!-- fot awesome -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/all.css" />
        <!-- core css -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/bootstrap.min.css" />
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/animate.css" />
        <!-- owl carousel -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.theme.default.css" />
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.carousel.min.css" />
        <!-- owl carousel -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/select2.min.css" />
        <!-- common css -->
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/style.css?v=1.1.4" />
        <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/responsive.css?v=1.1.3" />
        @foreach($pixels as $pixel)
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '{{{$pixel->code}}}');
          fbq('track', 'PageView');
        </script>
        <noscript>
          <img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id={{{$pixel->code}}}&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
        @endforeach

        <meta name="app-url" content="{{route('campaign',$campaign_data->slug)}}" />
        <meta name="robots" content="index, follow" />
        <meta name="description" content="{{$campaign_data->description}}" />
        <meta name="keywords" content="{{ $campaign_data->slug }}" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="product" />
        <meta name="twitter:site" content="{{$campaign_data->name}}" />
        <meta name="twitter:title" content="{{$campaign_data->name}}" />
        <meta name="twitter:description" content="{{ $campaign_data->description}}" />
        <meta name="twitter:creator" content="hellodinajpur.com" />
        <meta property="og:url" content="{{route('campaign',$campaign_data->slug)}}" />
        <meta name="twitter:image" content="{{asset($campaign_data->image_one)}}" />

        <!-- Open Graph data -->
        <meta property="og:title" content="{{$campaign_data->name}}" />
        <meta property="og:type" content="product" />
        <meta property="og:url" content="{{route('campaign',$campaign_data->slug)}}" />
        <meta property="og:image" content="{{asset($campaign_data->image_one)}}" />
        <meta property="og:description" content="{{ $campaign_data->description}}" />
        <meta property="og:site_name" content="{{$campaign_data->name}}" />
    </head>

    <body>
         @php
            $subtotal = Cart::instance('shopping')->subtotal();
            $subtotal=str_replace(',','',$subtotal);
            $subtotal=str_replace('.00', '',$subtotal);
            $shipping = Session::get('shipping')?Session::get('shipping'):0;
            $advance_amount = 0;
            foreach(Cart::instance('shopping')->content() as $item){
                $advance_amount += $item->options->advance;
            }
        @endphp

        <section class="campaign-logo">
            <div class="container">
                <div class="camp-show">
                    <a href="{{ route('home') }}"> <img src="{{ asset($generalsetting->white_logo) }}"
                        alt="" /></a>
                </div>
            </div>
        </section>

        <section style="background: url('{{asset($campaign_data->banner)}}'); background-repeat: no-repeat; background-size:cover; background-position: center;" >
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="campaign_image">
                            <div class="campaign_item">
                                <div class="banner_t">
                                    <h2>{{$campaign_data->banner_title}}</h2>
                                    <a href="#order_form" class="cam_order_now" id="cam_order_now"><i class="fa-solid fa-cart-shopping"></i> অর্ডার করুন </a>
                                    <p class="megaoffer_btn">মেগা অফার   {{ number_format($product->new_price )}}  টাকা</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="camp_video_sec">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                       <div class="camp_vid">
                            <iframe width="560" height="480" src="https://www.youtube.com/embed/{{$campaign_data->video}}?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>


                    </div>
                    <div class="col-sm-12">
                        <div class="ord_btn">
                            <a href="#order_form" class="cam_order_now" id="cam_order_now"> অর্ডার করতে ক্লিক করুন <i class="fa-solid fa-hand-point-right"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="cont_inner">
                            <div class="cont_num">
                                <h2>আমাদের থেকে বিস্তারিত জানতে এই নাম্বারে কল করুন</h2>
                                <a href="tel:{{$contact->phone}}">{{$contact->phone}}</a>
                            </div>
                            <div class="discount_inn">
                                <h2>
                                    @if($product->old_price)
                                    <del>{{$campaign_data->name}} এর আগের দাম {{$product->old_price}}/=</del>
                                    @endif
                                    <p>{{$campaign_data->name}} এর বর্তমান দাম {{$product->new_price}}/=</p>
                                </h2>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rules_sec">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="rules_inner">

                            <div class="rules_item">
                                <div class="rules_head">
                                    <h2>{{$campaign_data->necessity_title}}</h2>
                                    <div class="rules_des">
                                        {!! $campaign_data->short_description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="rules_item">
                                <div class="rules_head">
                                    <h2>{{$campaign_data->rules}}</h2>
                                    <div class="rules_des">
                                     {!! $campaign_data->rules_description !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="campro_inn">
                            <div class="campro_head">
                                <h2>{{$campaign_data->pro_title}}</h2>
                            </div>

                            <div class="campro_img_slider owl-carousel">
                               <div class="campro_img_item">
                                   <img src="{{asset($campaign_data->image_one)}}" alt="">
                               </div>
                               <div class="campro_img_item">
                                   <img src="{{asset($campaign_data->image_two)}}" alt="">
                               </div>
                               <div class="campro_img_item">
                                   <img src="{{asset($campaign_data->image_three)}}" alt="">
                               </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="ord_btn">
                                    <a href="#order_form" class="cam_order_now" id="cam_order_now"> অর্ডার করতে ক্লিক করুন2 <i class="fa-solid fa-hand-point-right"></i> </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="why_choose_sec">
            <div class="container">
                <div class="row">
                  <div class="col-sm-12">
                      <div class="why_choose_inn">
                          <div class="why_choose">
                              <div class="why_choose_head">
                                <h2>আমাদের উপর কেন আস্থা রাখবেন ??</h2>
                              </div>
                              <div class="why_choose_midd">
                                  <div class="why_choose_widget">
                                      {!! $campaign_data->description !!}
                                  </div>
                                  <div class="why_choose_widget">
                                      <div class="why_img">
                                          <img src="{{asset($campaign_data->whychoose_img)}}" alt="">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="rev_inn">
                            <div class="campro_head">
                                <h2>{{$campaign_data->review}}</h2>
                            </div>
                            <div class="review_slider owl-carousel">
                            @foreach($campaign_data->images as $key=>$value)
                            <div class="review_item">
                                <img src="{{asset($value->image)}}" alt="">
                            </div>
                            @endforeach
                           </div>
                            <div class="col-sm-12">
                                <div class="ord_btn">
                                    <a href="#order_form" class="cam_order_now" id="cam_order_now"> অর্ডার করতে ক্লিক করুন <i class="fa-solid fa-hand-point-right"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <section class="form_sec">
        <div class="container">
           <div class="row">
             <div class="col-sm-12">
                <div class="form_inn">
                    <div class="col-sm-12">
                        <div class="row">
                <div class="col-sm-12">
                    <h2 class="campaign_offer">অফারটি সীমিত সময়ের জন্য, তাই অফার শেষ হওয়ার আগেই অর্ডার করুন</h2>
                </div>
            </div>
            <div class="row order_by">
            <div class="col-sm-5 cus-order-2">
                <div class="checkout-shipping" id="order_form">
                    <form action="{{route('customer.ordersave')}}" method="POST" data-parsley-validate="">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="potro_font">অর্ডার নিশ্চিত করতে আপনার তথ্য লিখুন</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label for="name">আপনার নাম লিখুন * </label>
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>
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
                                        <label for="phone">আপনার ফোন লিখুন *</label>
                                        <input type="number" minlength="11" id="number" maxlength="11" pattern="0[0-9]+" title="please enter number only and 0 must first character" title="Please enter an 11-digit number." id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required>
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
                                        <label for="address">আপনার ঠিকানা লিখুন  *</label>
                                        <input type="address" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}"  required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                               <!--  <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label for="district">আপনার  জেলা *</label>
                                        <input type="district" id="district" class="form-control @error('district') is-invalid @enderror" name="district" value="{{old('district')}}"  required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> -->
                                <!--<div class="col-sm-12">-->
                                <!--    <div class="form-group mb-3">-->
                                <!--        <label for="area">আপনার এরিয়া সিলেক্ট করুন  *</label>-->
                                <!--        <select type="area" id="area" class="form-control @error('area') is-invalid @enderror" name="area"   required>-->
                                <!--            @foreach($shippingcharge as $key=>$value)-->
                                <!--            <option value="{{$value->id}}">{{$value->name}}</option>-->
                                <!--            @endforeach-->
                                <!--        </select>-->
                                <!--        @error('email')-->
                                <!--            <span class="invalid-feedback" role="alert">-->
                                <!--                <strong>{{ $message }}</strong>-->
                                <!--            </span>-->
                                <!--        @enderror-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!-- col-end -->





                                <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="district">জেলা *</label>
                                            <select id="district"
                                                class="form-control district @error('district') is-invalid @enderror"
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
                                            <label for="area">উপজেলা *</label>
                                            <select id="area"
                                                class="form-control area @error('area') is-invalid @enderror"
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
                                            <label id="payment_method">পেমেন্ট পদ্ধতি
                                            </label>
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
                                    @php 
                                    $item = Cart::instance('shopping')->content()->where('id', $campaign_data->product_id)->first();
                                    @endphp
                                  <!--======COLOR SIZE START====-->
                                  <div class="campaign-colorsize">
                                   @if($productcolors->isNotEmpty())
                                    <div class="pro-color" style="width: 100%;">
                                        <div class="color_inner">
                                            <p>Color -</p>
                                            <div class="size-container">
                                                <div class="selector">
                                                    @foreach ($productcolors as $color)
                                                        <div class="selector-item color-item" data-id="{{ $loop->index }}">
                                                            <input
                                                                type="radio"
                                                                id="fc-option{{ $color->color->colorName ?? '' }}"
                                                                value="{{ $color->color->colorName ?? '' }}"
                                                                name="product_color"
                                                                class="selector-item_radio emptyalert stock_color color_update" required 
                                                                data-color="{{ $color->color->colorName ?? '' }}"
                                                                data-id="{{ $campaign_data->product_id }}"
                                                            />
                                                            <label for="fc-option{{ $color->color->colorName ?? '' }}" class="selector-item_label">
                                                                {{ $color->color->colorName ?? '' }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($productsizes->isNotEmpty())
                                    <div class="pro-size" style="width: 100%;">
                                        <div class="size_inner">
                                            <p>Size - <span class="attribute-name"></span></p>
                                            <div class="size-container">
                                                <div class="selector">
                                                    
                                                    @foreach ($productsizes as $size)
                                                        <div class="selector-item">
                                                            <input type="radio"
                                                                id="f-option{{ $size->size->sizeName ?? '' }}"
                                                                value="{{ $size->size->sizeName ?? '' }}"
                                                                name="product_size"
                                                                class="selector-item_radio emptyalert stock_size size_update"
                                                                data-size="{{ $size->size->sizeName ?? '' }}"
                                                                data-id="{{ $campaign_data->product_id }}"
                                                                required />
                                                            <label for="f-option{{ $size->size->sizeName ?? '' }}" class="selector-item_label">
                                                                {{ $size->size->sizeName ?? '' }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>
                                  <!--======COLOR SIZE START====-->

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button class="order_place" type="submit">এখনই অর্ডার করুন</button>
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
            <div class="col-sm-7 cust-order-1">
                <div class="cart_details">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="potro_font">পণ্যের বিবরণ </h5>
                        </div>
                        <div class="card-body cartlist  table-responsive">
                            <table class="cart_table table table-bordered table-striped text-center mb-0">
                                <thead>
                                   <tr>
                                      <th style="width: 20%;">ডিলিট</th>
                                      <th style="width: 40%;">পণ্য</th>
                                      <th style="width: 20%;">পরিমাণ</th>
                                      <th style="width: 20%;">টাকা</th>
                                     </tr>
                                </thead>

                                <tbody>
                                    @foreach(Cart::instance('shopping')->content() as $value)
                                    <tr>
                                        <td>
                                            <a class="cart_remove" data-id="{{$value->rowId}}"><i class="fas fa-trash text-danger"></i></a>
                                        </td>
                                        <td class="text-left">
                                             <a style="font-size: 14px;" href="{{route('product',$value->options->slug)}}"><img src="{{asset($value->options->image)}}" height="30" width="30"> {{Str::limit($value->name,20)}}</a>
                                        </td>
                                        <td width="15%" class="cart_qty">
                                            <div class="qty-cart vcart-qty">
                                                <div class="quantity">
                                                    <button class="minus cart_decrement"  data-id="{{$value->rowId}}">-</button>
                                                    <input type="text" value="{{$value->qty}}" readonly />
                                                    <button class="plus  cart_increment" data-id="{{$value->rowId}}">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>৳{{$value->price*$value->qty}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                     <tr>
                                      <th colspan="3" class="text-end px-4">সাবটোটাল</th>
                                      <td>
                                       <span id="net_total"><span class="alinur">৳ </span><strong>{{$subtotal}}</strong></span>
                                      </td>
                                     </tr>
                                     <tr>
                                      <th colspan="3" class="text-end px-4"> ডেলিভারি চার্জ                                    </th>
                                      <td>
                                       <span id="cart_shipping_cost"><span class="alinur">৳ </span><strong>{{$shipping}}</strong></span>
                                      </td>
                                     </tr>
                                     <tr>
                                      <th colspan="3" class="text-end px-4">মোট</th>
                                      <td>
                                       <span id="grand_total"><span class="alinur">৳ </span><strong>{{$subtotal+$shipping}}</strong></span>
                                      </td>
                                     </tr>
                                    </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
            </div>
                    </div>
                </div>

             </div>
            </div>
        </div>
    </section>
    <section class="view-wesite">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ord_btn extra">
                        <a href="{{ route('home') }}" class="cam_order_now extra-now zoom-animation" id="cam_order_now">
                            <i class="fa-solid fa-hand-point-right"></i> ওয়েবসাইট ভিজিট করতে এই বাটনে ক্লিক করুন
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    
    <div class="admin-call">
        <a href="tel:{{ $contact->hotline }}">
            <img src="{{ asset('public/frontEnd/images/Call.png') }}" alt="" />
        </a>
        <button class="end-col">
            <i class="fa-regular fa-circle-xmark"></i>
        </button>
    </div>
    <!--call now section end-->

        <script src="{{ asset('public/frontEnd/campaign/js') }}/jquery-2.1.4.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/all.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/bootstrap.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/owl.carousel.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/select2.min.js"></script>
        <script src="{{ asset('public/frontEnd/campaign/js') }}/script.js"></script>


        <!-- bootstrap js -->
        <script>
            $(document).ready(function () {
                $(".owl-carousel").owlCarousel({
                    margin: 15,
                    loop: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    autoplayHoverPause: true,
                    items: 1,
                    });
                $('.owl-nav').remove();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>

         <script>
            $("[name='product_color']").on("click", function () {
                var id = $(this).data("id");
                var color = $(this).data("color");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id, product_color: color },
                        url: "{{route('product.color')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                            }
                        },
                    });
                }
            });
            $("[name='product_size']").on("click", function () {
                var id = $(this).data("id");
                var size = $(this).data("size");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id, product_size: size },
                        url: "{{route('product.size')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                            }
                        },
                    });
                }
            });
            $('.district').on('change',function(){
            var id = $(this).val();
                $.ajax({
                   type:"GET",
                   data:{'id':id},
                   url:"{{route('districts')}}",
                   success:function(res){
                    if(res){
                        $(".area").empty();
                        $(".area").append('<option value="">Select..</option>');
                        $.each(res,function(key,value){
                            $(".area").append('<option value="'+key+'" >'+value+'</option>');
                        });

                    }else{
                       $(".area").empty();
                    }
                   }
                });
           });

               $("#area").on("change", function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('shipping.charge') }}",
                    dataType: "html",
                    success: function(response) {
                        $(".cartlist").html(response);
                    },
                });
            });

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
        <script>
            $(window).on('load', function() {
            let count = 0;
            const maxCount = 2;

            const intervalId = setInterval(function() {
                if (count < maxCount) {
                    $('.admin-call').addClass('active');
                    console.log('it is working.');
                    count++;
                } else {
                    clearInterval(intervalId);
                }
            }, 10000); // 10000 milliseconds = 10 seconds
            });
    
            $(".end-col").click(function() {
                $('.admin-call').removeClass('active');
            });
        </script>



           <script>
            $(".cart_remove").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.remove_bn')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                $("#loading").hide();
                            }
                        },
                    });
                }
            });
            $(".cart_increment").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.increment_bn')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                $("#loading").hide();
                            }
                        },
                    });
                }
            });

            $(".cart_decrement").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.decrement_bn')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                $("#loading").hide();
                            }
                        },
                    });
                }
            });

        </script>
        <script>
            $('.review_slider').owlCarousel({
                dots: false,
                arrow: false,
                autoplay: true,
                loop: true,
                margin: 10,
                smartSpeed: 1000,
                mouseDrag: true,
                touchDrag: true,
                items: 6,
                responsiveClass: true,
                responsive: {
                    300: {
                        items: 1,
                    },
                    480: {
                        items: 2,
                    },
                    768: {
                        items: 5,
                    },
                    1170: {
                        items: 5,
                    },
                }
            });
        </script>

        <script>
            $('.campro_img_slider').owlCarousel({
                dots: false,
                arrow: false,
                autoplay: true,
                loop: true,
                margin: 10,
                smartSpeed: 1000,
                mouseDrag: true,
                touchDrag: true,
                items: 3,
                responsiveClass: true,
                responsive: {
                    300: {
                        items: 1,
                    },
                    480: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                    1170: {
                        items: 3,
                    },
                }
            });
        </script>
    </body>
</html>
