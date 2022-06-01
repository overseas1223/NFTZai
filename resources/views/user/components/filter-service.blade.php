@foreach($services as $st)
    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
        <div class="explore-item">
            <div class="artist-img position-relative">
                <img src="{{asset(IMG_SERVICE_PATH.$st->thumbnail)}}" alt="explore-img" class="img-fluid">
                <div class="artist-overlay position-absolute">
                    <div class="price-box-wrap d-flex align-items-center justify-content-between">
                        @if ($st->type == 1)
                            <div class="bg-green price-btn">{{visual_number_format($st->price_dollar).' '.__('USD')}}</div>
                        @else
                            <div class="bg-green price-btn">{{__('Bid Now')}}</div>
                        @endif
                        <button class="bg-white add-like"><i class="fas fa-heart"></i></button>
                    </div>
                    @if ($st->type == 1)
                        <a href="{{route('product_view', encrypt($st->id))}}" class="place-a-bid-btn">{{__('Purchase Now')}}</a>
                    @elseif($st->type == 2)
                        <a href="{{route('product_view', encrypt($st->id))}}" class="place-a-bid-btn">{{__('Place a Bid')}}</a>
                    @endif
                </div>
            </div>
            <div class="explore-content">
                <a href="{{route('product_view', encrypt($st->id))}}"><h5 class="font-semi-bold">{{$st->title}}</h5></a>
                <div class="explore-small-box explore-author-wrap d-flex align-items-center justify-content-between">
                    <div class="explore-author d-flex align-items-center">
                        <img src="{{is_null($st->author->photo) ? Avatar::create($st->author->first_name.' '.$st->author->last_name)->toBase64() : asset(IMG_USER_PATH.$st->author->photo)}}" alt="avatar">
                        <p class="ml-2">By <span>{{$st->author->first_name.' '.$st->author->last_name}}</span></p>
                    </div>
                    <div class="like-box">
                        <i class="far fa-heart"></i> {{$st->like}}
                    </div>
                </div>

                <div class="explore-small-box d-flex align-items-center justify-content-between">
                    @if ($st->type == 2)
                        <p>{{__('Highest Bid')}}<span>{{visual_number_format(highestBidService($st->id)).' '.__('USD')}}</span></p>
                    @endif

                    <p class="font-medium top-artist-stock-qty">{{round($st->available_item)}} {{__('in stock')}}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
