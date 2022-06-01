@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!-- Page Banner Area start here  -->
    <section class="page-banner-area user-profile-banner-area p-0" style="background-image: url({{asset('assets/user/img/page-banner2.jpg')}});">
        <div class="container">
            <div class="inner-page-single-dot1 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot1.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot2.png')}}" alt="{{__('dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{asset('assets/user/img/footer-img/footer-dot3.png')}}" alt="{{__('dot')}}"></div>
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{__('Edit Profile')}}</h1>
                        <p class="page-banner-para">{{__('You can set preferred display name, create your profile URL and
                            manage other personal settings.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="breadcrumb-section p-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="breadcrumb-area">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('login')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('user_profile')}}">{{__('Profile')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Edit Profile')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="edit-profile-page-area section-t-space">
        <div class="container">
            {{Form::open(['route' => 'update_profile', 'files' => true, 'data-handler'=>"showMessage" ,'class' => 'ajax'])}}
                <div class="row">
                    <div class="col-12">
                        <div class="user-profile-photo-part text-center">
                            <div class="profile-photo">
                                <img src="{{ isset(Auth::user()->photo) ? asset(IMG_USER_VIEW_PATH.Auth::user()->photo) : Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->toBase64()}}" id="target1" alt="{{__('profile photo')}}">
                            </div>
                            <h3 class="user-profile-edit-name">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
                            <div class="user-profile-code font-14">{{Auth::user()->country}}</div>
                            <div class="custom-file-upload theme-button2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input putImage1" id="customFile" name="thumbnail">
                                    <label class="custom-file-label" for="customFile">
                                        {{__('Change Image')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-center ajax-alert">
                        </div>
                    </div>
                    <!-- User Profile Photo Part End -->
                    <!-- Information Part Start -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="user-information-part">
                            <!-- Edit Info Box Start -->
                            <div class="create-new-page-box">
                                <h6 class="edit-user-small-title create-new-page-box-title font-weight-bold">{{__('Account
                                    Info')}}</h6>
                                <div class="form-group">
                                    <label for="item-name">{{__('First name')}}</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{__('Enter your first name')}}" value="{{Auth::user()->first_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="item-name">{{__('Last name')}}</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{__('Enter your last name')}}" value="{{Auth::user()->last_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="item-name">{{__('Phone Number')}}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <select class="form-control" name="country_code" id="country_code">
                                                @foreach(country_code() as $i => $c)
                                                    <option value="{{$i}}" {{Auth::user()->country_code == $i ? 'selected' : ''}}>
                                                        {{__('+')}}{{$i}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{__('Enter your phone number')}}" name="phone" value="{{Auth::user()->phone}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="item-name">{{__('Country')}}</label>
                                    <select class="form-control" name="country" id="country">
                                        <option value="">{{__('---SELECT COUNTRY---')}}</option>
                                        @foreach(country() as $cc)
                                            <option value="{{$cc}}" {{Auth::user()->country == $cc ? 'selected' : ''}}>{{$cc}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="item-name">{{__('Gender')}}</label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="">{{__('---SELECT A GENDER---')}}</option>
                                        <option value="{{MALE}}" {{Auth::user()->gender == MALE ? 'selected' : ''}}>{{__('Male')}}</option>
                                        <option value="{{FEMALE}}" {{Auth::user()->gender == FEMALE ? 'selected' : ''}}>{{__('Female')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="item-name">{{__('Birth Date')}}</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Bio')}}</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="{{__('About yourself in a few words')}}">{{Auth::user()->bio}}</textarea>
                                </div>
                            </div>
                            <!-- Edit Info Box End -->
                            <!-- Edit Info Box Start -->
                            <div class="create-new-page-box">
                                <h6 class="create-new-page-box-title font-weight-bold">{{__('Social')}}</h6>
                                <div class="form-group">
                                    <label for="website">{{__('Portfolio or website')}}</label>
                                    <input type="text" class="form-control" id="website" name="website" placeholder="{{__('Enter URL')}}" value="{{Auth::user()->website}}">
                                </div>
                                <div class="form-group" id="social_facebook">
                                    <label for="facebook">{{__('Facebook')}}</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="{{__('https://facebook.com/your_page')}}" value="{{isset(Auth::user()->social_media->facebook) ? Auth::user()->social_media->facebook : ''}}">

                                </div>
                                <div class="add-more-social-accounts" id="social_add_facebook">
                                    <button class="theme-button2" type="button">{{__('Add more social accounts')}}</button>
                                </div>
                                <div class="form-group d-none" id="social_twitter">
                                    <label for="twitter">{{__('Twitter')}}</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="{{__('https://twitter.com/your_page')}}" value="{{isset(Auth::user()->social_media->twitter) ? Auth::user()->social_media->twitter : ''}}">
                                </div>
                                <div class="add-more-social-accounts d-none" id="social_add_twitter">
                                    <button class="theme-button2" type="button" id="social_add_twitter">{{__('Add more social
                                        accounts')}}</button>
                                </div>
                                <div class="form-group d-none" id="social_instagram">
                                    <label for="instagram">{{__('Instagram')}}</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram" placeholder="{{__('https://instagram.com/your_page')}}" value="{{isset(Auth::user()->social_media->instagram) ? Auth::user()->social_media->instagram : ''}}">
                                </div>
                            </div>
                            <!-- Edit Info Box End -->
                        </div>
                    </div>
                    <!-- Information Part End -->
                    <!-- Notification Part Start -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="notification-part">
                            <!-- Edit Info Box Start -->
                            <div class="create-new-page-box">
                                <h6 class="edit-user-small-title create-new-page-box-title font-weight-bold">
                                    {{__('Notifications')}}</h6>
                                <div class="create-new-page-box-inner d-flex justify-content-between">
                                    <div>
                                        <h6 class="create-new-page-box-title font-weight-bold">{{__('Email Notifications')}}</h6>
                                        <p>{{__('You’ll receive bids on this item')}}</p>
                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="email_notification_status" {{Auth::user()->email_notification_status == 1 ? 'checked' : ''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="create-new-page-box-inner d-flex justify-content-between">
                                    <div>
                                        <h6 class="create-new-page-box-title font-weight-bold">{{__('New Bids')}}</h6>
                                        <p>{{__('You’ll receive notification bids on this item')}}</p>
                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="new_bid_notification" {{Auth::user()->new_bid_notification == 1 ? 'checked' : ''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="create-new-page-box-inner d-flex justify-content-between">
                                    <div>
                                        <h6 class="create-new-page-box-title font-weight-bold">{{__('Item Purchased')}}</h6>
                                        <p>{{__('If someone buy a new Item.')}}</p>
                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="item_purchased_notification" {{Auth::user()->item_purchased_notification == 1 ? 'checked' : ''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="create-new-page-box-inner d-flex justify-content-between">
                                    <div>
                                        <h6 class="create-new-page-box-title font-weight-bold">{{__('People Followed')}}</h6>
                                        <p>{{__('If someone buy a new Item.')}}</p>
                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="people_follow_notification" {{Auth::user()->people_follow_notification == 1 ? 'checked' : ''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="create-new-page-box-inner d-flex justify-content-between">
                                    <div class="edit-profile-note">{{__("To update your settings you should sign message
                                        through your wallet. Click 'Update profile' then sign the message")}}</div>
                                </div>
                                <div class="notification-part-btns">
                                    <button class="theme-button1">{{__('Update Profile')}}</button>
                                    <button class="theme-button2" type="reset">{{__('Cancel')}}</button>
                                </div>
                            </div>
                            <!-- Edit Info Box End -->
                        </div>
                    </div>
                    <!-- Notification Part End -->
                </div>
            {{Form::close()}}
        </div>
    </section>
    <!-- Edit Profile Page Area end here  -->
@endsection
@section('script')
    <script src="{{asset('assets/user/js/pages/edit-profile.js')}}"></script>
@endsection
