<!-- Desktop Menu Start -->
<section class="menu-section-area {{Auth::check() ? 'isLoginMenu' : '' }}">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="{{route('login')}}"><img src="{{is_null(allsetting()['logo']) || allsetting()['logo'] == '' ? asset(IMG_STATIC_PATH.'logo.png') : asset(IMG_PATH.allsetting()['logo'])}}" alt="{{__('Nftzai')}}"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-capitalize mr-auto">
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('discover') ? 'active' : ''}}" href="{{route('discover')}}">{{__('Discover')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('how-it-works') ? 'active' : ''}}" href="{{route('how-it-works')}}">{{__('How
                            it works')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::is('news') ? 'active' : ''}}" href="{{route('news')}}">{{__('News')}}</a>
                    </li>
                </ul>
                <div class="header-right-nav my-2 my-lg-0 d-flex">
                    <form class="searchbox" method="GET" action="#">
                        <input type="hidden" id="search-url" value="{{route('search_result_ajax')}}">
                        <input type="text" placeholder="Search..." name="keyword" class="searchbox-input" id="search-service" autocomplete="off">
                        <button type="submit" class="searchbox-submit searchbox-icon nav-search menu-round-btn"><i class="fas fa-search"></i></button>
                        <span class="searchbox-icon"><i class="fas fa-search"></i></span>
                        {{-- Menu Search Result Dropdown Box Start --}}
                        <div class="menu-search-result-dropdown-box position-absolute d-none" id="search-work">
                            <ul class="list-unstyled" id="search-result">
                            </ul>
                        </div>
                        {{-- Menu Search Result Dropdown Box End --}}
                    </form>
                    <ul class="header-right-menu-ul">
                        <!-- If isLoginMenu Then Show Menu User Box -->
                        @if(Auth::check())
                            <li><a href="{{route('service_create')}}" class="theme-button1 nav-upload">{{__('upload')}}</a></li>
                            <li class="nav-item dropdown">
                                <button class="dropdown-toggle d-flex align-items-center" id="userNavbarDropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="navbar-user-img-wrap position-relative">
                                    <img src="{{ isset(Auth::user()->photo) ? asset(IMG_USER_VIEW_PATH.Auth::user()->photo) : Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->toBase64()}}" alt="{{__('user')}}">
                                    <span class="user-verified-badge position-absolute"><i class="fas fa-check"></i></span>
                                </span>
                                    <span class="navbar-user-name font-semi-bold font-18">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userNavbarDropdown">
                                    <div class="navbarUserDropdownInner d-flex align-items-center">
                                        <div class="navbar-user-img-wrap position-relative">
                                            <img src="{{ isset(Auth::user()->photo) ? asset(IMG_USER_VIEW_PATH.Auth::user()->photo) : Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->toBase64()}}" alt="{{__('user')}}">
                                            <span class="user-verified-badge position-absolute"><i class="fas fa-check"></i></span>
                                        </div>
                                        <h6 class="navbar-user-name font-semi-bold font-18">{{Auth::user()->first_name}} {{Auth::user()->last_name}} </h6>
                                    </div>
                                    <!-- Show If Wallet not connected after login -->
                                    <a href="{{route('my_wallets')}}" class="dropdown-item theme-button1 user-dropdown-nav-wallet">{{__('My
                                    Wallet')}}</a>
                                    <!-- Show If Wallet not connected after login -->
                                    <a class="dropdown-item" href="{{route('login')}}"><i class="fas fa-tachometer-alt"></i>{{__('Dashboard')}}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('user_profile')}}"><i class="far fa-user"></i>{{__('My
                                    profile')}}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('my_collections')}}"><i class="far fa-image"></i>{{__('My
                                            Artworks')}}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('logOut')}}"><i class="fas fa-sign-in-alt"></i>{{__('Logout')}}</a>
                                </div>
                            </li>
                        @else
                            <li><a data-toggle="modal" href="#signInModal" class="theme-button1 nav-upload">{{__('Upload')}}</a></li>
                            <li class="nav-wallet"><a data-toggle="modal" href="#signInModal" class="theme-button2">{{__('Join With Us')}}</a></li>
                    @endif
                    <!-- If isLoginMenu Then Show Menu User Box -->
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navigation -->
</section>
<!-- Desktop Menu End -->
<!-- Start Mobile Header -->
<div class="mobile-header {{Auth::check() ? 'isLoginMenu' : '' }}">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <!-- Start Mobile Left Side -->
                <div class="mobile-header-left">
                    <ul class="mobile-menu-logo">
                        <li>
                            <a href="{{route('login')}}">
                                <div class="logo">
                                    <img src="{{asset('assets/user/img/logo.png')}}" alt="{{__('Nftzai')}}" />
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Mobile Left Side -->
                <!-- Start Mobile Right Side -->
                <div class="mobile-right-side">
                    <ul class="header-action-link d-flex align-items-center">
                        @if(Auth::check())
                                <!-- If isLoginMenu Then Show Menu User Box -->
                                <li class="nav-item dropdown">
                                    <button class="dropdown-toggle d-flex align-items-center" id="userNavbarDropdown1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="navbar-user-img-wrap position-relative">
                                    <img src="{{ isset(Auth::user()->photo) ? asset(IMG_USER_VIEW_PATH.Auth::user()->photo) : Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->toBase64()}}" alt="{{__('user')}}">
                                    <span class="user-verified-badge position-absolute"><i class="fas fa-check"></i></span>
                                </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userNavbarDropdown1">
                                        <div class="navbarUserDropdownInner d-flex align-items-center">
                                            <div class="navbar-user-img-wrap position-relative">
                                                <img src="{{ isset(Auth::user()->photo) ? asset(IMG_USER_VIEW_PATH.Auth::user()->photo) : Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->toBase64()}}" alt="{{__('user')}}">
                                                <span class="user-verified-badge position-absolute"><i class="fas fa-check"></i></span>
                                            </div>
                                        </div>
                                        <!-- Show If Wallet not connected after login -->
                                        <a href="{{route('my_wallets')}}" class="theme-button1 user-dropdown-nav-wallet w-100">{{__('My
                                            Wallets')}}</a>
                                        <!-- Show If Wallet not connected after login -->
                                        <a class="dropdown-item" href="{{route('login')}}"><i class="fas fa-tachometer-alt"></i>{{__('Dashboard')}}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{route('user_profile')}}"><i class="far fa-user"></i>{{__('My
                                            profile')}}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{route('my_collections')}}"><i class="far fa-image"></i>{{__('My
                                            Artworks')}}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{route('logOut')}}"><i class="fas fa-sign-in-alt"></i>{{__('Disconnect')}}</a>
                                    </div>
                                </li>
                                <!-- If isLoginMenu Then Show Menu User Box -->
                        @endif
                        <li>
                            <a href="#mobile-menu-offcanvas" class="offcanvas-toggle offside-menu">
                                <i class="fas fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Mobile Right Side -->
            </div>
        </div>
    </div>
</div>
<!-- End Mobile Header -->
<!--  Start Offcanvas Mobile Menu Section -->
<div id="mobile-menu-offcanvas" class="offcanvas offcanvas-rightside offcanvas-mobile-menu-section">
    <!-- Start Offcanvas Header -->
    <div class="offcanvas-header text-right">
        <button class="offcanvas-close">
            <img src="{{asset('assets/user/img/cancel.svg')}}" alt="{{__('cancel')}}" />
        </button>
    </div>
    <!-- End Offcanvas Header -->
    <!-- Start Offcanvas Mobile Menu Wrapper -->
    <div class="offcanvas-mobile-menu-wrapper">
        <!-- Start Mobile Menu  -->
        <div class="mobile-menu-bottom">
            <!-- Start Mobile Menu Nav -->
            <div class="offcanvas-menu">
                <ul>
                    <li><a href="{{route('discover')}}"><span>{{__('Discover')}}</span></a></li>
                    <li><a href="{{route('how-it-works')}}"><span>{{__('How It Works')}}</span></a></li>
                    <li><a href="{{route('news')}}"><span>{{__('News')}}</span></a></li>
                </ul>
            </div>
            <!-- End Mobile Menu Nav -->
            <!-- Offcanvas extra Info Wrap Start -->
            <div class="header-right-nav">
                <form class="mobile-search position-relative w-100">
                    <input type="text" placeholder="Search..." name="search" class="w-100">
                    <button type="button" class="nav-search menu-round-btn mobile-search-btn"><i class="fas fa-search"></i></button>
                </form>
                <ul>
                    @if(Auth::check() != true)
                        <li><a data-toggle="modal" href="#signInModal" class="theme-button1 nav-upload w-100">{{__('upload')}}</a></li>
                        <li><a data-toggle="modal" href="#signInModal" class="theme-button2 nav-wallet w-100">{{__('Connect
                            Wallet')}}</a></li>
                    @else
                        <li><a href="{{route('service_create')}}" class="theme-button1 nav-upload w-100">{{__('upload')}}</a></li>
                    @endif
                </ul>
            </div>
            <!-- Offcanvas extra Info Wrap End -->
        </div>
        <!-- End Mobile Menu -->
    </div>
    <!-- End Offcanvas Mobile Menu Wrapper -->
</div>
<!--  End Offcanvas Mobile Menu Section -->
