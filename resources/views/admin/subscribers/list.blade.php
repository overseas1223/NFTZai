@extends('admin.master',['menu'=>'subscribers'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Subscriber List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Subscribers')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Subscriber List')}}</li>
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
                            <h3 class="card-title">{{__("Subscriber List")}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="desktop">{{__('Email')}}</th>
                                        <th scope="col" class="all">{{__('Status')}}</th>
                                        <th scope="col" class="all">{{__('Created')}}</th>
                                        <th scope="col" class="desktop">{{__('Action')}}</th>
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
    <div id="table-url" data-url="{{route('admin_subscriber_list')}}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/subscribers/list.js')}}"></script>
@endsection
