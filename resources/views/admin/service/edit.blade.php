@extends('admin.master',['menu'=>'service_list'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Edit Service')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Service')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Edit Service')}}</li>
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
                            <h3 class="card-title">{{__('Edit Service')}}</h3>
                        </div>
                        <div class="card-body">
                            @include('admin.message')
                            <form method="POST" action="{{route('admin_update_service', encrypt($service->id))}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Title')}}</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="{{__('Enter title')}}" value="{{$service->title}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="category">{{__('Category')}}</label>
                                    <input type="text" class="form-control" id="category" name="category_id" value="{{ $service->category->title }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea id="description" class="form-control" name="description" readonly>{{$service->description}}</textarea>
                                </div>
                                @if ($service->type == 1)
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('Price (In USD)')}}</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1" name="title" placeholder="{{__('Enter price')}}" value="{{$service->price_dollar}}" readonly>
                                    </div>
                                @elseif($service->type == 2)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__('Minimum Bid Amount (In USD)')}}</label>
                                                <input type="number" class="form-control" id="exampleInputEmail1" name="title" placeholder="{{__('Min. bid amount')}}" value="{{$service->min_bid_amount}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{__('Maximum Bid Amount (In USD)')}}</label>
                                                <input type="number" class="form-control" id="exampleInputEmail1" name="title" placeholder="{{__('Max. bid amount')}}" value="{{$service->max_bid_amount}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Author')}}</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" value="{{$service->author->first_name.' '.$service->author->last_name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Color')}}</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" value="{{$service->color}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Image')}}</label> <br>
                                    <img src="{{asset(IMG_SERVICE_PATH.$service->thumbnail)}}" alt="{{__($service->title)}}" class="img-width-120">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is-slider" name="isSlider" {{$service->isSlider ==  1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is-slider">{{__('Include to Slider')}}</label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Comments')}}</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="comment" value="{{$service->comment}}">
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('Comment')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
