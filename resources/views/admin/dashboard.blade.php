@extends('admin.master',['menu'=>'dashboard'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Dashboard')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Dashboard')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{visual_number_format($total_deposit_coin)}}</h3>

                            <p>{{__('Total Deposit')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('deposit_history')}}" class="small-box-footer">{{__('More info')}} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{visual_number_format($total_withdrawal_coin)}}</h3>

                            <p>{{__('Total Withdrawal')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('admin_pending_withdrawal')}}" class="small-box-footer">{{__('More info')}} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$total_user}}</h3>

                            <p>{{__('Total User')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('admin_users')}}" class="small-box-footer">{{__('More info')}} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$earnings}}</h3>
                            <p>{{__('Artworks')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('admin_service_list')}}" class="small-box-footer">{{__('More info')}} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-top mb-3">
                                <h4>{{__('Withdrawal')}}</h4>
                            </div>
                            <p class="subtitle">{{__('Current Year')}}</p>
                            <canvas id="withdrawalChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-top mb-3">
                                <h4>{{__('Deposit')}}</h4>
                            </div>
                            <p class="subtitle">{{__('Current Year')}}</p>
                            <canvas id="depositChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-top mb-3">
                                    <h4>{{__('Pending Withdrawal')}}</h4>
                                </div>
                                <div class="table-area">
                                    <div class="table-responsive">
                                        {{-- <table id="pending_withdrwall" class="table-responsive table table-borderless custom-table display text-left width-100-per"> --}}
                                        <table id="pending_withdrwall" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="all">{{__('Type')}}</th>
                                                <th class="all">{{__('Sender')}}</th>
                                                <th class="all">{{__('Address')}}</th>
                                                <th class="all">{{__('Receiver')}}</th>
                                                <th class="all">{{__('Amount')}}</th>
                                                <th class="all">{{__('Fees')}}</th>
                                                <th class="all">{{__('Transaction Id')}}</th>
                                                <th class="all">{{__('Update Date')}}</th>
                                                <th class="all">{{__('Actions')}}</th>
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
    <div id="monthly_deposit" data-dt='{!! json_encode($monthly_deposit) !!}'></div>
    <div id="monthly_withdrawal" data-dt='{!! json_encode($monthly_withdrawal) !!}'></div>
    <div id="admin_pending_withdrawal" data-dt="{{route('admin_pending_withdrawal')}}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/chart/chart.min.js')}}"></script>
    <script src="{{asset('assets/admin/dist/js/datatables/dashboard.js')}}"></script>
@endsection
