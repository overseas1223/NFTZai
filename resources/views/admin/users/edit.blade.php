@extends('admin.master',['menu'=>'users','sub_menu'=>'user'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('User management')}}</li>
                    <li class="active-item">{{__('Edit User')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="user-management profile">
        <div class="row">
            <div class="col-12">
                @include('user.message')
                {{-- <div class="profile-info padding-40"> --}}
                <div class="profile-info">
                    <div class="row">
                        <div class="col-xl-4 mb-xl-0 mb-4">
                            <div class="user-info text-center">
                                <div class="avater-img">
                                    <img src="{{show_image($user->id,'user')}}">
                                </div>
                                <h4>{{$user->first_name.' '.$user->last_name}}</h4>
                                <p>{{$user->email}}</p>
                            </div>
                            <ul class="profile-transaction">
                                <li class="profile-deposit">
                                    <p>{{__('Total Deposit')}}</p>
                                    <h4>{{total_deposit($user->id)}} {{ settings('coin_name') }}</h4>
                                </li>
                                <li class="profile-withdrow">
                                    <p>{{__('Total Withdrawal')}}</p>
                                    <h4>{{total_withdrawal($user->id) }} {{ settings('coin_name') }}</h4>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-8">
                            <form action="{{route('admin_user_profile_update')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{encrypt($user->id)}}">
                                <div class="form-group">
                                    <label for="firstname">{{__('First Name')}}</label>
                                    <input name="first_name" value="{{old('first_name',$user->first_name)}}" type="text" class="form-control" id="firstname" placeholder="{{__('First name')}}">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lastname">{{__('Last Name')}}</label>
                                    <input name="last_name" value="{{old('last_name',$user->last_name)}}" type="text" class="form-control" id="lastname" placeholder="{{__('Last name')}}">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lastname">{{__('Phone Number')}}</label>
                                    <input name="phone" type="text" value="{{old('phone',$user->phone)}}" class="form-control" id="phoneVerify">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">{{__('Email')}}</label>
                                    <span class="email-input form-control"> {{ $user->email }} </span>
                                </div>
                                <div class="form-group form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="top_seller" id="flexCheckDefault" {{isTopSeller($user->id) != 0 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{__('Top Seller')}}
                                    </label>
                                </div>
                                <button type="submit" class="button-primary theme-btn">{{__('Update')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
