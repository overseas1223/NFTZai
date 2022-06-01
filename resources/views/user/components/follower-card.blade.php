@foreach ($collections as $item)
    <div class="col-12">
        <div class="followers-item">
            <div class="followers-user">
                <div class="followers-avatar mr-3"><img src="{{ isset($item->follower->photo) ? asset(IMG_USER_VIEW_PATH.$item->follower->photo) : Avatar::create($item->follower->first_name.' '.$item->follower->last_name)->toBase64()}}" alt="{{__('Avatar')}}"></div>
                <div class="followers-details">
                    <h4 class="followers-name font-medium font-18">{{$item->follower->first_name.' '.$item->follower->last_name}}</h4>
                    <div class="followers-subname font-14">{{$item->follower->country}}</div>
                    <div class="followers-specialist font-14 font-weight-bold">{{__('Seller')}}</div>

                    <div class="followers-btns d-flex align-items-center">
                        @if (Auth::check() == true && Auth::user()->role == USER_ROLE_USER)
                            <a href="{{isFollowed($item->follower->id) == 0 ? route('follow_seller', encrypt($item->follower->id)) : 'javascript:void(0)'}}" class="button-small theme-button2 followers-button">{{isFollowed($item->follower->id) == 0 ? __('Follow') : __('Followed')}}</a>
                        @else
                            <button class="button-small theme-button2 followers-button" type="button" data-toggle="modal" data-target="#notAuthModal">{{__('Follow')}}</button>
                        @endif
                        <div class="followers-counter font-13 ml-3"><span class="color-heading font-medium">{{countFollowers($item->follower->id)}}</span>
                            {{__('followers')}}</div>
                    </div>
                </div>
            </div>
            <div class="followers-wrap">
                <div class="followers-gallery">
                    @foreach(followServices($item->follower->id) as $sr)
                        <div class="followers-preview"><img src="{{asset(IMG_SERVICE_PATH.$sr->thumbnail)}}" alt="{{__('Follower')}}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
