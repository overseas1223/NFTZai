@extends('admin.master',['menu'=>'setting', 'sub_menu'=>'payment-method'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-9">
                <ul>
                    <li>{{__('Setting')}}</li>
                    <li class="active-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <div class="user-management">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="header-bar p-4">
                        <div class="table-title">
                            <h3>{{ $title }}</h3>
                        </div>
                    </div>
                    <div class="table-area">
                        <div class="table-responsive">
                            <table id="table" class=" table table-bordered text-center">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('Method Name')}}</th>
                                    <th scope="col">{{__('Status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payment_methods as $key => $value)
                                    <tr>
                                        <td>
                                            {{$value}}
                                        </td>
                                        <td>
                                            @if($key == BTC)

                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" onclick="return processForm('payment_method_coin_payment')" id="notification" name="security" @if(isset($settings['payment_method_coin_payment']) && ($settings['payment_method_coin_payment'] == 1)) checked @endif>
                                                    <label class="custom-control-label" for="notification">Off/On</label>
                                                </div>

                                            @endif
                                            @if($key == BANK_DEPOSIT)

                                                <div>
                                                    <label class="switch custom-control custom-switch">
                                                        <input type="checkbox" onclick="return processForm('payment_method_bank_deposit')"
                                                        class="custom-control-input" id="notification" name="security" @if(isset($settings['payment_method_bank_deposit']) && ($settings['payment_method_bank_deposit'] == 1)) checked @endif>
                                                        <span class="slider" for="status"></span>
                                                    </label>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="table-url" data-url="{{ route('change_payment_method_status') }}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/settings/payment-method.js')}}"></script>
@endsection
