<?php
namespace App\Http\Controllers;
use App\Model\FaqHead;
use App\Model\LikeView;
use App\Model\Category;
use App\Model\News;
use App\Model\Service;
use App\Model\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * Class PageController
 */
class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function discover()
    {
        $categories =   Category::orderBy('title', 'ASC')->with('services', 'services.author')->get();
        $services = Service::where('status', APPROVED)->with('author')->get();
        $service_today = Service::where('status', APPROVED)->whereDate('created_at', Carbon::today())->with('author')->get();
        return view('user.pages.discover', ['title' => __('Discover'), 'categories' => $categories, 'service_today' => $service_today, 'services' => $services]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productView($id)
    {
        $id = decrypt($id);
        $service = Service::whereId($id)->with('category', 'author', 'buyer', 'all_transfers', 'resell_service', 'resell_service.author')->first();
        if(Auth::check() && Auth::user()->role == 2) {
            $view_row_count = LikeView::where('user_id', Auth::id())->where('service_id', $service->id)->where('isView', 1)->count();
            if($view_row_count == 0) {
                LikeView::create([
                    'user_id' => Auth::id(),
                    'service_id' => $service->id,
                    'isView' => 1,
                ]);
                $new_view = $service->views + 1;
                Service::whereId($service->id)->update([
                    'views' => $new_view,
                ]);
                $service = Service::whereId($id)->with('category', 'author', 'buyer')->first();
            }

        }
        return view('user.pages.product-view', ['title' => __('Product'), 'service' => $service]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function changePriceToCoin(Request $request)
    {
        if($request->ajax()) {
            if(isset($request->wid)) {
                $wallet = Wallet::with('coin')->where('id', $request->wid)->first();
                $amount = $request->amount;
                $gas_fee = 20;
                $fee_percentage = 0.02;
                $gas_fee_coin = 0;
                $gas_percentage_coin = $amount * $fee_percentage * conversionRate($wallet->coin->coin_type);
                $before_chain_price = $amount * conversionRate($wallet->coin->coin_type);
                $before_fee_coin = serviceChargeBuyer($before_chain_price);

                if ($request->mint_address != 'undefined' && $request->chainNet != 'undefined'){
                    $amount = $amount + $amount * $fee_percentage;
                    $gas_fee_coin = serviceChargeBuyer($amount * conversionRate($wallet->coin->coin_type));
                }
                $price = $amount * conversionRate($wallet->coin->coin_type);
                $service_fee_coin = serviceChargeBuyer($price);
                $final_pay = $price + $service_fee_coin;
                return response()->json([
                    'my_balance' => visual_number_format($wallet->balance),
                    'price' => visual_number_format($price),
                    'coin' => $wallet->coin->coin_type,
                    'coin_id' => $wallet->coin_id,
                    'service_fee_coin' => visual_number_format($service_fee_coin),
                    'final_pay' => visual_number_format($final_pay),
                    'conversion_rate' => conversionRate($wallet->coin->coin_type),
                    'gas_fee_coin' => visual_number_format($gas_fee_coin),
                    'gas_percentage_coin' => visual_number_format($gas_percentage_coin),
                    'before_chain_price' => visual_number_format($before_chain_price),
                    'before_fee_coin' => visual_number_format($before_fee_coin),
                ]);

            }
            else {
                return response()->json([
                    'my_balance' => '-',
                    'price' => '-',
                    'coin' => '-',
                    'service_fee' => '-',
                    'final_pay' => '-',
                ]);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function filterService(Request $request)
    {
        if($request->ajax()) {
            $services = Service::when(!empty($request->type), function($query) use($request) {
                $query->where('type', $request->type);
            })->when(!empty($request->like), function($query) use($request) {
                $query->orderBy('like', $request->like);
            })->when(!empty($request->color), function($query) use($request) {
                $query->where('color', $request->color);
            })->when(!empty($request->origin), function($query) use($request) {
                $query->whereIn('origin', $request->origin);
            })->when(!empty($request->category), function($query) use($request) {
                $query->whereIn('category_id', $request->category);
            })->whereBetween('price_dollar', [$request->min, $request->max])->where('status', '!=', DRAFT)->where('available_item', '!=', 0)->get();
            return view('user.components.filter-service', ['services' => $services]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchResult(Request $request)
    {
        $services = Service::where('title', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('price_dollar', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('origin', 'LIKE', "%{$request->keyword}%")
                    ->get();
        return view('user.pages.search-result', ['title' => __('Search Result'),'services' => $services, 'keyword' => $request->keyword]);
    }

    public function searchResultAjax(Request $request)
    {
        $services = Service::where('title', 'LIKE', "%{$request->keyword}%")
            ->orWhere('price_dollar', 'LIKE', "%{$request->keyword}%")
            ->orWhere('origin', 'LIKE', "%{$request->keyword}%")
            ->get();
        if (count($services) == 0) {
            return view('user.components.no-data-ajax');
        }
        return view('user.components.search-result-ajax', ['title' => __('Search Result'),'services' => $services, 'keyword' => $request->keyword]);
    }

    /**
     * @param Request $request
     */
    public function serviceLikeStore(Request $request)
    {
        if($request->ajax()) {
            $id = $request->service_id;
            $service = Service::whereId($id)->first();
            if(Auth::check() && Auth::user()->role == 2) {
                $view_row_count = LikeView::where('user_id', Auth::id())->where('service_id', $service->id)->where('isLike', 1)->count();
                if($view_row_count == 0) {
                    LikeView::create([
                        'user_id' => Auth::id(),
                        'service_id' => $service->id,
                        'isLike' => 1,
                    ]);
                    $new_like = $service->like + 1;
                    Service::whereId($service->id)->update([
                        'like' => $new_like,
                    ]);
                    $service = Service::whereId($id)->first();
                }

            }
            return $service->like;
        }
    }

    /**
     * @param Request $request
     */
    public function serviceLikeDelete(Request $request)
    {
        if($request->ajax()) {
            $id = $request->service_id;
            $service = Service::whereId($id)->first();
            if(Auth::check() && Auth::user()->role == 2) {
                $view_row_count = LikeView::where('user_id', Auth::id())->where('service_id', $service->id)->where('isLike', 1)->count();
                if($view_row_count != 0) {
                    LikeView::where('user_id', Auth::id())->where('service_id', $service->id)->where('isLike', 1)->first()->delete();
                    $new_like = $service->like - 1;
                    Service::whereId($service->id)->update([
                        'like' => $new_like,
                    ]);
                    $service = Service::whereId($id)->first();
                }

            }
            return $service->like;
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function howItWorks()
    {
        $faqs = FaqHead::orderBy('id', 'ASC')->with('faqs')->get();
        return view('user.pages.how-it-works', ['title' => __('How It Works'), 'faqs' => $faqs]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news()
    {
        $all_news = News::orderBy('id', 'DESC')->get();
        return view('user.pages.news', ['title' => __('News'), 'all_news' => $all_news]);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newsDetails($slug)
    {
        $news = News::where('slug', $slug)->first();
        $trend_news = News::where('IsTrending', 1)->paginate(5);
        if(Auth::check() && Auth::user()->role == USER_ROLE_USER) {
            $cview = $news->view + 1;
            News::whereId($news->id)->update(['views' => $cview]);
        }
        return view('user.pages.news-details', ['title' => __('News'), 'news' => $news, 'trend_news' => $trend_news]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('user.pages.contact', ['title' => __('Contact Us')]);
    }
}
