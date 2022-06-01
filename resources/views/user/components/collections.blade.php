<div class="col-12 col-md-8 col-lg-9">
    <div class="search-rightside-area">
        <div class="artists-nav-wrap d-flex justify-content-between">
            <ul class="nav nav-tabs tab-nav-list border-0" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{Route::is('user_profile') ? 'active' : '' }}" data-toggle="tab" href="#On_sale" role="tab">{{__('on
                        sales')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Route::is('my_collections') ? 'active' : '' }}" data-toggle="tab" href="#Collectibles" role="tab">{{__('Collectibles')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Created" role="tab">{{__('Draft')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Like" role="tab">{{__('Like')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Following" role="tab">{{__('Following')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Followers" role="tab">{{__('Followers')}}</a>
                </li>
            </ul>

        </div>
        <div class="tab-content">
            <div class="top-artist-warp tab-pane {{Route::is('user_profile') ? 'active show' : ''}}" id="On_sale" role="tabpanel">
                <div class="row" id="post-sale">

                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="load-more-btn theme-button2 mt-3" id="load-more-sale" data-paginate="2">{{__('Load
                            More')}}</button>
                    </div>
                </div>
            </div>

            <div class="top-artist-warp fade tab-pane {{Route::is('my_collections') ? 'active show' : ''}}" id="Collectibles" role="tabpanel">
                <div class="row" id="post">

                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="load-more-btn theme-button2 mt-3" id="load-more" data-paginate="2">{{__('Load More')}}</button>
                    </div>
                </div>
            </div>

            <div class="top-artist-warp fade tab-pane" id="Created" role="tabpanel">
                <div class="row" id="post-created">

                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <button class="load-more-btn theme-button2 mt-3" id="load-more-created" data-paginate="2">{{__('Load
                            More')}}</button>
                    </div>
                </div>
            </div>

            <div class="top-artist-warp fade tab-pane" id="Like" role="tabpanel">
                <div class="row" id="post-like">

                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="load-more-btn theme-button2 mt-3" id="load-more-like" data-paginate="2">{{__('Load
                            More')}}</button>
                    </div>
                </div>
            </div>
            <div class="top-artist-warp following-tab-wrap fade tab-pane" id="Following" role="tabpanel">
                <div class="row" id="following">
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="load-more-btn theme-button2 mt-3" id="load-more-following" data-paginate="2">{{__('Load
                            More')}}</button>
                    </div>
                </div>
            </div>
            <div class="top-artist-warp following-tab-wrap fade tab-pane" id="Followers" role="tabpanel">
                <div class="row" id="follower">
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="load-more-btn theme-button2 mt-3" id="load-more-follower" data-paginate="2">{{__('Load
                            More')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="{{route('on_sales_data')}}" id="on-sale-data">
<input type="hidden" value="{{route('my_collection_data')}}" id="my-collection-data">
<input type="hidden" value="{{route('my_created_data')}}" id="my-created-data">
<input type="hidden" value="{{route('my_like_data')}}" id="my-like-data">
<input type="hidden" value="{{route('update_cover_photo')}}" id="update-cover-photo">
<input type="hidden" value="{{route('following_data')}}" id="following-data">
<input type="hidden" value="{{route('follower_data')}}" id="follower-data">
@section('script')
    <script src="{{asset('assets/user/js/pages/collections-component.js')}}"></script>
@endsection
