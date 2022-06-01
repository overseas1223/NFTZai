@extends('admin.master',['menu'=>'setting','sub_menu'=>'withdrawal-limit'])
@section('title',__('Withdrawal Limit Settings'))
@section('content')
    <div class="main-content-inner">
        <div class="row">
            <div class="col-12 mt-5">
                {{ Form::open(['route' => ['update_withdrawal_limit_process', 'id' => encrypt($item->id)]]) }}
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label class="form-label">{{__('Coin')}}</label>
                                                <div class="controls">
                                                    <input name="coin_name"  type="text" readonly class="form-control" value="{{$item->coin->coin_type}}" >
                                                    <input name="coin_id"  type="hidden"  class="form-control" value="{{$item->coin->id}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">{{__('From')}}</label>
                                                <div class="controls">
                                                    <input name="from"  type="text" class="form-control" placeholder="{{__('0.00')}}" @if(isset($item))value="{{$item->from}}" @else value="{{old('from')}}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">{{__('To')}}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" placeholder="{{__('0.00')}}" name="to" @if(isset($item))value="{{$item->to}}" @else value="{{old('to')}}" @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">{{__('Google 2FA')}}</label>
                                                <div class="controls">
                                                    <label class="switch">
                                                        <input type="checkbox" value="1" name="google2fa" @if(isset($item) && $item->google2fa==1)checked  @endif>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{__('Email 2FA')}}</label>
                                                <div class="controls">
                                                    <label class="switch">
                                                        <input type="checkbox" value="1" name="email2fa" @if(isset($item) && $item->email2fa==1)checked  @endif>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{__('Admin Approval')}}</label>
                                                <div class="controls">
                                                    <label class="switch">
                                                        <input type="checkbox" name="admin_approval" @if(isset($item) && $item->admin_approval==1)checked  @endif>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 text-right">
                                <a class="btn btn-warning" href="{{route('withdrawal_coin_settings')}}">{{__('Back')}}</a>
                            </div>
                            <div class="col-md-1 text-right margin-left-20">
                                <button class="btn btn-success btn-cons cur-pointer" type="submit"
                                        name="submit">{{__('Save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection