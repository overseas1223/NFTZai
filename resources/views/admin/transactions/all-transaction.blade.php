@extends('admin.master',['menu'=>'service-transaction', 'sub_menu' => 'all-transactions'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Transactions (Buy-Sell)')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Transactions')}}</a></li>
                        <li class="breadcrumb-item active">{{__('All Transactions')}}</li>
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
                            <h3 class="card-title">{{__("All Transactions")}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="all">{{__('Sell/Bid')}}</th>
                                        <th scope="col" class="all">{{__('Transaction Holder')}}</th>
                                        <th scope="col" class="all">{{__('Transaction Amount')}}</th>
                                        <th scope="col" class="all">{{__('Platform Earnings')}}</th>
                                        <th scope="col" class="all">{{__('Transaction Type')}}</th>
                                        <th scope="col" class="all">{{__('Transaction Time')}}</th>
                                        <th scope="col" class="desktop">{{__('Comments')}}</th>
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
    </section>
    <div id="table-url" data-url="{{route('admin_all_transaction')}}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/transactions/list.js')}}"></script>
@endsection
