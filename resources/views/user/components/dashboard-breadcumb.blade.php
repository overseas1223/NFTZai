<!-- Page Banner Area start here  -->
<section class="page-banner-area p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? asset(IMG_STATIC_PATH.'page-banner.png') : asset(IMG_PATH.allsetting()['dashboard_image'])}});">
    <div class="container">
        <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="dot"></div>
        <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="dot"></div>
        <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="dot"></div>
        <div class="row page-banner-top-space">
            <div class="col-12 col-lg-12">
                <div class="page-banner-content text-center">
                    <h1 class="page-banner-title">{{$title}}</h1>
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
                        <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
