@extends('frontEnd.layouts.master') 
@section('title',Auth::guard('seller')->user()->name)
@push('css')
<link rel="stylesheet" href="{{asset('public/frontEnd/css/jquery-ui.css')}}" />
@endpush 
@section('content')
<section class="product-section">
    <div class="container">
        <div class="sorting-section">
            <div class="row">
                <div class="col-sm-6">
                    <div class="category-breadcrumb d-flex align-items-center">
                        <a href="{{ route('home') }}">Home</a>
                        <span>/</span>
                        <strong>{{(Auth::guard('seller')->user()->name)}}</strong>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="showing-data">
                                <span>Showing {{ $yourshop->firstItem() }}-{{ $yourshop->lastItem() }} of {{ $yourshop->total() }} Results</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mobile-filter-toggle">
                                <i class="fa fa-list-ul"></i><span>filter</span>
                            </div>
                            <div class="page-sort">
                                <form action="" class="sort-form">
                                    <select name="sort" class="form-control form-select sort">
                                        <option value="1" @if(request()->get('sort')==1)selected @endif>Product: Latest</option>
                                        <option value="2" @if(request()->get('sort')==2)selected @endif>Product: Oldest</option>
                                        <option value="3" @if(request()->get('sort')==3)selected @endif>Price: High To Low</option>
                                        <option value="4" @if(request()->get('sort')==4)selected @endif>Price: Low To High</option>
                                        <option value="5" @if(request()->get('sort')==5)selected @endif>Name: A-Z</option>
                                        <option value="6" @if(request()->get('sort')==6)selected @endif>Name: Z-A</option>
                                    </select>
                                    <input type="hidden" name="min_price" value="{{request()->get('min_price')}}" />
                                    <input type="hidden" name="max_price" value="{{request()->get('max_price')}}" />
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                 <div class="offer_timer" id="simple_timer"></div>
            </div>
            <div class="col-sm-12">
                <div class="product-sliders main_product_inner">
                    @foreach($yourshop as $key=>$value)
                    <div class="product_item wist_item wow zoomIn" data-wow-duration="1s">
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
        <div class="row">
            <div class="col-sm-12">
                <div class="custom_paginate">
                    {{$yourshop->links('pagination::bootstrap-4')}}
                   
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@push('script')
<script>
    $(".sort").change(function(){
       $('#loading').show();
       $(".sort-form").submit();
    })
</script>
<script>
    $("#simple_timer").syotimer({
        date: new Date(2015, 0, 1),
        layout: "hms",
        doubleNumbers: false,
        effectType: "opacity",

        periodUnit: "d",
        periodic: true,
        periodInterval: 1,
    });
</script>
@endpush