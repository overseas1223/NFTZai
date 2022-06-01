@foreach($collections as $cu)
    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
        <div class="explore-item user-profile-item">
            <div class="artist-img position-relative">
                <img src="{{asset(IMG_SERVICE_PATH.$cu->thumbnail)}}" alt="explore-img" class="img-fluid">
                <div class="artist-overlay position-absolute">
                    <div class="price-box-wrap d-flex align-items-center justify-content-between">
                        @if ($cu->type == 1)
                            <div class="bg-green price-btn">{{visual_number_format($cu->price_dollar).' '.__('USD')}}</div>
                        @else
                            <div class="bg-green price-btn">{{__('Bid Now')}}</div>
                        @endif
                        <a href="{{route('product_view', encrypt($cu->id))}}" class="bg-white add-like"><i class="fas fa-heart"></i></a>
                    </div>
                    @if ($cu->type == 1)
                        <a href="{{route('product_view', encrypt($cu->id))}}" class="place-a-bid-btn">{{__('Purchase
                                                                    Now')}}</a>
                    @elseif($cu->type == 2)
                        <a href="{{route('product_view', encrypt($cu->id))}}" class="place-a-bid-btn">{{__('Place
                                                                    a Bid')}}</a>
                    @endif
                </div>
            </div>
            <div class="explore-content">
                <a href="{{route('product_view', encrypt($cu->id))}}"><h5 class="font-semi-bold">{{$cu->title}}</h5></a>
                <div class="explore-small-box explore-author-wrap d-flex align-items-center justify-content-between">
                    <div class="explore-author d-flex align-items-center">
                        <p>{{__('Uploaded')}} <span>{{\Carbon\Carbon::parse($cu->created_at)->format('jS F')}}</span></p>
                    </div>
                    <div class="like-box">
                        <i class="far fa-heart"></i> {{$cu->like}}
                    </div>
                </div>
                <div class="explore-small-box d-flex align-items-center justify-content-between">
                    <p class="on-sell">{{__('Status :')}} <span>{{service_status($cu->id)}}</span></p>
                    <p class="font-medium top-artist-stock-qty">{{number_format($cu->available_item)}}
                        {{__('in stock')}}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
