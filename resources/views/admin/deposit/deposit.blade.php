@extends('admin.master',['menu'=>'transaction', 'sub_menu'=>'deposit'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div id="table-url" data-url="{{route('deposit_history')}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Deposit/Withdrawal')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Deposit/Withdrawal')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Deposit History')}}</li>
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
                            <h3 class="card-title">{{__("Deposit History")}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="all">{{__('Type')}}</th>
                                        <th class="all">{{__('Sender')}}</th>
                                        <th class="">{{__('Address')}}</th>
                                        <th class="desktop">{{__('Receiver')}}</th>
                                        <th class="desktop">{{__('Amount')}}</th>
                                        <th class="desktop">{{__('Fees')}}</th>
                                        <th class="">{{__('Transaction Id')}}</th>
                                        <th class="desktop">{{__('Status')}}</th>
                                        <th class="all">{{__('Time')}}</th>
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
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/deposit/deposit.js')}}"></script>
@endsection
