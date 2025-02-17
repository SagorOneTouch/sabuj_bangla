@extends('frontend.layouts.app')

@section('content')
<style>
    /* left image css */
    #advertisement {
        position: absolute;
        top: 170px;
        left: 0;
        width: 115px;
        height: 100%;
        z-index: 1;

    }

    #advertisement img {
        height: auto;
    }

    /* right image css */
    #advertisement2 {
        position: absolute;
        top: 170px;
        right: 0;
        width: 115px;
        height: 100%;
        z-index: 1;

    }

    #advertisement2 img {
        height: auto;
    }

    #middleAd {
        width: 70%;
    }

    /* hide the ad image in mobile responsive */
    @media (max-width: 900 px) {
        #advertisement {
            display: none;
        }
    }

    @media (max-width: 900 px) {
        #advertisement2 {
            display: none;
        }
    }
</style>


<!-- Sliders & Today's deal -->
<div class="home-banner-area mb-3">
    <div class="container">
        <div class="d-flex flex-wrap position-relative">

            <div class="position-static d-none d-xl-block">
                @include('frontend.partials.category_menu')
            </div>

            <!-- middle advertisement -->
            <div id="middleAd">
                <img src="{{ asset('uploads/all/middle-top.jpg') }}" alt="" style="height: 185px; width: 108%;">
            </div>
            <!-- Sliders section removed -->
             
        </div>
    </div>
</div>


<!-- Flash Deal -->
@php
$flash_deal = get_featured_flash_deal();
@endphp
@if($flash_deal != null)
<section class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        <!-- Top Section -->
        <div class="d-flex flex-wrap mb-2 mb-md-3 align-items-baseline justify-content-between">
            <!-- Title -->
            <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                <span class="d-inline-block">{{ translate('Flash Sale') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="24" viewBox="0 0 16 24" class="ml-3">
                    <path id="Path_28795" data-name="Path 28795" d="M30.953,13.695a.474.474,0,0,0-.424-.25h-4.9l3.917-7.81a.423.423,0,0,0-.028-.428.477.477,0,0,0-.4-.207H21.588a.473.473,0,0,0-.429.263L15.041,18.151a.423.423,0,0,0,.034.423.478.478,0,0,0,.4.2h4.593l-2.229,9.683a.438.438,0,0,0,.259.5.489.489,0,0,0,.571-.127L30.9,14.164a.425.425,0,0,0,.054-.469Z" transform="translate(-15 -5)" fill="#fcc201" />
                </svg>
            </h3>
            <!-- Links -->
            <div>
                <div class="text-dark d-flex align-items-center mb-0">
                    <a href="{{ route('flash-deals') }}" class="fs-10 fs-md-12 fw-700 text-reset has-transition opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary mr-3">{{ translate('View All Flash Sale') }}</a>
                    <span class=" border-left border-soft-light border-width-2 pl-3">
                        <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="fs-10 fs-md-12 fw-700 text-reset has-transition opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary">{{ translate('View All Products from This Flash Sale') }}</a>
                    </span>
                </div>
            </div>
        </div>

        <!-- Countdown for small device -->
        <div class="bg-white mb-3 d-md-none">
            <div class="aiz-count-down-circle" end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
        </div>

        <div class="row gutters-5 gutters-md-16">
            <!-- Flash Deals Baner & Countdown -->
            <div class="col-xxl-4 col-lg-5 col-6 h-200px h-md-400px h-lg-475px">
                <div class="h-100 w-100 w-xl-auto" style="background-image: url('{{ uploaded_asset($flash_deal->banner) }}'); background-size: cover; background-position: center center;">
                    <div class="py-5 px-md-3 px-xl-5 d-none d-md-block">
                        <div class="bg-white">
                            <div class="aiz-count-down-circle" end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Flash Deals Products -->
            <div class="col-xxl-8 col-lg-7 col-6">
                @php
                $flash_deals = $flash_deal->flash_deal_products->take(10);
                @endphp
                <div class="aiz-carousel border-top @if(count($flash_deals)>8) border-right @endif arrow-inactive-none arrow-x-0" data-items="5" data-xxl-items="5" data-xl-items="3.5" data-lg-items="3" data-md-items="2" data-sm-items="2.5" data-xs-items="2" data-arrows="true" data-dots="false">
                    @php
                    $init = 0 ;
                    $end = 1 ;
                    @endphp
                    @for ($i = 0; $i < 5; $i++)
                        <div class="carousel-box  @if($i==0) border-left @endif">
                        @foreach ($flash_deals as $key => $flash_deal_product)
                        @if ($key >= $init && $key <= $end)
                            @php
                            $product=get_single_product($flash_deal_product->product_id);
                            @endphp
                            @if ($product != null && $product->published != 0)
                            @php
                            $product_url = route('product', $product->slug);
                            if($product->auction_product == 1) {
                            $product_url = route('auction-product', $product->slug);
                            }
                            @endphp
                            <div class="h-100px h-md-200px h-lg-auto flash-deal-item position-relative text-center border-bottom @if($i!=4) border-right @endif has-transition hov-shadow-out z-1">
                                <a href="{{ $product_url }}" class="d-block py-md-3 overflow-hidden hov-scale-img" title="{{  $product->getTranslation('name')  }}">
                                    <!-- Image -->
                                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" class="lazyload h-60px h-md-100px h-lg-140px mw-100 mx-auto has-transition"
                                        alt="{{  $product->getTranslation('name')  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    <!-- Price -->
                                    <div class="fs-10 fs-md-14 mt-md-3 text-center h-md-48px has-transition overflow-hidden pt-md-4 flash-deal-price">
                                        <span class="d-block text-primary fw-700">{{ home_discounted_base_price($product) }}</span>
                                        @if(home_base_price($product) != home_discounted_base_price($product))
                                        <del class="d-block fw-400 text-secondary">{{ home_base_price($product) }}</del>
                                        @endif
                                    </div>
                                </a>
                            </div>
                            @endif
                            @endif
                            @endforeach

                            @php
                            $init += 2;
                            $end += 2;
                            @endphp
                </div>
                @endfor
            </div>
        </div>
    </div>
    </div>
</section>
@endif

<!-- key features -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<section class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">

        <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5" data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2" data-xs-items="1.4" data-arrows="true" data-dots="false">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-center">
                                <h6><i class="fa fa-shopping-cart"></i> <span style="color: red;">+10000 products</span> to shop from</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-center">
                                <h6><i class="fa fa-money" aria-hidden="true"></i> Pay <span style="color: red;">after</span> receiving products</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-center">
                                <h6><i class="fa fa-clock-o" aria-hidden="true"></i> Get your delivery within <span style="color: red;">1 hour</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-center">
                                <h6><i class="fa fa-exchange" aria-hidden="true"></i> Get offers that <span style="color: red;">save your money</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<div id="section_featured">

</div>

<!-- Today's deal -->
@if(count($todays_deal_products) > 0)
<section class="mb-2 mb-md-3 ">
    <div class="container">
        <!-- Banner -->
        @if (get_setting('todays_deal_banner') != null || get_setting('todays_deal_banner_small') != null)
        <div class="overflow-hidden d-none d-md-block">
            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                data-src="{{ uploaded_asset(get_setting('todays_deal_banner')) }}"
                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
        </div>
        <div class="overflow-hidden d-md-none">
            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                data-src="{{ get_setting('todays_deal_banner_small') != null ? uploaded_asset(get_setting('todays_deal_banner_small')) : uploaded_asset(get_setting('todays_deal_banner')) }}"
                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
        </div>
        @endif
        <!-- Products -->
        <div class="" style="background-color: {{ get_setting('todays_deal_bg_color', '#3d4666') }};">
            <div class="text-right px-4 px-xl-5 pt-4 pt-md-3">
                <a href="{{ route('todays-deal') }}" class="fs-12 fw-700 text-white has-transition hov-text-warning">{{ translate('View All') }}</a>
            </div>
            <div class="c-scrollbar-light overflow-hidden pl-5 pr-5 pb-3 pt-2 pb-md-5 pt-md-3">
                <div class="h-100 d-flex flex-column justify-content-center">
                    <div class="todays-deal aiz-carousel" data-items="7" data-xxl-items="7" data-xl-items="6" data-lg-items="5" data-md-items="4" data-sm-items="3" data-xs-items="2" data-arrows="true" data-dots="false" data-autoplay="true" data-infinite="true">
                        @foreach ($todays_deal_products as $key => $product)
                        <div class="carousel-box h-100 px-3 px-lg-0">
                            <a href="{{ route('product', $product->slug) }}" class="h-100 overflow-hidden hov-scale-img mx-auto" title="{{  $product->getTranslation('name')  }}">
                                <!-- Image -->
                                <div class="img h-80px w-80px rounded-content overflow-hidden mx-auto">
                                    <img class="lazyload img-fit m-auto has-transition"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        alt="{{ $product->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </div>
                                <!-- Price -->
                                <div class="fs-14 mt-3 text-center">
                                    <span class="d-block text-white fw-700">{{ home_discounted_base_price($product) }}</span>
                                    @if(home_base_price($product) != home_discounted_base_price($product))
                                    <del class="d-block text-secondary fw-400">{{ home_base_price($product) }}</del>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Banner section 1 -->
@if (get_setting('home_banner1_images') != null)
<div class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        @php
        $banner_1_imags = json_decode(get_setting('home_banner1_images'));
        $data_md = count($banner_1_imags) >= 2 ? 2 : 1;
        @endphp
        <div class="w-100">
            <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15" data-items="{{ count($banner_1_imags) }}" data-xxl-items="{{ count($banner_1_imags) }}" data-xl-items="{{ count($banner_1_imags) }}" data-lg-items="{{ $data_md }}" data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true" data-dots="false">
                @foreach ($banner_1_imags as $key => $value)
                <div class="carousel-box overflow-hidden hov-scale-img">
                    <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}" class="d-block text-reset overflow-hidden">
                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($value) }}"
                            alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100 has-transition" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Featured Categories -->
@if (count($featured_categories) > 0)
<section class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        <div class="bg-white">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <!-- Title -->
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">{{ translate('Featured Categories') }}</span>
                </h3>
                <!-- Links -->
                <div class="d-flex">
                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('categories.all') }}">{{ translate('View All Categories') }}</a>
                </div>
            </div>
        </div>
        <!-- Categories -->
        <div class="bg-white px-sm-3">
            <div class="aiz-carousel sm-gutters-17" data-items="8" data-xxl-items="8" data-xl-items="6" data-lg-items="5" data-md-items="4" data-sm-items="3" data-xs-items="2" data-arrows="true" data-dots="false" data-autoplay="true" data-infinite="true">
                @foreach ($featured_categories as $key => $category)
                <div class="carousel-box position-relative text-center has-transition hov-scale-img hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                    <a href="{{ route('products.category', $category->slug) }}" class="d-block">
                        <img src="{{ uploaded_asset($category->banner) }}" class="lazyload h-130px mx-auto has-transition p-2 p-sm-4 mw-100"
                            alt="{{ $category->getTranslation('name') }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                    <h6 class="text-dark mb-3 h-40px text-truncate-2">
                        <a class="text-reset fw-700 fs-14 hov-text-primary" href="{{ route('products.category', $category->slug) }}" title="{{  $category->getTranslation('name')  }}">{{ $category->getTranslation('name') }}</a>
                    </h6>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Banner Section 2 -->
@if (get_setting('home_banner2_images') != null)
<div class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        @php
        $banner_2_imags = json_decode(get_setting('home_banner2_images'));
        $data_md = count($banner_2_imags) >= 2 ? 2 : 1;
        @endphp
        <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15" data-items="{{ count($banner_2_imags) }}" data-xxl-items="{{ count($banner_2_imags) }}" data-xl-items="{{ count($banner_2_imags) }}" data-lg-items="{{ $data_md }}" data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true" data-dots="false">
            @foreach ($banner_2_imags as $key => $value)
            <div class="carousel-box overflow-hidden hov-scale-img">
                <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}" class="d-block text-reset overflow-hidden">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($value) }}"
                        alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100 has-transition" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Best Selling  -->
<div id="section_best_selling">

</div>

<!-- shop & get more -->
<div id="cards_landscape_wrap-2">
    <div class="container">
        <div class="col-md-6 offset-md-3 mb-1">
            <div class="faq-title text-center">
                <h4>Shop & Get More</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <a href="">
                    <div class="card-flyer">
                        <div class="text-box">
                            <div class="text-container">
                                <h6>Loyalty Rewards</h6>
                                <p>
                                    Earn points with every purchase and enjoy exclusive rewards and discounts through our Loyalty Rewards
                                    Program.
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <a href="">
                    <div class="card-flyer">
                        <div class="text-box">
                            <div class="text-container">
                                <h6>Personalized Shopping</h6>
                                <p>
                                    Experience a tailored shopping journey with personalized recommendations and offers based on your
                                    preferences.
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <a href="">
                    <div class="card-flyer">
                        <div class="text-box">
                            <div class="text-container">
                                <h6>Customer Support</h6>
                                <p>
                                    Get prompt and effective assistance with our dedicated customer support, available through chat, email,
                                    and phone.
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <a href="">
                    <div class="card-flyer">
                        <div class="text-box">
                            <div class="text-container">
                                <h6>Premium Care</h6>
                                <p>
                                    Enjoy enhanced service with Premium Care, offering priority support, exclusive benefits,
                                    and personalized attention.
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- New Products -->
<div id="section_newest">
    @if (count($newest_products) > 0)
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <!-- Title -->
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">{{ translate('New Products') }}</span>
                </h3>
                <!-- Links -->
                <div class="d-flex">
                    <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_newest')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                    <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('search',['sort_by'=>'newest']) }}">{{ translate('View All') }}</a>
                    <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_newest')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                </div>
            </div>
            <!-- Products Section -->
            <div class="px-sm-3">
                <div class="aiz-carousel arrow-none sm-gutters-16" data-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                    @foreach ($newest_products as $key => $new_product)
                    <div class="carousel-box px-3 position-relative has-transition border-right border-top border-bottom @if($key == 0) border-left @endif hov-animate-outline">
                        @include('frontend.partials.product_box_1',['product' => $new_product])
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
</div>

<!-- Banner Section 3 -->
@if (get_setting('home_banner3_images') != null)
<div class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        @php
        $banner_3_imags = json_decode(get_setting('home_banner3_images'));
        $data_md = count($banner_3_imags) >= 2 ? 2 : 1;
        @endphp
        <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15" data-items="{{ count($banner_3_imags) }}" data-xxl-items="{{ count($banner_3_imags) }}" data-xl-items="{{ count($banner_3_imags) }}" data-lg-items="{{ $data_md }}" data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true" data-dots="false">
            @foreach ($banner_3_imags as $key => $value)
            <div class="carousel-box overflow-hidden hov-scale-img">
                <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}" class="d-block text-reset overflow-hidden">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($value) }}"
                        alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100 has-transition" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Auction Product -->
@if(addon_is_activated('auction'))
<div id="auction_products">

</div>
@endif

<!-- Cupon -->
@if(get_setting('coupon_system') == 1)
<div class="mb-2 mb-md-3 mt-2 mt-md-3" style="background-color: {{ get_setting('cupon_background_color', '#194a22') }}">
    <div class="container">
        <div class="row py-5">
            <div class="col-xl-8 text-center text-xl-left">
                <div class="d-lg-flex">
                    <div class="mb-3 mb-lg-0">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109.602" height="93.34" viewBox="0 0 109.602 93.34">
                            <defs>
                                <clipPath id="clip-pathcup">
                                    <path id="Union_10" data-name="Union 10" d="M12263,13778v-15h64v-41h12v56Z" transform="translate(-11966 -8442.865)" fill="none" stroke="#fff" stroke-width="2" />
                                </clipPath>
                            </defs>
                            <g id="Group_24326" data-name="Group 24326" transform="translate(-274.201 -5254.611)">
                                <g id="Mask_Group_23" data-name="Mask Group 23" transform="translate(-3652.459 1785.452) rotate(-45)" clip-path="url(#clip-pathcup)">
                                    <g id="Group_24322" data-name="Group 24322" transform="translate(207 18.136)">
                                        <g id="Subtraction_167" data-name="Subtraction 167" transform="translate(-12177 -8458)" fill="none">
                                            <path d="M12335,13770h-56a8.009,8.009,0,0,1-8-8v-8a8,8,0,0,0,0-16v-8a8.009,8.009,0,0,1,8-8h56a8.009,8.009,0,0,1,8,8v8a8,8,0,0,0,0,16v8A8.009,8.009,0,0,1,12335,13770Z" stroke="none" />
                                            <path d="M 12335.0009765625 13768.0009765625 C 12338.3095703125 13768.0009765625 12341.0009765625 13765.30859375 12341.0009765625 13762 L 12341.0009765625 13755.798828125 C 12336.4423828125 13754.8701171875 12333.0009765625 13750.8291015625 12333.0009765625 13746 C 12333.0009765625 13741.171875 12336.4423828125 13737.130859375 12341.0009765625 13736.201171875 L 12341.0009765625 13729.9990234375 C 12341.0009765625 13726.6904296875 12338.3095703125 13723.9990234375 12335.0009765625 13723.9990234375 L 12278.9990234375 13723.9990234375 C 12275.6904296875 13723.9990234375 12272.9990234375 13726.6904296875 12272.9990234375 13729.9990234375 L 12272.9990234375 13736.201171875 C 12277.5576171875 13737.1298828125 12280.9990234375 13741.1708984375 12280.9990234375 13746 C 12280.9990234375 13750.828125 12277.5576171875 13754.869140625 12272.9990234375 13755.798828125 L 12272.9990234375 13762 C 12272.9990234375 13765.30859375 12275.6904296875 13768.0009765625 12278.9990234375 13768.0009765625 L 12335.0009765625 13768.0009765625 M 12335.0009765625 13770.0009765625 L 12278.9990234375 13770.0009765625 C 12274.587890625 13770.0009765625 12270.9990234375 13766.412109375 12270.9990234375 13762 L 12270.9990234375 13754 C 12275.4111328125 13753.9990234375 12278.9990234375 13750.4111328125 12278.9990234375 13746 C 12278.9990234375 13741.5888671875 12275.41015625 13738 12270.9990234375 13738 L 12270.9990234375 13729.9990234375 C 12270.9990234375 13725.587890625 12274.587890625 13721.9990234375 12278.9990234375 13721.9990234375 L 12335.0009765625 13721.9990234375 C 12339.412109375 13721.9990234375 12343.0009765625 13725.587890625 12343.0009765625 13729.9990234375 L 12343.0009765625 13738 C 12338.5888671875 13738.0009765625 12335.0009765625 13741.5888671875 12335.0009765625 13746 C 12335.0009765625 13750.4111328125 12338.58984375 13754 12343.0009765625 13754 L 12343.0009765625 13762 C 12343.0009765625 13766.412109375 12339.412109375 13770.0009765625 12335.0009765625 13770.0009765625 Z" stroke="none" fill="#fff" />
                                        </g>
                                    </g>
                                </g>
                                <g id="Group_24321" data-name="Group 24321" transform="translate(-3514.477 1653.317) rotate(-45)">
                                    <g id="Subtraction_167-2" data-name="Subtraction 167" transform="translate(-12177 -8458)" fill="none">
                                        <path d="M12335,13770h-56a8.009,8.009,0,0,1-8-8v-8a8,8,0,0,0,0-16v-8a8.009,8.009,0,0,1,8-8h56a8.009,8.009,0,0,1,8,8v8a8,8,0,0,0,0,16v8A8.009,8.009,0,0,1,12335,13770Z" stroke="none" />
                                        <path d="M 12335.0009765625 13768.0009765625 C 12338.3095703125 13768.0009765625 12341.0009765625 13765.30859375 12341.0009765625 13762 L 12341.0009765625 13755.798828125 C 12336.4423828125 13754.8701171875 12333.0009765625 13750.8291015625 12333.0009765625 13746 C 12333.0009765625 13741.171875 12336.4423828125 13737.130859375 12341.0009765625 13736.201171875 L 12341.0009765625 13729.9990234375 C 12341.0009765625 13726.6904296875 12338.3095703125 13723.9990234375 12335.0009765625 13723.9990234375 L 12278.9990234375 13723.9990234375 C 12275.6904296875 13723.9990234375 12272.9990234375 13726.6904296875 12272.9990234375 13729.9990234375 L 12272.9990234375 13736.201171875 C 12277.5576171875 13737.1298828125 12280.9990234375 13741.1708984375 12280.9990234375 13746 C 12280.9990234375 13750.828125 12277.5576171875 13754.869140625 12272.9990234375 13755.798828125 L 12272.9990234375 13762 C 12272.9990234375 13765.30859375 12275.6904296875 13768.0009765625 12278.9990234375 13768.0009765625 L 12335.0009765625 13768.0009765625 M 12335.0009765625 13770.0009765625 L 12278.9990234375 13770.0009765625 C 12274.587890625 13770.0009765625 12270.9990234375 13766.412109375 12270.9990234375 13762 L 12270.9990234375 13754 C 12275.4111328125 13753.9990234375 12278.9990234375 13750.4111328125 12278.9990234375 13746 C 12278.9990234375 13741.5888671875 12275.41015625 13738 12270.9990234375 13738 L 12270.9990234375 13729.9990234375 C 12270.9990234375 13725.587890625 12274.587890625 13721.9990234375 12278.9990234375 13721.9990234375 L 12335.0009765625 13721.9990234375 C 12339.412109375 13721.9990234375 12343.0009765625 13725.587890625 12343.0009765625 13729.9990234375 L 12343.0009765625 13738 C 12338.5888671875 13738.0009765625 12335.0009765625 13741.5888671875 12335.0009765625 13746 C 12335.0009765625 13750.4111328125 12338.58984375 13754 12343.0009765625 13754 L 12343.0009765625 13762 C 12343.0009765625 13766.412109375 12339.412109375 13770.0009765625 12335.0009765625 13770.0009765625 Z" stroke="none" fill="#fff" />
                                    </g>
                                    <g id="Group_24325" data-name="Group 24325">
                                        <rect id="Rectangle_18578" data-name="Rectangle 18578" width="8" height="2" transform="translate(120 5287)" fill="#fff" />
                                        <rect id="Rectangle_18579" data-name="Rectangle 18579" width="8" height="2" transform="translate(132 5287)" fill="#fff" />
                                        <rect id="Rectangle_18581" data-name="Rectangle 18581" width="8" height="2" transform="translate(144 5287)" fill="#fff" />
                                        <rect id="Rectangle_18580" data-name="Rectangle 18580" width="8" height="2" transform="translate(108 5287)" fill="#fff" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <div class="ml-lg-3">
                        <h5 class="fs-36 fw-400 text-white mb-3">{{ translate(get_setting('cupon_title')) }}</h5>
                        <h5 class="fs-20 fw-400 text-gray">{{ translate(get_setting('cupon_subtitle')) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 text-center text-xl-right mt-4">
                <a href="{{ route('coupons.all') }}" class="btn text-white hov-bg-white hov-text-dark border border-width-2 fs-16 px-4" style="border-radius: 28px;background: rgba(255, 255, 255, 0.2);box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.16);">{{ translate('View All Coupons') }}</a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Category wise Products -->
<div id="section_home_categories" class="mb-2 mb-md-3 mt-2 mt-md-3">

</div>

<!-- Classified Product -->
@if(get_setting('classified_product') == 1)
@php
$classified_products = get_home_page_classified_products(6);
@endphp
@if (count($classified_products) > 0)
<section class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        <!-- Top Section -->
        <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
            <!-- Title -->
            <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                <span class="">{{ translate('Classified Ads') }}</span>
            </h3>
            <!-- Links -->
            <div class="d-flex">
                <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('customer.products') }}">{{ translate('View All Products') }}</a>
            </div>
        </div>
        <!-- Banner -->
        @if (get_setting('classified_banner_image') != null || get_setting('classified_banner_image_small') != null)
        <div class="mb-3 overflow-hidden hov-scale-img d-none d-md-block">
            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                data-src="{{ uploaded_asset(get_setting('classified_banner_image')) }}"
                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
        </div>
        <div class="mb-3 overflow-hidden hov-scale-img d-md-none">
            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                data-src="{{ get_setting('classified_banner_image_small') != null ? uploaded_asset(get_setting('classified_banner_image_small')) : uploaded_asset(get_setting('classified_banner_image')) }}"
                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
        </div>
        @endif
        <!-- Products Section -->
        <div class="bg-white">
            <div class="row no-gutters border-top border-left">
                @foreach ($classified_products as $key => $classified_product)
                <div class="col-xl-4 col-md-6 border-right border-bottom has-transition hov-shadow-out z-1">
                    <div class="aiz-card-box p-2 has-transition bg-white">
                        <div class="row hov-scale-img">
                            <div class="col-4 col-md-5 mb-3 mb-md-0">
                                <a href="{{ route('customer.product', $classified_product->slug) }}" class="d-block overflow-hidden h-auto h-md-150px text-center">
                                    <img class="img-fluid lazyload mx-auto has-transition"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($classified_product->thumbnail_img) }}"
                                        alt="{{ $classified_product->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                            </div>
                            <div class="col">
                                <h3 class="fw-400 fs-14 text-dark text-truncate-2 lh-1-4 mb-3 h-35px d-none d-sm-block">
                                    <a href="{{ route('customer.product', $classified_product->slug) }}" class="d-block text-reset hov-text-primary">{{ $classified_product->getTranslation('name') }}</a>
                                </h3>
                                <div class="fs-14 mb-3">
                                    <span class="text-secondary">{{ $classified_product->user ? $classified_product->user->name : '' }}</span><br>
                                    <span class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                </div>
                                @if($classified_product->conditon == 'new')
                                <span class="badge badge-inline badge-soft-info fs-13 fw-700 p-3 text-info" style="border-radius: 20px;">{{translate('New')}}</span>
                                @elseif($classified_product->conditon == 'used')
                                <span class="badge badge-inline badge-soft-warning fs-13 fw-700 p-3 text-danger" style="border-radius: 20px;">{{translate('Used')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@endif

<!-- Top Sellers -->
<!-- code removed for design purpose -->

<!-- Top Brands -->
@if (get_setting('top_brands') != null)
<section class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        <!-- Top Section -->
        <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
            <!-- Title -->
            <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">{{ translate('Top Brands') }}</h3>
            <!-- Links -->
            <div class="d-flex">
                <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('brands.all') }}">{{ translate('View All Brands') }}</a>
            </div>
        </div>
        <!-- Brands Section -->
        <div class="bg-white px-3">
            <div class="row row-cols-xxl-6 row-cols-xl-6 row-cols-lg-4 row-cols-md-4 row-cols-3 gutters-16 border-top border-left">
                @php $top_brands = json_decode(get_setting('top_brands')); @endphp
                @foreach ($top_brands as $value)
                @php $brand = get_single_brand($value); @endphp
                @if ($brand != null)
                <div class="col text-center border-right border-bottom hov-scale-img has-transition hov-shadow-out z-1">
                    <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-sm-3">
                        <img src="{{ uploaded_asset($brand->logo) }}" class="lazyload h-md-100px mx-auto has-transition p-2 p-sm-4 mw-100"
                            alt="{{ $brand->getTranslation('name') }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        <p class="text-center text-dark fs-12 fs-md-14 fw-700 mt-2">{{ $brand->getTranslation('name') }}</p>
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- popular product slider -->

<!-- faq - common questions -->
<section class="faq-section">
    <div class="container">
        <div class="row">
            <!-- title -->
            <div class="col-md-6 offset-md-3">
                <div class="faq-title text-center pb-3">
                    <h4>Common Questions</h4>
                </div>
            </div>

            <div class="col-md-6 offset-md-3">
                <div class="faq" id="accordion">
                    <div class="card">
                        <div class="card-header" id="faqHeading-1">
                            <div class="mb-0">
                                <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-1" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
                                    <span class="badge">1</span>What is your delivery hours?
                                </h5>
                            </div>
                        </div>
                        <div id="faqCollapse-1" class="collapse" aria-labelledby="faqHeading-1" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    We deliver from 8am to 11pm. You can choose from available slots to find something that is convenient for you.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="faqHeading-2">
                            <div class="mb-0">
                                <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-2" data-aria-expanded="false" data-aria-controls="faqCollapse-2">
                                    <span class="badge">2</span> What is your policy on refunds?
                                </h5>
                            </div>
                        </div>
                        <div id="faqCollapse-2" class="collapse" aria-labelledby="faqHeading-2" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    We offer a refund or return policy of 2 days on most unopened or unspoilt package products.
                                <ol>
                                    <li>For perishable products such as Milk, fruits, and fresh vegetables, we have 1 (one) day return policy.</li>
                                    <li>Diaper items must be returned for refunds before 10% or 3 pieces (whichever comes first) have beedn used.</li>
                                    <li>Certain products; Face Musk, Disposable Vinyl Gloves, Alcohol Pads, and Covid Testing Kits are not acceptabe for
                                        refund or return either opened or unopened.
                                    </li>
                                </ol>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="faqHeading-3">
                            <div class="mb-0">
                                <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-3" data-aria-expanded="false" data-aria-controls="faqCollapse-3">
                                    <span class="badge">3</span>What about the prices?
                                </h5>
                            </div>
                        </div>
                        <div id="faqCollapse-3" class="collapse" aria-labelledby="faqHeading-3" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    Our prices are our own but we try our best to offer them to you at or below market prices. Our prices are the same as
                                    the local market and we are working hard to get them even lower! If you feel that any product is prices unfairly, please
                                    let us know.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>




@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.post('{{ route("home.section.featured") }}', {
                _token: '{{ csrf_token() }}'
            },
            function(data) {
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
        $.post('{{ route("home.section.best_selling") }}', {
                _token: '{{ csrf_token() }}'
            },
            function(data) {
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
        $.post('{{ route("home.section.auction_products") }}', {
                _token: '{{ csrf_token() }}'
            },
            function(data) {
                $('#auction_products').html(data);
                AIZ.plugins.slickCarousel();
            });
        $.post('{{ route("home.section.home_categories") }}', {
                _token: '{{ csrf_token() }}'
            },
            function(data) {
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
        $.post('{{ route("home.section.best_sellers") }}', {
                _token: '{{ csrf_token() }}'
            },
            function(data) {
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
    });
</script>
@endsection