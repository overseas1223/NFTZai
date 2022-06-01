@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!-- Page Banner Area start here  -->
    <section class="page-banner-area p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? asset(IMG_STATIC_PATH.'page-banner.png') : asset(IMG_PATH.allsetting()['dashboard_image'])}});">
        <div class="container">
            <!-- Page Banner element -->
            <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="{{__('dot')}}"></div>
            <!-- Page Banner element -->
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{$seller->first_name.' '.$seller->last_name}}</h1>
                        <p class="page-banner-para">{{$seller->country}}</p>
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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Profile')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->
    <!-- Profile Page Area start here  -->
    <section class="profile-page-area other-profile-page-area section-t-space section-b-90-space">
        <div class="container">
            <div class="row">
                <!-- Profile Sidebar Area Start -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="search-sidebar-wrap user-profile-sidebar-wrap">
                        <div class="user-profile-img">
                            <img src="{{is_null($seller->photo) ? Avatar::create($seller->first_name.' '.$seller->last_name)->toBase64() : asset(IMG_USER_PATH.$seller->photo)}}" alt="{{__('user')}}">
                        </div>
                        <div class="user-profile-sidebar-name">
                            <h5>{{$seller->first_name.' '. $seller->last_name}}</h5>
                            <h6>{{$seller->country}}</h6>
                            <p class="user-profile-sidebar-about font-13">{{$seller->bio}}</p>
                            <div class="user-profile-url">
                                <a href="{{$seller->website}}" class="font-14">{{$seller->website}}</a>
                            </div>
                        </div>
                        <div class="user-profile-sidebar-follow-box">
                            @if (Auth::check() == true && Auth::user()->role == USER_ROLE_USER)
                                <a href="{{isFollowed($seller->id) == 0 ? route('follow_seller', encrypt($seller->id)) : 'javascript:void(0)'}}" class="button-small theme-button2 followers-button">{{isFollowed($seller->id) == 0 ? __('Follow') : __('Followed')}}</a>
                            @else
                                <button class="theme-button1 user-follow-btn" data-toggle="modal" data-target="#notAuthModal">{{__('Follow')}}</button>
                            @endif
                            <button class="menu-round-btn theme-border"><i class="far fa-flag"></i></button>
                        </div>
                        <div class="user-profile-sidebar-social-box">
                            <ul class="d-flex align-items-center justify-content-center">
                                <li><a href="{{isset($seller->social_media->facebook) ? $seller->social_media->facebook : 'javascript:void(0)' }}" class="mx-2 p-2"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="{{isset($seller->social_media->twitter) ? $seller->social_media->twitter : 'javascript:void(0)' }}" class="mx-2 p-2"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="{{isset($seller->social_media->instagram) ? $seller->social_media->instagram : 'javascript:void(0)' }}" class="mx-2 p-2"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="membership-status">{{__('Member since')}} {{\Carbon\Carbon::parse($seller->created_at)->format('j M, Y')}}</div>
                    </div>
                </div>
                <!-- Profile Sidebar Area End -->
                <!-- Profile rightside Area -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="search-rightside-area">
                        <!-- Tab Nav -->
                        <div class="artists-nav-wrap d-flex justify-content-between">
                            <ul class="nav nav-tabs tab-nav-list border-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#Today" role="tab">{{__('Today')}}</a>
                                </li>
                                @foreach ($categories as $cattab)
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#Game{{$cattab->id}}" role="tab">{{$cattab->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Tab Nav -->
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div class="top-artist-warp tab-pane active" id="Today" role="tabpanel">
                                <div class="row">
                                    <!-- Explore item start -->
                                    @foreach ($services as $st)
                                        @if (\Carbon\Carbon::parse($st->created_at)->toDateString() == \Carbon\Carbon::now()->toDateString())
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                <div class="explore-item user-profile-item">
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
                                                                <p>{{__('Uploaded')}} <span>{{\Carbon\Carbon::parse($st->created_at)->format('jS F')}}</span></p>
                                                            </div>
                                                            <div class="like-box">
                                                                <i class="far fa-heart"></i> {{$st->like}}
                                                            </div>
                                                        </div>

                                                        <div class="explore-small-box d-flex align-items-center justify-content-between">
                                                            <p class="on-sell">{{__('Status :')}} <span>{{service_status($st->id)}}</span></p>
                                                            <p class="font-medium top-artist-stock-qty">{{number_format($st->available_item)}}
                                                                {{__('in stock')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <!-- Explore item end -->
                                </div>
                            </div>
                            @foreach ($categories as $cat)
                                <div class="top-artist-warp fade tab-pane" id="Game{{$cat->id}}" role="tabpanel">
                                    <div class="row">
                                        <!-- Explore item start -->
                                        @forelse(categoryServicesSeller($cat->id, $seller->id) as $cu)
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                <div class="explore-item user-profile-item">
                                                    <div class="artist-img position-relative">
                                                        <img src="{{asset(IMG_SERVICE_PATH.$cu->thumbnail)}}" alt="{{__('explore-img')}}" class="img-fluid">
                                                        <div class="artist-overlay position-absolute">
                                                            <div class="price-box-wrap d-flex align-items-center justify-content-between">
                                                                @if ($cu->type == 1)
                                                                    <div class="bg-green price-btn">{{visual_number_format($cu->price_dollar).' '.__('USD')}}</div>
                                                                @else
                                                                    <div class="bg-green price-btn">{{__('Bid Now')}}</div>
                                                                @endif
                                                                <a href="{{route('product_view', encrypt($cu->id))}}" class="bg-white add-like"><i class="fas fa-heart"></i></a>
                                                            </div>
                                                            @if ($cu->type == 1)
                                                                <a href="{{route('product_view', encrypt($cu->id))}}" class="place-a-bid-btn">{{__('Purchase
                                                                    Now')}}</a>
                                                            @elseif($cu->type == 2)
                                                                <a href="{{route('product_view', encrypt($cu->id))}}" class="place-a-bid-btn">{{__('Place
                                                                    a Bid')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="explore-content">
                                                        <a href="{{route('product_view', encrypt($cu->id))}}"><h5 class="font-semi-bold">{{$cu->title}}</h5></a>
                                                        <div class="explore-small-box explore-author-wrap d-flex align-items-center justify-content-between">
                                                            <div class="explore-author d-flex align-items-center">
                                                                <p>{{__('Uploaded')}} <span>{{\Carbon\Carbon::parse($cu->created_at)->format('jS F')}}</span></p>
                                                            </div>
                                                            <div class="like-box">
                                                                <i class="far fa-heart"></i> {{$cu->like}}
                                                            </div>
                                                        </div>
                                                        <div class="explore-small-box d-flex align-items-center justify-content-between">
                                                            <p class="on-sell">{{__('Status :')}} <span>{{service_status($cu->id)}}</span></p>
                                                            <p class="font-medium top-artist-stock-qty">{{number_format($cu->available_item)}}
                                                                {{__('in stock')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="artist-item text-center">
                                                <h1>{{__('No Data Found!')}}</h1>
                                            </div>
                                        @endforelse
                                        <!-- Explore item end -->
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Tab Content -->
                    </div>
                </div>
                <!-- Profile rightside Area -->
            </div>
        </div>
    </section>
    <!-- Profile Page Area end here  -->
@endsection
