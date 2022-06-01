@extends('admin.master',['menu'=>'news_list'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Add News')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('News')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Add News')}}</li>
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
                            <h3 class="card-title">{{__('Add News')}}</h3>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <form method="POST" action="{{route('admin_store_news')}}" enctype="multipart/form-data" class="admin-add-news-page">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Title')}}</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="{{__('Enter title')}}">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea id="description" class="form-control summernote" name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">{{__('Thumbnail')}}</label>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="hot-news" name="hot_news">
                                    <label class="form-check-label" for="hot-news">{{__('Include to Hot News')}}</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="trending-news" name="trending_news">
                                    <label class="form-check-label" for="hot-news">{{__('Include to Trending News')}}</label>
                                </div>
                                <button type="submit" class="btn btn-info mt-2">{{__('Add News')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/news/add.js')}}"></script>
@endsection
