<?php
namespace App\Http\Controllers;
use App\Model\Category;
use App\Model\TopSeller;
use App\User;

/**
 * Class SellerController
 */
class SellerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allSeller()
    {
        $sellers = User::where('role', 2)->has('service_sells')->with('service_sells')->paginate(8);
        $categories = Category::orderBy('title', 'ASC')->paginate(8);
        $top_sellers = TopSeller::with('seller')->paginate(10);
        return view('user.pages.all-seller', ['title' => __('All Seller'), 'sellers' => $sellers, 'categories' => $categories, 'top_sellers' => $top_sellers]);
    }
}
