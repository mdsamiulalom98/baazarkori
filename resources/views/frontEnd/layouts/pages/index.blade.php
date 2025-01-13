@extends('frontEnd.layouts.master') 
@section('title', 'BaazarKori - Your One-Stop Online Retail, Wholesale, and Reseller Platform') 
@push('seo')
<meta name="app-url" content="https://baazarkori.com/" />
<meta name="robots" content="index, follow" />
<meta name="description" content="BaazarKori is your trusted online platform for retail, wholesale, and reselling. Shop electronics, fashion, and more with secure payment and fast delivery." />
<meta name="keywords" content="Online retail, wholesale, reseller, shopping platform, electronics, fashion, household items, secure payment, fast delivery" />

<!-- Open Graph data -->
<meta property="og:title" content="BaazarKori - Your One-Stop Online Retail, Wholesale, and Reseller Platform" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://baazarkori.com/" />
<meta property="og:image" content="{{ asset($generalsetting->white_logo) }}" />
<meta property="og:description" content="BaazarKori is your trusted online platform for retail, wholesale, and reselling. Shop electronics, fashion, and more with secure payment and fast delivery." />
@endpush 
@section('content')
<section class="slider-section" style="background-image: url({{ asset($backgroundimg->image) }});">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <div class="home-slider-container">
                    <div class="main_slider owl-carousel">
                        @foreach ($sliders as $key => $value)
                            <div class="slider-item">
                               <div class="slider-des">
                                   <h5>{{$value->title}}</h5>
                                   <h4>{{$value->subtitle}}</h4>
                                   <a href="{{$value->link}}">Start Buying</a>
                               </div>
                               <div class="slider-img">
                                   <a href="{{$value->link}}">
                                        <img src="{{ asset($value->image) }}" alt="slider image {{$key+1}}" />
                                   </a>
                               </div>
                            </div>
                            <!-- slider item -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- slider end -->
<!-- shop-banner section start -->
<section class="shop-banner">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="shop-banner-slider owl-carousel">
                    @foreach ($sliderbottomads as $key => $value)
                    <div class="shop-item">
                        <a href="{{$value->link}}">
                            <div class="head-multi-shop">
                                <div class="shop-img">
                                    <img src="{{asset($value->image)}}" alt="" />
                                </div>
                                <div class="shop-des">
                                    <h5>
                                        {{$value->title}}
                                    </h5>
                                    <div class="shop-button">
                                      <a href="{{$value->link}}">Shop Now</a>
                                    <a href="{{$value->link}}"><i class="fa-solid fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <!-- end-col -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="special-feature">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                
                <div class="special-offer owl-carousel specialoffer-slider">
                    @foreach ($special_offer as $key => $value)
                    <div class="specialoffer-item">
                        <h4>{{$value->title}}</h4>
                        <a href="{{ route('product', $value->product->slug) }}" class="special-image-link">
                            <img src="{{asset($value->product->image->image)}}" alt="" />
                        </a>
                        <div class="special-product-name">
                            <a href="{{ route('product', $value->product->slug) }}">{{$value->product->name}}</a>
                        </div>
                        <div class="special-product-price">
                            <h5>৳{{$value->product->new_price}}</h5>
                        </div>
                        <div class="special-counter">
                             <div class="deal-progress">
                                <div class="deal-stock">
                                    <span class="stock-sold">Already Sold: <strong>{{$value->product->sold}}</strong></span>
                                    <span class="stock-available">Available: <strong>{{$value->product->stock}}</strong></span>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-warning" style="width: 75%"></div>
                            </div>
                            </div>

                            <!-- end-progress-bar -->
                            <h6>Hurry Up! Offer ends in: </h6>
                            <div class="timer_inner">
                                <div class="flipper myFlipper{{$key+1}}" 
                                     data-datetime="{{$value->date}} 00:00:00" 
                                     data-template="dd|HH|ii|ss" 
                                     data-labels="Days|Hours|Minutes|Seconds" 
                                     data-reverse="true" 
                                     >
                                </div>

                            </div>
                         </div>
                    </div> 
                        
                    @endforeach 
                </div>
            </div>
            <!-- end-col -->
            <div class="col-sm-8">
                <!-- start-nav-Tabs -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Featured</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">On Sale</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Top rated</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="feature">
                                <div class="product_sliders">
                                @foreach ($feature_product as $key => $value)
                                  <div class="product_item wist_item">
                                    <div class="product_item_inner">
                                        <!-- persentige-start -->
                                       <div class="top__btns">
                                            @if($value->old_price)
                                        <div class="discount__top">
                                            <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                        </div>
                                        @endif
                                        <del>৳ {{ $value->old_price }}</del>
                                       </div>
                                       <!-- persentige -end  -->
                                       <!-- ratting-start -->
                                       <div class="product-ratting">
                                           @if($value->reviews)
                                             <div class="details-ratting-wrap review_pro">
                                                    @php
                                                        $averageRating = $value->reviews->avg('ratting');
                                                        $filledStars = floor($averageRating);
                                                        $emptyStars = 5 - $filledStars;
                                                    @endphp
                                                    
                                                    @if ($averageRating >= 0 && $averageRating <= 5)
                                                        @for ($i = 1; $i <= $filledStars; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                
                                                        @if ($averageRating == $filledStars)
                                                            {{-- If averageRating is an integer, don't display half star --}}
                                                        @else
                                                            <i class="far fa-star-half-alt"></i>
                                                        @endif
                                                    
                                                        @for ($i = 1; $i <= $emptyStars; $i++)
                                                            <i class="far fa-star"></i>
                                                        @endfor
                                                    
                                                        <span> | </span>
                                                    @else
                                                        <span>Invalid rating range</span>
                                                    @endif
                                                    
                                                    </div>
                                           @endif 
                                       <div class="sold-product">
                                           <p>sold ({{$value->sold}})</p>
                                       </div>
                                       </div>
                                       <!-- ratting-end -->
                                       <div class="pro_name">
                                                <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                            </div>
                                        <div class="pro_img">
                                            <a href="{{ route('product', $value->slug) }}">
                                                <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                                            </a>
                                        </div>
                                       
                                        <div class="button-product">
                                            <div class="quick_wishlist mobile-fav">
                                                <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                                            </div>
                                            
                                            <div class="details-compare-button">
                                                <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                                </a>
                                            </div>
                                        </div>
                                        <div class="pro_des">
                                            
                                              <div class="hover__price">
                                                <div class="btn_buy_hover">
                                                    <p>
                                                        ৳ {{ $value->new_price }} @if ($value->old_price) @endif
                                                        @if($value->whole_sell_price)
                                                        <strong>৳ {{$value->whole_sell_price}}</strong>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="pro__btns_fotter fotter__btn">
                                            
                                            <div class="pro_btn">
                                                <div class="cart_btn">
                                                    <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                                </div>
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $value->id }}" />
                                                    <input type="hidden" name="qty" value="1" />
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                  </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <!-- popular product-start -->
                            <div class="feature">
                                <div class="product_sliders">
                                @foreach ($on_sale_tab as $key => $value)
                            
                                  <div class="product_item wist_item">
                                    <div class="product_item_inner">
                                       <!-- persentige-start -->
                                       <div class="top__btns">
                                            @if($value->old_price)
                                        <div class="discount__top">
                                            <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                        </div>
                                        @endif
                                        <!-- @if($value->stock <= 0)
                                          <div> <p class="out__stock">Out Of Stock</p></div>
                                        @endif -->
                                        <del>৳ {{ $value->old_price }}</del>
                                       </div>
                                       <!-- persentige -end  -->
                                       <!-- ratting-start -->
                                       <div class="product-ratting">
                                           @if($value->reviews)
                                             <div class="details-ratting-wrap review_pro">
                                                    @php
                                                        $averageRating = $value->reviews->avg('ratting');
                                                        $filledStars = floor($averageRating);
                                                        $emptyStars = 5 - $filledStars;
                                                    @endphp
                                                    
                                                    @if ($averageRating >= 0 && $averageRating <= 5)
                                                        @for ($i = 1; $i <= $filledStars; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                
                                                        @if ($averageRating == $filledStars)
                                                            {{-- If averageRating is an integer, don't display half star --}}
                                                        @else
                                                            <i class="far fa-star-half-alt"></i>
                                                        @endif
                                                    
                                                        @for ($i = 1; $i <= $emptyStars; $i++)
                                                            <i class="far fa-star"></i>
                                                        @endfor
                                                    
                                                        <span> | </span>
                                                    @else
                                                        <span>Invalid rating range</span>
                                                    @endif
                                                    
                                                    </div>
                                           @endif 
                                       <div class="sold-product">
                                           <p>sold ({{$value->sold}})</p>
                                       </div>
                                       </div>
                                       <!-- ratting-end -->
                                       <div class="pro_name">
                                                <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                            </div>
                                        <div class="pro_img">
                                            <a href="{{ route('product', $value->slug) }}">
                                                <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                                            </a>
                                        </div>

                                        <div class="button-product">
                                            <div class="quick_wishlist mobile-fav">
                                                <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                                            </div>
                                            
                                            <div class="details-compare-button">
                                                <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                                </a>
                                            </div>
                                        </div>
                                        <div class="pro_des">
                                              <div class="hover__price">
                                                <div class="btn_buy_hover">
                                                    <p>
                                                        ৳ {{ $value->new_price }} 
                                                        @if($value->whole_sell_price)
                                                        <strong>৳ {{$value->whole_sell_price}}</strong>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro__btns_fotter fotter__btn">
                                            
                                            <div class="pro_btn">
                                                <div class="cart_btn">
                                                    <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                                </div>
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $value->id }}" />
                                                    <input type="hidden" name="qty" value="1" />
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                  </div>
                                 
                                @endforeach
                                </div>
                            </div>
                            <!-- popular product-end -->
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="feature">
                                <div class="product_sliders">
                                @foreach ($toprated as $key => $value)
                                  <div class="product_item wist_item">
                                    <div class="product_item_inner">
                                       <!-- persentige-start -->
                                       <div class="top__btns">
                                            @if($value->old_price)
                                        <div class="discount__top">
                                            <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                        </div>
                                        @endif
                                        <!-- @if($value->stock <= 0)
                                          <div> <p class="out__stock">Out Of Stock</p></div>
                                        @endif -->
                                        <del>৳ {{ $value->old_price }}</del>
                                       </div>
                                       <!-- persentige -end  -->
                                       <!-- ratting-start -->
                                       <div class="product-ratting">
                                           @if($value->reviews)
                                             <div class="details-ratting-wrap review_pro">
                                                    @php
                                                        $averageRating = $value->reviews->avg('ratting');
                                                        $filledStars = floor($averageRating);
                                                        $emptyStars = 5 - $filledStars;
                                                    @endphp
                                                    
                                                    @if ($averageRating >= 0 && $averageRating <= 5)
                                                        @for ($i = 1; $i <= $filledStars; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                
                                                        @if ($averageRating == $filledStars)
                                                            {{-- If averageRating is an integer, don't display half star --}}
                                                        @else
                                                            <i class="far fa-star-half-alt"></i>
                                                        @endif
                                                    
                                                        @for ($i = 1; $i <= $emptyStars; $i++)
                                                            <i class="far fa-star"></i>
                                                        @endfor
                                                    
                                                        <span> | </span>
                                                    @else
                                                        <span>Invalid rating range</span>
                                                    @endif
                                                    
                                                    </div>
                                           @endif 
                                       <div class="sold-product">
                                           <p>sold ({{$value->sold}})</p>
                                       </div>
                                       </div>
                                       <!-- ratting-end -->
                                       <div class="pro_name">
                                                <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                            </div>
                                        <div class="pro_img">
                                            <a href="{{ route('product', $value->slug) }}">
                                                <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                                            </a>
                                        </div>

                                        <div class="button-product">
                                            <div class="quick_wishlist mobile-fav">
                                                <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                                            </div>
                                            
                                            <div class="details-compare-button">
                                                <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                                </a>
                                            </div>
                                        </div>                                      
                                        <div class="pro_des">
                                            
                                              <div class="hover__price">
                                                <div class="btn_buy_hover">
                                                    <p>
                                                        ৳ {{ $value->new_price }}
                                                        @if($value->whole_sell_price)
                                                        <strong>৳ {{$value->whole_sell_price}}</strong>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro__btns_fotter fotter__btn">
                                            <div class="pro_btn">
                                                <div class="cart_btn">
                                                    <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                                </div>
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $value->id }}" />
                                                    <input type="hidden" name="qty" value="1" />
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                @endforeach
                                </div>
                            </div>
                            <!-- ----------end---------- -->
                        </div>
                    </div>
                    <!-- End-nav-Tabs -->
            </div>
            <!-- end-col -->
        </div>
    </div>
</section>
<!-- special-feature section end -->



@foreach ($homeproducts as $index => $homecat)
    
    @if($index == 0)
    <section class="" style="background-image: url('https://demo.fleetcart.envaysoft.com/storage/media/vm21euwszrldK6E9iEtqsm2WtiJ4OyaA7VIGHPe3.png');">
        <div class="container">
            <div class="row">
                @foreach ($featureads as $key => $value)
                <div class="col-md-3">
                    <a href="{{$value->link}}" target="_self" class="banner"><img src="{{asset($value->image)}}" alt="Banner" /></a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach
<!----------- best-deals-section-start ----------->
<section class="best-seller-section">
    <div class="container">
        <div class="best-saller-head">
            <div class="best-saller-left all-header">
                <h5>Best Deals</h5>
            </div>
            <div class="best-saller-right">
                <ul class="Cat-menu">
                    @foreach ($menucategories as $key=>$scategory)
                        <li class="best-saller @if($key > 1) over_list @endif">
                            <a href="{{ url('category/' . $scategory->slug) }}">
                                <span>{{ Str::limit($scategory->name, 25) }}</span>
                                
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="best-seller-body">
            <div class="row">
                <div class="col-sm-4">
                  <div class="product-sliders deals_product_inner">
                    @foreach ($best_deals as $key => $value)
                    @if($key < 4)
                    <div class="product_item wist_item">
                        <div class="product_item_inner">
                           <!-- persentige-start -->
                               <div class="top__btns">
                                    @if($value->old_price)
                                <div class="discount__top">
                                    <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                </div>
                                @endif
                                <del>৳ {{ $value->old_price }}</del>
                               </div>
                               <!-- persentige -end  -->
                               <!-- ratting-start -->
                               <div class="product-ratting">
                                   @if($value->reviews)
                                     <div class="details-ratting-wrap review_pro">
                                            @php
                                                $averageRating = $value->reviews->avg('ratting');
                                                $filledStars = floor($averageRating);
                                                $emptyStars = 5 - $filledStars;
                                            @endphp
                                            
                                            @if ($averageRating >= 0 && $averageRating <= 5)
                                                @for ($i = 1; $i <= $filledStars; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                        
                                                @if ($averageRating == $filledStars)
                                                    {{-- If averageRating is an integer, don't display half star --}}
                                                @else
                                                    <i class="far fa-star-half-alt"></i>
                                                @endif
                                            
                                                @for ($i = 1; $i <= $emptyStars; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            
                                                <span> | </span>
                                            @else
                                                <span>Invalid rating range</span>
                                            @endif
                                            
                                            </div>
                                   @endif 
                               <div class="sold-product">
                                   <p>sold ({{$value->sold}})</p>
                               </div>
                               </div>
                               <!-- ratting-end -->
                           <div class="pro_name">
                                    <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                </div>
                            <div class="pro_img">
                                <a href="{{ route('product', $value->slug) }}">
                                    <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                                </a>
                            </div>
        
                            <div class="button-product">
                                <div class="quick_wishlist mobile-fav">
                                    <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                                </div>
                                
                                <div class="details-compare-button">
                                    <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                    </a>
                                </div>
                            </div>
                            <div class="pro_des">
                                
                                  <div class="hover__price-sell">
                                    <div class="btn_buy_hover">
                                        <p>
                                            ৳ {{ $value->new_price }} @if ($value->old_price) @endif
                                            @if($value->whole_sell_price)
                                            <strong>৳ {{$value->whole_sell_price}}</strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="pro__btns_fotter fotter__btn"> 
                                <div class="pro_btn">
                                    <div class="cart_btn">
                                        <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                    </div>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                  </div>
                </div>
                 <!-- end-best-seller-col item  -->
                 <div class="col-sm-4">
                        <div class="special-offer-bottom">
                        @foreach ($special_offer as $key => $value)
                        @if($key == 1)
                        <h4>Special Offer</h4>
                        <a href="{{route ('product', $value->product->slug)}}"><img src="{{ asset($value->product->image->image)}}" alt="" /></a>
                        <div class="special-product-name">
                            <a href="{{ route('product', $value->product->slug)}}">{{Str::limit($value->product->name, 50) }}</a>
                        </div>
                        <div class="special-product-price">
                            <p>৳ {{ $value->product->new_price }} @if ($value->product->old_price) @endif
                                @if($value->product->whole_sell_price)
                                <span>৳ {{$value->product->whole_sell_price}}</span>
                                @endif
                            </p>
                        </div>

                         <div class="button-products">
                                <div class="quick_wishlist mobile-fav">
                                    <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                                </div>
                                
                                <div class="details-compare-buttons">
                                    <a href="#" data-id="{{$value->product->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                    </a>
                                </div>
                            </div>
                           <div class="pro__btns_fotters fotter__btns"> 
                                <div class="pro_btns">
                                    <div class="cart_btns">
                                        <a data-id="{{ $value->product->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                    </div>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                    </form>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                 <!-- end-col -->
                 <div class="col-sm-4">
                  <div class="product-sliders deals_product_inner">
                   @foreach ($best_deals as $key => $value)
                    @if($key > 4)
                     <div class="product_item wist_item">
                        <div class="product_item_inner">
                            <!-- persentige-start -->
                               <div class="top__btns">
                                    @if($value->old_price)
                                <div class="discount__top">
                                    <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                </div>
                                @endif
                                <del>৳ {{ $value->old_price }}</del>
                               </div>
                               <!-- persentige -end  -->
                               <!-- ratting-start -->
                               <div class="product-ratting">
                                   @if($value->reviews)
                                     <div class="details-ratting-wrap review_pro">
                                            @php
                                                $averageRating = $value->reviews->avg('ratting');
                                                $filledStars = floor($averageRating);
                                                $emptyStars = 5 - $filledStars;
                                            @endphp
                                            
                                            @if ($averageRating >= 0 && $averageRating <= 5)
                                                @for ($i = 1; $i <= $filledStars; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                        
                                                @if ($averageRating == $filledStars)
                                                    {{-- If averageRating is an integer, don't display half star --}}
                                                @else
                                                    <i class="far fa-star-half-alt"></i>
                                                @endif
                                            
                                                @for ($i = 1; $i <= $emptyStars; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            
                                                <span> | </span>
                                            @else
                                                <span>Invalid rating range</span>
                                            @endif
                                            
                                            </div>
                                   @endif 
                               <div class="sold-product">
                                   <p>sold ({{$value->sold}})</p>
                               </div>
                               </div>
                               <!-- ratting-end -->
                           <div class="pro_name">
                                    <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                </div>
                            <div class="pro_img">
                                <a href="{{ route('product', $value->slug) }}">
                                    <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                                </a>
                            </div>
                            <div class="button-product">
                                <div class="quick_wishlist mobile-fav">
                                    <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                                </div>
                                <div class="details-compare-button">
                                    <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                    </a>
                                </div>
                            </div>
                            <div class="pro_des">
                                
                                  <div class="hover__price-sell">
                                    <div class="btn_buy_hover">
                                        <p>
                                            ৳ {{ $value->new_price }} @if ($value->old_price) @endif
                                            @if($value->whole_sell_price)
                                            <strong>৳ {{$value->whole_sell_price}}</strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="pro__btns_fotter fotter__btn"> 
                                <div class="pro_btn">
                                    <div class="cart_btn">
                                        <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                    </div>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                    </form>
                                </div>
                            </div>

                        </div>
                     </div>
                     @endif
                   @endforeach
                  </div>
                </div>
                 <!-- end-best-seller-col item  -->
                 <div class="col-sm-12 btn-view">
                    <a href="{{ route('hotdeals') }}" class="view_more_btn" style="">View More</a>
                </div>
           
                  </div>
                </div>
                 <!-- end-best-seller-col item  -->
            </div>
        </div>
        <!-- seller-part-1 end -->
    </div>
</section>
<!----------- best-deals-section-end ----------->
<!----------- best-seller-section-start ----------->
<section class="best-seller-section">
    <div class="container">
        <div class="best-saller-head">
            <div class="best-saller-left all-header">
                <h5>Best Seller</h5>
            </div>
            <div class="best-saller-right">
                <ul class="Cat-menu">
                    @foreach ($menucategories as $key=>$scategory)
                     @if($key < 3)
                        <li class="best-saller over_list ">
                            <a href="{{ url('category/' . $scategory->slug) }}">
                                <span>{{ Str::limit($scategory->name, 25) }}</span>
                                
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
                
            </div>
        </div>
        @foreach ($homeproducts as $index => $homecat)
        <div class="seller_slider owl-carousel">
            @foreach ($homecat->products as $key => $value)
            <div class="seller_item wist_item">
                <div class="seller_item_inner">
                   <div class="seller-product-image">
                    <div class="b-seller_img">
                        <a href="{{ route('product', $value->slug) }}">
                            <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                        </a>
                    </div>
                   </div>
                   <!-- seller-product-image end -->
                    <div class="seller-product-description">
                        <div class="spro_name">
                            <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                        </div>

                        <div class="button-seller">
                            <div class="quick_wishlist mobile-fav">
                                <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                            </div>
                            
                            <div class="details-compare-button-seller">
                                <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                </a>
                            </div>
                        </div>
                        <div class="pro_des">
                              <div class="hover__price1">
                                <div class="btn_buy_hover_sell">
                                    <p>
                                        ৳ {{ $value->new_price }} @if ($value->old_price) @endif
                                        @if($value->whole_sell_price)
                                        <strong>৳ {{$value->whole_sell_price}}</strong>
                                        @endif
                                    </p>
                                </div>
                            </div>  
                        </div>
                        <div class="pro__btns_fotter fotter__btn">  
                            <div class="pro_btn">
                                <div class="cart_btn">
                                    <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                </div>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $value->id }}" />
                                    <input type="hidden" name="qty" value="1" />
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    <!-- end-seller-description-end -->
                </div>
              </div>
            @endforeach
        </div>
        @endforeach
        <div class="seller_slider owl-carousel">
            @foreach ($on_sale as $key => $value)
            
            <div class="seller_item wist_item">
                <div class="seller_item_inner">
                   <div class="seller-product-image">
                    <div class="b-seller_img">
                        <a href="{{ route('product', $value->slug) }}">
                            <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                        </a>
                    </div>
                   </div>
                   <!-- seller-product-image end -->
                    <div class="seller-product-description">
                        <div class="spro_name">
                            <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                        </div>

                        <div class="button-seller">
                            <div class="quick_wishlist mobile-fav">
                                <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                            </div>
                            
                            <div class="details-compare-button-seller">
                                <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                </a>
                            </div>
                        </div>
                        <div class="pro_des">
                              <div class="hover__price1">
                                <div class="btn_buy_hover_sell">
                                    <p>
                                        ৳ {{ $value->new_price }} @if ($value->old_price) @endif
                                        @if($value->whole_sell_price)
                                        <strong>৳ {{$value->whole_sell_price}}</strong>
                                        @endif
                                    </p>
                                </div>
                            </div>  
                        </div>
                        <div class="pro__btns_fotter fotter__btn">  
                            <div class="pro_btn">
                                <div class="cart_btn">
                                    <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                </div>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $value->id }}" />
                                    <input type="hidden" name="qty" value="1" />
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    <!-- end-seller-description-end -->
                </div>
              </div>
            @endforeach
        </div>
        <!-- seller-part-1 end -->
    </div>
</section>
<!------------- best-seller-section-end ------------>


<section class="homeproduct">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="sec_title">
                    <h3 class="section-title-header">
                        Recently Added
                    </h3>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="product_slider owl-carousel">
                    @foreach ($hotdeal_top as $key => $value)
                    <div class="product_item wist_item">
                        <div class="product_item_inner">
                           <!-- persentige-start -->
                               <div class="top__btns">
                                    @if($value->old_price)
                                <div class="discount__top">
                                    <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                </div>
                                @endif
                                <del>৳ {{ $value->old_price }}</del>
                               </div>
                               <!-- persentige -end  -->
                               <!-- ratting-start -->
                               <div class="product-ratting">
                                   @if($value->reviews)
                                     <div class="details-ratting-wrap review_pro">
                                            @php
                                                $averageRating = $value->reviews->avg('ratting');
                                                $filledStars = floor($averageRating);
                                                $emptyStars = 5 - $filledStars;
                                            @endphp
                                            
                                            @if ($averageRating >= 0 && $averageRating <= 5)
                                                @for ($i = 1; $i <= $filledStars; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                        
                                                @if ($averageRating == $filledStars)
                                                    {{-- If averageRating is an integer, don't display half star --}}
                                                @else
                                                    <i class="far fa-star-half-alt"></i>
                                                @endif
                                            
                                                @for ($i = 1; $i <= $emptyStars; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            
                                                <span> | </span>
                                            @else
                                                <span>Invalid rating range</span>
                                            @endif
                                            
                                            </div>
                                   @endif 
                               <div class="sold-product">
                                   <p>sold ({{$value->sold}})</p>
                               </div>
                               </div>
                               <!-- ratting-end -->
                           <div class="pro_name">
                                    <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                </div>
                            <div class="pro_img">
                                <a href="{{ route('product', $value->slug) }}">
                                    <img src="{{ asset($value->image ? $value->image->image : '') }}" width="182" height="192" alt="{{ $value->name }}" />
                                </a>
                            </div>

                            <div class="button-product">
                                <div class="quick_wishlist mobile-fav">
                                    <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i><a>Favorite</a></button>
                                </div>
                                
                                <div class="details-compare-button">
                                    <a href="#" data-id="{{$value->id}}" class="comparecartbutton"><i class="fa-solid fa-sliders"></i>Compare
                                    </a>
                                </div>
                            </div>
                            <div class="pro_des">
                                
                                  <div class="hover__price-sell">
                                    <div class="btn_buy_hover">
                                        <p>
                                            ৳ {{ $value->new_price }} @if ($value->old_price) @endif
                                            @if($value->whole_sell_price)
                                            <strong>৳ {{$value->whole_sell_price}}</strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="pro__btns_fotter fotter__btn"> 
                                <div class="pro_btn">
                                    <div class="cart_btn">
                                        <a data-id="{{ $value->id }}" class="addcartbutton"><i class="fa-solid fa-cart-plus"></i></a>
                                    </div>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-12 btn-view">
                <a href="{{ route('hotdeals') }}" class="view_more_btn" style="">View More</a>
            </div>
        </div>
    </div>
</section>
<!-- homeproduct-section-end -->


@if($popup_banner->count() > 0)
<section>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="my_modal_img">
            @foreach($popup_banner as $key=>$value)
            <a href="{{$value->link}}">
                <img src="{{asset($value->image)}}">
            </a>
            @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@endif
@endsection 
@push('script')
<script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
<!-- <script src="{{ asset('public/frontEnd/js/jquery.syotimer.min.js') }}"></script> -->
<script src="{{ asset('public/frontEnd/js/jquery.flipper-responsive.js') }}"></script>

@foreach ($special_offer as $key => $value)
<script>
    $(function(){
        $('.myFlipper{{$key+1}}').flipper('init');
    });
</script>
@endforeach

<script>
    $(document).ready(function() {
        $(".main_slider").owlCarousel({
            items: 1,
            loop: true,
            dots: true,
            autoplay: true,
            nav: true,
            autoplayHoverPause: false,
            margin: 0,
            mouseDrag: true,
            smartSpeed: 1000,
            autoplayTimeout: 6000,
            // animateOut: "fadeOutRight",
            // animateIn: "slideInLeft",
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                600: {
                    items: 1,
                    nav: true,
                },
                1000: {
                    items: 1,
                    nav: true,
                    loop: true,
                },
            },

            navText: ["<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>"
            ],
        });

    var owl = $('.main_slider');
    owl.owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,

    });
    owl.on('changed.owl.carousel', function (event) {
        var item = event.item.index - 2; // Position of the current item
        $('h4').removeClass('animated fadeInUp');
        $('h5').removeClass('animated fadeInRight');
        $('a').removeClass('animated fadeInRight');
        $('img').removeClass('animated fadeInUp');
        $('.owl-item').not('.cloned').eq(item).find('h4').addClass('animated fadeInUp');
        $('.owl-item').not('.cloned').eq(item).find('h5').addClass('animated fadeInRight');
        $('.owl-item').not('.cloned').eq(item).find('a').addClass('animated fadeInRight');
        $('.owl-item').not('.cloned').eq(item).find('img').addClass('animated fadeInUp');
    });
    });
</script>
<script>
    $('.specialoffer-slider').owlCarousel({
        items: 1,
        loop:true,            
        dots: false,
        margin:1,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:1,
                nav:false
            },
            1000:{
                items:1,
                loop:false
            }
        }
    });
</script>
<script>
    $(document).ready(function() {
        $(".hotdeals-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: false,
                },
            },
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".shop-banner-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                },
                600: {
                    items: 2,
                    nav: false,
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true,
                    margin: 1,
                },
            },
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".category-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 5,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 8,
                    nav: true,
                    loop: false,
                },
            },
        });

        $(".product_slider").owlCarousel({
            margin: 10,
            items: 6,
            loop: true,
            dots: false,
            autoplay: false,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                600: {
                    items: 5,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: false,
                },
            },
        });
        $(".seller_slider").owlCarousel({
            margin: 15,
            items: 4,
            loop: true,
            dots: false,
            autoplay: false,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 4,
                    nav: false,
                },
            },
        });
        
    });
</script>

@if(request()->get('view')=='')
 <script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
@endif
                        
@endpush
