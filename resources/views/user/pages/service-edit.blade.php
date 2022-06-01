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
                        <h1 class="page-banner-title">{{__('Upload')}}</h1>
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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Upload')}}</li>
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
            {{Form::open(['route' => ['service_update', encrypt($service->id)], 'files' => true, 'data-handler'=>"showMessage" ,'class' => 'ajax'])}}
            <div class="row">
                <div class="col-12 col-md-7 col-lg-7">
                    <!-- Create New Box Start -->
                    <div class="create-new-page-box">
                        <h6 class="create-new-page-box-title font-weight-bold">{{__('Item Details')}}</h6>

                        <div class="form-group">
                            <label for="item-name">{{__('Item name')}}</label>
                            <input type="text" class="form-control" id="item-name" name="title" placeholder="{{__("e. g. 'Redeemable Bitcoin Card with logo'")}}" value="{{$service->title}}">
                        </div>

                        <div class="form-group">
                            <label for="description">{{__('DESCRIPTION')}}</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="{{__("e. g. 'After purchasing you will able to recived the logo...'")}}">{{$service->description}}</textarea>
                        </div>

                        <div class="row">

                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="category">{{__('Category')}}</label>
                                    <select class="form-control" id="category" name="category_id">
                                        <option value="">{{__('---SELECT A CATEGORY---')}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{$service->category_id == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if ($service->type == FIXED_PRICE)
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="price">{{__('Price')}}</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="price" name="price_dollar" placeholder="{{__('Price')}}" value="{{visual_number_format($service->price_dollar)}}">
                                    </div>
                                </div>
                            @elseif($service->type == BID_PRICE)
                                <div class="col-12 col-lg-6" id="max_bid_d">
                                    <div class="form-group">
                                        <label for="max_bid_amount">{{__('Max Bid Amount')}}</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="max_bid_amount" name="max_bid_amount" value="{{visual_number_format($service->max_bid_amount)}}">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6" id="min_bid_d">
                                    <div class="form-group">
                                        <label for="min_bid_amount">{{__('Min Bid Amount')}}</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="min_bid_amount" name="min_bid_amount" value="{{visual_number_format($service->min_bid_amount)}}">
                                    </div>
                                </div>
                            @endif

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="color">{{__('Color')}}</label>
                                    <select class="form-control" id="color" name="color">
                                        <option value="">{{__('---SELECT COLOR---')}}</option>
                                        @foreach(colors() as $color)
                                            <option value="{{$color}}" {{$service->color == $color ? 'selected' : ''}}>{{$color}}</option>
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
                                            <option value="{{$origin}}" {{$service->origin == $origin ? 'selected' : ''}}>{{$origin}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="video_link">{{__('Video Link')}} </label>
                                    <input type="text" class="form-control" id="video_link" name="video_link" placeholder="{{__('Video Link')}}" value="{{$service->video_link}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="video_link">{{__('Mint Address')}} </label>
                                    <input type="text" class="form-control" id="mint_address" name="mint_address" placeholder="{{__('Mint Address')}}" value="{{$service->mint_address}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="expired_date">{{__('Expired Date')}} </label>
                                    <input type="datetime-local" class="form-control" id="expired_at" name="expired_at">
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
                                    <input type="checkbox" value="1" name="is_unlockable" {{$service->is_unlockable == 1 ? 'checked' : ''}}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Create New Box End -->
                    <!-- Create New Box Start -->
                    <div class="create-new-page-box">
                        <div class="create-new-page-box-inner d-flex justify-content-between">
                            <div class="ajax-alert">
                            </div>
                        </div>
                    </div>
                    <!-- Create New Box End -->
                    <!-- Create New Box Start -->
                    <div class="create-new-page-box create-new-page-box-btn-wrap">
                        <div class="create-new-page-box-inner d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" class="theme-button1">{{__('Edit Item')}}</button>
                                <button type="button" class="theme-button2" data-toggle="modal" data-target="#mainItemPreviewModal">
                                    {{__('Show Preview')}}</button>
                            </div>
                            <div class="save-or-not-msg">{{__('File Saved !')}}</div>
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
                        <img src="{{asset(IMG_SERVICE_PATH.$service->thumbnail)}}" alt="{{__('preview')}}" class="img-fluid preview-img" id="target1">
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
    <script src="{{asset('assets/user/js/pages/service-edit.js')}}"></script>
@endsection
