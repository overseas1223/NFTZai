@extends('admin.master',['menu'=>'faq', 'sub_menu' => __('heading')])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Edit FAQ Heading')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('FAQ')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Edit FAQ Heading')}}</li>
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
                            <h3 class="card-title">{{__('Edit FAQ Heading')}}</h3>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <form method="POST" action="{{route('admin_faq_heading_update', encrypt($heading->id))}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">{{__('Title')}}</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="{{__('Enter title')}}" value="{{$heading->title}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">{{__('Icon')}}</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="icon" placeholder="{{__('Enter icon')}}" value="{{$heading->icon}}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info">{{__('Update FAQ')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
