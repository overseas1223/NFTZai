@extends('admin.master',['menu'=>'category_list'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div id="table-url" data-url="{{route('admin_category_list')}}"></div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Category List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Category Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Category List')}}</li>
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
                            <h3 class="card-title float-right"><a href="{{route('admin_add_category')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{__('Add')}}</a></h3>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <div class="table-area">
                                <div class=" table-responsive">
                                    <table id="slider" class="table table-bordered table-striped dataTable display width-100-per">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="all">{{__('Title')}}</th>
                                            <th scope="col" class="none">{{__('Description')}}</th>
                                            <th scope="col" class="all">{{__('Created At')}}</th>
                                            <th scope="col" class="all">{{__('Actions')}}</th>
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
    <script src="{{asset('assets/admin/dist/js/pages/categories/list.js')}}"></script>
@endsection
