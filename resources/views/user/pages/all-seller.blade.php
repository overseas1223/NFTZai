@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <section class="page-banner-area p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? asset(IMG_STATIC_PATH.'page-banner.png') : asset(IMG_PATH.allsetting()['dashboard_image'])}});">
        <div class="container">
            <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="{{__('dot')}}"></div>
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{__('Seller')}}</h1>
                        <p class="page-banner-para">{{__('The easiest way to discover and know to the Top sellers')}}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="breadcrumb-section p-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="breadcrumb-area">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('login')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Seller')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="all-artist-page-top-artists-area section-t-space section-b-90-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="section-heading">{{__('Top Seller')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="all-artist-page-carousel">
                        <div class="all-artist-page-items owl-carousel owl-theme">
                            @foreach ($top_sellers as $ts)
                                <div class="all-artist-page-slider-item">
                                    <div class="all-artist-page-item-img">
                                        <div class="all-artist-item-cover-photo">
                                            <img src="{{is_null($ts->seller->cover_photo) ? asset('assets/user/img/top-artists/cover-1.jpg') : asset(IMG_USER_COVER_PHOTO.$ts->seller->cover_photo)}}" alt="{{__('coverphoto')}}">
                                        </div>
                                        <div class="all-artist-img-inner-img position-relative">
                                            <div class="all-artist-img-inner-img-wrap"><img src="{{is_null($ts->seller->photo) ? Avatar::create($ts->seller->first_name.' '.$ts->seller->last_name)->toBase64() : asset(IMG_USER_PATH.$ts->seller->photo)}}" alt="{{__('round')}}"></div>
                                            <span class="position-absolute"><i class="fas fa-check"></i></span>
                                        </div>
                                    </div>
                                    <div class="all-artist-page-slider-item-content text-center">
                                        <a href="{{route('seller_profile', encrypt($ts->seller->id))}}"><h5 class="font-semi-bold">{{$ts->seller->first_name.' '.$ts->seller->last_name}}</h5></a>
                                        <div class="sales-artwork-box d-flex align-items-center justify-content-between">
                                            <div class="all-artist-sales-box">
                                                <p>{{__('Sales')}}</p>
                                                <h6 class="sales-artwork-count d-flex align-items-center justify-content-center"> <img src="{{asset('assets/user/img/top-artists/sales-icon.svg')}}" alt="{{__('sales')}}">
                                                    {{__('23')}}</h6>
                                            </div>
                                            <div class="all-artist-sales-box">
                                                <p>{{__('Artworks')}}</p>
                                                <h6 class="sales-artwork-count d-flex align-items-center justify-content-center"> <img src="{{asset('assets/user/img/top-artists/art-work-icon.svg')}}" alt="{{__('sales')}}">
                                                    {{__('43')}}</h6>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{route('seller_profile', encrypt($ts->seller->id))}}" class="theme-button1 w-100">{{__('View Profile')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="list-of-artist-area section-b-90-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="section-heading">{{__('List of Seller')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="artists-nav-wrap d-flex justify-content-between">
                        <ul class="nav nav-tabs tab-nav-list border-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#All_Artists" role="tab">{{__('All
                                    Artists')}}</a>
                            </li>
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Trending{{$category->id}}" role="tab">{{$category->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="top-artist-warp tab-pane active" id="All_Artists" role="tabpanel">
                    <div class="row">
                        @forelse($sellers as $allseller)
                        <div class="col-12 col-sm-3 col-lg-3">
                            <div class="artist-item text-center">
                                <a href="{{route('seller_profile', encrypt($allseller->id))}}" class="artist-img"><img src="{{is_null($allseller->photo) ? Avatar::create($allseller->first_name.' '.$allseller->last_name)->toBase64() : asset(IMG_USER_PATH.$allseller->photo)}}" alt="{{__('artists')}}" class="img-fluid"></a>
                                <div class="artists-content">
                                    <a href="{{route('seller_profile', encrypt($allseller->id))}}"><h5>{{$allseller->first_name.' '.$allseller->last_name}}</h5></a>
                                    <p class="font-semi-bold">{{__('Top Seller')}}</p>
                                    <div class="follow-wrap">
                                        <a href="{{route('seller_profile', encrypt($allseller->id))}}" class="follow-btn">{{__('+ Follow')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-12 col-sm-3 col-lg-3">
                                <div class="artist-item text-center">
                                    <h1>{{__('No data found!')}}</h1>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                @foreach($categories as $cat)
                <div class="top-artist-warp fade tab-pane" id="Trending{{$cat->id}}" role="tabpanel">
                    <div class="row">
                        <!-- Top Artist item start -->
                        @forelse(categoryUser($cat->id) as $cu)
                        <div class="col-12 col-sm-3 col-lg-3">
                            <div class="artist-item text-center">
                                <a href="{{route('seller_profile', encrypt($cu->id))}}" class="artist-img"><img src="{{is_null($cu->photo) ? Avatar::create($cu->first_name.' '.$cu->last_name)->toBase64() : asset(IMG_USER_PATH.$cu->photo)}}" alt="{{__('artists')}}" class="img-fluid"></a>
                                <div class="artists-content">
                                    <a href="{{route('seller_profile', encrypt($cu->id))}}"><h5>{{$cu->first_name.' '.$cu->last_name}}</h5></a>
                                    <p class="font-semi-bold">{{__('Top Seller')}}</p>
                                    <div class="follow-wrap">
                                        <button class="follow-btn">{{__('+ Follow')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="artist-item text-center">
                                <h1>{{__('No Data Found!')}}</h1>
                            </div>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
