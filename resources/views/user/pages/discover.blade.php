@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <div id="filter-url" data-url="{{route('filter_service')}}"></div>
    <section class="page-banner-area p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? asset(IMG_STATIC_PATH.'page-banner.png') : asset(IMG_PATH.allsetting()['dashboard_image'])}});">
        <div class="container">
            <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="{{__('dot')}}"></div>
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{__('Search your keyword')}}</h1>

                        <div class="section-banner-search">
                            <form method="GET" action="{{route('search_result')}}">
                                <div class="form-group position-relative mb-0">
                                    <input type="search" name="keyword" class="form-control" placeholder="{{__('Search here...')}}">
                                    <button type="submit" class="position-absolute"><i class="fas fa-arrow-right"></i></button>
                                </div>
                            </form>
                        </div>

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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Discover')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="search-page-area section-t-space section-b-90-space">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="search-sidebar-wrap">
                        <div class="search-sidebar-box">
                            <h6 class="search-sidebar-box-title">{{__('Type')}}</h6>
                            <select class="form-control" id="service-type">
                                <option value="">{{__('---SELECT A TYPE---')}}</option>
                                <option value="">{{__('Any Type')}}</option>
                                <option value="1">{{__('Fixed')}}</option>
                                <option value="2">{{__('Bid')}}</option>
                            </select>
                        </div>
                        <div class="search-sidebar-box">
                            <h6 class="search-sidebar-box-title">{{__('Price Range')}}</h6>
                            <div id="slider-range" class="price-filter-range"></div>
                            <div class="range-value-box">
                                <span class="range-value-wrap">{{__('USD')}}<input readonly type="number" min=0 max="9900" id="min_price" class="price-range-field" /></span>
                                <span class="range-value-wrap">{{__('USD')}}<input readonly type="number" min=0 max="10000" id="max_price" class="price-range-field" /></span>
                            </div>

                        </div>
                        <div class="search-sidebar-box">
                            <h6 class="search-sidebar-box-title">{{__('Like')}}</h6>
                            <select class="form-control" id="like">
                                <option value="">{{__('---SELECT---')}}</option>
                                <option value="DESC">{{__('Most liked')}}</option>
                                <option value="ASC">{{__('Least liked')}}</option>
                            </select>
                        </div>
                        <div class="search-sidebar-box">
                            <h6 class="search-sidebar-box-title">{{__('color')}}</h6>
                            <select class="form-control" id="color">
                                <option VALUE="">{{__('---SELECT A COLOR---')}}</option>
                                <option value="">{{__('Any Color')}}</option>
                                @foreach(colors() as $color)
                                    <option value="{{$color}}">{{$color}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-sidebar-box">
                            <h6 class="search-sidebar-box-title">{{__('Category')}}</h6>
                            @foreach ($categories as $cat)
                                <label class="checkbox-wrap d-block">
                                    <input type="checkbox" value="{{$cat->id}}" class="category">
                                    <span class="checkmark"></span>
                                    {{$cat->title}}
                                </label>
                            @endforeach

                        </div>
                        <div class="search-sidebar-box">
                            <h6 class="search-sidebar-box-title">{{__('Origin')}}</h6>
                            @foreach (serviceOrigin() as $origin)
                                <label class="checkbox-wrap d-block">
                                    <input type="checkbox" value="{{$origin->origin}}" class="origin">
                                    <span class="checkmark"></span>
                                    {{$origin->origin}}
                                </label>
                            @endforeach
                        </div>
                        <div class="search-sidebar-box mb-0">
                            <button type="reset" class="sidebar-reset-btn d-flex align-items-center" id="reset-filter"> <span><i class="fas fa-times"></i></span>
                                {{__('Reset Filter')}}</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="search-rightside-area">
                        <div class="row" id="all-service">
                            @foreach($services as $st)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
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
                                                    <a href="{{route('product_view', encrypt($st->id))}}" class="place-a-bid-btn">{{__('Purchase
                                                                Now')}}</a>
                                                @elseif($st->type == 2)
                                                    <a href="{{route('product_view', encrypt($st->id))}}" class="place-a-bid-btn">{{__('Place
                                                                a Bid')}}</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{asset('assets/user/js/pages/discover.js')}}"></script>
@endsection
