@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!--Main Menu/Navbar Area Start -->
    @include('user.components.dashboard-breadcumb')
    <!-- Connect Your Wallet Page Area start here  -->
    <div id="table-url" data-url="{{route('my_service_data')}}"></div>
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
                                <colgroup>
                                    <col class="first-col">
                                    <col class="second-col">
                                    <col class="third-col">
                                    <col class="fourth-col">
                                    <col class="fifth-col">
                                    <col class="sixth-col">
                                    <col class="seventh-col">
                                </colgroup>

                                <thead>
                                <tr>
                                    <th class="all">{{__('Title')}}</th>
                                    <th class="none">{{__('Description')}}</th>
                                    <th class="none">{{__('Mint Address')}}</th>
                                    <th class="all">{{__('Category')}}</th>
                                    <th class="all">{{__('Type')}}</th>
                                    <th class="none">{{__('Available Stock')}}</th>
                                    <th class="all">{{__('Price')}}</th>
                                    <th class="none">{{__('Bid Amount (In USD)')}}</th>
                                    <th class="none">{{__('Views')}}</th>
                                    <th class="none">{{__('Likes')}}</th>
                                    <th class="all">{{__('Thumbnail')}}</th>
                                    <th class="none">{{__('Comment')}}</th>
                                    <th class="all">{{__('Status')}}</th>
                                    <th class="all">{{__('Action')}}</th>
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
    <script src="{{asset('assets/user/js/datatables/my-service-data.js')}}"></script>
@endsection
