@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!-- Page Banner Area start here  -->
    <section class="page-banner-area p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? asset(IMG_STATIC_PATH.'page-banner.png') : asset(IMG_PATH.allsetting()['dashboard_image'])}});">
        <div class="container">
            <!-- Page Banner element -->
            <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="{{__('dot')}}"></div>
            <!-- Page Banner element -->
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{__('Explore')}}</h1>
                        <p class="page-banner-para">{{__('Newly listed assets are the hottest crypto assets that are rocking
                            the market')}}</p>
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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Explore')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->
    <!-- northern light carousel Area Start -->
    <section class="northern-light-area place-a-bid-page main-items-area section-t-space section-b-90-space">
        <div class="container">
            <div class="main-items-carousel">
                <div class="main-items-carousel position-relative">
                    <!-- main item slider start -->
                    <div class="main-item">
                        <div class="row">
                            @if ($service->type == 1)
                                <div class="col-12 col-md-12 col-lg-5">
                                    <div class="main-item-content-part">
                                        <h2 class="section-heading">{{$service->title}}</h2>
                                        <div class="main-item-views-love d-flex align-items-center justify-content-between">
                                            <div class="main-item-views-part d-flex align-items-center">
                                                <span>{{__('Views:')}} {{$service->views}}</span>
                                                <span>{{__('Sell:')}} {{transferCount($service->id)}} {{__('Times')}}</span>
                                            </div>
                                            <div class="main-item-love-part">
                                                <button class="color-red" id="like_now"><i class="{{liked($service->id) == 0 ? 'far' : 'fas' }} fa-heart"></i></button> <span class="font-weight-bold color-heading" id="like_count">{{$service->like}}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="likeable" value="{{liked($service->id) == 0 ? 1 : 0 }}">
                                        <input type="hidden" value="{{route('service_like_store')}}" id="s-like-store">
                                        <input type="hidden" value="{{route('service_like_delete')}}" id="s-like-remove">
                                        <input type="hidden" value="{{$service->id}}" id="sid">
                                        <!-- Main Item Leftside Box Start -->
                                        <div class="main-item-leftside-box">
                                            <div class="current-bid-box">
                                                <p class="font-weight-bold color-heading">{{__('Address: ')}}</p>
                                                <a href="{{MINT_URL.$service->mint_address}}" target="_blank">{{$service->mint_address}}</a>
                                                <p class="font-weight-bold color-heading">{{__('Price')}}</p>
                                                <div class="bid-price-box">
                                                    <h2>{{visual_number_format($service->price_dollar)}} <span class="bid-small-price">{{__('USD')}}</span></h2>
                                                </div>
                                            </div>
                                            <div class="owner-creator-box">
                                                @if ($service->is_resellable == 1)
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->resell_service->author->photo) ? Avatar::create($service->resell_service->author->first_name.' '.$service->resell_service->author->last_name)->toBase64() : asset(IMG_USER_PATH.$service->resell_service->author->photo)}}" alt="{{__('creator')}}">
                                                        <h6>{{$service->resell_service->author->first_name.' '.$service->resell_service->author->last_name}}</h6>
                                                        <p>{{__('Creator')}}</p>
                                                    </div>
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->author->photo) ? Avatar::create($service->author->first_name.' '.$service->author->last_name)->toBase64() : asset(IMG_USER_PATH.$service->author->photo)}}" alt="{{__('creator')}}">
                                                        <h6>{{$service->author->first_name.' '.$service->author->last_name}}</h6>
                                                        <p>{{__('Owner')}}</p>
                                                    </div>
                                                @else
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->author->photo) ? Avatar::create($service->author->first_name.' '.$service->author->last_name)->toBase64() : asset(IMG_USER_PATH.$service->author->photo)}}" alt="{{__('creator')}}">
                                                        <h6>{{$service->author->first_name.' '.$service->author->last_name}}</h6>
                                                        <p>{{__('Creator')}}</p>
                                                    </div>
                                                @endif
                                                @if (isset($service->buyer_id))
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->buyer->photo) ? Avatar::create($service->buyer->first_name.' '.$service->buyer->last_name)->toBase64() : asset(IMG_USER_PATH.$service->buyer->photo)}}" alt="{{__('owner')}}">
                                                        <h6>{{$service->buyer->first_name.' '.$service->buyer->last_name}}</h6>
                                                        <p>{{__('New Owner')}}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <!-- Main Item Leftside Box End -->
                                        <!-- Main Item Leftside Box Start -->
                                        <div class="main-item-leftside-box">
                                            <div class="highest-bid-box d-flex align-items-center justify-content-between">
                                                <div class="highest-box-item d-flex align-items-center">
                                                    <img src="{{asset('assets/user/img/main-item-img/color-icon.png')}}" alt="{{__('bid')}}">
                                                    <div class="highest-box-text">
                                                        <p>{{__('Color')}}</p>
                                                        <h6>{{$service->color}}</h6>
                                                    </div>
                                                </div>
                                                <div class="highest-box-item d-flex align-items-center">
                                                    <img src="{{asset('assets/user/img/main-item-img/country-icon.png')}}" alt="{{__('bid')}}">
                                                    <div class="highest-box-text">
                                                        <p>{{__('Origin')}}</p>
                                                        <h6>{{$service->origin}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-item-btn-box">
                                                @if (slodOutMessage($service->id) != 1)
                                                    @if (Auth::check() == true && Auth::user()->role == USER_ROLE_USER )
                                                        @if ($service->created_by == Auth::id())
                                                            <button class="theme-button1 w-100" data-toggle="modal" data-target="#purchaseNotModal">
                                                                {{__('Purchase')}}</button>
                                                        @else
                                                            <button class="theme-button1 w-100" data-toggle="modal" data-target="#purchase1Modal">
                                                                {{__('Purchase')}}</button>
                                                        @endif
                                                    @else
                                                        <button class="theme-button1 w-100" data-toggle="modal" data-target="#notAuthModal">
                                                            {{__('Purchase')}}</button>
                                                    @endif
                                                @else
                                                    <button class="theme-button1 w-100 disabled">
                                                        {{$service->buyer_id == Auth::id() ? __('You Buy This Product') :__('Stock Out')}}
                                                    </button>
                                                @endif

                                            </div>
                                            <p class="main-item-box-condition text-center">
                                                <span class="font-semi-bold">{{__('Transfer History')}}</span>
                                                <span><button data-toggle="modal" href="#transactionHistoryModal{{$service->id}}">{{__('Click Here')}}</button></span>
                                            </p>
                                        </div>
                                        <!-- Main Item Leftside Box End -->
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-7">
                                    <div class="main-item-img-part position-relative d-flex justify-content-center">
                                        <div class="main-item-img">
                                            <img src="{{asset(IMG_SERVICE_PATH.$service->thumbnail)}}" alt="{{__('item')}}">
                                        </div>
                                        <!-- Main Item upper box start -->
                                        <div class="main-item-upper-box position-absolute w-100 d-flex justify-content-between">
                                            <!-- Main Item upper left -->
                                            <div class="main-item-upper-left">
                                                <span class="badge badge-pill">{{$service->category->title}}</span>
                                                @if($service->is_unlockable == 1)
                                                    <span class="badge badge-pill">{{__('Unlockable')}}</span>
                                                @endif
                                            </div>
                                            <!-- Main Item upper right -->
                                        </div>

                                        <!-- Main Item upper box end -->

                                        <!-- Countdown box start -->
                                        <div class="countdown-box position-absolute">
                                            <span class="bg-green time-remaining">{{('Expired Date')}}</span>
                                            <div class="countdown">
                                                <input type="hidden" value="{{\Carbon\Carbon::parse($service->expired_at)->format('M j, Y H:i:s')}}" class="expired_time">
                                                <div class="timer-down-wrap"><span class="days">{{__('06')}}</span><span class="timing-title">{{__('Days')}}</span></div>
                                                <div class="timer-down-wrap"><span class="hours">{{__('06')}}</span><span class="timing-title">{{__('Hrs')}}</span></div>
                                                <div class="timer-down-wrap"><span class="minutes">{{__('35')}}</span><span class="timing-title">{{__('Min')}}</span></div>
                                                <div class="timer-down-wrap"><span class="seconds">{{__('54')}}</span><span class="timing-title">{{__('Sec')}}</span></div>
                                            </div>
                                        </div>
                                        <!-- Countdown box end -->
                                    </div>
                                </div>
                            @elseif($service->type == 2)
                                <div class="col-12 col-md-12 col-lg-5">
                                    <div class="main-item-content-part">
                                        <h2 class="section-heading">{{$service->title}}</h2>
                                        <div class="main-item-views-love d-flex align-items-center justify-content-between">
                                            <div class="main-item-views-part d-flex align-items-center">
                                                <span>{{__('Views:')}} {{$service->views}}</span>
                                                <span>{{__('Sell:')}} {{transferCount($service->id)}} {{__('Times')}}</span>
                                            </div>
                                            <div class="main-item-love-part">
                                                <button class="color-red" id="like_now"><i class="{{liked($service->id) == 0 ? 'far' : 'fas' }} fa-heart"></i></button> <span class="font-weight-bold color-heading" id="like_count">{{$service->like}}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="likeable" value="{{liked($service->id) == 0 ? 1 : 0 }}">
                                        <!-- Main Item Leftside Box Start -->
                                        <div class="main-item-leftside-box">
                                            <div class="current-bid-box">
                                                <p class="font-weight-bold color-heading">{{__('Address: ')}}</p>
                                                <a href="{{MINT_URL.$service->mint_address}}" target="_blank">{{$service->mint_address}}</a>
                                                <p class="font-weight-bold color-heading">{{__('Min Bid Amount')}}</p>
                                                <div class="bid-price-box">
                                                    <h2>{{visual_number_format($service->min_bid_amount) }} <span class="bid-small-price">{{__('USD')}}</span></h2>
                                                </div>
                                            </div>
                                            <div class="owner-creator-box">
                                                @if ($service->is_resellable == 1)
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->resell_service->author->photo) ? Avatar::create($service->resell_service->author->first_name.' '.$service->resell_service->author->last_name)->toBase64() : asset(IMG_USER_PATH.$service->resell_service->author->photo)}}" alt="{{__('creator')}}">
                                                        <h6>{{$service->resell_service->author->first_name.' '.$service->resell_service->author->last_name}}</h6>
                                                        <p>{{__('Creator')}}</p>
                                                    </div>
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->author->photo) ? Avatar::create($service->author->first_name.' '.$service->author->last_name)->toBase64() : asset(IMG_USER_PATH.$service->author->photo)}}" alt="{{__('creator')}}">
                                                        <h6>{{$service->author->first_name.' '.$service->author->last_name}}</h6>
                                                        <p>{{__('Owner')}}</p>
                                                    </div>
                                                @else
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->author->photo) ? Avatar::create($service->author->first_name.' '.$service->author->last_name)->toBase64() : asset(IMG_USER_PATH.$service->author->photo)}}" alt="{{__('creator')}}">
                                                        <h6>{{$service->author->first_name.' '.$service->author->last_name}}</h6>
                                                        <p>{{__('Creator')}}</p>
                                                    </div>
                                                @endif
                                                <div class="owner-box">
                                                    <img src="{{asset('assets/user/img/main-item-img/bid-avatar.png')}}" alt="{{__('owner')}}">
                                                    <h6>{{highestBidService($service->id)}} {{__('USD')}}</h6>
                                                    <p>{{__('Highest Bid')}}</p>
                                                </div>
                                                <div class="owner-box">
                                                    <img src="{{asset('assets/user/img/main-item-img/bid-avatar.png')}}" alt="{{__('owner')}}">
                                                    <h6>{{countBidService($service->id)}} </h6>
                                                    <p>{{__('All Bids')}}</p>
                                                </div>
                                                @if (isset($service->buyer_id))
                                                    <div class="owner-box">
                                                        <img src="{{is_null($service->buyer->photo) ? Avatar::create($service->buyer->first_name.' '.$service->buyer->last_name)->toBase64() : asset(IMG_USER_PATH.$service->buyer->photo)}}" alt="{{__('owner')}}">
                                                        <h6>{{$service->buyer->first_name.' '.$service->buyer->last_name}}</h6>
                                                        <p>{{__('Owner')}}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Main Item Leftside Box End -->
                                        <!-- Main Item Leftside Box Start -->
                                        <div class="main-item-leftside-box">
                                            <div class="highest-bid-box d-flex align-items-center justify-content-between">
                                                <div class="highest-box-item d-flex align-items-center">
                                                    <img src="{{asset('assets/user/img/main-item-img/color-icon.png')}}" alt="{{__('bid')}}">
                                                    <div class="highest-box-text">
                                                        <p>{{__('Color')}}</p>
                                                        <h6>{{$service->color}}</h6>
                                                    </div>
                                                </div>
                                                <div class="highest-box-item d-flex align-items-center">
                                                    <img src="{{asset('assets/user/img/main-item-img/country-icon.png')}}" alt="{{__('bid')}}">
                                                    <div class="highest-box-text">
                                                        <p>{{__('Origin')}}</p>
                                                        <h6>{{$service->origin}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-item-btn-box">
                                                <!-- If Wallet connected then show it -->
                                                @if (slodOutMessage($service->id) != 1)
                                                    @if (Auth::check() == true && Auth::user()->role == USER_ROLE_USER )
                                                        @if ($service->created_by == Auth::id())
                                                            <button class="theme-button1 w-100" data-toggle="modal" data-target="#purchaseNotModal">
                                                                {{__('Place a Bid')}}</button>
                                                        @else
                                                            <button class="theme-button1 w-100" data-toggle="modal" data-target="#purchase1Modal">
                                                                {{__('Place a Bid')}}</button>
                                                        @endif
                                                    @else
                                                        <button class="theme-button1 w-100" data-toggle="modal" data-target="#notAuthModal">
                                                            {{__('Place a Bid')}}</button>
                                                    @endif
                                                @else
                                                    <button class="theme-button1 w-100 disabled">
                                                        {{$service->buyer_id == Auth::id() ? __('You Buy This Product') :__('Stock Out')}}
                                                    </button>
                                                @endif

                                            </div>
                                            <p class="main-item-box-condition text-center">
                                                <span class="font-semi-bold">{{__('Transfer History')}}</span>
                                                <span><button data-toggle="modal" href="#transactionHistoryModal{{$service->id}}">{{__('Click Here')}}</button></span>
                                            </p>
                                        </div>
                                        <!-- Main Item Leftside Box End -->
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-7">
                                    <div class="main-item-img-part position-relative d-flex justify-content-center">
                                        <div class="main-item-img">
                                            <img src="{{asset(IMG_SERVICE_PATH.$service->thumbnail)}}" alt="{{__('item')}}">
                                        </div>
                                        <!-- Main Item upper box start -->
                                        <div class="main-item-upper-box position-absolute w-100 d-flex justify-content-between">
                                            <!-- Main Item upper left -->
                                            <div class="main-item-upper-left">
                                                <span class="badge badge-pill">{{$service->category->title}}</span>
                                                @if($service->is_unlockable == 1)
                                                    <span class="badge badge-pill">{{__('Unlockable')}}</span>
                                                @endif
                                            </div>
                                            <!-- Main Item upper right -->
                                        </div>
                                        <!-- Main Item upper box end -->
                                        <!-- Countdown box start -->
                                        <div class="countdown-box position-absolute">
                                            <span class="bg-green time-remaining">{{__('Expired Date')}}</span>
                                            <div class="countdown">
                                                <input type="hidden" value="{{\Carbon\Carbon::parse($service->expired_at)->format('M j, Y H:i:s')}}" class="expired_time">
                                                <div class="timer-down-wrap"><span class="days">{{__('06')}}</span><span class="timing-title">{{__('Days')}}</span></div>
                                                <div class="timer-down-wrap"><span class="hours">{{__('06')}}</span><span class="timing-title">{{__('Hrs')}}</span></div>
                                                <div class="timer-down-wrap"><span class="minutes">{{__('35')}}</span><span class="timing-title">{{__('Min')}}</span></div>
                                                <div class="timer-down-wrap"><span class="seconds">{{__('54')}}</span><span class="timing-title">{{__('Sec')}}</span></div>
                                            </div>
                                        </div>
                                        <!-- Countdown box end -->
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- main item slider end -->
                </div>
            </div>
        </div>
    </section>
    <!-- northern light carousel Area End -->
    <div class="modal fade common-modal" id="transactionHistoryModal{{$service->id}}" tabindex="-1" aria-labelledby="transactionHistoryModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header p-0">
                        <h4 class="withdrawal-header modal-title">{{__('Transfer History')}}</h4>
                        <span class="fas fa-close">
                    </span>
                    </div>
                    <div class="modal-body p-0 pt-2 w-ajax-alert">
                        <div class="table-responsive">
                            <table id="serviceList" class="table table-striped table-bordered data-table display responsive">
                                <thead>
                                <tr>
                                    <th class="all">{{__('Previous Token')}}</th>
                                    <th class="all">{{__('New Token')}}</th>
                                    <th class="none">{{__('Transfer Date')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse(transferHistory($service->id) as $ats)
                                    <tr>
                                        <td><a href="{{MINT_URL.$ats->prev_mint_address}}">{{Str::limit($ats->prev_mint_address, 10, '...')}}</a></td>
                                        <td><a href="{{MINT_URL.$ats->new_mint_address}}">{{Str::limit($ats->new_mint_address, 10, '...')}}</a></td>
                                        <td>{{\Carbon\Carbon::parse($ats->created_at)->format('m-d-Y')}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">{{__('No Transfer Found!')}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')
    <script src="{{asset('assets/user/js/multi-countdown.js')}}"></script>
@if (Auth::check() && Auth::user()->role == 2)
    <script src="{{asset('assets/user/js/pages/product-view.js')}}"></script>
@endif
@endsection
