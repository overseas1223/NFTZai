@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!-- Page Banner Area start here  -->
    <section class="page-banner-area news-page-banner p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? asset(IMG_STATIC_PATH.'page-banner.png') : asset(IMG_PATH.allsetting()['dashboard_image'])}});">
        <div class="container">
            <!-- Page Banner element -->
            <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="{{__('dot')}}"></div>
            <!-- Page Banner element -->
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{__('News')}}</h1>
                        <p class="page-banner-para">{{__('Get the latest news on the NFT marketplace and crypto world.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Banner Area end here  -->
    <!-- Page Breadcrumb Area start here  -->
    <section class="breadcrumb-section p-0">
        <div class="container">
            <div class="row">
                <!-- Breadcrumb Area -->
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="breadcrumb-area">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('login')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('News')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->
    <!-- news List Area / News Details start here  -->
    <section class="news-list-area news-details-area section-t-space">
        <div class="container">
            <div class="row">
                <!-- news List Item Start -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="news-list-item news-details-content">
                        <div class="card news-item">
                            <div class="card-body">
                                <div class="news-publish-date color-green fw-bold">{{\Carbon\Carbon::parse($news->created_at)->format('F j, Y')}}</div>
                                <h3 class="news-title">{{$news->title}}</h3>
                                <!-- News extra info -->
                                <div class="news-details-extra-info d-flex justify-content-between">
                                    <div class="extra-info-left">
                                        <span><i class="far fa-eye"></i> {{$news->views}}</span>
                                        <span><i class="fas fa-calendar-alt"></i> {{\Carbon\Carbon::parse($news->created_at)->format('F j, Y')}}</span>
                                    </div>
                                </div>
                                <!-- News extra info -->
                            </div>
                            {{-- <img src="{{asset(IMG_NEWS_PATH.$news->thumbnail)}}" alt="{{__('news')}}" class="img-fluid"> --}}

                            <div class="box-bg-image" data-background="{{asset(IMG_NEWS_PATH.$news->thumbnail)}}">
                                <img src="{{asset(IMG_NEWS_PATH.$news->thumbnail)}}" alt="{{__('news')}}" class="img-fluid">
                            </div>
                        </div>
                        <div class="news-details-para">
                            {!! clean($news->description) !!}
                        </div>
                    </div>
                </div>
                <!-- News RightSide Area Start -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="news-right-side-wrap">
                        <h2 class="section-heading">{{__('Trending')}}</h2>
                        <div class="trending-news-list">
                            <!-- news List Item Start -->
                            @foreach($trend_news as $tn)
                            <div class="news-list-item news-item-small trending-news-item">
                                <div class="card news-item">
                                    <div class="card-body">
                                        <div class="news-publish-date color-green fw-bold">{{\Carbon\Carbon::parse($tn->created_at)->format('F j, Y')}}</div>
                                        <h3 class="news-title"><a href="{{route('news_details', $tn->slug)}}">{{$tn->title}}</a></h3>
                                        {!!clean(Str::limit($tn->description, 50, '...'))!!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- news List Item End -->
                        </div>
                    </div>
                </div>
                <!-- News RightSide Area End -->
            </div>
        </div>
    </section>
    <!-- news List Area / News Details end here  -->
@endsection
