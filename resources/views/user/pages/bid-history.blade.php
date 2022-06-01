@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    @include('user.components.dashboard-breadcumb')
    <div id="table-url" data-url="{{route('bid_history')}}"></div>
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
                                    <th class="all">{{__('ID')}}</th>
                                    <th class="none">{{__('Title')}}</th>
                                    <th class="none">{{__('Description')}}</th>
                                    <th class="all">{{__('Bid Amount(USD)')}}</th>
                                    <th class="all">{{__('Highest Bid')}}</th>
                                    <th class="all">{{__('Thumbnail')}}</th>
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
            </div>
        </div>
    </section>
    @foreach($services as $service)
        <div class="modal fade common-modal" id="resellModal{{$service->service_id}}" tabindex="-1" aria-labelledby="resellModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header p-0">
                        <h4 class="withdrawal-header modal-title">{{__('Resell Product')}}</h4>
                        <span class="fas fa-close">
                    </span>
                    </div>
                    <div class="modal-body p-0 w-ajax-alert">
                        <form action="{{route('resell_service', encrypt($service->service_id))}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <label for="type">{{__('Type')}}</label>
                                        <select name="type" class="form-control" id="type" required>
                                            <option value="">{{__('---SELECT TYPE---')}}</option>
                                            <option value="{{FIXED_PRICE}}">{{__('Fixed Price')}}</option>
                                            <option value="{{BID_PRICE}}">{{__('Bid')}}</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group d-none" id="price_dollar_d">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <label for="type">{{__('Price')}}</label>
                                        <input class="form-control" placeholder="{{__('New Price')}}" name="price_dollar" value="0" id="price_dollar" step="0.01" type="number" min="0" max="9999">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none" id="min_bid_price_d">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <label for="type">{{__('Minimum Bid Amount')}}</label>
                                        <input class="form-control" placeholder="{{__('Minimum Bid')}}" name="min_bid_price" id="min_bid_price" value="0.01" step="0.01" type="number" min="0" max="9999">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none" id="max_bid_price_d">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <label for="type">{{__('Maximum Bid Amount')}}</label>
                                        <input class="form-control" placeholder="{{__('Maximum Bid')}}" name="max_bid_price" id="max_bid_price" value="999999" step="0.01" type="number" min="0" max="999999">
                                    </div>
                                </div>
                            </div>
                            <div class="sign-up-button-part">
                                <button type="submit"  class="theme-button1 d-none" id="f-submit">{{__('Submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('script')
    <script src="{{asset('assets/user/js/datatables/bid-history.js')}}"></script>
    <script src="{{asset('assets/user/js/pages/init-resell.js')}}"></script>
@endsection
