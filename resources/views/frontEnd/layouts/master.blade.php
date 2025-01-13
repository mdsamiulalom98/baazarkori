<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - {{ $generalsetting->name }}</title>
    <!-- App favicon -->

    <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" alt="Baazarkori Ecommerce Favicon" />
    <meta name="author" content="Baazarkori Ecommerce" />
    <link rel="canonical" href="https://baazarkori.com/" />
    @stack('seo')
    @stack('css')
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/flipper.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.theme.default.min.css') }}" />
    <!-- toastr css -->
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/assets/css/toastr.min.css" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/wsit-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/style.css?v=1.4.12') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/responsive.css?v=1.4.22') }}" />

    <style>
        @foreach ($socialicons as $value)
            .footer-about ul li a.{{ $value->slug }}:hover i {
                color: {{ $value->color }} !important;
            }
        @endforeach
    </style>
    @foreach ($pixels as $pixel)
        <!-- Facebook Pixel Code -->
        <script>
            !(function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = "2.0";
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            })(window, document, "script", "https://connect.facebook.net/en_US/fbevents.js");
            fbq("init", "{{ $pixel->code }}");
            fbq("track", "PageView");
        </script>
        <noscript>
            <img height="1" width="1" style="display: none;"
                src="https://www.facebook.com/tr?id={{ $pixel->code }}&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endforeach

    @foreach ($gtm_code as $gtm)
        <!-- Google tag (gtag.js) -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })
            (window, document, 'script', 'dataLayer', 'GTM-{{ $gtm->code }}');
        </script>
        <!-- End Google Tag Manager -->
    @endforeach
</head>

<body class="gotop">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
    @endphp
    <div class="mobile-menu">
        <div class="mobile-menu-logo">
            <div class="logo-image">
                <a href="{{ route('home') }}"> <img src="{{ asset($generalsetting->white_logo) }}"
                        alt="" /></a>
            </div>
            <div class="mobile-menu-close">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <ul class="first-nav">
                <li class="parent-category" style="margin-left: 16px; color: red !important; padding-right:5px; font-size:18px; font-weight; 800">
                    <a href="{{ route('seller.login') }}" style="color:red;">
                        <i class="fa fa-sign-in"></i>
                        @lang('Seller Corner')
                    </a>
                </li>
            @foreach ($menucategories as $scategory)
                <li class="parent-category">
                    <a href="{{ url('category/' . $scategory->slug) }}" class="menu-category-name">
                        <img src="{{ asset($scategory->icon) }}" alt="" class="side_cat_img" />
                        {{ $scategory->name }}
                    </a>
                    @if ($scategory->subcategories->count() > 0)
                        <span class="menu-category-toggle">
                            <i class="fa fa-chevron-down"></i>
                        </span>
                    @endif
                    <ul class="second-nav" style="display: none;">
                        @foreach ($scategory->subcategories as $subcategory)
                            <li class="parent-subcategory">
                                <a href="{{ url('subcategory/' . $subcategory->slug) }}"
                                    class="menu-subcategory-name">{{ $subcategory->subcategoryName }}</a>
                                @if ($subcategory->childcategories->count() > 0)
                                    <span class="menu-subcategory-toggle"><i class="fa fa-chevron-down"></i></span>
                                @endif
                                <ul class="third-nav" style="display: none;">
                                    @foreach ($subcategory->childcategories as $childcat)
                                        <li class="childcategory"><a href="{{ url('products/' . $childcat->slug) }}"
                                                class="menu-childcategory-name">{{ $childcat->childcategoryName }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
    <header id="navbar_top">
        <div class="mobile-header sticky">
            <div class="mobile-logo">
                <div class="menu-bar">
                    <a class="toggle">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </div>
                <div class="menu-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset($generalsetting->white_logo) }}"
                            alt="" /></a>
                </div>
                <div class="menu-bag">
                    <p class="margin-shopping wishlist-qty" >
                        <a href="{{ route('customer.wishlist') }}">
                            <i class="fa-regular fa-heart"></i>
                            <span>{{ Cart::instance('wishlist')->count() }}</span>
                        </a>
                    </p>
                    <p class="margin-shopping">
                        <a href="{{ route('cart') }}"><i class="fa-solid fa-cart-shopping"></i>
                            <span class="mobilecart-qty">{{ Cart::instance('shopping')->count() }}</span></a>
                    </p>
                </div>
            </div>
        </div>

        <div class="mobile-search">
            <form action="{{ route('search') }}">
                <div class="district-search">
                    <select name="category" id="category">
                        <option value="">All District</option>
                        @foreach($districts as $category)
                            <option value="{{ $category->district }}">{{ $category->district }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" placeholder="Search Product ... " value=""
                    class="msearch_keyword msearch_click" name="keyword" id="searchBar" />
                <button><i data-feather="search"></i></button>
            </form>
            <div class="search_result"></div>
        </div>
        <div class="news-headline mobile">
            <div class="headline-inner">
                <div class="headline-wrapper">
                    @foreach ($newstickers as $key => $value)
                        <marquee direction="left" class="newsticker-color">
                            <p>{{ $value->title }}</p>
                        </marquee>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- newsticker-end -->
        <!-- header to end -->
        <!-- static-top-bar-start -->
        <div class="top-bar">
            <div class="container">
                <div class="main-topbar">
                    <div class="topbar-left">
                        <a title="Welcome to Worldwide Electronics Store" href="#">Welcome to Baazarkori Website
                            Store</a>
                    </div>
                    <div class="topbar-right">
                        <ul>
                            <li class="right-border">
                                <p>
                                    <a href="{{ route('seller.login') }}">
                                        <i class="fa fa-sign-in"></i>
                                        @lang('Seller Corner')
                                    </a>
                                </p>
                            </li>
                            <li>
                                <a title="Track Your Order" href="{{ route('customer.order_track') }}"
                                    class="right-border"><i class="fa-solid fa-truck-fast"></i>Track Your Order</a>
                            </li>
                            <li>
                                <a title="Shop" href="{{ route('hotdeals') }}" class="right-border"><i
                                        class="fa-solid fa-bag-shopping"></i>Shop</a>
                            </li>
                            
                            @if (Auth::guard('customer')->user())
                                <li class="for_order">
                                    <p>
                                        <a href="{{ route('customer.dashboard') }}">
                                            <i class="fa-regular fa-user"></i>

                                            {{ Str::limit(Auth::guard('customer')->user()->name, 10) }}
                                        </a>
                                    </p>
                                </li>
                            @else
                                <li>
                                    <a title="My Account" href="{{ route('customer.login') }}"><i
                                            class="fa-regular fa-user"></i>My Account</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- static-top-bar-end -->

        <div class="main-header">
            <div class="logo-area">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="logo-header">
                                <div class="main-logo">
                                    <a href="{{ route('home') }}"><img
                                            src="{{ asset($generalsetting->white_logo) }}" alt="" /></a>
                                </div>
                                <div class="web-dot menu-bar">
                                    <!-- bootstrap offcanvas start -->
                                    <!-- <a class="toggle">
                                            <i class="fa-solid fa-bars"></i>
                                        </a> -->
                                    <a class="btn btn-white" data-bs-toggle="offcanvas" href="#offcanvasExample"
                                        role="button" aria-controls="offcanvasExample">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>

                                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                                        aria-labelledby="offcanvasExampleLabel">
                                        <div class="offcanvas-header">


                                        </div>
                                        <div class="offcanvas-body">
                                            <div class="mobile-menu mobile-menus active">
                                                <div class="mobile-menu-logo">
                                                    <div class="logo-image">
                                                        <a href="{{ route('home') }}"> <img
                                                                src="{{ asset($generalsetting->white_logo) }}"
                                                                alt="" /></a>
                                                    </div>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                </div>
                                                <ul class="first-nav">
                                                    @foreach ($menucategories as $scategory)
                                                        <li class="parent-category">
                                                            <a href="{{ url('category/' . $scategory->slug) }}"
                                                                class="menu-category-name">
                                                                <img src="{{ asset($scategory->icon) }}"
                                                                    alt="" class="side_cat_img" />
                                                                {{ $scategory->name }}
                                                            </a>
                                                            @if ($scategory->subcategories->count() > 0)
                                                                <span class="menu-category-toggle">
                                                                    <i class="fa fa-chevron-down"></i>
                                                                </span>
                                                            @endif
                                                            <ul class="second-nav" style="display: none;">
                                                                @foreach ($scategory->subcategories as $subcategory)
                                                                    <li class="parent-subcategory">
                                                                        <a href="{{ url('subcategory/' . $subcategory->slug) }}"
                                                                            class="menu-subcategory-name">{{ $subcategory->subcategoryName }}</a>
                                                                        @if ($subcategory->childcategories->count() > 0)
                                                                            <span class="menu-subcategory-toggle"><i
                                                                                    class="fa fa-chevron-down"></i></span>
                                                                        @endif
                                                                        <ul class="third-nav" style="display: none;">
                                                                            @foreach ($subcategory->childcategories as $childcat)
                                                                                <li class="childcategory"><a
                                                                                        href="{{ url('products/' . $childcat->slug) }}"
                                                                                        class="menu-childcategory-name">{{ $childcat->childcategoryName }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- bootstrap offcanvas end -->
                                </div>

                                <div class="main-search">
                                    <form action="{{ route('search') }}">
                                        <div class="district-search">
                                            <select name="category" id="category">
                                                <option value="">All District</option>
                                                @foreach($districts as $category)
                                                    <option value="{{ $category->district }}">{{ $category->district }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" placeholder="Search Product..." id="desktopSearch"
                                            class="search_keyword search_click" name="keyword" />
                                        <button>
                                            <i data-feather="search"></i>
                                        </button>
                                        

                                    </form>
                                    <div class="search_result"></div>
                                </div>
                                <div class="header-list-items">
                                    <ul>
                                        <li class="main-menu-li" id="compareContent">
                                            <a href="{{ route('compare.product') }}" class="main-menu-link">
                                                <p class="margin-shopping">
                                                    <i class="fa-solid fa-code-compare"></i>
                                                    @if (Cart::instance('compare')->content()->count() > 0)
                                                        <span>{{ Cart::instance('compare')->content()->count() }}</span>
                                                    @endif
                                                    <div class="hover-des">
                                                        Compare
                                                    </div>
                                                </p>
                                            </a>
                                        </li>
                                        <!--  ---------end compare -->

                                        <li class="wish-dialog wishlist-qty" >
                                            <a href="{{ route('customer.wishlist') }}" class="main-menu-link">
                                                <p class="margin-shopping">
                                                    <i class="fa-solid fa-heart"></i>
                                                        <span>{{Cart::instance('wishlist')->count()}}</span>
                                                            <div class="hover-des">
                                                                Favorite
                                                            </div>
                                                </p>
                                            </a>
                                        </li>


                                        <!-- <li class="wish-dialog">
                                                <p class="margin-shopping" id="wishlist-qty">
                                                     <a href="{{ route('customer.wishlist') }}">
                                                        <i class="fa-solid fa-heart"></i>
                                                        <span>{{ Cart::instance('compare')->content()->count() }}</span>
                                                        <div class="hover-des">
                                                            Favorite
                                                        </div>
                                                    </a>
                                                </p>

                                        </li> -->
                                        @if (Auth::guard('customer')->user())
                                            <li class="for_order">
                                                <p>
                                                    <a href="{{ route('customer.dashboard') }}">
                                                        <i class="fa-regular fa-user"></i>

                                                        {{ Str::limit(Auth::guard('customer')->user()->name, 10) }}
                                                    </a>
                                                <div class="hover-des">
                                                    My Account
                                                </div>
                                                </p>
                                            </li>
                                        @else
                                            <li class="for_order">
                                                <p>
                                                    <a href="{{ route('customer.login') }}">
                                                        <i class="fa-regular fa-user"></i>
                                                    </a>
                                                <div class="hover-des">
                                                    Login/Registration
                                                </div>
                                                </p>
                                            </li>
                                        @endif

                                        <li class="cart-dialog" id="cart-qty">
                                            <a href="{{ route('cart') }}">
                                                <p class="margin-shopping">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                    <span>{{ Cart::instance('shopping')->count() }}</span>
                                                </p>
                                            </a>
                                            <div class="cshort-summary">
                                                <ul>
                                                    @foreach (Cart::instance('shopping')->content() as $key => $value)
                                                        <li>
                                                            <a href=""><img
                                                                    src="{{ asset($value->options->image) }}"
                                                                    alt="" /></a>
                                                        </li>
                                                        <li><a href="">{{ Str::limit($value->name, 30) }}</a>
                                                        </li>
                                                        <li>Qty: {{ $value->qty }}</li>
                                                        <li>
                                                            <p>৳{{ $value->price }}</p>
                                                            <button class="remove-cart cart_remove"
                                                                data-id="{{ $value->rowId }}"><i
                                                                    data-feather="x"></i></button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <p><strong>Total : ৳{{ $subtotal }}</strong></p>
                                                <a href="{{ route('customer.checkout') }}" class="go_cart"> Order Now
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="menu-area">
                <div class="container"> 
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="catagory_menu">
                                <ul>
                                    <li class="cat_bar {{ request()->is('/') ? 'active' : '' }}">
                                        <a href="#">
                                            <i class="fa-solid fa-bars"></i>
                                            <span class="cat_head">All Departments</span>
                                            <i class="fa-solid fa-angle-down cat_down"></i>
                                        </a>
                                        <ul class="Cat_menu">
                                            @foreach ($menucategories as $key => $scategory)
                                                <li
                                                    class="Cat_list cat_list_hover @if ($key > 8) over_list @endif">
                                                    <a href="{{ url('category/' . $scategory->slug) }}">
                                                        <img src="{{ asset($scategory->icon) }}" alt="" />
                                                        <span>{{ Str::limit($scategory->name, 25) }}</span>
                                                        @if ($scategory->subcategories->count() > 0)
                                                            <i class="fa-solid fa-chevron-right cat_down"></i>
                                                        @endif
                                                    </a>
                                                    @if ($scategory->subcategories->count() > 0)
                                                        <ul class="child_menu">
                                                            @foreach ($scategory->subcategories as $subcat)
                                                                <div>
                                                                    <li class="child_main">
                                                                        <a
                                                                            href="{{ url('subcategory/' . $subcat->slug) }}">{{ $subcat->subcategoryName }}</a>
                                                                        @if ($subcat->childcategories->count() > 0)
                                                                            <ul class="child_sub">
                                                                                @foreach ($subcat->childcategories as $chidcat)
                                                                                    <li>
                                                                                        <a
                                                                                            href="{{ url('products/' . $chidcat->slug) }}">{{ $chidcat->childcategoryName }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                </div>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                            @if ($menucategories->count() > 10)
                                                <li class="see-more-button"><a>See More <i
                                                            class="fa-solid fa-angles-down"></i></a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <!--<li><a href="{{ route('offers') }}">Offers</a></li>-->
                                    <!--<li><a href="">About Us</a></li>-->
                                    <li><a href="{{ route('feature_product') }}">Featured Brands </a></li>
                                    <li><a href="{{ route('toprated') }}">Top Rated</a></li>
                                    <li><a href="{{ route('on_sale') }}">On Sale</a></li>
                                    <li><a href="{{ route('baazarkorimall') }}">Baazarkori Mall</a></li>
                                    <!-- <div class="right_text">
                                        <h6><a href="{{ $freeshipping->link }}">{{ $freeshipping->title }}</a></h6>
                                    </div> -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <!-- newsticker-start -->
                            <div class="news-headline">
                                <div class="headline-inner">
                                    <div class="headline-wrapper">
                                        @foreach ($newstickers as $key => $value)
                                            <marquee direction="left" class="newsticker-color">
                                                <p>{{ $value->title }}</p>
                                            </marquee>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- newsticker-end -->
                        </div>
                    </div>
                </div>
            </div>

    </header>
    <div id="content">
        @yield('content')
    </div>
    <!-- content end -->
    <!-- brand -section start -->
    <section class="brand-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="our-brand owl-carousel">
                        @foreach ($brands as $key => $value)
                            <div class="brand_item">
                                <img src="{{ asset($value->image) }}" alt="" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- brand -section end -->
    <!-- on-sale product section start -->
    <section class="multi-products">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="feature-header">
                        <h5>Featured Products</h5>
                    </div>
                    @foreach ($feature_products as $key => $value)
                        <div class="show-product">
                            <div class="feature-img">
                                <a href="{{ route('product', $value->slug) }}">
                                    <img src="{{ asset($value->image ? $value->image->image : '') }}" />
                                </a>
                            </div>
                            <div class="feature-des">
                                <div class="spro_name">
                                    <a
                                        href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                </div>
                                <div class="feature-ratting">
                                    @if ($value->reviews)
                                        <div class="details-ratting-wrap mreview_pro">
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

                                                <span> ({{ number_format($averageRating, 0) }})</span>
                                            @else
                                                <span>Invalid rating range</span>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                                <div class="feature-price">
                                    <p>
                                        ৳ {{ $value->new_price }} @if ($value->old_price)
                                        @endif
                                        @if ($value->whole_sell_price)
                                            <strong>৳ {{ $value->whole_sell_price }}</strong>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- end-col -->
                </div>
                <!-- end-col -->
                <div class="col-sm-3">
                    <div class="feature-header">
                        <h5>Top Selling Products</h5>
                    </div>
                    @foreach ($toprateds as $key => $value)
                        <div class="show-product">
                            <div class="feature-img">
                                <a href="{{ route('product', $value->slug) }}">
                                    <img src="{{ asset($value->image ? $value->image->image : '') }}" />
                                </a>
                            </div>
                            <div class="feature-des">
                                <div class="spro_name">
                                    <a
                                        href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                </div>
                                <div class="feature-ratting">
                                    @if ($value->reviews)
                                        <div class="details-ratting-wrap mreview_pro">
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

                                                <span> ({{ number_format($averageRating, 0) }})</span>
                                            @else
                                                <span>Invalid rating range</span>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                                <div class="feature-price">
                                    <p>৳ {{ $value->new_price }} @if ($value->old_price)
                                        @endif
                                        @if ($value->whole_sell_price)
                                            <strong>৳ {{ $value->whole_sell_price }}</strong>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- end-col -->
                </div>
                <!-- end-col -->
                <div class="col-sm-3">
                    <div class="feature-header">
                        <h5>On-sale Products</h5>
                    </div>
                    @foreach ($on_sales as $key => $value)
                        <div class="show-product">
                            <div class="feature-img">
                                <a href="{{ route('product', $value->slug) }}">
                                    <img src="{{ asset($value->image ? $value->image->image : '') }}" />
                                </a>
                            </div>
                            <div class="feature-des">
                                <div class="spro_name">
                                    <a
                                        href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                </div>
                                <div class="feature-ratting">
                                    @if ($value->reviews)
                                        <div class="details-ratting-wrap mreview_pro">
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

                                                <span> ({{ number_format($averageRating, 0) }})</span>
                                            @else
                                                <span>Invalid rating range</span>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                                <div class="feature-price">
                                    <p>৳ {{ $value->new_price }} @if ($value->old_price)
                                        @endif
                                        @if ($value->whole_sell_price)
                                            <strong>৳ {{ $value->whole_sell_price }}</strong>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- end-col -->
                </div>
                <!-- end-col -->
                <div class="col-sm-3">
                    @foreach ($footertopads as $key => $value)
                        <div class="big-feature-img">
                            <a href="{{ $value->link }}">
                                <img src="{{ asset($value->image) }}"
                                    alt="footertopads image {{ $key + 1 }}" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- on-sale product section end -->
    <footer>
        <div class="newsletter">
            <div class="container">
                <div class="footer-head">
                    <div class="newslater-section">
                        <div class="newsletter-logo">
                            <img src="{{ asset('public/frontEnd/images/6.png') }}" alt="" />
                        </div>
                        <div class="newsletter-sign">
                            <h5 class="newsletter-title">Sign up to Newsletter</h5>
                        </div>
                    </div>
                    <div class="neswletter-des">
                        <span class="newsletter-marketing-text">...and receive <strong>৳ 20 coupon for first
                                shopping</strong></span>
                    </div>
                    <div class="neswletter-search">
                        <ul class="social_link">
                            <div class="footer-search">
                                <form action="{{ route('search') }}">
                                    <input type="email" placeholder=" Enter Your Email Address " value=""
                                        class="search_keyword search_click" id="siginup" name="keyword" />
                                    <button>
                                        <a href="">SignUp</a>
                                    </button>
                                </form>
                                <div class="search_result"></div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div class="footer-about">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset($generalsetting->white_logo) }}" alt="" />
                            </a>
                            <div class="get-question">
                                <div class="question-img">
                                    <img src="{{ asset('public/frontEnd/images/haadphone.webp') }}"
                                        alt="" />
                                </div>
                                <div class="question-des">
                                    <p>Got Questions ? Call us 24/7!</p>
                                    <h4><a href="tel:{{ $contact->hotline }}"
                                            class="footer-hotlint">{{ $contact->phone }} ,
                                            {{ $contact->hotline }}</a></h4>
                                </div>
                            </div>
                            <strong>Contact Info :</strong>
                            <p>{{ $contact->address }}</p>

                            <ul class="social_link">
                                @foreach ($socialicons as $value)
                                    <li class="social_list">
                                        <a class="mobile-social-link {{ $value->slug }}"
                                            href="{{ $value->link }}"><i class="{{ $value->icon }}"
                                                style="color: #ddd"></i></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-3 mb-3 mb-sm-0 col-6">
                        <div class="footer-menu">
                            <ul class="Cat_menu-footer">
                                <li class="title"><a>Find It Fast</a></li>
                                @foreach ($menucategories as $key => $scategory)
                                    <li
                                        class="Cat_list cat_list_hover @if ($key > 1) over_list @endif">
                                        <a href="{{ url('category/' . $scategory->slug) }}">
                                            <span>{{ Str::limit($scategory->name, 25) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-2 mb-3 mb-sm-0 col-6">
                        <div class="footer-menu">
                            <ul>
                                <li class="title"><a>Link</a></li>
                                <li>
                                    <a href="{{ route('contact') }}"> <a href="{{ route('contact') }}">Contact
                                            Us</a></a>
                                </li>
                                @foreach ($pages as $page)
                                    <li><a
                                            href="{{ route('page', ['slug' => $page->slug]) }}">{{ $page->name }}</a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="footer-menu">
                            <ul>
                                <li class="title stay_conn"><a>Customer Care</a></li>
                            </ul>
                            <ul>
                                <li>
                                    <a href="{{ route('customer.login') }}">My Account</a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.order_track') }}">Track your Order</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}">Customer Service</a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.register') }}">Registration</a>
                                </li>
                                <li class="fake-show">
                                    <a href=""><strong>Customer <span>( {{$generalsetting->customer}} )</span></strong></a>
                                </li>
                                <li class="fake-show">
                                    <a href=""><strong>Uddokta <span>( {{$generalsetting->uddokta}} )</span></strong></a>
                                </li>
                                <li class="fake-show">
                                    <a href=""><strong>Reseller <span>( {{$generalsetting->reseller}} )</span></strong></a>
                                </li>
                                <li class="fake-show">
                                    <a href=""><strong>Seller <span>( {{$generalsetting->seller}} )</span></strong></a>
                                </li>
                            </ul>

                            

                            
                            <div class="download_app">
                                <a href="{{asset('public/frontEnd/mobileappapk/app-release.apk')}}">
                                    <img src="{{asset('public/frontEnd/images/app-download.png')}}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- col end -->
                </div>

            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="copyright-pay">
                            <div class="copyright">
                                <p>Copyright © {{ date('Y') }} {{ $generalsetting->name }}. All rights reserved.
                                    Design & Developed By <a href="https://websolutionit.com/"
                                        target="_blank">Websolution IT</a></p>
                            </div>
                            <div class="pay">
                                <img src="{{ asset('public/frontEnd/images/patment.webp') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer_nav">
        <ul>
            <li>
                <a class="toggle">
                    <span>
                        <i class="fa-solid fa-bars"></i>
                    </span>
                    <span>Category</span>
                </a>
            </li>

            <li class="main-menu-li" id="compareContent">
                <a href="{{ route('compare.product') }}" class="main-menu-link">
                    <span>
                        <i class="fa-solid fa-sliders"></i>
                    </span>
                    <span>Compare @if (Cart::instance('compare')->content()->count() > 0)
                            {{ Cart::instance('compare')->content()->count() }}
                        @endif
                    </span>
                </a>
            </li>
            <!-- <li class="main-menu-li" id="compareContent">
                    <a href="{{ route('compare.product') }}" class="main-menu-link">
                      <p class="margin-shopping">
                        <i class="fa-solid fa-sliders"></i>
                         @if (Cart::instance('compare')->content()->count() > 0)
<span>{{ Cart::instance('compare')->content()->count() }}</span>
@endif
                       </p>
                    </a>
                  </li> -->

            <li class="mobile_home">
                <a href="{{ route('home') }}">
                    <span><i class="fa-solid fa-home"></i></span> <span>Home</span>
                </a>
            </li>

            <li>
                <a href="{{ route('cart') }}">
                    <span>
                        <i class="fa-solid fa-cart-shopping"></i>
                    </span>
                    <span>Cart (<b class="mobilecart-qty">{{ Cart::instance('shopping')->count() }}</b>)</span>
                </a>
            </li>
            @if (Auth::guard('customer')->user())
                <li>
                    <a href="{{ route('customer.account') }}">
                        <span>
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <span>Account</span>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('customer.login') }}">
                        <span>
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <span>Login</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div class="scrolltop" style="">
        <div class="scroll">
            <i class="fa fa-angle-up"></i>
        </div>
    </div>
    <!-- /. fixed sidebar -->
    <div class="admin-call">
        <a href="tel:{{ $contact->hotline }}">
            <img src="{{ asset('public/frontEnd/images/Call.png') }}" alt="" />
        </a>
        <button class="end-col">
            <i class="fa-regular fa-circle-xmark"></i>
        </button>
    </div>
    <!--call now section end-->
    <div class="facebook_page">
        <a href="{{$contact->facebook_link}}" target="_blank">
            <i class="fa-brands fa-facebook-messenger"></i>
        </a>
    </div>

    <div id="custom-modal"></div>
    <div id="page-overlay"></div>
    <div id="loading">
        <div class="custom-loader"></div>
    </div>

    <script src="{{ asset('public/frontEnd/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/mobile-menu.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/wsit-menu.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/mobile-menu-init.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/wow.min.js') }}"></script>
    <script>
        new WOW().init();
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- feather icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/toastr.min.js"></script>
    {!! Toastr::message() !!} @stack('script')
    <script>
        $(".quick_view").on("click", function() {
            var id = $(this).data("id");
            $("#loading").show();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('quickview') }}",
                    success: function(data) {
                        if (data) {
                            $("#custom-modal").html(data);
                            $("#custom-modal").show();
                            $("#loading").hide();
                            $("#page-overlay").show();
                        }
                    },
                });
            }
        });
    </script>
    <!-- quick view end -->
    <script>
        $(".our-brand").owlCarousel({
            margin: 15,
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
    </script>
    <!-- cart js start -->
    <script>
        $(".addcartbutton").on("click", function() {
            var id = $(this).data("id");
            var qty = 1;
            if (id) {
                $.ajax({
                    cache: "false",
                    type: "GET",
                    url: "{{ url('add-to-cart') }}/" + id + "/" + qty,
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            toastr.success('Success', 'Product add to cart successfully');
                            return cart_count() + mobile_cart();
                        }
                    },
                });
            }
        });
        $(".cart_store").on("click", function() {
            var id = $(this).data("id");
            var qty = $(this).parent().find("input").val();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id,
                        qty: qty ? qty : 1
                    },
                    url: "{{ route('cart.store') }}",
                    success: function(data) {
                        if (data) {
                            toastr.success('Success', 'Product add to cart succfully');
                            return cart_count() + mobile_cart();
                        }
                    },
                });
            }
        });

        // $(".cart_remove").on("click", function () {
        //     var id = $(this).data("id");
        //     if (id) {
        //         $.ajax({
        //             type: "GET",
        //             data: { id: id },
        //             url: "{{ route('cart.remove') }}",
        //             success: function (data) {
        //                 if (data) {
        //                     $(".cartlist").html(data);
        //                     return cart_count() + mobile_cart() + cart_summary();
        //                 }
        //             },
        //         });
        //     }
        // });

        //         $(".cart_increment").on("click", function () {
        //             var id = $(this).data("id");

        // // alert('second');
        //             if (id) {
        //                 $.ajax({
        //                     type: "GET",
        //                     data: { id: id },
        //                     url: "{{ route('cart.increment') }}",
        //                     success: function (data) {
        //                         if (data) {
        //                             $(".cartlist").html(data);
        //                             return cart_count() + mobile_cart();
        //                         }
        //                     },
        //                 });
        //             }
        //         });

        //         $(".cart_decrement").on("click", function () {
        //             var id = $(this).data("id");
        //             if (id) {
        //                 $.ajax({
        //                     type: "GET",
        //                     data: { id: id },
        //                     url: "{{ route('cart.decrement') }}",
        //                     success: function (data) {
        //                         if (data) {
        //                             $(".cartlist").html(data);
        //                             return cart_count() + mobile_cart();
        //                         }
        //                     },
        //                 });
        //             }
        //         });

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
                },
            });
        }

        function mobile_cart() {
            $.ajax({
                type: "GET",
                url: "{{ route('mobile.cart.count') }}",
                success: function(data) {
                    if (data) {
                        $(".mobilecart-qty").html(data);
                    } else {
                        $(".mobilecart-qty").empty();
                    }
                },
            });
        }

        function cart_summary() {
            $.ajax({
                type: "GET",
                url: "{{ route('shipping.charge') }}",
                dataType: "html",
                success: function(response) {
                    $(".cart-summary").html(response);
                },
            });
        }
    </script>
    <!-- cart js end -->
    <script>
        $(".search_click").on("keyup change", function() {
            var keyword = $(".search_keyword").val();
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "{{ route('livesearch') }}",
                success: function(products) {
                    if (products) {
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
        $(".msearch_click").on("keyup change", function() {
            var keyword = $(".msearch_keyword").val();
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "{{ route('livesearch') }}",
                success: function(products) {
                    if (products) {
                        $("#loading").hide();
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
    </script>
    <!-- <script>
    $(document).ready(function () {
        // Desktop Search
        $(".search_click").on("keyup change", function () {
            let keyword = $(".search_keyword").val();
            let category = $("#category").val(); 
            $.ajax({
                type: "GET",
                url: "{{ route('livesearch') }}",
                data: {
                    keyword: keyword,
                    category: category,
                },
                success: function (response) {
                    if (response) {
                        $(".search_result").html(response);
                    } else {
                        $(".search_result").html("<p>Product Not Found</p>");
                    }
                },
                error: function () {
                    $(".search_result").html("<p>Error</p>");
                },
            });
        });

        // Mobile Search
        $(".msearch_click").on("keyup change", function () {
            let keyword = $(".msearch_keyword").val();
            let category = $("#category").val();
            $.ajax({
                type: "GET",
                url: "{{ route('livesearch') }}",
                data: {
                    keyword: keyword,
                    category: category,
                },
                success: function (response) {
                    if (response) {
                        $("#loading").hide();
                        $(".search_result").html(response);
                    } else {
                        $(".search_result").html("<p>Product Not Found</p>");
                    }
                },
                error: function () {
                    $(".search_result").html("<p>Error</p>");
                },
            });
        });
    });
    </script> -->
    <!-- search js start -->
    <script></script>
    <script>
        // get type
        $('.comparecartbutton').click(function() {
            var id = $(this).data('id');
            if (id) {
                $.ajax({
                    cache: 'false',
                    type: "GET",
                    url: "{{ url('add-to-compare') }}/" + id,
                    dataType: "json",
                    success: function(compareinfo) {
                        return compare_content();
                    }
                });
            }
        });

        function compare_content() {
            $.ajax({
                type: "GET",
                url: "{{ url('compare/content') }}",
                dataType: "html",
                success: function(compareinfo) {
                    toastr.success('Product add in compare', '');
                    $('#compareContent').html(compareinfo);
                }
            });
        }
    </script>
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

        $("#district2").on("change", function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                data: {
                    id: id
                },
                url: "{{ route('shipping_districts') }}",
                // dataType: "json",
                success: function(response) {
                    console.log('faltu: ', response);
                    $(".cartlist").html(response.html);
                    // $(".cartlist").empty();
                    if (response) {
                        $(".area").empty();
                        $(".area").append('<option value="">Select..</option>');
                        $.each(response.areas, function(key, value) {
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
    <script>
        $(".toggle").on("click", function() {
            $("#page-overlay").show();
            $(".mobile-menu").addClass("active");
        });

        $("#page-overlay").on("click", function() {
            $("#page-overlay").hide();
            $(".mobile-menu").removeClass("active");
            $(".feature-products").removeClass("active");
        });

        $(".mobile-menu-close").on("click", function() {
            $("#page-overlay").hide();
            $(".mobile-menu").removeClass("active");
        });

        $(".mobile-filter-toggle").on("click", function() {
            $("#page-overlay").show();
            $(".feature-products").addClass("active");
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".parent-category").each(function() {
                const menuCatToggle = $(this).find(".menu-category-toggle");
                const secondNav = $(this).find(".second-nav");

                menuCatToggle.on("click", function() {
                    menuCatToggle.toggleClass("active");
                    secondNav.slideToggle("fast");
                    $(this).closest(".parent-category").toggleClass("active");
                });
            });
            $(".parent-subcategory").each(function() {
                const menuSubcatToggle = $(this).find(".menu-subcategory-toggle");
                const thirdNav = $(this).find(".third-nav");

                menuSubcatToggle.on("click", function() {
                    menuSubcatToggle.toggleClass("active");
                    thirdNav.slideToggle("fast");
                    $(this).closest(".parent-subcategory").toggleClass("active");
                });
            });
        });
    </script>

    <script>
        var menu = new MmenuLight(document.querySelector("#menu"), "all");

        var navigator = menu.navigation({
            selectedClass: "Selected",
            slidingSubmenus: true,
            // theme: 'dark',
            title: "ক্যাটাগরি",
        });

        var drawer = menu.offcanvas({
            // position: 'left'
        });

        //  Open the menu.
        document.querySelector('a[href="#menu"]').addEventListener("click", (evnt) => {
            evnt.preventDefault();
            drawer.open();
        });
    </script>

    <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $(".scrolltop:hidden").stop(true, true).fadeIn();
            } else {
                $(".scrolltop").stop(true, true).fadeOut();
            }
        });
        $(function() {
            $(".scroll").click(function() {
                $("html,body").animate({
                    scrollTop: $(".gotop").offset().top
                }, "1000");
                return false;
            });
        });
    </script>

    <script>
        $('.wishlist_store').on('click', function() {
            var id = $(this).data('id');
            var qty = 1;
            $("#loading").show();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        'id': id,
                        'qty': qty ? qty : 1
                    },
                    url: "{{ route('wishlist.store') }}",
                    success: function(data) {
                        if (data) {
                            $("#loading").hide();
                            toastr.success('success', 'Product added in wishlist');
                            return wishlist_count() + mobile_wishlist_count();
                        }
                    }
                });
            }
        });

        $('.wishlist_remove').on('click', function() {
            var id = $(this).data('id');
            $("#loading").show();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        'id': id
                    },
                    url: "{{ route('wishlist.remove') }}",
                    success: function(data) {
                        if (data) {
                            $("#wishlist").html(data);
                            $("#loading").hide();
                            //return wishlist_count();
                        }
                    }
                });
            }
        });

        function wishlist_count() {
            $.ajax({
                type: "GET",
                url: "{{ route('wishlist.count') }}",
                success: function(data) {
                    if (data) {
                        $(".wishlist-qty").html(data);
                    } else {
                        $(".wishlist-qty").empty();
                    }
                }
            });
        };
    </script>
    <!-- seachbar-start -->
    <script>
        $(document).ready(function() {
            $('#searchBar').on('focus', function() {
                $(this).removeAttr('placeholder');
            });

            $('#searchBar').on('blur', function() {
                if ($(this).val() === '') {
                    $(this).attr('placeholder', 'Search Product');
                }
            });
        });
    </script>
    <!-- seachbar-end -->
    <!-- signup-placeholder-start -->
    <script>
        $(document).ready(function() {
            $('#siginup').on('focus', function() {
                $(this).removeAttr('placeholder');
            });

            $('#siginup').on('blur', function() {
                if ($(this).val() === '') {
                    $(this).attr('placeholder', 'Enter Your Email Address');
                }
            });
        });
    </script>
    <!-- signup-placeholder-end -->
    <!-- wishlist js end -->
    <script>
        $(".filter_btn").click(function() {
            $(".filter_sidebar").addClass('active');
            $("body").css("overflow-y", "hidden");
        })
        $(".filter_close").click(function() {
            $(".filter_sidebar").removeClass('active');
            $("body").css("overflow-y", "auto");
        });
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
        function copyResellerCode() {
            var resellercode = document.getElementById("resellercode").innerText;
            var tempInput = document.createElement("input");
            tempInput.value = resellercode;
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999);
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            toastr.success('Reseller Code copied successfully!');
        }
    </script>      

    @foreach($gtm_code as $gtm)
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-{{$gtm->code}}" 
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endforeach
</body>

</html>
