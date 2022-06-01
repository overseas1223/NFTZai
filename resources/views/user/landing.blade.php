@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!--Main Menu/Navbar Area Start -->
    <!-- Header Start -->
    <header class="hero-area home-banner-area position-relative">
        <!-- Hero Effect Images Start -->
        <div class="hero-area-effect-box">
            <img src="{{asset('assets/user/img/home-page/hero-area/hero-dot1.png')}}" alt="{{__('dot2')}}" class="hero-dot1 position-absolute box">
            <img src="{{asset('assets/user/img/home-page/hero-area/hero-dot2.png')}}" alt="{{__('dot2')}}" class="hero-dot2 position-absolute box">
            <img src="{{asset('assets/user/img/home-page/hero-area/hero-net1.svg')}}" alt="{{__('hero')}}" class="hero-net-img-1 box position-absolute">
            <img src="{{asset('assets/user/img/home-page/hero-area/hero-net2.svg')}}" alt="{{__('hero')}}" class="hero-net-img-2 box position-absolute">
            <span class="coordinates"></span>
        </div>
        <!-- Hero Effect Images End -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (isset($slider))
                        <div class="hero-content text-center">
                            <img src="{{asset('assets/user/img/home-page/hero-area/star.png')}}" alt="{{__('star')}}" class="hero-star-img">
                            <p>{{$slider->short_description}}</p>
                            <h1 class="hero-heading">
                                {{$slider->long_desc_header}}
                                <span class="shimmer">{{$slider->long_desc_middle}} <img src="{{asset('assets/user/img/home-page/hero-area/line-shape.png')}}" alt="{{__('line')}}" class="hero-line-shape"></span>
                                {{$slider->long_desc_footer}}
                            </h1>
                            <div class="hero-btns">
                                <a href="{{route('discover')}}" class="theme-button1">{{__('Start Exploring')}}</a>
                                <a href="{{route('how-it-works')}}" class="theme-button2">{{__('Learn More')}}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <a id="down-arrow" href="#goBottomSection" class="js-scroll-trigger">
            <img src="{{asset('assets/user/img/home-page/hero-area/double-angle.png')}}" alt="{{__('arrow')}}">
        </a>
    </header>
    <!-- Header End -->

    <!-- Top Famous NFTs Authors Area Start -->
    <section id="goBottomSection" class="top-famous-nft-authors-area section-t-space pb-0">
        <div class="container">
            <div class="row">
                <!-- Section Title Start -->
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="section-heading">{{allsetting()['home_famous_title']}}</h2>
                        <p class="section-sub-heading">{{allsetting()['home_famous_content']}}</p>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>
            <div Class="row">
                <div class="col-12">
                    <!-- Collaborate area start -->
                    <div class="collaborate-to-make-wrap position-relative text-center">
                        <!-- Collaborate Left Image -->
                        <div class="collaborate-logos-left">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/1.png')}}" alt="{{__('figma')}}" class="figma-icon position-absolute img">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/2.png')}}" alt="{{__('react')}}" class="react-icon position-absolute img">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/3.png')}}" alt="{{__('flutter')}}" class="flutter-icon position-absolute img">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/4.png')}}" alt="{{__('xd')}}" class="xd-icon position-absolute img">
                            <!-- dot element Left side -->
                            <div class="dot-elements-wrap dot-elements-left">
                                <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/dot1.svg')}}" alt="{{__('dot')}}" class="dot1 position-absolute">
                                <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/dot2.svg')}}" alt="{{__('dot')}}" class="dot2 position-absolute floating_animation">
                            </div>
                        </div>
                        <!-- Main Image Wrap -->
                        <div class="main-img-wrap d-flex align-items-center justify-content-center">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/border-all.png')}}" alt="{{__('border')}}" class="border1 position-relative img-fluid">
                            <div class="main-logo position-absolute"><h2>{{__('Nftzai')}}<span class="color-green">{{__('.')}}</span></h2></div>
                        </div>
                        <!-- Collaborate Right Image -->
                        <div class="collaborate-logos-right">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/r1.png')}}" alt="{{__('vue')}}" class="vue-icon position-absolute">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/r2.png')}}" alt="{{__('js-tech')}}" class="js-icon position-absolute">
                            <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/r3.png')}}" alt="{{__('html-tech')}}" class="html-icon position-absolute">
                            <!-- dot right side images -->
                            <div class="dot-elements-wrap dot-elements-right">
                                <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/dot5.svg')}}" alt="{{__('dot')}}" class="dot5 position-absolute floating_animation">
                                <img src="{{asset('assets/user/img/home-page/top-famous-nft-authors/dot6.svg')}}" alt="{{__('dot')}}" class="dot6 position-absolute floating_animation">
                            </div>
                        </div>
                    </div>
                    <!-- Collaborate area end -->
                </div>
            </div>
        </div>
    </section>
    <!-- Top Famous NFTs Authors Area End -->

    <!-- northern light carousel Area Start -->
    @if (isset($slide_images))
        <section class="northern-light-area main-items-area section-t-space">
            <div class="container">
                <div class="main-items-carousel">
                    <div class="main-items owl-carousel owl-theme position-relative">
                        <!-- main item slider start -->
                        @foreach ($slide_images as $slider)
                            @if ($slider->isSlider == 1 && $slider->available_item != 0 && $slider->status != SOLD)
                                <div class="main-item">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="main-item-content-part">
                                                <h2 class="section-heading">{{$slider->title}}</h2>
                                                <div class="main-item-author d-flex">
                                                    <img src="{{is_null($slider->author->photo) ? Avatar::create($slider->author->first_name.' '.$slider->author->last_name)->toBase64() : asset(IMG_USER_PATH.$slider->author->photo)}}" alt="{{__('creator')}}">
                                                    {{__('By')}} <span class="main-item-author-name">{{$slider->author->first_name.' '.$slider->author->last_name}}</span>
                                                </div>
                                                <p class="section-sub-heading">{{$slider->description}}</p>
                                                @if ($slider->type == 1)
                                                    <div class="current-bid-box">
                                                        <p class="font-weight-bold color-heading">{{__('Price')}}</p>
                                                        <div class="bid-price-box">
                                                            <h2>{{visual_number_format($slider->price_dollar)}} <span class="bid-small-price">{{__('In USD')}}</span></h2>
                                                        </div>
                                                    </div>
                                                @elseif ($slider->type == 2)
                                                    <div class="current-bid-box">
                                                        <p class="font-weight-bold color-heading">{{__('Min. Bid Amount')}}</p>
                                                        <div class="bid-price-box">
                                                            <h2>{{visual_number_format($slider->min_bid_amount)}} <span class="bid-small-price">{{__('In USD')}}</span></h2>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="highest-bid-box d-flex align-items-center justify-content-between">
                                                    <div class="highest-box-item d-flex align-items-center">
                                                        <i class="fas fa-heart"></i>
                                                        <div class="highest-box-text">
                                                            <p>{{__('Likes')}}</p>
                                                            <h6>{{$slider->like}}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="highest-box-item d-flex align-items-center">
                                                        <i class="fas fa-eye"></i>
                                                        <div class="highest-box-text">
                                                            <p>{{__('Views')}}</p>
                                                            <h6>{{$slider->views}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="main-item-btn-box">
                                                    <a href="{{route('product_view', encrypt($slider->id))}}" class="theme-button2">{{__('View
                                                    Item')}}</a>
                                                </div>
                                                <p class="main-item-box-condition">{{__('By placing a bid, we reserve funds from
                                                your Ethereum account till the end of the auction')}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7">
                                            <div class="main-item-img-part position-relative d-flex justify-content-center">
                                                <div class="main-item-img">
                                                    <img src="{{asset(IMG_SERVICE_PATH.$slider->thumbnail)}}" alt="{{__('item')}}">
                                                </div>
                                                <!-- Countdown box start -->
                                                <div class="countdown-box position-absolute">
                                                    <span class="bg-green time-remaining">{{__('Time Remaining')}}</span>
                                                    <div class="countdown">
                                                        <input type="hidden" value="{{\Carbon\Carbon::parse($slider->expired_at)->format('M j, Y H:i:s')}}" class="expired_time">
                                                        <div class="timer-down-wrap"><span class="days">{{__('06')}}</span><span class="timing-title">{{__('Days')}}</span></div>
                                                        <div class="timer-down-wrap"><span class="hours">{{__('06')}}</span><span class="timing-title">{{__('Hrs')}}</span></div>
                                                        <div class="timer-down-wrap"><span class="minutes">{{__('35')}}</span><span class="timing-title">{{__('Min')}}</span></div>
                                                        <div class="timer-down-wrap"><span class="seconds">{{__('54')}}</span><span class="timing-title">{{__('Sec')}}</span></div>
                                                    </div>
                                                </div>
                                                <!-- Countdown box end -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                    @endforeach
                    <!-- main item slider end -->
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- northern light carousel Area End -->
    <!-- Top Artists Area Start -->
    <section class="top-artists-area section-t-space">
        <div class="container">
            <!-- Tab Nav -->
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="artists-nav-wrap d-flex justify-content-between">
                        <h2 class="section-heading">{{__('Top Seller')}}</h2>
                        <ul class="nav nav-tabs tab-nav-list border-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Today" role="tab">{{__('Today')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#ThisMonth" role="tab">{{__('This Month')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#ThisYear" role="tab">{{__('This Year')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Tab Nav -->
            <!-- Tab Content -->
                <div class="tab-content">
                    <div class="top-artist-warp tab-pane active" id="Today" role="tabpanel">
                        <div class="row">
                            <!-- Top Artist item start -->
                            @foreach ($top_sellers_today as $tst)
                                <div class="col-12 col-sm-3 col-lg-3">
                                    <div class="artist-item text-center">
                                        <a href="{{route('seller_profile', encrypt($tst->seller->id))}}" class="artist-img"><img src="{{is_null($tst->seller->photo) ? Avatar::create($tst->seller->first_name.' '.$tst->seller->last_name)->toBase64() : IMG_USER_PATH.$tst->seller->photo}}" alt="{{__('artists')}}" class="img-fluid"></a>
                                        <div class="artists-content">
                                            <a href="{{route('seller_profile', encrypt($tst->seller->id))}}"><h5>{{$tst->seller->first_name.' '.$tst->seller->last_name}}</h5></a>
                                            <p class="font-semi-bold">{{__('Top Seller')}}</p>
                                            <div class="follow-wrap">
                                                <a href="{{route('seller_profile', encrypt($tst->seller->id))}}" class="follow-btn">{{__('+ Follow')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        <!-- Top Artist item end -->
                            <div class="col-12 text-center">
                                <a href="{{route('all_seller')}}" class="load-more-btn theme-button2 mt-3">{{__('View All')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="top-artist-warp fade tab-pane" id="ThisMonth" role="tabpanel">
                        <div class="row">
                            <!-- Top Artist item start -->
                            @foreach ($top_sellers_month as $tstt)
                                <div class="col-12 col-sm-3 col-lg-3">
                                    <div class="artist-item text-center">
                                        <a href="{{route('seller_profile', encrypt($tstt->seller->id))}}" class="artist-img"><img src="{{is_null($tstt->seller->photo) ? Avatar::create($tstt->seller->first_name.' '.$tstt->seller->last_name)->toBase64() : IMG_USER_PATH.$tstt->seller->photo}}" alt="{{__('artists')}}" class="img-fluid"></a>
                                        <div class="artists-content">
                                            <a href="{{route('seller_profile', encrypt($tstt->seller->id))}}"><h5>{{$tstt->seller->first_name.' '.$tstt->seller->last_name}}</h5></a>
                                            <p class="font-semi-bold">{{__('Top Seller')}}</p>
                                            <div class="follow-wrap">
                                                <a href="{{route('seller_profile', encrypt($tstt->seller->id))}}" class="follow-btn">{{__('+ Follow')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Top Artist item end -->
                            <div class="col-12 text-center">
                                <a href="{{route('all_seller')}}" class="load-more-btn theme-button2 mt-3">{{__('View All')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="top-artist-warp fade tab-pane" id="ThisYear" role="tabpanel">
                        <div class="row">
                            <!-- Top Artist item start -->
                            @foreach ($top_sellers_year as $tsst)
                                <div class="col-12 col-sm-3 col-lg-3">
                                    <div class="artist-item text-center">
                                        <a href="{{route('seller_profile', encrypt($tsst->seller->id))}}" class="artist-img"><img src="{{is_null($tsst->seller->photo) ? Avatar::create($tsst->seller->first_name.' '.$tsst->seller->last_name)->toBase64() : IMG_USER_PATH.$tsst->seller->photo}}" alt="{{__('artists')}}" class="img-fluid"></a>
                                        <div class="artists-content">
                                            <a href="{{route('seller_profile', encrypt($tsst->seller->id))}}"><h5>{{$tsst->seller->first_name.' '.$tsst->seller->last_name}}</h5></a>
                                            <p class="font-semi-bold">{{__('Top Seller')}}</p>
                                            <div class="follow-wrap">
                                                <a href="{{route('seller_profile', encrypt($tsst->seller->id))}}" class="follow-btn">{{__('+ Follow')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                        <!-- Top Artist item end -->
                            <div class="col-12 text-center">
                                <a href="{{route('all_seller')}}" class="load-more-btn theme-button2 mt-3">{{__('View All')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Tab Content -->
        </div>
    </section>
    <!-- Top Artists Area End -->
    <!-- Latest Collection Area Start -->
    <section class="latest-collection-area section-t-space section-b-90-space">
        <div class="container">
            <div class="latest-collection-dots">
                <img src="{{asset('assets/user/img/dot-big.png')}}" alt="{{__('dot')}}" class="latest-c-dot1 position-absolute">
                <img src="{{asset('assets/user/img/dot-small.png')}}" alt="{{__('dot')}}" class="latest-c-dot2 position-absolute">
            </div>
            <div class="row">
                <!-- Section Title Start -->
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="section-heading">{{allsetting()['home_latest_title']}}</h2>
                        <p class="section-sub-heading">{{allsetting()['home_latest_content']}}</p>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="latest-collection-carousel">
                        <div class="latest-collection-items owl-carousel owl-theme">
                            <!-- collecton slider item start -->
                            @foreach($latest_services as $latest)
                            <div class="latest-collection-item">
                                <a href="{{route('product_view', encrypt($latest->id))}}" class="latest-collection-item-img">
                                    <img src="{{asset(IMG_SERVICE_PATH.$latest->thumbnail)}}" alt="{{__('know us')}}">
                                </a>
                                <div class="collection-item-content">
                                    <h5><a href="{{route('product_view', encrypt($latest->id))}}">{{$latest->title}}</a></h5>
                                    <div class="c-bottom-box-wrap d-flex align-items-center justify-content-between">
                                        <div class="collection-item-bottom-box">
                                            <div class="collection-authors d-flex align-items-center">
                                                <img src="{{is_null($latest->author->photo) ? Avatar::create($latest->author->first_name.' '.$latest->author->last_name)->toBase64() : asset(IMG_USER_PATH.$latest->author->photo)}}" alt="{{__('artist')}}">
                                            </div>
                                            <p class="c-artists-name">{{__('By:')}} {{$latest->author->first_name}} {{$latest->author->last_name}}</p>
                                        </div>
                                        <h6 class="c-item-num-btn">{{round($latest->available_item)}} {{__('items')}}</h6>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- collecton slider item end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Collection Area Start -->
    <!-- Amazing Traditional artwork Area Start -->
    <section class="amazing-traditional-artwork-area section-b-space section-t-space">
        <div class="container">
            <!-- Element img -->
            <div class="amazing-yellow-ball position-absolute"><img src="{{asset('assets/user/img/home-page/amazing-traditional-img/yellow-ball.png')}}" alt="{{__('ball')}}"></div>
            <!-- Element img -->
            <div class="row">
                <div class="col-12 col-lg-5 amazing-artwork-left position-relative">
                    <div class="">
                        <h2 class="section-heading">{{allsetting()['counters_title']}}</h2>
                        <!-- Element wrap Start-->
                        <img src="{{asset('assets/user/img/home-page/amazing-traditional-img/net-shape.png')}}" alt="{{__('art')}}" class="amazing-artwork-shape position-absolute">
                        <!-- Element wrap End -->
                        <!--Counter Area Start-->
                        <div class="counter-area">
                            <div class="counter-box">
                                <h4 class="count-content"><span class="counter">{{allsetting()['counters_count_one']}} </span><span>{{__('K+')}}</span></h4>
                                <p class="count-text">{{allsetting()['counters_content_one']}}</p>
                            </div>
                            <div class="counter-box">
                                <h4 class="count-content"><span class="counter">{{allsetting()['counters_count_two']}}</span><span>{{__('K+')}}</span></h4>
                                <p class="count-text">{{allsetting()['counters_content_two']}}</p>
                            </div>
                            <div class="counter-box">
                                <h4 class="count-content"><span class="counter">{{allsetting()['counters_count_three']}}</span><span>{{__('K+')}}</span></h4>
                                <p class="count-text">{{allsetting()['counters_content_three']}}</p>
                            </div>
                        </div>
                        <!--Counter Area End-->
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="amazing-artwork-right">
                        <div class="big-img d-flex">
                            <div class="big-img-1 text-center">
                                <img src="{{asset('assets/user/img/home-page/amazing-traditional-img/circle-logo.png')}}" alt="{{__('pic')}}" class="explore-circle-logo">
                                <img src="{{is_null(allsetting()['counters_img_one']) || allsetting()['counters_img_one'] == '' ? asset(IMG_STATIC_PATH.'home-page/amazing-traditional-img/pic1.jpg') : asset(IMG_PATH.allsetting()['counters_img_one'])}}" alt="{{__('pic')}}" class="explore-big-pic1 img-fluid">
                            </div>
                            <img src="{{is_null(allsetting()['counters_img_two']) || allsetting()['counters_img_two'] == '' ? asset(IMG_STATIC_PATH.'home-page/amazing-traditional-img/pic2.jpg') : asset(IMG_PATH.allsetting()['counters_img_two'])}}" alt="{{__('pic')}}" class="explore-big-pic2 img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Amazing Traditional artwork Area End -->
    <!-- Explore More Area Start -->
    <section class="explore-more-area section-t-space section-b-90-space">
        <div class="container">
            <!-- Element shape -->
            <div class="explore-radius-shape position-absolute"><img src="{{asset('assets/user/img/home-page/explore-more-radius-shape.png')}}" alt="{{__('shape')}}"></div>
            <!-- Element shape -->
            <!-- Section Title Start -->
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="section-heading">{{allsetting()['home_explorer_title']}}</h2>
                        <p class="section-sub-heading">{{allsetting()['home_explorer_content']}}</p>
                    </div>
                </div>
            </div>
            <!-- Section Title End -->
            <!-- Tab Nav -->
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="artists-nav-wrap d-flex justify-content-between">
                        <ul class="nav nav-tabs tab-nav-list border-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Today1" role="tab">{{__('Today')}}</a>
                            </li>
                            @foreach($categories_services as $cat)
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Game{{$cat->id}}" role="tab">{{$cat->title}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Tab Nav -->
            <!-- Tab Content -->
            <div class="tab-content">
                <div class="top-artist-warp tab-pane active" id="Today1" role="tabpanel">
                    <div class="row">
                        <!-- Explore item start -->
                        @foreach ($latest_services as $st)
                                <div class="col-12 col-sm-4 col-lg-3">
                                    <div class="explore-item">
                                        <div class="artist-img position-relative">
                                            <img src="{{asset(IMG_SERVICE_PATH.$st->thumbnail)}}" alt="{{__('explore-img')}}" class="img-fluid">
                                            <div class="artist-overlay position-absolute">
                                                <div class="price-box-wrap d-flex align-items-center justify-content-between">
                                                    @if ($st->type == 1)
                                                        <div class="bg-green price-btn">{{visual_number_format($st->price_dollar).' '.__('USD')}}</div>
                                                    @else
                                                        <div class="bg-green price-btn">{{__('Bid Now')}}</div>
                                                    @endif
                                                    <a href="{{route('product_view', encrypt($st->id))}}" class="bg-white add-like"><i class="fas fa-heart"></i></a>
                                                </div>
                                                @if ($st->type == 1)
                                                    <a href="{{route('product_view', encrypt($st->id))}}" class="place-a-bid-btn">{{slodOutMessage($st->id) != 1 ? __('Purchase
                                                                    Now') : __('Stock Out')}}</a>
                                                @elseif($st->type == 2)
                                                    <a href="{{route('product_view', encrypt($st->id))}}" class="place-a-bid-btn">{{slodOutMessage($st->id) != 1 ? __('Place
                                                                    a Bid') : __('Stock Out')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="explore-content">
                                            <a href="{{route('product_view', encrypt($st->id))}}"><h5 class="font-semi-bold">{{$st->title}}</h5></a>
                                            <div class="explore-small-box explore-author-wrap d-flex align-items-center justify-content-between">
                                                <div class="explore-author d-flex align-items-center">
                                                    <img src="{{is_null($st->author->photo) ? Avatar::create($st->author->first_name.' '.$st->author->last_name)->toBase64() : asset(IMG_USER_PATH.$st->author->photo)}}" alt="{{__('avatar')}}">
                                                    <p class="ml-2">{{__('By')}} <span>{{$st->author->first_name.' '.$st->author->last_name}}</span></p>
                                                </div>
                                                <div class="like-box">
                                                    <i class="far fa-heart"></i> {{$st->like}}
                                                </div>
                                            </div>
                                            <div class="explore-small-box d-flex align-items-center justify-content-between">
                                                @if ($st->type == 2)
                                                    <p>{{__('Highest Bid')}}<span>{{visual_number_format(highestBidService($st->id)).' '.__('USD')}}</span></p>
                                                @endif
                                                <p class="font-medium top-artist-stock-qty">{{round($st->available_item)}}
                                                    {{__('in stock')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                        <!-- Explore item end -->
                    </div>
                </div>
                @foreach ($categories_services as $category)
                    <div class="top-artist-warp fade tab-pane" id="Game{{$category->id}}" role="tabpanel">
                        <div class="row">
                            <!-- Explore item start -->
                            @foreach ($category->services as $service)
                                <div class="col-12 col-sm-4 col-lg-3">
                                    <div class="explore-item">
                                        <div class="artist-img position-relative">
                                            <img src="{{asset(IMG_SERVICE_PATH.$service->thumbnail)}}" alt="{{__('explore-img')}}" class="img-fluid">
                                            <div class="artist-overlay position-absolute">
                                                <div class="price-box-wrap d-flex align-items-center justify-content-between">
                                                    @if ($service->type == 1)
                                                        <div class="bg-green price-btn">{{visual_number_format($service->price_dollar).' '.__('USD')}}</div>
                                                    @else
                                                        <div class="bg-green price-btn">{{__('Bid Now')}}</div>
                                                    @endif
                                                    <a href="{{route('product_view', encrypt($service->id))}}" class="bg-white add-like"><i class="fas fa-heart"></i></a>
                                                </div>
                                                @if ($service->type == 1)
                                                    <a href="{{route('product_view', encrypt($service->id))}}" class="place-a-bid-btn">{{slodOutMessage($service->id) != 1 ? __('Purchase
                                                                    Now') : __('Stock Out')}}</a>
                                                @elseif($service->type == 2)
                                                    <a href="{{route('product_view', encrypt($service->id))}}" class="place-a-bid-btn">{{slodOutMessage($service->id) != 1 ? __('Place
                                                                    a Bid') : __('Stock Out')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="explore-content">
                                            <a href="{{route('product_view', encrypt($service->id))}}"><h5 class="font-semi-bold">{{$service->title}}</h5></a>
                                            <div class="explore-small-box explore-author-wrap d-flex align-items-center justify-content-between">
                                                <div class="explore-author d-flex align-items-center">
                                                    <img src="{{is_null($service->author->photo) ? Avatar::create($service->author->first_name.' '.$service->author->last_name)->toBase64() : asset(IMG_USER_PATH.$service->author->photo)}}" alt="{{__('avatar')}}">
                                                    <p class="ml-2">{{__('By')}} <span>{{$service->author->first_name.' '.$service->author->last_name}}</span></p>
                                                </div>
                                                <div class="like-box">
                                                    <i class="far fa-heart"></i> {{$service->like}}
                                                </div>
                                            </div>
                                            <div class="explore-small-box d-flex align-items-center justify-content-between">
                                                @if ($service->type == 2)
                                                    <p>{{__('Highest Bid')}}<span>{{visual_number_format(highestBidService($service->id)).' '.__('USD')}}</span></p>
                                                @endif
                                                <p class="font-medium top-artist-stock-qty">{{round($service->available_item)}}
                                                    {{__('in stock')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Explore item end -->
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Tab Content -->
        </div>
    </section>
    <!-- Explore More Area End -->
    <!-- Call To Action Area Start -->
    <section class="call-to-action-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="call-to-action-content text-center">
                        <h2>{{allsetting()['home_footer_title']}}</h2>
                        <p>{{allsetting()['home_footer_content']}}</p>
                        @if(Auth::check() == true && Auth::user()->role == USER_ROLE_USER)
                            <a href="{{route('service_create')}}" class="theme-button1">{{__('Upload Now')}}</a>
                        @else
                            <a data-toggle="modal" href="#signInModal" class="theme-button1">{{__('Join With Us')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call To Action Area End -->
@endsection
