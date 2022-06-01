@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    @include('user.components.dashboard-breadcumb')
    <div id="table-url" data-url="{{route('deposit_data')}}"></div>
    <section class="profile-page-area section-t-space section-b-90-space">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="search-sidebar-wrap user-profile-sidebar-wrap">
                    @include('user.components.user-sidebar')
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="search-rightside-area">
                        <div class="table-responsive">
                            <table id="serviceList" class="user-dashboard-table table table-striped table-bordered data-table display responsive">
                                <thead>
                                <tr>
                                    <th class="all">{{__('Wallet')}}</th>
                                    <th class="all">{{__('Amount')}}</th>
                                    <th class="all">{{__('Address')}}</th>
                                    <th class="all">{{__('Transaction Hash')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{asset('assets/user/js/datatables/deposit-data.js')}}"></script>
@endsection
