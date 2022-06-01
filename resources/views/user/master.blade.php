<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{__('Nftzai - NFT Marketplace HTML5 Responsive Template')}}">
    <meta name="keywords" content="{{__('crypto currency, currency, crypto, nft marketplace, NFT, nft, NFT marketplace')}}">
    <meta name="author" content="{{__('zainiktheme')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:type" content="{{__('Web Template')}}">
    <meta property="og:title" content="{{__('Nftzai - NFT Marketplace HTML5 Responsive Template')}}">
    <meta property="og:description" content="{{__('Nftzai - NFT Marketplace HTML5 Responsive Template')}}">
    <meta property="og:image" content="{{asset('assets/user/img/01_preview.png')}}">
    <meta name="twitter:card" content="{{__('zainiktheme')}}">
    <meta name="twitter:title" content="{{__('Nftzai - NFT Marketplace HTML5 Responsive Template')}}">
    <meta name="twitter:description" content="{{__('Nftzai - NFT Marketplace HTML5 Responsive Template')}}">
    <meta name="twitter:image" content="{{asset('assets/user/img/01_preview.png')}}">
    <meta name="msapplication-TileImage" content="{{asset('assets/user/img/01_preview.png')}}">
    <meta name="msapplication-TileColor" content="rgba(103, 20, 222,.55)">
    <meta name="theme-color" content="#69B756">
    @yield('style')
    <title>@yield('title') {{__('| Nftzai')}}</title>
    <!--=======================================
      All Css Style link
    ===========================================-->
    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/user/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets/user/css/jquery-ui.min.css')}}" rel="stylesheet">

    <!-- Font Awesome for this template -->
    <link href="{{asset('assets/user/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Flat Icon for this template -->
    <link href="{{asset('assets/user/vendor/flat-icon/flaticon.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- Animate Css-->
    <link rel="stylesheet" href="{{asset('assets/user/css/animate.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/user/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/owl.theme.default.min.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/vendor/datatable/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/vendor/datatable/css/responsive.dataTables.min.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/user/css/nice-select.css')}}">

    <!-- Custom styles for this template -->
    <link href="{{asset('assets/user/css/style.css')}}" rel="stylesheet">
    <!-- Extra CSS -->
    <link href="{{asset('assets/user/css/extra.css')}}" rel="stylesheet">

    <!-- Responsive Css-->
    <link rel="stylesheet" href="{{asset('assets/user/css/responsive.css')}}">

    @stack('post_styles')

    <!-- FAVICONS -->
    <link rel="icon" href="{{asset('assets/user/img/favicon-16x16.png')}}" type="image/png" sizes="16x16')}}">
    <link rel="shortcut icon" href="{{asset('assets/user/img/favicon-16x16.png')}}" type="image/x-icon')}}">
    <link rel="shortcut icon" href="{{asset('assets/user/img/favicon.png')}}">

    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/apple-icon-72x72.png')}}" sizes="72x72" />
    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/apple-icon-114x114.png')}}" sizes="114x114" />
    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/apple-icon-144x144.png')}}" sizes="144x144"/>
    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/favicon-16x16.png')}}" />

</head>
<body>
@include('user.message')
<!-- Pre Loader Area start -->
<div id="preloader">
    <div id="status"></div>
</div>
<!-- Pre Loader Area End -->

<!--Main Menu/Navbar Area Start -->

@include('user.menu')

<!-- Offcanvas Overlay -->
<div class="offcanvas-overlay"></div>
@yield('content')

@include('user.footer')
@include('user.modal')
<!-- ======================================
    All Jquery Script link
===========================================-->

<!-- Bootstrap core JavaScript -->
<script src="{{asset('assets/user/vendor/jquery/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/jquery/popper.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- ==== Plugin JavaScript ==== -->

<script src="{{asset('assets/user/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<script src="{{asset('assets/user/js/jquery-ui.min.js')}}"></script>

<!--WOW JS Script-->
<script src="{{asset('assets/user/js/wow.min.js')}}"></script>

<!--WayPoints JS Script-->
<script src="{{asset('assets/user/js/waypoints.min.js')}}"></script>

<!--Counter Up JS Script-->
<script src="{{asset('assets/user/js/jquery.counterup.min.js')}}"></script>

<script src="{{asset('assets/user/js/owl.carousel.min.js')}}"></script>

<!--Countdown Script-->
@if(Route::is('login'))
<script src="{{asset('assets/user/js/multi-countdown.js')}}"></script>
@endif

<!--niceSelect JS Script-->
<script src="{{asset('assets/user/js/jquery.nice-select.min.js')}}"></script>

<script src="{{asset('assets/user/js/TweenMax.min.js')}}"></script>

<!-- Range Slider -->
<script src="{{asset('assets/user/js/price_range_script.js')}}"></script>

<!-- Menu js -->
<script src="{{asset('assets/user/js/menu.js')}}"></script>

<!-- Datatables js -->
<script src="{{asset('assets/user/vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/datatable/js/dataTables.responsive.min.js')}}"></script>

<!-- Custom scripts for this template -->
<script src="{{asset('assets/user/js/custom.js')}}"></script>

<script src="{{asset('assets/user/js/qrcode.min.js')}}"></script>

<!-- Bootstrap core JavaScript -->
@include('user.common')
@yield('script')

</body>

</html>
