@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!--Main Menu/Navbar Area Start -->
    @include('user.components.dashboard-breadcumb')
    <!-- Connect Your Wallet Page Area start here  -->
    <div id="table-url" data-url="{{route('withdraw_data')}}"></div>
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
                    <div class="search-rightside-area">
                        <div class="table-responsive">
                            <table id="serviceList" class="user-dashboard-table table table-striped table-bordered data-table display responsive">
                                <thead>
                                <tr>
                                    <th class="all">{{__('Wallet')}}</th>
                                    <th class="all">{{__('Wallet (Receiver)')}}</th>
                                    <th class="all">{{__('Address')}}</th>
                                    <th class="all">{{__('Transaction Hash')}}</th>
                                    <th class="all">{{__('Amount')}}</th>
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
    <script src="{{asset('assets/user/js/pages/withdraw-data.js')}}"></script>
@endsection
