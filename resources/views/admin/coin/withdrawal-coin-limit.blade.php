@extends('admin.master',['menu'=>'setting','sub_menu'=>'withdrawal-limit'])
@section('title',__('Withdrawal Limit Settings'))
@section('content')
    <section class="content">
        {{-- <div class="container-fluid"> --}}
            {{-- <div class="row"> --}}
                {{-- <div class="col-12"> --}}
                    <div class="main-content-inner">
                        {{-- <div class="row"> --}}
                            <div class="mt-5">
                                {{ Form::open(['route' => ['withdrawal_limit_save']]) }}
                                <div class="card p-4">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{-- <div class="col-md-12"> --}}
                                                    {{-- <div class="form-group"> --}}
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">{{__('Coin')}}</label>
                                                                    <div class="controls">
                                                                        <select name="coin_id" class="form-control">
                                                                            @foreach($coins as $coin)
                                                                                <option value="{{$coin->id}}">{{$coin->coin_type}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">{{__('From')}}</label>
                                                                    <div class="controls">
                                                                        <input type="text" class="form-control" placeholder="{{__('0.00')}}"
                                                                               name="from" value="<?php if (old('from') != null) {
                                                                            echo e(old('from'));
                                                                        }?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">{{__('To')}}</label>
                                                                    <div class="controls">
                                                                        <input type="text" class="form-control" placeholder="{{__('0.00')}}" name="to"
                                                                               value="<?php if (old('to') != null) {
                                                                                   echo e(old('to'));
                                                                               }?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- </div> --}}
                                                    {{-- <div class="form-group"> --}}
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                {{-- <label class="form-label">{{__('Google 2FA')}}</label>
                                                                <div class="controls">
                                                                    <label class="switch">
                                                                        <input type="checkbox" data-toggle="switch" value="1" name="google2fa" @if(isset($item) && $item->google2fa==1)checked  @endif>
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                </div> --}}

                                                                <div class="form-group">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" value="1" name="google2fa" @if(isset($item) && $item->google2fa==1)checked  @endif>
                                                                        <label class="custom-control-label" for="customSwitch1">{{__('Google 2FA')}}</label>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-4">

                                                                {{-- <label class="form-label">{{__('Email 2FA')}}</label>
                                                                <div class="controls">
                                                                    <label class="switch">
                                                                        <input type="checkbox" data-toggle="switch" value="1" name="email2fa" @if(isset($item) && $item->email2fa==1)checked  @endif>
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                </div> --}}

                                                                <div class="form-group">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" value="1" name="email2fa" @if(isset($item) && $item->email2fa==1)checked  @endif>
                                                                        <label class="custom-control-label" for="customSwitch2">{{__('Email 2FA')}}</label>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-4">
                                                                {{-- <label class="form-label">{{__('Admin Approval')}}</label>
                                                                <div class="controls">
                                                                    <label class="switch">
                                                                        <input type="checkbox" data-toggle="switch" name="admin_approval" @if(isset($item) && $item->admin_approval==1)checked  @endif>
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                </div> --}}

                                                                <div class="form-group">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch3" name="admin_approval" @if(isset($item) && $item->admin_approval==1)checked  @endif>
                                                                        <label class="custom-control-label" for="customSwitch3">{{__('Admin Approval')}}</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    {{-- </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if(isset($item))<input type="text" name="w_limit_id" value="{{encrypt($item->l_id)}}">  @endif
                                            <div class="col-md-12">
                                                <button class="btn btn-info btn-cons" type="submit"
                                                        name="submit">{{__('Save Coin Limit')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::close() }}
                                <div class="card p-4">
                                    <div class="card-block">
                                        <div class="">
                                            <h4>{{__('Withdrawals Coin Limit Level Lists')}}
                                            </h4>
                                            <hr>
                                            <div class="">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>{{__('Coin')}}</th>
                                                            <th>{{__('From')}}</th>
                                                            <th>{{__('To')}}</th>
                                                            <th>{{__('Google 2FA')}}</th>
                                                            <th>{{__('Email 2FA')}}</th>
                                                            <th>{{__('Admin Approval')}}</th>
                                                            <th>{{__('Created By')}}</th>
                                                            <th>{{__('Action')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(isset($sendLimits) && ($sendLimits->count() > 0))
                                                            <?php $level = 0; ?>
                                                            @foreach($sendLimits as $sendLimit)
                                                                <tr>
                                                                    <td>{{$sendLimit->coin_type}}</td>
                                                                    <td>{{$sendLimit->from}}</td>
                                                                    <td>{{$sendLimit->to}}</td>
                                                                    <td>{{$sendLimit->google2fa ? __('Yes') : __('False')}}</td>
                                                                    <td>{{$sendLimit->email2fa ? __('Yes') : __('False')}}</td>
                                                                    <td>{{$sendLimit->admin_approval ? __('Yes') : __('False')}}</td>

                                                                    <td>
                                                                        <a title="View User" data-toggle="tooltip"
                                                                           href="{{ route('admin_user_profile').'?id='.encrypt($sendLimit->created_by)}}">{{$sendLimit->user->email}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="activity-icon">
                                                                            <ul>
                                                                                <li>
                                                                                    <a title="Update Limit" data-toggle="tooltip"
                                                                                        href="{{route('update_withdrawal_limit',['id'=>encrypt($sendLimit->l_id)])}}"
                                                                                        class="user-list-actions-icon btn-success">
                                                                                            <i class="fas fa-pencil-alt"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a title="Delete Limit" data-toggle="tooltip"
                                                                                        href="#" data-setting-id="{{encrypt($sendLimit->l_id)}}"
                                                                                        class="user-list-actions-icon bg-danger">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="11">{{__('No Withdrawal Limit Settings Found!')}}</td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                        <tfoot>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    {{-- </div> --}}
                {{-- </div> --}}
            </div>
        {{-- </div> --}}
    </section>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/coin/withdrawls-coin-limit.js')}}"></script>
@endsection
