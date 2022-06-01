@foreach ($collections as $item)
    <div class="col-12">
        <div class="followers-item">
            <div class="followers-user">
                <div class="followers-avatar mr-3"><img src="{{ isset($item->following_user->photo) ? asset(IMG_USER_VIEW_PATH.$item->following_user->photo) : Avatar::create($item->following_user->first_name.' '.$item->following_user->last_name)->toBase64()}}" alt="{{__('Avatar')}}"></div>
                <div class="followers-details">
                    <h4 class="followers-name font-medium font-18">{{$item->following_user->first_name.' '.$item->following_user->last_name}}</h4>
                    <div class="followers-subname font-14">{{$item->following_user->country}}</div>
                    <div class="followers-specialist font-14 font-weight-bold">{{__('Seller')}}</div>

                    <div class="followers-btns d-flex align-items-center">
                        @if (Auth::check() == true && Auth::user()->role == USER_ROLE_USER)
                            <a href="{{route('unfollow_seller', encrypt($item->following_user->id))}}" class="button-small theme-button2 followers-button">{{__('Unfollow')}}</a>
                        @else
                            <button class="button-small theme-button2 followers-button" type="button" data-toggle="modal" data-target="#notAuthModal">{{__('Unfollow')}}</button>
                        @endif
                        <div class="followers-counter font-13 ml-3"><span class="color-heading font-medium">{{countFollowers($item->following_user->id)}}</span>
                            {{__('followers')}}</div>
                    </div>
                </div>
            </div>
            <div class="followers-wrap">
                <div class="followers-gallery">
                    @foreach(followServices($item->following_user->id) as $sr)
                    <div class="followers-preview"><img src="{{asset(IMG_SERVICE_PATH.$sr->thumbnail)}}" alt="{{__('Follower')}}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
