@extends('admin.master',['menu'=>'service_list'])
@section('title', isset($title) ? $title : '')
@section('content')
    <!-- breadcrumb -->
    <div id="table-url" data-url="{{route('admin_show_bid', encrypt($id))}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Bid Details of ').$bid_details->title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Service Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Service')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <section class="content">
        <div class="container-fluid user-management">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @include('admin.message')
                        <div class="card-header">
                            <h3 class="card-title">{{__('Bid Details of ').$bid_details->title}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-area">
                                <div class=" table-responsive">
                                    <table id="table" class="table table-bordered table-striped dataTable display text-center">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="all">{{__('User')}}</th>
                                            <th scope="col" class="all">{{__('Bid Amount (in USD)')}}</th>
                                            <th scope="col" class="all">{{__('Transaction ID')}}</th>
                                            <th scope="col" class="all">{{__('Time')}}</th>
                                            <th scope="col" class="all">{{__('Action')}}</th>
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
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/service/bid.js')}}"></script>
@endsection
