@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'general'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Settings')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="user-management card">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs mb-3 user-page-tab-list user-management-tab-list" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='general') active @endif nav-link " id="pills-user-tab"
                           data-toggle="pill" data-controls="general" href="#general" role="tab"
                           aria-controls="pills-user" aria-selected="true">
                           <i class="fas fa-cogs"></i><span>{{__('General Settings')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='email') active @endif nav-link " id="pills-add-user-tab"
                           data-toggle="pill" data-controls="email" href="#email" role="tab"
                           aria-controls="pills-add-user" aria-selected="true">
                           <i class="fas fa-cog"></i><span>{{__('Email Settings')}} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="@if(isset($tab) && $tab=='payment') active @endif nav-link " id="pills-email-tab"
                           data-toggle="pill" data-controls="payment" href="#payment" role="tab"
                           aria-controls="pills-email" aria-selected="true">
                           <i class="fas fa-key"></i><span>{{__('Payment Settings')}}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show @if(isset($tab) && $tab=='general')  active @endif" id="general"
                         role="tabpanel" aria-labelledby="pills-user-tab">
                        <div class="header-bar">
                            <div class="table-title">
                                <h3>{{__('General Settings')}}</h3>
                            </div>
                        </div>
                        <div class="profile-info-form">
                            <form action="{{route('admin_common_settings')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-3 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label>{{__('Language')}}</label>
                                            <div class="cp-select-area">
                                                <select name="lang" class="form-control">
                                                    @foreach(language() as $val)
                                                        <option
                                                            @if(isset($settings['lang']) && $settings['lang']==$val) selected
                                                            @endif value="{{$val}}">{{langName($val)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Company Name')}}</label>
                                            <input class="form-control" type="text" name="company_name"
                                                   placeholder="{{__('Company Name')}}"
                                                   value="{{$settings['app_title']}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12  mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Copyright Text')}}</label>
                                            <input class="form-control" type="text" name="copyright_text"
                                                   placeholder="{{__('Copyright Text')}}"
                                                   value="{{$settings['copyright_text']}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label
                                                for="#">{{__('Number of confirmation for Notifier deposit')}} </label>
                                            <input class="form-control number_only" type="text"
                                                   name="number_of_confirmation" placeholder=""
                                                   value="{{$settings['number_of_confirmation']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="uplode-img-list">
                                    <div class="row">
                                        <div class="col-lg-6 mt-20">
                                            <div class="single-uplode">
                                                <div class="uplode-catagory">
                                                    <span>{{__('Logo')}}</span>
                                                </div>
                                                <div class="form-group buy_coin_address_input ">
                                                    <div id="file-upload" class="section-p">
                                                        <input type="file" placeholder="0.00" name="logo"
                                                               id="file" ref="file" class="dropify"
                                                               @if(isset($settings['logo']) && (!empty($settings['logo'])))  data-default-file="{{asset(path_image().$settings['logo'])}}" @endif />
                                                    </div>
                                                </div>
                                                <div class="form-group admin-inner-pages-thumb">
                                                    <img src="{{asset(path_image().$settings['logo'])}}" alt="img" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mt-20">
                                            <div class="single-uplode">
                                                <div class="uplode-catagory">
                                                    <span>{{__('Login Logo')}}</span>
                                                </div>
                                                <div class="form-group buy_coin_address_input ">
                                                    <div id="file-upload" class="section-p">
                                                        <input type="file" placeholder="0.00" name="login_logo"
                                                               id="file" ref="file" class="dropify"
                                                               @if(isset($settings['login_logo']) && (!empty($settings['login_logo'])))  data-default-file="{{asset(path_image().$settings['login_logo'])}}" @endif />
                                                    </div>
                                                </div>

                                                <div class="form-group admin-inner-pages-thumb">
                                                    <img src="{{asset(path_image().$settings['login_logo'])}}" alt="img" class="img-fluid">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 mt-20">
                                            <div class="single-uplode">
                                                <div class="uplode-catagory">
                                                    <span>{{__('Favicon')}}</span>
                                                </div>
                                                <div class="form-group buy_coin_address_input ">
                                                    <div id="file-upload" class="section-p">
                                                        <input type="file" placeholder="0.00" name="favicon"
                                                               id="file" ref="file" class="dropify"
                                                               @if(isset($settings['favicon']) && (!empty($settings['favicon'])))  data-default-file="{{asset(path_image().$settings['favicon'])}}" @endif />
                                                    </div>
                                                </div>

                                                <div class="form-group admin-inner-pages-thumb">
                                                    <img src="{{asset(path_image().$settings['favicon'])}}" alt="img" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mt-20">
                                            <div class="single-uplode">
                                                <div class="uplode-catagory">
                                                    <span>{{__('Dashboard Image')}}</span>
                                                </div>
                                                <div class="form-group buy_coin_address_input ">
                                                    <div id="file-upload" class="section-p">
                                                        <input type="file" placeholder="0.00" name="dashboard_image"
                                                               id="file" ref="file" class="dropify"
                                                               @if(isset($settings['dashboard_image']) && (!empty($settings['dashboard_image'])))  data-default-file="{{asset(path_image().$settings['dashboard_image'])}}" @endif />
                                                    </div>
                                                </div>

                                                <div class="form-group admin-inner-pages-thumb">
                                                    <img src="{{asset(path_image().$settings['dashboard_image'])}}" alt="img" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(isset($itech))
                                        <input type="hidden" name="itech" value="{{$itech}}">
                                    @endif
                                    <div class="col-lg-2 col-12 mt-20">
                                        <button class="btn btn-info mt-2">{{__('Update')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='email') show active @endif" id="email"
                         role="tabpanel" aria-labelledby="pills-add-user-tab">
                        <div class="header-bar">
                            <div class="table-title">
                                <h3>{{__('Email Setup')}}</h3>
                            </div>
                        </div>
                        <div class="profile-info-form">
                            <form action="{{route('admin_save_email_settings')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Email Host')}}</label>
                                            <input class="form-control" type="text" name="mail_host"
                                                   placeholder="{{__('Host')}}" value="{{$settings['mail_host']}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Email Port')}}</label>
                                            <input class="form-control" type="text" name="mail_port"
                                                   placeholder="{{__('Port')}}" value="{{$settings['mail_port']}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Email Username')}}</label>
                                            <input class="form-control" type="text" name="mail_username"
                                                   placeholder="{{__('Username')}}"
                                                   value="{{isset($settings['mail_username']) ? $settings['mail_username'] : ''}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Email Password')}}</label>
                                            <input class="form-control" type="password" name="mail_password"
                                                   placeholder="{{__('Password')}}"
                                                   value="{{$settings['mail_password']}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Mail Encryption')}}</label>
                                            <input class="form-control" type="text" name="mail_encryption"
                                                   placeholder="{{__('Encryption')}}"
                                                   value="{{isset($settings['mail_encryption']) ? $settings['mail_encryption'] : ''}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Mail Form Address')}}</label>
                                            <input class="form-control" type="text" name="mail_from_address"
                                                   placeholder="{{__('Mail from address')}}"
                                                   value="{{isset($settings['mail_from_address']) ? $settings['mail_from_address'] : ''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-12 mt-20">
                                        <button type="submit" class="btn btn-info mt-2">{{__('Update')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane @if(isset($tab) && $tab=='payment') show active @endif" id="payment"
                         role="tabpanel" aria-labelledby="pills-email-tab">
                        <div class="header-bar">
                            <div class="table-title">
                                <h3>{{__('Coin Payment Details')}}</h3>
                            </div>
                        </div>
                        <div class="profile-info-form">
                            <form action="{{route('admin_save_payment_settings')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-3 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('COIN PAYMENT PUBLIC KEY')}}</label>
                                            <input class="form-control" type="text" name="COIN_PAYMENT_PUBLIC_KEY"
                                                   autocomplete="off" placeholder=""
                                                   value="{{settings('COIN_PAYMENT_PUBLIC_KEY')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12 mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('COIN PAYMENT PRIVATE KEY')}}</label>
                                            <input class="form-control" type="text" name="COIN_PAYMENT_PRIVATE_KEY"
                                                   autocomplete="off" placeholder=""
                                                   value="{{settings('COIN_PAYMENT_PRIVATE_KEY')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12  mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Coin Payment Base Coin Type')}}</label>
                                            <input class="form-control" type="text" name="base_coin_type"
                                                   placeholder="{{__('Coin Type eg. BTC')}}"
                                                   value="{{isset($settings['base_coin_type']) ? $settings['base_coin_type'] : ''}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12  mt-20">
                                        <div class="form-group">
                                            <label for="#">{{__('Service Charge')}}</label>
                                            <input class="form-control" type="text" name="service_charge"
                                                   placeholder="{{__('Coin Type eg. BTC')}}"
                                                   value="{{isset($settings['service_charge']) ? $settings['service_charge'] : ''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-12 mt-20">
                                        <button type="submit" class="btn btn-info mt-2">{{__('Update')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/settings/general.js')}}"></script>
@endsection
