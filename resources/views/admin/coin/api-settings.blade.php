@extends('admin.master',['menu'=>'coin','sub_menu'=>'api-settings'])
@section('title',__('Api Settings'))
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="main-content-inner">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body admin-api-settings-form-wrap">
                                        {{Form::open(['route'=>'api_settings_save'])}}
                                        <div class="row">
                                            @if(isset($coins[0]))
                                                @foreach($coins as $coin)
                                                    <label class="col-sm-12 form-group-title" for=""
                                                           >{{ __(':coin Api Credentials',['coin'=>$coin->coin_type]) }}</label>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="form-label">{{__(':coin User',['coin'=>$coin->coin_type])}}</div>
                                                                <select name="api_service[]" class="form-control">
                                                                    @foreach(api_service() as $key=>$val)
                                                                        <option @if($coin->api_service==$key)selected
                                                                                @endif value="{{$key}}">{{$val}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="form-label">{{__(':coin Withdrawal Fees Percent',['coin'=>$coin->coin_type])}}</div>
                                                                <input type="text" class="form-control fees-amount" name="withdrawal_fee_percent[]"
                                                                       value="{{$coin->withdrawal_fee_percent}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="form-label">{{__(':coin Withdrawal Fees Fixed',['coin'=>$coin->coin_type])}}</div>
                                                                <input type="text" class="form-control fees-amount" name="withdrawal_fee_fixed[]"
                                                                       value="{{$coin->withdrawal_fee_fixed}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <div class="form-label">{{__(':coin Withdrawal Fees Method',['coin'=>$coin->coin_type])}}</div>
                                                                <select name="withdrawal_fee_method[]" class="form-control">
                                                                    @foreach(withdrawalFeesMethod() as $key => $val)
                                                                        <option @if($coin->withdrawal_fee_method == $key){{__('selected')}}
                                                                                @endif value="{{$key}}">{{$val}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="coin_id[]"
                                                           @if(!empty($coin->id))value="{{encrypt($coin->id)}}" @endif>
                                                @endforeach
                                            @endif
                                            <div class="col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-info">{{__('Update')}}</button>
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
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/coin/api-setting.js')}}"></script>
@endsection
