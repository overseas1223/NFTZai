@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    @include('user.components.profile-breadcumb')
    <!-- Profile Page Area start here  -->
    <section class="profile-page-area section-t-space section-b-90-space">
        <div class="container">
            <div class="row">
                @include('user.components.profile-sidebar')
                <!-- Profile rightside Area -->
                @include('user.components.collections')
                <!-- Profile rightside Area -->
            </div>
        </div>
    </section>
    <!-- Profile Page Area end here  -->
@endsection
