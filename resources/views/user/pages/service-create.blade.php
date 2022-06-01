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
                        <h1 class="page-banner-title">{{__('Upload Artwork')}}</h1>
                        <p class="page-banner-para">{{__('Choose you want your collectible to be one of a kind or if you want
                            to sell one collectible multiple times')}}
                        </p>
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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Upload Artwork')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->
    <!-- Upload Page Area start here  -->
    <section class="create-new-page-area section-t-space">
        <div class="container">
            {{Form::open(['route' => 'service_store', 'files' => true, 'data-handler'=>"showMessage" ,'class' => 'ajax', 'id' => 'CreateNFT'])}}
                <div class="row">
                    <div class="col-12 col-md-7 col-lg-7">
                        <!-- Create New Box Start -->
                        <div class="create-new-page-box">
                            <h6 class="create-new-page-box-title font-weight-bold">{{__('Item Details')}}</h6>
                            <div class="form-group">
                                <label for="item-name">{{__('Service Type')}}</label>
                                <div class="common-radio d-flex align-items-center">

                                    <div class="radiobox-wrap">
                                        <label class="custom-radio" for="type1">
                                            <input id="type1" type="radio" name="type" value="{{FIXED_PRICE}}">

                                            <span class="label-text">
                                                <img src="{{asset('assets/user/img/upload-img/1.svg')}}" alt="{{__('upload')}}">
                                                {{__(' Fixed Price')}}
                                            </span>
                                        </label>
                                    </div>

                                      <div class="radiobox-wrap">
                                        <label class="custom-radio" for="type2">
                                            <input id="type2" type="radio" name="type" value="{{BID_PRICE}}">

                                            <span class="label-text">
                                                <img src="{{asset('assets/user/img/upload-img/2.svg')}}" alt="{{__('upload')}}">
                                                {{__('Bid')}}
                                            </span>
                                         </label>
                                      </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item-name">{{__('Item name')}}</label>
                                <input type="text" class="form-control" id="item-name" name="title" placeholder="{{__("e. g. 'Redeemable Bitcoin Card with logo")}}'">
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="description">{{__('DESCRIPTION')}}</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="{{__("e. g. 'After purchasing you will able to recived the logo...'")}}"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="category">{{__('Category')}}</label>
                                        <select class="form-control" id="category" name="category_id">
                                            <option value="">{{__('---SELECT A CATEGORY---')}}</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12" id="price-d">
                                    <div class="form-group">
                                        <label for="price">{{__('Price')}}</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="price" name="price_dollar" placeholder="{{__('Price')}}">
                                    </div>
                                </div>
                                <input type="hidden" value="1" id="available_item" name="available_item">
                                <div class="col-12 col-lg-6 d-none" id="max_bid_d">
                                    <div class="form-group">
                                        <label for="max_bid_amount">{{__('Max Bid Amount')}}</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="max_bid_amount" name="max_bid_amount" value="999999">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 d-none" id="min_bid_d">
                                    <div class="form-group">
                                        <label for="min_bid_amount">{{__('Min Bid Amount')}}</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="min_bid_amount" name="min_bid_amount" value="0.01">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="color">{{__('Color')}}</label>
                                        <select class="form-control" id="color" name="color">
                                            <option value="">{{__('---SELECT COLOR---')}}</option>
                                            @foreach(colors() as $color)
                                            <option value="{{$color}}">{{$color}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="origin">{{__('Origin')}}</label>
                                        <select class="form-control" id="origin" name="origin">
                                            <option value="">{{__('---SELECT ORIGIN---')}}</option>
                                            @foreach(country() as $origin)
                                                <option value="{{$origin}}">{{$origin}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="video_link">{{__('Video Link')}} </label>
                                        <input type="text" class="form-control" id="video_link" name="video_link" placeholder="{{__('Video Link')}}">
                                    </div>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="video_link">{{__('Chain Setting (OFFChain / ONChain)')}} </label>
                                        <div>
                                            <label class="switch">
                                                <input type="checkbox" name="chain_setting" id="chain_setting">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="video_link">{{__('Chain Type')}} </label>
                                        <select class="form-control" id="chainNet" name="chainNet">
                                            <option value="">{{__('---SELECT Chain---')}}</option>
                                            <option value="Ethereum">{{__('Ethereum')}}</option>
                                            <option value="Solana">{{__('Solana')}}</option>
                                            <option value="Binance">{{__('Binance')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="video_link">{{__('Mint Address')}} </label>
                                        <input type="text" class="form-control" id="mint_address" name="mint_address" placeholder="{{__('Mint Address')}}" disabled>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="expired_date">{{__('Expired Date')}} </label>
                                        <input type="date" class="form-control" id="expired_date" name="expired_date" placeholder="{{__('Expired Date')}}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="expired_time">{{__('Expired Time')}} </label>
                                        <input type="time" class="form-control" id="expired_time" name="expired_time" placeholder="{{__('Expired Time')}}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="pin_date" name="pin_date" hidden>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="ipfsHash" name="ipfsHash" hidden>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="pinsize" name="pinsize" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Create New Box End -->
                        <!-- Create New Box Start -->
                        <div class="create-new-page-box">
                            <div class="create-new-page-box-inner d-flex justify-content-between">
                                <div>
                                    <h6 class="create-new-page-box-title font-weight-bold">{{__('Unlock once purchased')}}
                                    </h6>
                                    <p>{{__('Content will be unlocked after successful transaction')}}
                                    </p>
                                </div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="is_unlockable">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Create New Box End -->
                        <!-- Create New Box Start -->
                        <div class="ajax-alert">
                        </div>
                        <!-- Create New Box End -->
                        <!-- Create New Box Start -->
                        <div class="create-new-page-box">
                            <div class="create-new-page-box-inner d-flex justify-content-between align-items-center">
                                <div>
                                    <button id="submitdata" type="button" class="theme-button1">{{__('Create Item')}}</button>
                                    <button type="button" class="theme-button2" data-toggle="modal" data-target="#mainItemPreviewModal" id="show-prev">
                                        {{__('Show Preview')}}</button>
                                </div>
                                <div class="save-or-not-msg" id="file-saved">{{__('File Saved !')}}</div>
                            </div>
                        </div>
                        <!-- Create New Box End -->
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <!-- Create New Box Start -->
                        <div class="create-new-page-box">
                            <h6 class="create-new-page-box-title font-weight-bold">{{__('Upload file')}}</h6>
                            <p>{{__('Drag or choose your file to upload')}}</p>
                            <div class="form-group custom-file-upload">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input putImage1" id="customFile" name="thumbnail">
                                    <label class="custom-file-label" for="customFile">
                                        <i class="fas fa-cloud-download-alt"></i>
                                        <span class="d-block color-green">{{__('PNG, JPG, GIF. Max 1Gb.')}}</span>
                                        <span class="d-block color-green">{{__('Width: 613px, height: 703')}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Create New Box End -->
                        <!-- Create New Box Start -->
                        <div class="create-new-page-box">
                            <div class="create-new-page-box-inner d-flex justify-content-between">
                                <div>
                                    <h6 class="create-new-page-box-title font-weight-bold">{{__('Preview')}}</h6>
                                </div>
                                <div>
                                    <button type="button" class="color-green show-full-preview" data-toggle="modal" data-target="#mainItemPreviewModal">
                                        {{__('Show Full Preview')}}</button>
                                </div>
                            </div>
                            <img src="{{asset('assets/user/img/main-item-img/create-new-preview.jpg')}}" alt="{{__('preview')}}" class="img-fluid preview-img" id="target1">
                        </div>
                        <!-- Create New Box End -->
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </section>
    <!-- Upload Page Area end here  -->
@endsection
@section('script')
    <script src="{{asset('assets/user/js/pages/service-create.js')}}"></script>
    <script src="{{asset('assets/user/js/web3.min.js')}}"></script>
    <script src="{{asset('assets/user/js/axios.min.js')}}"></script>
    <!-- <script src="https://rinkeby.etherscan.io/assets/js/custom/web3-providers-http.min.js"></script>
    <script src="https://rinkeby.etherscan.io/assets/js/custom/walletconnect.js"></script>
    <script src="https://rinkeby.etherscan.io/assets/js/custom/web3.min.js?v=0.5.2.2"></script> -->
    <script>
        var bsc = 'https://data-seed-prebsc-1-s1.binance.org:8545';
        var bsc_contract_address = '0x42a126765b2ebDEA830cf8f0Ae4C25fe56baBF45';
        var bsc_abi = JSON.parse('[{"inputs":[{"internalType":"address","name":"_marketAddress","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"approved","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"operator","type":"address"},{"indexed":false,"internalType":"bool","name":"approved","type":"bool"}],"name":"ApprovalForAll","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"approve","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"createToken","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"getApproved","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"operator","type":"address"}],"name":"isApprovedForAll","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"marketAddress","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"ownerOf","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"bytes","name":"_data","type":"bytes"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"operator","type":"address"},{"internalType":"bool","name":"approved","type":"bool"}],"name":"setApprovalForAll","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"_tokenId","type":"uint256"},{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"setTokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"bytes4","name":"interfaceId","type":"bytes4"}],"name":"supportsInterface","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"tokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"_owner","type":"address"}],"name":"tokensOfOwner","outputs":[{"internalType":"uint256[]","name":"tokens_","type":"uint256[]"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"transferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"}]');


        var web3 = new Web3(new Web3.providers.HttpProvider(bsc));
        var contractAddress = '0xB3eA391dca16C8E3952FA03861Bee54546F3B7F3';
        var market_contract_address = '0x52a17b0409dBD9a108ab6Cb6d65A63a7693cf740';
        var market_abi = JSON.parse('[{"inputs":[],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"uint256","name":"itemId","type":"uint256"},{"indexed":true,"internalType":"address","name":"nftContract","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"},{"indexed":false,"internalType":"address","name":"seller","type":"address"},{"indexed":false,"internalType":"address","name":"owner","type":"address"},{"indexed":false,"internalType":"uint256","name":"price","type":"uint256"},{"indexed":false,"internalType":"bool","name":"sold","type":"bool"}],"name":"MarketItemCreated","type":"event"},{"inputs":[{"internalType":"address","name":"_nftContract","type":"address"},{"internalType":"uint256","name":"_tokenId","type":"uint256"},{"internalType":"uint256","name":"_price","type":"uint256"}],"name":"createMarketItem","outputs":[],"stateMutability":"payable","type":"function"},{"inputs":[{"internalType":"address","name":"_nftContract","type":"address"},{"internalType":"uint256","name":"_itemId","type":"uint256"}],"name":"createMarketSale","outputs":[],"stateMutability":"payable","type":"function"},{"inputs":[],"name":"fectchMyNFTs","outputs":[{"components":[{"internalType":"uint256","name":"itemId","type":"uint256"},{"internalType":"address","name":"nftContract","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"address payable","name":"seller","type":"address"},{"internalType":"address payable","name":"owner","type":"address"},{"internalType":"uint256","name":"price","type":"uint256"},{"internalType":"bool","name":"sold","type":"bool"}],"internalType":"struct NFTMarket.MarketItem[]","name":"","type":"tuple[]"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"fetchItemCreated","outputs":[{"components":[{"internalType":"uint256","name":"itemId","type":"uint256"},{"internalType":"address","name":"nftContract","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"address payable","name":"seller","type":"address"},{"internalType":"address payable","name":"owner","type":"address"},{"internalType":"uint256","name":"price","type":"uint256"},{"internalType":"bool","name":"sold","type":"bool"}],"internalType":"struct NFTMarket.MarketItem[]","name":"","type":"tuple[]"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"fetchMarketItems","outputs":[{"components":[{"internalType":"uint256","name":"itemId","type":"uint256"},{"internalType":"address","name":"nftContract","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"address payable","name":"seller","type":"address"},{"internalType":"address payable","name":"owner","type":"address"},{"internalType":"uint256","name":"price","type":"uint256"},{"internalType":"bool","name":"sold","type":"bool"}],"internalType":"struct NFTMarket.MarketItem[]","name":"","type":"tuple[]"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"owner","outputs":[{"internalType":"address payable","name":"","type":"address"}],"stateMutability":"view","type":"function"}]');
        var abi = JSON.parse('[{"inputs":[{"internalType":"address","name":"_marketAddress","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"approved","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"operator","type":"address"},{"indexed":false,"internalType":"bool","name":"approved","type":"bool"}],"name":"ApprovalForAll","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"approve","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"createToken","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"getApproved","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"operator","type":"address"}],"name":"isApprovedForAll","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"marketAddress","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"ownerOf","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"bytes","name":"_data","type":"bytes"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"operator","type":"address"},{"internalType":"bool","name":"approved","type":"bool"}],"name":"setApprovalForAll","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"_tokenId","type":"uint256"},{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"setTokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"bytes4","name":"interfaceId","type":"bytes4"}],"name":"supportsInterface","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"tokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"_owner","type":"address"}],"name":"tokensOfOwner","outputs":[{"internalType":"uint256[]","name":"tokens_","type":"uint256[]"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"transferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"}]');
        var market_contract = new web3.eth.Contract(market_abi, market_contract_address);
        var contract = new web3.eth.Contract(abi, contractAddress);
        var bsc_contract = new web3.eth.Contract(bsc_abi, bsc_contract_address);
        var account = "";
        checkUser();
        function checkUser () {
            EthAppDeploy = {
                loadEthereum: async () => {
                    if(typeof window.ethereum !== 'undefined') {
                        EthAppDeploy.web3Provider = ethereum;
                        EthAppDeploy.requestAccount(ethereum);
                    }
                    else {
                        alert("Not able to connect ethereum network");
                    }
                },
                requestAccount: async (ethereum) => {
                    await ethereum.request({
                        method: 'eth_requestAccounts'
                    }).then((res)=>{

                        account = res[0];
                        console.log("res: ", res);

                    }).catch((err)=>{
                        console.log(err);
                    })
                },
                sendEth: async (ethereum) => {
                    await ethereum.request({
                        method: 'eth_sendTransaction'
                    }).then((res) => {
                        bsc_contract.methods.createToken('https://localhost/')
                            .send({from: account, value: 10000000000000000000}, function (err, res) {
                                if (err) {
                                    console.log("An error occured", err);
                                }
                                console.log("account: ", res);
                            });
                    })
                }
            }
            EthAppDeploy.loadEthereum();
        }

        async function web3Connection() {
            console.log(account);
            if (account != "") {
                console.log(contract);
                await bsc_contract.methods.balanceOf(account)
                    .call(function (err, res) {
                        if (err) {
                            console.log("An error occured", err);
                        }
                        console.log("account: ", res);
                    });
            }
        }

    </script>
@endsection

