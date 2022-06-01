@extends('zainiklab.installer.layout')

@section('title', 'Configuration')

@section('content')
    <div class="section-wrap-body">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$errors->first()}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="primary-form">
            <form action="{{ route('ZaiInstaller::final') }}" method="POST">
                @csrf
                <div class="single-section">
                    <h4 class="section-title">{{__('Please enter your application details')}}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="AppName">App Name</label>
                                <input type="text" class="form-control" id="AppName" name="app_name" value="{{ env('APP_NAME') }}" placeholder="{{__('ZaiInstaller')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="AppURL">App URL</label>
                                <input type="text" class="form-control" id="AppURL" name="app_url" value="{{ env('APP_URL') }}" placeholder="{{__('http://localhost:8000')}}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-section">
                    <h4 class="section-title">{{__('Please enter your database connection details')}}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="DatabaseHost">{{__('Database Host')}}</label>
                                <input type="text" class="form-control" id="DatabaseHost" name="db_host" value="{{ env('DB_HOST') }}" placeholder="{{__('localhost')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="DatabaseUser">Database User</label>
                                <input type="text" class="form-control" id="DatabaseUser" name="db_user" value="{{ env('DB_USERNAME') }}" placeholder="{{__('root')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="DatabaseName">Database Name</label>
                                <input type="text" class="form-control" id="DatabaseName" name="db_name" value="{{ env('DB_DATABASE') }}" placeholder="{{__('zai_news')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control" id="Password" name="db_password" value="{{ env('DB_PASSWORD') }}" placeholder="{{__('password')}}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-section">
                    <h4 class="section-title">{{__('Please enter your SMTP details')}}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="MailHost">{{__('Mail Host')}}</label>
                                <input type="text" class="form-control" id="MailHost" name="mail_host" value="{{ env('MAIL_HOST') }}" placeholder="{{__('mailhog')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="MailPort">{{__('Port')}}</label>
                                <input type="text" class="form-control" id="MailPort" name="mail_port" value="{{ env('MAIL_PORT') }}" placeholder="{{__('root')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="MailUsername">{{__('Username')}}</label>
                                <input type="text" class="form-control" id="MailUsername" name="mail_username" value="{{ env('MAIL_USERNAME') }}" placeholder="{{__('zai_news')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="MailPassword">{{__('Password')}}</label>
                                <input type="password" class="form-control" id="MailPassword" name="mail_password" value="{{ env('MAIL_PASSWORD') }}" placeholder="{{__('password')}}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-section">
                    <h4 class="section-title">{{__('Please enter your Item purchase code')}}</h4>
                    <div class="form-group">
                        <label for="purchasecode">{{__('Item purchase code')}}</label>
                        <input type="text" class="form-control" id="purchasecode" name="purchasecode" value="NHLE-L6MI-4GE4-ETEV" placeholder="{{__('NHLE-L6MI-4GE4-ETEV')}}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button class="primary-btn">{{__('Close')}}</button>
                    </div>
                    <div class="col-6">
                        <button class="primary-btn next" type="submit">{{__('Next')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
