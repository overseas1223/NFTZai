<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Model\Bid;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\ResellService;
use App\Model\SellService;
use App\Model\Service;
use App\Model\Wallet;
use App\Model\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function dashboard() {
        $service_sum = Service::where('created_by', Auth::id())->count();
        $purchase_sum = Service::where('buyer_id', Auth::id())->count();
        $deposit_sum = Deposit::where('deposit_by', Auth::id())->sum('doller');
        $withdraw_sum = Withdrawal::where('withdraw_by', Auth::id())->sum('doller');
        $offchainList = Service::where('buyer_id', Auth::user()->id)->where('mint_address', null)->orWhere(function ($query) {
                 $query->where('created_by', Auth::user()->id)->where('buyer_id', null)->where('mint_address', null);
              })->get();
        $coin_type = Coin::where('coin_type', 'ETH')->first();
        $wallet = Wallet::where('user_id', Auth::user()->id)->where('coin_id', $coin_type->id)->first();
        return view('user.dashboard', ['title' => __('Dashboard'), 'menu' => 'dashboard', 'service_sum' => $service_sum, 'purchase_sum' => $purchase_sum, 'deposit_sum' => $deposit_sum, 'withdraw_sum' => $withdraw_sum, 'offchainList' => $offchainList, 'wid' => $wallet->id]);
    }

    public function userUpload()
    {
        return view('user.pages.upload', ['title' => __('Upload')]);
    }

    public function wallets()
    {
        return view('user.pages.wallets', ['title' => __('Connect Wallet')]);
    }

    public function purchaseHistory(Request $request)
    {
        if ($request->ajax()) {
            $items = SellService::where('user_id', Auth::id())->with('service')->latest();
            return datatables($items)
                ->addColumn('title', function($data) {
                    return $data->service->title;
                })
                ->addColumn('description', function($data) {
                    return $data->service->description;
                })
                ->addColumn('price_dollar', function($data) {
                    return visual_number_format(bcadd($data->price_amount, $data->service_charge) );
                })
                ->addColumn('price', function($data) {
                    return visual_number_format(bcadd($data->coin_amount, $data->service_charge_coin)).' '.$data->coin_type;
                })
                ->editColumn('thumbnail', function($data) {
                    return '<img src="'.asset(IMG_SERVICE_PATH.$data->service->thumbnail).'" class="img-50" />';
                })
                ->editColumn('action', function($data) {
                    return '<ul class="d-flex justify-content-center align-items-center my-wallet-actions-btn">
                        <li>
                            <a href="'.route('product_view', encrypt($data->service_id)).'" class="btn btn-success" title="Product Link" target="_blank"><i class="fas fa-link"></i></a>
                        </li>'.$this->resellButtonShow($data->service_id).'
                    </ul>';
                })
                ->rawColumns(['action', 'thumbnail', 'description', 'action'])
                ->make(true);
        }
        $services = SellService::where('user_id', Auth::id())->latest()->get();
        return view('user.pages.purchase-history', ['title' => __('Purchase History'), 'menu' => 'purchase-history', 'services' => $services]);
    }

    public function resellButtonShow($service_id)
    {
        if (!ResellService::where('past_service_id', $service_id)->exists()) {
            return '<li>
                        <button data-toggle="modal" href="#resellModal'.$service_id.'" class="btn btn-info" title="Resell Product"><i class="fas fa-object-ungroup"></i></button>
                    </li>';
        }
    }

    public function bidHistory(Request $request)
    {
        if ($request->ajax()) {
            $items = Bid::where('user_id', Auth::id())->with('service')->latest();
            return datatables($items)
                ->editColumn('id', function($data) {
                    return $data->transaction_id;
                })
                ->addColumn('title', function($data) {
                    return $data->service->title;
                })
                ->addColumn('description', function($data) {
                    return $data->service->description;
                })
                ->addColumn('price_usd', function($data) {
                    return visual_number_format($data->bid_amount).' (in USD)';
                })
                ->addColumn('highest_bid', function($data) {
                    return visual_number_format(highestBidService($data->service_id)).' (in USD)';
                })
                ->editColumn('thumbnail', function($data) {
                    return '<img src="'.asset(IMG_SERVICE_PATH.$data->service->thumbnail).'" class="img-50" />';
                })
                ->editColumn('status', function($data) {
                    if($data->service->status == SOLD) {
                        return 'Sold';
                    }
                    else {
                        return 'Ongoing';
                    };
                })
                ->addColumn('action', function($data) {

                    if ($data->service->status == SOLD) {
                        return yourbidServiceMessage($data->service_id);
                    }
                    else {
                        $btn = '';
                        $btn = $btn.'
                            <div class="dropdown">
                              <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                              </button>
                              <div class="dropdown-menu top-0 ">
                                <a class="dropdown-item" href="'.route('product_view', encrypt($data->service_id)).'">'.__('Bid Again').'</a>
                              </div>
                            </div>
                           ';
                        return $btn;
                    }
                })
                ->rawColumns(['action', 'thumbnail', 'description'])
                ->make(true);
        }
        $services = Bid::where('user_id', Auth::id())->with('service')->latest()->get();
        return view('user.pages.bid-history', ['title' => __('Bidding History'), 'menu' => 'bid-history', 'services' => $services]);
    }

    public function deploynft (Request $request) {
        $service_id = $request->service_id;
        $mint_address = $request->mint_address;
        $wallet_id = $request->wid;
        $coin_price = $request->coin_price;

        $wallet = Wallet::whereId($wallet_id)->first();
        if ($wallet->user_id != Auth::user()->id)
            return response()->json(['status' => false, 'message' => 'authError']);
        if ($wallet->balance < $coin_price) {
            return response()->json(['status' => false, 'message' => 'priceError']);
        }
        $service = Service::whereId($service_id)->first();
        $result = $this->addedPinata($service->thumbnail, $service->title);
        $coin = Coin::whereId($wallet->coin_id)->first();

        Service::whereId($service_id)->update([
            'mint_address' => $mint_address,
            'chain_type' => $coin->full_name,
            'ipfsHash' => 'https://gateway.pinata.cloud/ipfs/' . $result['IpfsHash'],
            'pin_date' => $result['PinSize'],
            'pinsize' => $result['Timestamp']
        ]);

        Wallet::whereId($wallet_id)->decrement('balance', $coin_price);
        Wallet::whereId($wallet_id)->increment('on_hold', $coin_price);

        return response()->json(['status' => true, 'message' => 'success']);
    }
    public function addedPinata ($thumbnail, $filename) {

        $uploaded_file_name = $filename;
        $url = base_path() . '/public/uploaded_file/services/' . $thumbnail;

        $response = Http::withHeaders([
            'pinata_api_key' => 'b1595d122e177efa6f23',
            'pinata_secret_api_key' => 'b1136711a25f07948bd6d36da2be31b0669ab70d1864d38fffee32772e6549fe'
        ])->attach('file', file_get_contents($url),$uploaded_file_name)
            ->post( 'https://api.pinata.cloud/pinning/pinFileToIPFS', [
            ]);
        $data = $response->json();
        return $data;
    }

}
