@extends('admin.master',['menu'=>'users', 'sub_menu'=>'user'])
@section('title', isset($title) ? $title : '')
@section('content')
    <!-- breadcrumb -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('User')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('User Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('User')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <section class="content">
        <div class="container-fluid user-management">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs mb-3 user-page-tab-list" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a data-id="active_users" class="nav-link active" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="true">
                                        <img src="{{asset('assets/admin/images/user-management-icons/user.svg')}}" class="img-fluid" alt="{{__('image')}}">
                                        <span>{{__('User List')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-id="profile_tab" class="nav-link add_user" id="pills-add-user-tab" data-toggle="pill" href="#pills-add-user" role="tab" aria-controls="pills-add-user" aria-selected="true">
                                        <img src="{{asset('assets/admin/images/user-management-icons/add-user.svg')}}" class="img-fluid" alt="{{__('image')}}">
                                        <span>{{__('Add User')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-id="suspend_user" class="nav-link" id="pills-suspended-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-suspended-user" aria-selected="true">
                                        <img src="{{asset('assets/admin/images/user-management-icons/block-user.svg')}}" class="img-fluid" alt="{{__('image')}}">
                                        <span>{{__('Suspended User')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-id="deleted_user" class="nav-link" id="pills-deleted-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-deleted-user" aria-selected="true">
                                        <img src="{{asset('assets/admin/images/user-management-icons/delete-user.svg')}}" class="img-fluid" alt="{{__('image')}}">
                                        <span>{{__('Deleted User')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-id="email_pending" class="nav-link" id="pills-email-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-email" aria-selected="true">
                                        <img src="{{asset('assets/admin/images/user-management-icons/email.svg')}}" class="img-fluid" alt="{{__('image')}}">
                                        {{__('Email Pending')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                                    <div class="table-area">
                                        <div class="table-responsive">
                                            <table id="table" class="table table-bordered table-striped dataTable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="all">{{__('User Name')}}</th>
                                                        <th scope="col" class="desktop">{{__('Email ID')}}</th>
                                                        <th scope="col" class="all">{{__('Role')}}</th>
                                                        <th scope="col" class="desktop">{{__('Status')}}</th>
                                                        <th scope="col" class="desktop">{{__('Created At')}}</th>
                                                        <th scope="col" class="all">{{__('Activity')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane add_user" id="pills-add-user" role="tabpanel" aria-labelledby="pills-add-user-tab">
                                    <div class="header-bar">
                                        <div class="table-title">
                                            <h3>{{__('Add User')}}</h3>
                                        </div>
                                    </div>
                                    <div class="add-user-form">
                                        <form action="{{route('admin_user_add_edit')}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">{{__('First Name')}}</label>
                                                        <input type="text" name="first_name" class="form-control" id="firstname" value="{{old('first_name')}}"  placeholder="First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">{{__('Last Name')}}</label>
                                                        <input name="last_name" type="text" class="form-control" id="lastname" value="{{old('last_name')}}"  placeholder="Last Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">{{__('Email')}}</label>
                                                        <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}" placeholder="Email address">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">{{__('Phone Number')}}</label>
                                                        <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}"  placeholder="phone">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{__('Role')}}</label>
                                                        <div class="cp-select-area">
                                                            <select name="role" class="wide form-control">
                                                                <option value="{{USER_ROLE_ADMIN}}">{{__('Admin')}}</option>
                                                                <option data-display="User" value="{{USER_ROLE_USER}}">{{__('User')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-info mt-2">{{__('Save User')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="pills-suspended-user" role="tabpanel" aria-labelledby="pills-suspended-user-tab">
                                    <div class="header-bar">
                                        <div class="search">
                                            <form>
                                                <div class="form-group">
                                                    <input type="search" class="form-control" placeholder="Search">
                                                    <button class="btn btn-search"><img src="{{asset('assets/admin/images/search.svg')}}" class="img-fluid" alt="{{__('image')}}"></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-area">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped dataTable display text-center width-100-per">
                                                <thead>
                                                <tr>
                                                    <th>{{__('First Name')}}</th>
                                                    <th>{{__('Last Name')}}</th>
                                                    <th>{{__('Email ID')}}</th>
                                                    <th>{{__('Updated At')}}</th>
                                                    <th>{{__('Activity')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-pagination">
                                            <ul>
                                                <li><a href="javascript:void(0)"><img src="{{asset('assets/admin/images/angle-left.svg')}}" class="img-fluid" alt="{{__('image')}}"></a></li>
                                                <li class="active"><a href="javascript:void(0)">{{__('1')}}</a></li>
                                                <li><a href="javascript:void(0)">{{__('2')}}</a></li>
                                                <li><a href="javascript:void(0)">{{__('3')}}</a></li>
                                                <li><a href="javascript:void(0)"><img src="{{asset('assets/admin/images/angle-right.svg')}}" class="img-fluid" alt="{{__('image')}}"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="table-url" data-url="{{route('admin_users')}}"></div>
@endsection
@section('script')
    @if(isset($errors->all()[0]))
        <script src="{{asset('assets/admin/dist/js/pages/users/tab.js')}}"></script>
    @endif
    <script src="{{asset('assets/admin/dist/js/pages/users/users.js')}}"></script>
@endsection
