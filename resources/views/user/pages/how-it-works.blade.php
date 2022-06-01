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
                        <h1 class="page-banner-title">{{__('Frequently asked questions')}}</h1>
                        <p class="page-banner-para">{{__('Join our community to get free updates and a a lot of freebies are
                            waiting for you or')}}
                            <a href="{{route('contact')}}" class="color-green font-weight-bold">{{__('Contact Support')}}</a>
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
                            <li class="breadcrumb-item active" aria-current="page">{{__('FAQ')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->

    <!-- Connect Your Wallet Page Area start here  -->
    <section class="faq-page-area section-t-space">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <ul class="nav nav-tabs tab-nav-list faq-tab-nav-list flex-column border-0" role="tablist">
                        @foreach($faqs as $fq)
                        <li class="nav-item">
                            <a class="nav-link {{$fq->id == 1 ? 'active' : ''}}" data-toggle="tab" href="#general{{$fq->id}}" role="tab"><i class="{{$fq->icon}}"></i>{{ $fq->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-12 col-md-8 col-lg-8 offset-lg-1">
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach ($faqs as $fq)
                            <div class="tab-pane {{$fq->id == 1 ? 'active' : ''}}" id="general{{$fq->id}}" role="tabpanel">
                                <div class="faq-list">
                                    <div class="accordion" id="accordionExample">
                                        @foreach ($fq->faqs as $f)
                                            <div class="card">
                                                <div class="card-header" id="headingOne{{$f->id}}">
                                                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne{{$f->id}}">{{$f->question}}</button>
                                                </div>
                                                <div id="collapseOne{{$f->id}}" class="collapse show" aria-labelledby="headingOne{{$f->id}}" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <p>{{$f->answer}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Connect Your Wallet Page Area end here  -->
@endsection
