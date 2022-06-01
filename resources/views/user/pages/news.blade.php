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
    <!-- news List Area start here  -->
    <section class="news-list-area section-b-90-space section-t-space">
        <div class="container">
            <div class="row">
                <!-- news List Item Start -->
                <div class="col-12 col-md-7 col-lg-7 news-page-top-part-left-items">
                    @foreach($all_news as $an)
                        @if($loop->first)
                            <div class="news-list-item">
                                <div class="card news-item">
                                    <a href="{{route('news_details', $an->slug)}}" class="box-bg-image" data-background="{{asset(IMG_NEWS_PATH.$an->thumbnail)}}">
                                        <img src="{{asset(IMG_NEWS_PATH.$an->thumbnail)}}" alt="{{__('news')}}" class="img-fluid">
                                    </a>
                                    <div class="card-body">
                                        <div class="news-publish-date color-green fw-bold">{{\Carbon\Carbon::parse($an->created_at)->format('F j, Y')}}</div>
                                        <h3 class="news-title"><a href="{{route('news_details', $an->slug)}}">{{$an->title}}</a></h3>
                                        <p class="card-text">{!! clean(Str::limit($an->description, 200, '...'))!!} <a href="{{route('news_details', $an->slug)}}" class="news-read-more font-weight-bold">{{__('Read
                                            More')}}</a></p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- news List Item End -->
                <div class="col-12 col-md-5 col-lg-5 news-page-top-part-right-items">
                    <!-- news List Item Start -->
                    @foreach($all_news as $ant)
                        @if ($loop->iteration == 2)
                            <div class="news-list-item news-item-small">
                                <div class="card news-item">
                                    <a href="{{route('news_details', $ant->slug)}}" class="box-bg-image" data-background="{{asset(IMG_NEWS_PATH.$ant->thumbnail)}}">
                                        <img src="{{asset(IMG_NEWS_PATH.$ant->thumbnail)}}" alt="{{__('news')}}" class="img-fluid">
                                    </a>
                                    <div class="card-body">
                                        <div class="news-publish-date color-green fw-bold">{{\Carbon\Carbon::parse($ant->created_at)->format('F j, Y')}}</div>
                                        <h3 class="news-title"><a href="{{route('news_details', $ant->slug)}}">{{$ant->title}}</a></h3>
                                        <p class="card-text">{!!clean(Str::limit($ant->description, 100, '...'))!!} <a href="{{route('news_details', $ant->slug)}}" class="news-read-more font-weight-bold">{{__('Read
                                            More')}}</a></p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    <!-- news List Item End -->
                        <!-- news List Item Start -->
                        @if ($loop->iteration == 3)
                            <div class="news-list-item news-item-small">
                                <div class="card news-item">
                                    <a href="{{route('news_details', $ant->slug)}}" class="box-bg-image" data-background="{{asset(IMG_NEWS_PATH.$ant->thumbnail)}}">
                                        <img src="{{asset(IMG_NEWS_PATH.$ant->thumbnail)}}" alt="{{__('news')}}" class="img-fluid">
                                    </a>
                                    <div class="card-body">
                                        <div class="news-publish-date color-green fw-bold">{{\Carbon\Carbon::parse($ant->created_at)->format('F j, Y')}}</div>
                                        <h3 class="news-title"><a href="{{route('news_details', $ant->slug)}}">{{$ant->title}}</a></h3>
                                        <p class="card-text">{!!clean(Str::limit($ant->description, 100, '...'))!!} <a href="{{route('news_details', $ant->slug)}}" class="news-read-more font-weight-bold">{{__('Read
                                            More')}}</a></p>
                                    </div>
                                </div>
                            </div>
                    @endif
                @endforeach
                    <!-- news List Item End -->
                </div>
            </div>
        </div>
    </section>
    <!-- news List Area end here  -->
    <!-- Hot News Area start here  -->
    <section class="news-list-area hot-news-area section-b-90-space">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="hot-news-area">
                        <h2 class="section-heading">{{__('Hot News')}}</h2>
                        <div class="hot-news-item-list">
                            <!-- news List Item Start -->
                            @foreach($all_news as $anh)
                                @if ($anh->isHotNews == 1)
                                    <div class="news-list-item news-item-small hot-news-item">
                                        <div class="card news-item d-flex">
                                            <div class="col-12 col-md-5 col-lg-5">
                                                <a href="{{route('news_details', $anh->slug)}}" class="box-bg-image" data-background="{{asset(IMG_NEWS_PATH.$anh->thumbnail)}}">
                                                    <img src="{{asset(IMG_NEWS_PATH.$anh->thumbnail)}}" alt="{{__('news')}}" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="card-body col-12 col-md-8 col-lg-7">
                                                <div class="news-publish-date color-green fw-bold">{{\Carbon\Carbon::parse($anh->created_at)->format('F j, Y')}}</div>
                                                <h3 class="news-title"><a href="{{route('news_details', $anh->slug)}}">{{$anh->title}}</a></h3>
                                                <div class="card-text">{!!clean(Str::limit($anh->description, 105, '...'))!!} <a href="{{route('news_details', $anh->slug)}}" class="news-read-more font-weight-bold">{{__('Read
                                                    More')}}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <!-- news List Item End -->
                        </div>
                    </div>
                </div>
                <!-- News RightSide Area Start -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="news-right-side-wrap">
                        <h2 class="section-heading">{{__('Trending')}}</h2>
                        <div class="trending-news-list">
                            <!-- news List Item Start -->
                            @foreach($all_news as $antt)
                                @if ($antt->IsTrending == 1)
                            <div class="news-list-item news-item-small trending-news-item">
                                <div class="card news-item">
                                    <div class="card-body">
                                        <div class="news-publish-date color-green fw-bold">{{\Carbon\Carbon::parse($antt->created_at)->format('F j, Y')}}</div>
                                        <h3 class="news-title"><a href="{{route('news_details', $antt->slug)}}">{{$antt->title}}</a></h3>
                                        {!!clean(Str::limit($anh->description, 50, '...'))!!}
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                            <!-- news List Item End -->
                        </div>
                    </div>
                </div>
                <!-- News RightSide Area End -->
            </div>
        </div>
    </section>
    <!-- Hot News Area end here  -->
@endsection