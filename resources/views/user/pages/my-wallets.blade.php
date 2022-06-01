@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    @include('user.components.dashboard-breadcumb')
    <!-- Profile Page Area start here  -->
    <div id="deposit-url" data-url="{{route('get_wallet_address')}}"></div>
    <section class="profile-page-area section-t-space section-b-90-space">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="search-sidebar-wrap user-profile-sidebar-wrap">
                        @include('user.components.user-sidebar')
                    </div>
                </div>
                <!-- Profile rightside Area -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="search-rightside-area">
                        <div class="table-responsive">
                            <table id="serviceList" class="table table-striped table-bordered data-table display responsive">
                                <thead>
                                <tr>
                                    <th class="all">{{__('Coin Name')}}</th>
                                    <th class="all">{{__('Type')}}</th>
                                    <th class="none">{{__('Address')}}</th>
                                    <th class="all">{{__('Balance')}}</th>
                                    <th class="all">{{__('On Hold Balance')}}</th>
                                    <th class="all">{{__('Last Update')}}</th>
                                    <th class="all">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($wallets as $wallet)
                                        <tr>
                                            <td>{{$wallet->coin->full_name}}</td>
                                            <td>{{$wallet->coin->coin_type}}</td>
                                            <td>{{$wallet->address}}</td>
                                            <td>{{visual_number_format($wallet->balance)}}</td>
                                            <td>{{visual_number_format($wallet->on_hold)}}</td>
                                            <td>{{ \Carbon\Carbon::parse($wallet->updated_at)->diffForHumans() }}</td>
                                            <td>
                                                <ul class="d-flex justify-content-center align-items-center my-wallet-actions-btn">
                                                    <li>
                                                        <button data-toggle="modal" data-wallet_id="{{$wallet->id}}" data-address="{{$wallet->address}}" data-coin="{{$wallet->coin->coin_type}}" href="#depositModal"  title="{{__('Deposit')}}" class="deposit-btn btn btn-success"><i class="fas fa-arrow-down"></i> </button>
                                                    </li>
                                                    <li>
                                                        <button data-toggle="modal" data-wallet_id="{{$wallet->id}}"  title="{{__('withdraw')}}" data-coin="{{$wallet->coin->coin_type}}" class="withdrawal-btn btn btn-danger" href="#withdrawalModal"><i class="fas fa-arrow-up"></i> </button>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('activity_log', $wallet->coin_id)}}" title="{{__('Activity log')}}" class="btn btn-info"><i class="fas fa-list"></i> </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>{{__('No Data Found!')}}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Profile rightside Area -->
            </div>
        </div>
    </section>
    <!-- deposit modal  -->
    <div class="modal fade common-modal" id="depositModal" tabindex="-1" aria-labelledby="depositModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h4 class="deposit-header modal-title">{{__('Calculating...')}}</h4>
                    <span class="fas fa-close">
                    </span>
                </div>
                <div class="modal-body p-0">
                    <div class="deposit-modal-content">
                        <p class="pb-3">{{__('Please use this Coin exactly as displayed')}}</p>
                        <p class="pb-3 depositAddress"></p>
                        <div id="qrcode" class="deposit-qr pb-3">
                        </div>
                        <div class="creator-not-verified d-flex justify-content-center align-items-center mb-0">
                            <div class="creator-not-verified-left"><i class="fas fa-exclamation"></i></div>
                            <div class="creator-not-verified-right">
                                <p class="font-medium note noteDanger">{{__('Calculating...')}}</p>
                                <p class="font-12 paraText send-text">{{__('Sending any others currency to this address may result in this loss of your deposit')}}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade common-modal" id="withdrawalModal" tabindex="-1" aria-labelledby="withdrawalModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h4 class="withdrawal-header modal-title">{{__('Calculating...')}}</h4>
                    <span class="fas fa-close">
                    </span>
                </div>
                <div class="modal-body p-0 w-ajax-alert">
                    {{Form::open(['route' => 'withdrawal_coin', 'files' => true, 'data-handler'=>"withdrawalCallback" ,'class' => 'ajax-withdrawal'])}}
                    <div class="w-alert-body"></div>
                    <input class="wallet_id form-control" name="wallet_id" type="hidden" value="">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <input class="w-address form-control" placeholder="{{__('Address')}}" name="address" type="text" required>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <input class="w-amount form-control" placeholder="{{__('Amount')}}" name="amount" type="text" required>
                                </div>
                                <div class="col-12 pt-3">
                                    <div class="creator-not-verified d-flex justify-content-center align-items-center mb-0">
                                        <div class="creator-not-verified-left"><i class="fas fa-exclamation"></i></div>
                                        <div class="creator-not-verified-right">
                                            <p class="font-medium paraText w-notice">{{__('Note : You Are About To withdrawal')}}</p>
                                            <p class="font-12 paraText">{{__('Sending any others currency to this address may result in this loss of your deposit')}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <div class="sign-up-button-part">
                        <button type="submit"  class="theme-button1">{{__('Submit')}}</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade common-modal" id="withdrawalConfirmModal" tabindex="-1" aria-labelledby="withdrawalConfirmModal" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h4 class="withdrawal-confirm-header modal-title">{{__('Put the code below')}}</h4>
                    <span class="fas fa-close">
                    </span>
                </div>
                <div class="modal-body wc-ajax-alert">
                    {{Form::open(['route' => 'withdrawal_two_fa_coin', 'files' => true, 'data-handler'=>"showMessage" ,'class' => 'ajax'])}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <input class="w-code form-control" placeholder="{{__('Code Here')}}" name="w-code" type="text" required>
                                    <input id="w-hash" class="w-hash form-control"  name="w-hash" type="hidden">
                                </div>
                                <div class="col-12 pt-3">
                                    <span class="paraText wc-notice"> {{__('check your email and put the following code here')}} </span>
                                    <input class="wallet_id form-control" name="wallet_id" type="hidden">
                                </div>
                            </div>
                        </div>
                    <div class="sign-up-button-part">
                        <button type="submit"  class="theme-button1">{{__('Submit')}}</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('assets/user/js/pages/my-wallets.js')}}"></script>
@endsection
