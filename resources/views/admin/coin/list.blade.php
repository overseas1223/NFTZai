@extends('admin.master',['menu'=>'coin', 'sub_menu'=>'coin_list'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div id="table-url" data-url="{{route('coin_list')}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Coin List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Coin Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Coin List')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-right"><a href="{{route('coin_add')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{__(' Add')}}</a></h3>
                        </div>
                        <div class="card-body">
                            <table id="slider" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>{{__('Icon')}}</th>
                                    <th>{{__('Coin Type')}}</th>
                                    <th>{{__('Full Name')}}</th>
                                    <th>{{__('Min Deposit')}}</th>
                                    <th>{{__('Deposit Status')}}</th>
                                    <th>{{__('Withdrawal Status')}}</th>
                                    <th>{{__('Earnings')}}</th>
                                    <th>{{__('Active Status')}}</th>
                                    <th>{{__('Created At')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/coin/list.js')}}"></script>
@endsection
