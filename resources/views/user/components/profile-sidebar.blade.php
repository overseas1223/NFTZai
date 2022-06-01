<!-- Profile Sidebar Area Start -->
<div class="col-12 col-md-4 col-lg-3">
    <div class="search-sidebar-wrap user-profile-sidebar-wrap">
        <div class="user-profile-img">
            <img src="{{ isset(Auth::user()->photo) ? asset(IMG_USER_VIEW_PATH.Auth::user()->photo) : Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->toBase64()}}" alt="{{__('user')}}">
        </div>
        <div class="user-profile-sidebar-name">
            <h5>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h5>
            <p class="user-profile-sidebar-about font-13">{{Auth::user()->bio}}</p>
            <div class="user-profile-url">
                <a href="#" class="font-14">{{Auth::user()->website}}</a>
            </div>
        </div>
        <div class="user-profile-sidebar-follow-box">
            <button class="menu-round-btn theme-border" id="goToServiceCreate" data-id="{{route('service_create')}}" data-toggle="tooltip" data-placement="top" title="Upload">
                <i class="fas fa-upload"></i>
            </button>
            <button class="menu-round-btn theme-border" data-toggle="tooltip" data-placement="top" title="{{Auth::user()->country}}"><i class="far fa-flag"></i></button>
        </div>
        <div class="user-profile-sidebar-social-box">
            <ul class="d-flex align-items-center justify-content-center">
                <li><a href="{{isset(Auth::user()->social_media->facebook) ? Auth::user()->social_media->facebook : 'javascript:void(0)' }}" class="mx-2 p-2"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="{{isset(Auth::user()->social_media->twitter) ? Auth::user()->social_media->twitter : 'javascript:void(0)' }}" class="mx-2 p-2"><i class="fab fa-twitter"></i></a></li>
                <li><a href="{{isset(Auth::user()->social_media->instagram) ? Auth::user()->social_media->instagram : 'javascript:void(0)' }}" class="mx-2 p-2"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="membership-status">{{__('Member since')}} {{\Carbon\Carbon::parse(Auth::user()->created_at)->format('j M, Y')}}</div>
    </div>
</div>
