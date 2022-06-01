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
                        <h1 class="page-banner-title">{{__('Selling Method')}}</h1>
                        <p class="page-banner-para">{{__('Choose different options for selling your collectible, you can sell
                            at
                            fixed price, auction and in a group.')}}
                        </p>
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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Upload')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->
    <!-- Upload Page Area start here  -->
    <section class="upload-page-area section-t-space">
        <div class="container">
            <div class="row">
                <!-- Upload Box Start -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <a href="{{route('userServiceCreate', encrypt(FIXED_PRICE))}}" class="upload-box-item">
                        <div class="upload-box-inner">
                            <img src="{{asset('assets/user/img/upload-img/1.svg')}}" alt="{{__('upload')}}">
                            <h3>{{__('Set Price')}}</h3>
                            <p>S{{__('ell at fixed price')}}</p>
                        </div>
                    </a>
                </div>
                <!-- Upload Box End -->
                <!-- Upload Box Start -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <a href="{{route('userServiceCreate', encrypt(BID_PRICE))}}" class="upload-box-item">
                        <div class="upload-box-inner">
                            <img src="{{asset('assets/user/img/upload-img/2.svg')}}" alt="{{__('upload')}}">
                            <h3>{{__('Highest Bid')}}</h3>
                            <p>{{__('Sell through Auction')}}</p>
                        </div>
                    </a>
                </div>
                <!-- Upload Box End -->
                <div class="col-12">
                    <p class="upload-user-private-text text-center">{{__('We do not own your private keys and cannot access
                        your funds without your confirmation.')}}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Upload Page Area end here  -->
@endsection
