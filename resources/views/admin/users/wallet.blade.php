@extends('admin.master',['menu'=>'wallet'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Wallet List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Wallet Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Wallet List')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__("User Wallet List")}}</h3>
                        </div>
                        <div class="card-body">

                            <div class="table-area">

                                <div class="table-responsive">

                                    {{-- <table id="table" class="table table-bordered table-striped"> --}}
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="desktop">{{__('User')}}</th>
                                                <th class="all">{{__('Type')}}</th>
                                                <th class="desktop">{{__('Coin Name')}}</th>
                                                <th class="desktop">{{__('Address')}}</th>
                                                <th class="desktop">{{__('Balance')}}</th>
                                                <th class="all">{{__('Update Date')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="table-url" data-url="{{route('admin_wallet_list')}}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/users/admin-wallet.js')}}"></script>
@endsection
