@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!-- Page Banner Area start here  -->
    <section class="page-banner-area faq-page-banner p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? asset(IMG_STATIC_PATH.'page-banner.png') : asset(IMG_PATH.allsetting()['dashboard_image'])}});">
        <div class="container">
            <!-- Page Banner element -->
            <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="{{__('dot')}}"></div>
            <!-- Page Banner element -->
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{__('Reset Password')}}</h1>
                        <p class="page-banner-para">{{__('Join our community to get free updates and a alot of freebies are
                            waiting for you or')}}</p>
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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Reset Password')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->

    <!-- Reset Password Page Area start here  -->
    <section class="reset-password-page section-t-space section-b-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-md-offset-6">
                {{Form::open(['route' => 'reset_password_save', 'files' => true, 'data-handler'=>"showMessage"])}}
                        <!-- Reset Password Form -->
                        <div class="form-group">
                            <input class="form-control" placeholder="{{__('Token')}}" name="token" type="text" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="{{__('Email')}}" name="email" type="email" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="{{__('Password')}}" name="password" type="password" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="{{__('Confirm Password')}}" name="password_confirmation" type="password" required>
                        </div>
                        <div class="sign-up-button-part">
                            <button type="submit" class="theme-button1">{{__('Save')}}</button>
                        </div>
                        <!-- Reset Password Form -->
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </section>
    <!-- Reset Password Page Area end here  -->
@endsection
