@extends('admin.master',['menu'=>'profile'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li class="active-item">{{__('Profile')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="user-management profile card">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs mb-3 user-page-tab-list user-management-tab-list mb-3" id="pills-tab" role="tablist">
                    <li>
                        <a class=" @if(isset($tab) && $tab=='profile') active @endif nav-link " data-id="profile" data-toggle="pill" role="tab" data-controls="profile" aria-selected="true" href="#profile">
                            <i class="fas fa-user"></i>
                            <span>{{__('My Profile')}}</span>
                        </a>
                    </li>
                    <li>
                        <a class=" @if(isset($tab) && $tab=='edit_profile') active @endif nav-link  " data-id="edit_profile" data-toggle="pill" role="tab" data-controls="edit_profile" aria-selected="true" href="#edit_profile">
                            <i class="fas fa-user-edit"></i>
                            <span>{{__('Edit Profile')}}</span>
                        </a>
                    </li>
                    <li>
                        <a class=" @if(isset($tab) && $tab=='change_pass') active @endif nav-link  " data-id="change_pass" data-toggle="pill" role="tab" data-controls="change_pass" aria-selected="true" href="#change_pass">
                            <i class="fas fa-unlock"></i>
                            <span>{{__('Change Password')}}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-pt-n" id="tabContent">
                    <!-- genarel-setting start-->
                    <div class="tab-pane fade show @if(isset($tab) && $tab=='profile')  active @endif " id="profile" role="tabpanel" aria-labelledby="general-setting-tab">
                        <div class="form-area plr-65">
                            <h4 class="mb-4">{{__('My Profile')}}</h4>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="profile-img-area text-center">
                                        <div class="prifile-img">
                                            <img width="100" src="{{!empty(Auth::user()->photo) ? show_image(Auth::user()->id,'user') : Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->toBase64()}}" alt="{{__('profile')}}">
                                        </div>
                                        <div class="profile-name mt-1 mb-3">
                                            <h3>{!! clean(Auth::user()->first_name.' '.Auth::user()->last_name) !!}</h3>
                                            <span>{!! clean(Auth::user()->email) !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 offset-lg-1">
                                    <div class="profile-info">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                <tr>
                                                    <td>{{__('Name')}}</td>
                                                    <td>:</td>
                                                    <td><span>{!! clean(Auth::user()->first_name.' '.Auth::user()->last_name) !!}</span></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Role')}}</td>
                                                    <td>:</td>
                                                    <td><span>{{userRole($user->role)}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Email')}}</td>
                                                    <td>:</td>
                                                    <td><span>{!! clean(Auth::user()->email) !!}</span></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Email verification')}}</td>
                                                    <td>:</td>
                                                    <td><span class="color">{{statusAction($user->is_verified)}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Contact')}}</td>
                                                    <td>:</td>
                                                    <td><span>{{\Illuminate\Support\Facades\Auth::user()->phone}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Status')}}</td>
                                                    <td>:</td>
                                                    <td><span>{{statusAction($user->status)}}</span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade @if(isset($tab) && $tab=='edit_profile')show active @endif" id="edit_profile" role="tabpanel" aria-labelledby="apisetting-tab">
                        <div class="form-area">
                            <h4 class="mb-4">{{__('Edit Profile')}}</h4>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="profile-img-area text-center">
                                        <div class="uplode-img mb-4">
                                            <form enctype="multipart/form-data" method="post" action="{{route('upload_profile_image')}}">
                                                @csrf
                                                <div id="file-upload" class="section-p">
                                                    <input type="file" name="file_one" id="file" ref="file" class="dropify" data-default-file="{{show_image(Auth::user()->id,'user')}}" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="profile-info-form form-area  p-0">
                                        <form action="{{route('user_profile_update')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="firstname">{{__('First Name')}}</label>
                                                <input name="first_name" value="{{old('first_name',Auth::user()->first_name)}}" type="text" class="form-control" id="firstname" placeholder="{{__('First name')}}">
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">{{__('Last Name')}}</label>
                                                <input name="last_name" value="{{old('last_name',Auth::user()->last_name)}}" type="text" class="form-control" id="lastname" placeholder="{{__('Last name')}}">
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">{{__('Phone Number')}}</label>
                                                <input name="phone"   type="text" value="{{old('phone',Auth::user()->phone)}}" class="form-control" id="phoneVerify" placeholder="{{__('01999999999')}}">
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">{{__('Email')}}</label>
                                                <input name="" readonly type="email" value="{{old('email',Auth::user()->email)}}" class="form-control" id="email" placeholder="{{__('email')}}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-info">{{__('Update')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade @if(isset($tab) && $tab=='change_pass')show active @endif" id="change_pass" role="tabpanel" aria-labelledby="braintree-tab">
                        <div class="form-area ">
                            <h4 class="mb-4">{{__('Change Password')}}</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="profile-info-form form-area p-0">
                                        <form method="POST" action="{{route('change_password_save')}}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="currentpassword">{{__('Current Password')}}</label>
                                                <input name="password" type="password" class="form-control" id="currentpassword">
                                                <span class="flaticon-look"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="newpassword">{{__('New Password')}}</label>
                                                <input name="new_password" type="password" class="form-control" id="newpassword">
                                                <span class="flaticon-look"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmpassword">{{__('Confirm Password')}}</label>
                                                <input name="confirm_new_password" type="password" class="form-control" id="confirmpassword">
                                                <span class="flaticon-look"></span>
                                            </div>
                                            <button type="submit" class="btn btn-info">{{__('Change Password')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="table-url" data-url="{{route('admin_profile')}}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/users/admin-profile.js')}}"></script>
@endsection
