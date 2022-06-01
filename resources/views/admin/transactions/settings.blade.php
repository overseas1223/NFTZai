@extends('admin.master',['menu'=>'service-transaction', 'sub_menu' => 'transaction-settings'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Service Charge Settings')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Transactions')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Settings')}}</li>
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
                            <h3 class="card-title">{{__('Service Charge Settings')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('admin.message')
                            <form method="POST" action="{{route('admin_service_charge_update')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('Buyer Service Charge (fixed)')}}</label>
                                            <input type="number" min="0" step="0.00001" class="form-control" id="exampleInputEmail1" name="buyer_sc_fixed" value="{{SCAmount('buyer', SERVICE_CHARGE_FIXED)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('Buyer Service Charge (percentage)')}}</label>
                                            <input type="number" min="0" step="0.00001" class="form-control" id="exampleInputEmail1" name="buyer_sc_percent" value="{{SCAmount('buyer', SERVICE_CHARGE_PERCENTAGE)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('Activate')}}</label>
                                            <select name="buyer_sc_active" class="form-control">
                                                <option value="buyer_fixed" {{SCActive('buyer', SERVICE_CHARGE_FIXED) ? 'selected' : ''}}>{{__('Fixed')}}</option>
                                                <option value="buyer_percent" {{SCActive('buyer', SERVICE_CHARGE_PERCENTAGE) ? 'selected' : ''}}>{{__('Percentage')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('Seller Service Charge (fixed)')}}</label>
                                            <input type="number" min="0" step="0.00001" class="form-control" id="exampleInputEmail1" name="seller_sc_fixed" value="{{SCAmount('seller', SERVICE_CHARGE_FIXED)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('Seller Service Charge (percentage)')}}</label>
                                            <input type="number" min="0" step="0.00001" class="form-control" id="exampleInputEmail1" name="seller_sc_percent" value="{{SCAmount('seller', SERVICE_CHARGE_PERCENTAGE)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('Activate')}}</label>
                                            <select name="sellerr_sc_active" class="form-control">
                                                <option value="seller_fixed" {{SCActive('seller', SERVICE_CHARGE_FIXED) ? 'selected' : ''}}>{{__('Fixed')}}</option>
                                                <option value="seller_percent" {{SCActive('seller', SERVICE_CHARGE_PERCENTAGE) ? 'selected' : ''}}>{{__('Percentage')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info">{{__('Add Category')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
