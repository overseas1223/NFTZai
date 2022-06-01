@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!--Main Menu/Navbar Area Start -->
    @include('user.components.dashboard-breadcumb')
    <!-- Connect Your Wallet Page Area start here  -->
    <div id="table-url" data-url="{{route('my_earnings')}}"></div>
    <div id="table-urlbid" data-urlbid="{{route('my_earnings_bid')}}"></div>
    <section class="profile-page-area section-t-space section-b-90-space">
        <div class="container">
            <div class="row">
                <!-- Profile Sidebar Area Start -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="search-sidebar-wrap user-profile-sidebar-wrap">
                        <!-- User Dashboard Sidebar Menu Start-->
                    @include('user.components.user-sidebar')
                    <!-- User Dashboard Sidebar Menu End -->
                    </div>
                </div>
                <!-- Profile Sidebar Area End -->
                <!-- Profile rightside Area -->
                <div class="col-12 col-md-8 col-lg-9">
                    <h1 class="page-banner-title mb-4">{{__('Fixed Purchase Earnings - '.visual_number_format($purchase_earning).__(' USD'))}}</h1>
                    <div class="search-rightside-area">
                        <div class="table-responsive">
                            <table id="serviceList" class="user-dashboard-table table table-striped table-bordered data-table display responsive">
                                <thead>
                                <tr>
                                    <th class="all">{{__('Artwork')}}</th>
                                    <th class="all">{{__('Thumb')}}</th>
                                    <th class="all">{{__('Buyer')}}</th>
                                    <th class="all">{{__('Earning (in USD)')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <h1 class="page-banner-title mt-4 mb-4">{{__('Bid Purchase Earnings - '.visual_number_format($bid_earning).__(' USD'))}}</h1>
                    <div class="search-rightside-area">
                        <div class="table-responsive">
                            <table id="bidserviceList" class="user-dashboard-table table table-striped table-bordered data-table display responsive">
                                <thead>
                                <tr>
                                    <th class="all">{{__('Artwork')}}</th>
                                    <th class="all">{{__('Thumb')}}</th>
                                    <th class="all">{{__('Buyer')}}</th>
                                    <th class="all">{{__('Earning (in USD)')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Profile rightside Area -->
            </div>
        </div>
    </section>
    <!-- Connect Your Wallet Page Area end here  -->
@endsection
@section('script')
    <script src="{{asset('assets/user/js/datatables/my-earnings.js')}}"></script>
@endsection
