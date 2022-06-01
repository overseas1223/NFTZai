@extends('admin.master',['menu'=>'coin', 'sub_menu'=>'coin_list'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="main-content-inner">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        {{Form::open(['route'=>'coin_save', 'files' => true])}}
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Coin Short Name')}}</div>
                                                        <input type="text" class="form-control" name="ctype" id="ctype" @if(isset($item))value="{{$item->coin_type}}" @else value="{{old('ctype')}}" @endif>
                                                        <p class="text-warning">{{__('N. B. Coin short name will always convert into
                                                    uppercase.')}}</p>
                                                        <pre class="text-danger">{{$errors->first('ctype')}}</pre>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Coin Full Name')}}</div>
                                                        <input type="text" class="form-control" name="coin_full_name" @if(isset($item))value="{{$item->full_name}}" @else value="{{old('coin_full_name')}}" @endif>
                                                        <pre class="text-danger">{{$errors->first('coin_full_name')}}</pre>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Minimum Buy Amount')}}</div>
                                                        <input type="text" class="form-control" name="minimum_buy_amount"
                                                               @if(isset($item))value="{{$item->minimum_buy_amount}}" @else value="0.00000010" @endif >
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                             <div class="col-md-3">
                                                <div class="custom-control custom-switch mb-4">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="deposit_status" @if(isset($item) && $item->deposit_status==1)checked  @endif>
                                                    <label class="custom-control-label" for="customSwitch1">{{__('Deposit Status')}}</label>
                                                </div>
                                             </div>

                                            <div class="col-md-3">
                                                <div class="custom-control custom-switch mb-4">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch2"  name="withdrawal_status" @if(isset($item) && $item->withdrawal_status==1)checked  @endif>
                                                    <label class="custom-control-label" for="customSwitch2">{{__('Withdrawal Status')}}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="custom-control custom-switch mb-4">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch3" name="active_status" @if(isset($item) && $item->active_status==1)checked  @endif>
                                                    <label class="custom-control-label" for="customSwitch3">{{__('Active Status')}}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="custom-control custom-switch mb-4">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch4" name="is_currency" @if(isset($item) && $item->is_currency==1)checked  @endif>
                                                    <label class="custom-control-label" for="customSwitch4">{{__('Is Currency')}}</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-lg-6 col-xl-4">
                                                <div class="form-label">{{__('Coin Icon')}}</div>
                                                <div class="form-group choose-coin-icon-group">
                                                    <div class="input-group">
                                                        <div class="input-group-btn mb-3">
                                                            <span class="btn btn-default">
                                                                <input type="file" name="coin_icon">
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="coin-icon-img-wrap">
                                                        <img src="{{empty($item->coin_icon) ? '' : getImageUrl(coinIconPath() . $item->coin_icon)}}">
                                                    </div>

                                                    <img id='img-upload'/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                @if(isset($item))<input type="hidden" name="coin_id" value="{{encrypt($item->id)}}">  @endif
                                                <button type="submit" class="btn btn-info">{{$button_title}} {{__('Coin')}}</button>
                                            </div>
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
