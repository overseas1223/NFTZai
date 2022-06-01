@extends('admin.master',['menu'=>'news_list'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div id="table-url" data-url="{{route('admin_news_list')}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('News List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('News Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('News List')}}</li>
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
                            <h3 class="card-title float-right"><a href="{{route('admin_add_news')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{__('Add')}}</a></h3>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <div class="table-area">
                                <div class="table-responsive">
                                    {{-- <table id="slider" class="table table-bordered table-striped responsive"> --}}
                                    <table id="slider" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="all">{{__('Title')}}</th>
                                            <th scope="col" class="none">{{__('Description')}}</th>
                                            <th scope="col" class="none">{{__('thumbnail')}}</th>
                                            <th scope="col" class="all">{{__('views')}}</th>
                                            <th scope="col" class="all">{{__('likes')}}</th>
                                            <th scope="col" class="all">{{__('Created At')}}</th>
                                            <th scope="col" class="all">{{__('Actions')}}</th>
                                        </tr>
                                        </thead>
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
    <script src="{{asset('assets/admin/dist/js/pages/news/list.js')}}"></script>
@endsection
