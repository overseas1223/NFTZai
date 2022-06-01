@extends('admin.master',['menu'=>'faq', 'sub_menu' => __('contents')])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Edit FAQ Content')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('FAQ')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Edit FAQ Content')}}</li>
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
                            <h3 class="card-title">{{__('Edit FAQ Content')}}</h3>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <form method="POST" action="{{route('admin_faq_content_update', encrypt($faq->id))}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">{{__('Question')}}</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="question" placeholder="{{__('Enter question')}}" value="{{$faq->question}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">{{__('heading')}}</label>
                                        <select name="fh_id" class="form-control">
                                            <option value="">{{__('---SELECT A HEADING---')}}</option>
                                            @foreach ($headings as $hd)
                                                <option value="{{$hd->id}}" {{$faq->fh_id == $hd->id ? 'selected' : ''}}>{{$hd->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1">{{__('Answer')}}</label>
                                        <textarea name="answer" class="form-control" placeholder="{{__('Enter answer')}}">{{$faq->answer}}</textarea>
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
