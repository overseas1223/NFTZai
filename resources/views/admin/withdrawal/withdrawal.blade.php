@extends('admin.master',['menu'=>'transaction', 'sub_menu'=>'withdrawal'])
@section('title', isset($title) ? $title : '')
@section('content')
    <!-- breadcrumb -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Deposit/Withdrawal')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Deposit/Withdrawal')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Withdraw History')}}</li>
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
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs user-page-tab-list" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">{{__('Pending')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">{{__('Rejected')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">{{__('Accepted')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="desktop">{{__('Type')}}</th>
                                            <th class="desktop">{{__('Sender')}}</th>
                                            <th class="">{{__('Address')}}</th>
                                            <th class="desktop">{{__('Receiver')}}</th>
                                            <th class="desktop">{{__('Amount')}}</th>
                                            <th class="desktop">{{__('Fees')}}</th>
                                            <th class="">{{__('Transaction Id')}}</th>
                                            <th class="desktop">{{__('Time')}}</th>
                                            <th class="desktop">{{__('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                    <table id="reject-withdrawal" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="all">{{__('Type')}}</th>
                                                <th class="all">{{__('Sender')}}</th>
                                                <th class="">{{__('Address')}}</th>
                                                <th class="all">{{__('Receiver')}}</th>
                                                <th class="all">{{__('Amount')}}</th>
                                                <th class="all">{{__('Fees')}}</th>
                                                <th class="">{{__('Transaction Id')}}</th>
                                                <th class="all">{{__('Time')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                    <table id="success-withdrawal" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="all">{{__('Type')}}</th>
                                            <th class="all">{{__('Sender')}}</th>
                                            <th class="">{{__('Address')}}</th>
                                            <th class="all">{{__('Receiver')}}</th>
                                            <th class="all">{{__('Amount')}}</th>
                                            <th class="all">{{__('Fees')}}</th>
                                            <th class="">{{__('Transaction Id')}}</th>
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
        </div>
    </section>
    <div id="table-url-one" data-url="{{route('admin_pending_withdrawal')}}"></div>
    <div id="table-url-two" data-url="{{route('admin_rejected_withdrawal')}}"></div>
    <div id="table-url-three" data-url="{{route('admin_success_withdrawal')}}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/withdrawls/withdrawl.js')}}"></script>
@endsection
