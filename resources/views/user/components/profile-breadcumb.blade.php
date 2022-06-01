<section class="page-banner-area user-profile-banner-area p-0" style="background-image: url({{is_null(Auth::user()->cover_photo) ? asset('assets/user/img/page-banner2.jpg') : asset(IMG_USER_COVER_PHOTO.Auth::user()->cover_photo)}});">
    <div class="container">
        <div class="row page-banner-top-space">
            <div class="col-12 col-lg-12">
                <div class="page-banner-content text-center">
                    <h1 class="page-banner-title">{{__('Profile')}}</h1>
                    <div class="user-profile-banner-btns">
                        <a href="{{route('edit_profile')}}" class="user-profile-banner-btn theme-button2">{{__('Edit profile')}}<i class="far fa-edit"></i></a>
                        <form enctype="multipart/form-data" id="imageUpload">
                            @csrf
                            <div class="custom-file-upload">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input cover-photo confirm-cover-photo" id="customFile" name="filename">
                                    <label class="custom-file-label user-profile-banner-btn theme-button2 " for="customFile">
                                        <span class="">{{__('Edit cover photo')}}<i class="far fa-file-image"></i></span>
                                    </label>
                                </div>
                            </div>
                            <button id="imgsubmit" class="btn btn-success d-none"></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<section class="breadcrumb-section p-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="breadcrumb-area">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('login')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Profile')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

