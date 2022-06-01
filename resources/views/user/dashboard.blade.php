@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/dist/js/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/dist/js/modal.css')}}">
@endsection
@section('content')
    <!--Main Menu/Navbar Area Start -->
    @include('user.components.dashboard-breadcumb')
    <!-- Connect Your Wallet Page Area start here  -->
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
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="card user-dashboard-page-card mb-3">
                                    <div class="card-header">{{__('Deposit')}}</div>
                                    <div class="card-body">
                                        <h1 class="card-title mb-0">{{visual_number_format($deposit_sum)}}</h1>
                                        <div class="user-dashboard-card-icon">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                    </div>
                                    <a href="{{route('deposit_data')}}" class="card-footer text-muted">
                                        More Info <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card user-dashboard-page-card mb-3">
                                    <div class="card-header">{{__('Withdraw')}}</div>
                                    <div class="card-body">
                                        <h1 class="card-title mb-0">{{visual_number_format($withdraw_sum)}}</h1>
                                        <div class="user-dashboard-card-icon">
                                            <i class="far fa-chart-bar"></i>
                                        </div>
                                    </div>
                                    <a href="{{route('withdraw_data')}}" class="card-footer text-muted">
                                        More Info <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card user-dashboard-page-card mb-3">
                                    <div class="card-header">{{__('Purchase')}}</div>
                                    <div class="card-body">
                                        <h1 class="card-title mb-0">{{$purchase_sum}}</h1>
                                        <div class="user-dashboard-card-icon">
                                            <i class="fas fa-store"></i>
                                        </div>
                                    </div>
                                    <a href="{{route('purchase_history')}}" class="card-footer text-muted">
                                        More Info <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card user-dashboard-page-card mb-3">
                                    <div class="card-header">{{__('Products')}}</div>
                                    <div class="card-body">
                                        <h1 class="card-title mb-0">{{$service_sum}}</h1>
                                        <div class="user-dashboard-card-icon">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                    </div>
                                    <a href="{{route('my_service_data')}}" class="card-footer text-muted">
                                        More Info <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if (count($offchainList) != 0)
                        <table class="table table-striped table-dark">
                            <thead>
                            <tr class="tran">
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Chain setting</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="transactions">
                            @foreach($offchainList as $item)
                                <tr>
                                    <td><img src="{{'/uploaded_file/services/'.$item->thumbnail}}" width="50px"></td>
                                    <td>{{$item->title}}</td>
                                    <td><p class="chaintitle">Off Chain</p></td>
                                    <td>{{$item->created_at}}</td>
                                    <td><button class="btn btn-primary myBtn" onclick="deploy({{$item->id}}, {{$item->price_dollar}}, {{$wid}})" style="padding:5px">Deploy</button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                        <div id="myModal" class="modal">
                            <div class="modal-content" style="width: 50%; padding: 1px">
                                <div class="modal-header">
                                    <span class="close">&times;</span>
                                    <h2>&nbsp;</h2>
                                </div>
                                <div class="modal-body">
                                    <div style="text-align:center" class="yet-create"><p style="font-size:23px;color:red;font-weight:bold">Enter Your Mint Address and Chain Network</p></div>
                                    <div class="form-group">
                                        <label for="item-name">{{__('Mint Address')}}</label>
                                        <input type="text" class="form-control" id="mintAddress" name="mintAddress" placeholder="{{__('Enter Your Mint_Address')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="video_link">{{__('Chain Type')}} </label>
                                        <select class="form-control" id="chainNet" name="chainNetchainNet">
                                            <option value="">{{__('---SELECT CHAIN---')}}</option>
                                            @foreach (coinListUser() as $wallet)
                                                <option value="{{$wallet->id}}">{{$wallet->coin->full_name.' ('.$wallet->coin->coin_type.')'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="text-align: center; display: none" id="paymentInfo">
                                        <div>
                                            <p style="font-weight: bold; color: blue; font-size: 18px; display: inline-block">Service fee:</p> <p style="display: inline-block;font-weight: bold" id="balance"></p>
                                            <hr />
                                        </div>
                                        <div>
                                            <p style="font-weight: bold; color: blue; font-size: 18px; display: inline-block">Gas fee:</p> <p style="display: inline-block;font-weight: bold" id="service-fee"></p>
                                            <hr />
                                        </div>
                                        <div>
                                            <p style="font-weight: bold; color: blue; font-size: 18px; display: inline-block">Total Pay:</p> <p style="display: inline-block;font-weight: bold" id="pay"></p>
                                            <hr />
                                        </div>
                                    </div>
                                    <div style="text-align: right">
                                        <button class="btn btn-primary" style="padding:10px" onclick="DeployNFT()" id="createWallet">Deploy NFT</button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <h3>&nbsp;</h3>
                                </div>
                            </div>
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
    <script src="{{asset('assets/admin/dist/js/toastr.min.js')}}"></script>
    <script src="{{asset('assets/admin/dist/js/pages/users/custom.js')}}"></script>
@endsection
