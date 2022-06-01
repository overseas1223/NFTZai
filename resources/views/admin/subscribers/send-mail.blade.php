@extends('admin.master',['menu'=>'subscribers'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Mail To Subscriber')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Subscribers')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Send Mail')}}</li>
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
                            <h3 class="card-title">{{__('Mail To Subscriber')}}</h3>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <form method="POST" action="{{route('admin_subscriber_mail_reply')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1">{{__('Email')}}</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="email" value="{{$subscriber->email_address}}" readonly>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1">{{__('Text')}}</label>
                                        <textarea name="reply" class="form-control" placeholder="{{__('Write something...')}}"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('Send Mail')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
