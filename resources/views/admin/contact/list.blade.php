@extends('admin.master',['menu'=>'contacts'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div id="table-url" data-url="{{route('admin_contact_list')}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Contact List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Contact')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Contact List')}}</li>
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
                            <h3 class="card-title">{{__("Contact List")}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="desktop">{{__('Title')}}</th>
                                        <th scope="col" class="all">{{__('Email')}}</th>
                                        <th scope="col" class="none">{{__('Message')}}</th>
                                        <th scope="col" class="none">{{__('Attached File')}}</th>
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
    <script src="{{asset('assets/admin/dist/js/pages/contact/list.js')}}"></script>
@endsection
