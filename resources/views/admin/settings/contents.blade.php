@extends('admin.master',['menu'=>'setting','sub_menu'=>'contents'])
@section('title',__('Contents'))
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="main-content-inner">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        {{Form::open(['route'=>'admin_contents_update'])}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Title (Famous Promo)')}}</div>
                                                        <input type="text" class="form-control" name="home_famous_title" value="{{allsetting()['home_famous_title']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Content (Famous Promo)')}}</div>
                                                        <input type="text" class="form-control" name="home_famous_content" value="{{allsetting()['home_famous_content']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Title (Latest)')}}</div>
                                                        <input type="text" class="form-control" name="home_latest_title" value="{{allsetting()['home_latest_title']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Content (Latest)')}}</div>
                                                        <input type="text" class="form-control" name="home_latest_content" value="{{allsetting()['home_latest_content']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Title (Explorer)')}}</div>
                                                        <input type="text" class="form-control" name="home_explorer_title" value="{{allsetting()['home_explorer_title']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Content (Explorer)')}}</div>
                                                        <input type="text" class="form-control" name="home_explorer_content" value="{{allsetting()['home_explorer_content']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Title (Footer)')}}</div>
                                                        <input type="text" class="form-control" name="home_footer_title" value="{{allsetting()['home_footer_title']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <div class="form-label">{{__('Content (Footer)')}}</div>
                                                        <input type="text" class="form-control" name="home_footer_content" value="{{allsetting()['home_footer_content']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-info">{{__('Update')}}</button>
                                            </div>
                                        </div>
                                        {{Form::close()}}
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
