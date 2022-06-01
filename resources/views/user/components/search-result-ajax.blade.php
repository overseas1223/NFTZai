@foreach ($services as $service)
    <li class="media menu-search-result-item">
        <div class="search-dropdown-img-wrap">
            <img src="{{asset(IMG_SERVICE_PATH.$service->thumbnail)}}" class="mr-3" alt="img">
        </div>
        <div class="media-body">
            <h6 class="mt-0 mb-1 font-13"><a href="{{route('product_view', encrypt($service->id))}}">{{\Illuminate\Support\Str::limit($service->title, 20, '...')}}</a></h6>
            <p class="font-12">{{\Illuminate\Support\Str::limit($service->description, 50, '...')}}</p>
        </div>
    </li>
@endforeach

