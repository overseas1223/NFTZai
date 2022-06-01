@extends('admin.master',['menu'=>'faq', 'sub_menu' => __('heading')])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div id="table-url" data-url="{{route('admin_faq_heading')}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('FAQ Heading List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('FAQ')}}</a></li>
                        <li class="breadcrumb-item active">{{__('FAQ Heading List')}}</li>
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
                            <h3 class="card-title">{{__("FAQ Heading List")}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="desktop">{{__('Title')}}</th>
                                        <th class="all">{{__('Icon')}}</th>
                                        <th class="desktop">{{__('Action')}}</th>
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
    <script src="{{asset('assets/admin/dist/js/pages/faq/heading/list.js')}}"></script>
@endsection
