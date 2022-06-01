@extends('admin.master',['menu'=>'service_list'])
@section('title', isset($title) ? $title : '')
@section('content')
    <!-- breadcrumb -->
    <div id="table-url" data-url="{{route('admin_service_list')}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Artworks')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Artwork Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Artworks')}}</li>
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
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs admin-services-tab-list user-page-tab-list mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a data-id="active_users" class="nav-link active" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="true">
                                        <span><i class="fas fa-list"></i> {{__('Artwork List')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-id="service_request" class="nav-link" id="pills-email-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-email" aria-selected="true">
                                        <span><i class="fas fa-american-sign-language-interpreting"></i>{{__('Artwork Request')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                                    <div class="table-area">
                                        <div class=" table-responsive">
                                            <table id="table" class="table table-bordered table-striped dataTable display width-100-per">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="all">{{__('Title')}}</th>
                                                    <th scope="col" class="none">{{__('Description')}}</th>
                                                    <th scope="col" class="all">{{__('Mint Address')}}</th>
                                                    <th scope="col" class="all">{{__('Owner')}}</th>
                                                    <th scope="col" class="all">{{__('Category')}}</th>
                                                    <th scope="col" class="all">{{__('Type')}}</th>
                                                    <th scope="col" class="all">{{__('Selling Type')}}</th>
                                                    <th scope="col" class="all">{{__('Price')}}</th>
                                                    <th scope="col" class="none">{{__('Bid Amount (In USD)')}}</th>
                                                    <th scope="col" class="all">{{__('Views')}}</th>
                                                    <th scope="col" class="all">{{__('Likes')}}</th>
                                                    <th scope="col" class="all">{{__('Thumbnail')}}</th>
                                                    <th scope="col" class="none">{{__('Comment')}}</th>
                                                    <th scope="col" class="all">{{__('Slider')}}</th>
                                                    <th scope="col" class="all">{{__('Status')}}</th>
                                                    <th scope="col" class="all">{{__('Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="pills-suspended-user" role="tabpanel" aria-labelledby="pills-suspended-user-tab">
                                    <div class="table-area">
                                        <div class=" table-responsive">
                                            <table id="table" class="table table-bordered table-striped dataTable display text-center width-100-per">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="all">{{__('Title')}}</th>
                                                    <th scope="col" class="none">{{__('Description')}}</th>
                                                    <th scope="col" class="all">{{__('Mint Address')}}</th>
                                                    <th scope="col" class="all">{{__('Owner')}}</th>
                                                    <th scope="col" class="all">{{__('Category')}}</th>
                                                    <th scope="col" class="all">{{__('Type')}}</th>
                                                    <th scope="col" class="all">{{__('Available Stock')}}</th>
                                                    <th scope="col" class="all">{{__('Price')}}</th>
                                                    <th scope="col" class="none">{{__('Bid Amount (In USD)')}}</th>
                                                    <th scope="col" class="all">{{__('Views')}}</th>
                                                    <th scope="col" class="all">{{__('Likes')}}</th>
                                                    <th scope="col" class="all">{{__('Thumbnail')}}</th>
                                                    <th scope="col" class="none">{{__('Comment')}}</th>
                                                    <th scope="col" class="all">{{__('Slider')}}</th>
                                                    <th scope="col" class="all">{{__('Status')}}</th>
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
            </div>
        </div>
    </section>
@endsection
@section('script')
    @if(isset($errors->all()[0]))
        <script src="{{asset('assets/admin/dist/js/pages/service/tab.js')}}"></script>
    @endif
    <script src="{{asset('assets/admin/dist/js/pages/service/list.js')}}"></script>
@endsection






















