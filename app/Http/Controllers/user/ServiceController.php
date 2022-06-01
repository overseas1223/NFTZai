<?php

namespace App\Http\Controllers\user;
use App\Model\BidHistory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceCreateRequest;
use App\Http\Requests\UserProductBidRequest;
use App\Http\Requests\UserProductPurchaseRequest;
use App\Model\Bid;
use App\Model\Category;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\Earning;
use App\Model\ResellService;
use App\Model\SellService;
use App\Model\Service;
use App\Model\Transaction;
use App\Model\TransferToken;
use App\Model\Wallet;
use App\Model\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Contract;
class ServiceController extends Controller
{

    public function serviceCreate()
    {
        $categories = Category::orderBy('title', 'ASC')->get();
        return view('user.pages.service-create', ['title' => __('Upload Artwork'), 'categories' => $categories]);
    }

    public function serviceStore(ServiceCreateRequest $request)
    {

        if (!empty($request->thumbnail)) {
            $thumb = uploadimage($request['thumbnail'], IMG_SERVICE_PATH);
        }
        $is_unlock = checkBoxValue($request->is_unlockable);
        try {

            $action = Service::create([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'expired_at' => $request->expired_date .' ' . $request->expired_time,
                'price_dollar' => $request->price_dollar,
                'fees_percentage' => 2,
                'fees_fixed' => 20,
                'fees_type' => FEES_FIXED,
                'available_item' => $request->available_item,
                'category_id' => $request->category_id,
                'created_by' => Auth::id(),
                'status' => DRAFT,
                'thumbnail' => $thumb,
                'video_link' => $request->video_link,
                'color' => $request->color,
                'origin' => $request->origin,
                'mint_address' => $request->mint_address,
                'max_bid_amount' => $request->max_bid_amount,
                'min_bid_amount' => $request->min_bid_amount,
                'is_unlockable' => $is_unlock,
                'pin_date' => $request->pin_date,
                'ipfsHash' => $request->ipfsHash,
                'pinsize' => $request->pinsize,
                'chain_type' => $request->chainNet,
                'state' => 'waiting',
            ]);
        }
        catch (\Exception $e){
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }


        if(!empty($action)) {
            return response()->json(['success' => true, 'message' => __('Service Added Successfully'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('my_service_data')]]);
        }
        else{
            return ['status' => false, 'message' => __('Service not added!')];
        }


    }

    public function myServiceData(Request $request)
    {
        if ($request->ajax()) {
            $items = Service::where('created_by', Auth::id());
            return datatables($items)
                ->addColumn('price', function($data) {
                    return visual_number_format($data->price_dollar);
                })
                ->editColumn('mint_address', function($data) {
                    return '<a href="'.MINT_URL.$data->mint_address.'" target="_blank">'.$data->mint_address.'</a>';
                })
                ->addColumn('category', function($data) {
                    return $data->category->title;
                })
                ->editColumn('type', function($data) {
                    $type = '';
                    if($data->type == 1) {
                        $type = 'Price Fixed';
                    }
                    elseif($data->type == 2) {
                        $type = 'Bid';
                    }
                    return $type;
                })
                ->editColumn('available_item', function($data) {
                    return round($data->available_item);
                })
                ->editColumn('thumbnail', function($data) {
                    return '<img src="'.asset(IMG_SERVICE_PATH.$data->thumbnail).'" class="img-50" />';
                })
                ->addColumn('bid_amount', function($data) {
                    if($data->type == 2) {
                        return $data->max_bid_amount.' - '.$data->min_bid_amount;
                    }
                    else {
                        return __('N/A');
                    }
                })
                ->editColumn('status', function($data) {
                    $status = '';
                    if($data->status == 0) {
                        $status = 'Draft';
                    }
                    elseif ($data->status == 1) {
                        $status = 'On Admin Approval';
                    }
                    elseif ($data->status == 2) {
                        $status = 'Approved';
                    }
                    elseif ($data->status == 3) {
                        $status = 'Processing';
                    }
                    elseif ($data->status == SOLD) {
                        $status = 'Sold';
                    }
                    elseif ($data->status == 5) {
                        $status = 'Unsold';
                    }
                    elseif ($data->status == 6) {
                        $status = 'Cancel by User';
                    }
                    elseif ($data->status == 7) {
                        $status = 'Cancel by Admin';
                    }
                    return $status;
                })
                ->addColumn('action', function($data) {
                    return $this->btnShowByStatus($data->status, $data->id);
                })
                ->rawColumns(['action', 'thumbnail', 'mint_address'])
                ->make(true);
        }
        return view('user.pages.my-service-data', ['title' => __('My Artworks'), 'menu' => 'my-service-data']);
    }



    public function btnShowByStatus($status, $id)
    {
        $btn = '';
        if($status == 0) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 ">
                        <a class="dropdown-item" href="'.route('product_to_admin', encrypt($id)).'">'.__('Submit to Admin Approval').'</a>
                        <a class="dropdown-item" href="'.route('service_edit', encrypt($id)).'">'.__('Edit').'</a>
                        <a class="dropdown-item" href="'.route('service_delete', encrypt($id)).'">'.__('Delete').'</a>
                      </div>
                    </div>
                    ';
        }
        elseif ($status == 1) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 ">
                        <a class="dropdown-item" href="'.route('service_delete', encrypt($id)).'">'.__('Cancel').'</a>
                      </div>
                    </div>
                    ';
        }
        elseif ($status == 2) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 ">
                        <a class="dropdown-item" href="'.route('product_view', encrypt($id)).'">'.__('View').'</a>
                      </div>
                    </div>
                    ';
        }
        elseif ($status == 3) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 " aria-labelledby="dropdownMenuButton4">
                        <a class="dropdown-item" href="'.route('product_view', encrypt($id)).'">'.__('View').'</a>
                      </div>
                    </div>
                    ';
        }
        elseif ($status == 4) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 " aria-labelledby="dropdownMenuButton5">

                      </div>
                    </div>
                    ';
        }
        elseif ($status == 5) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 " aria-labelledby="dropdownMenuButton6">

                      </div>
                    </div>
                    ';
        }
        elseif ($status == 6) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 " aria-labelledby="dropdownMenuButton7">

                      </div>
                    </div>
                    ';
        }
        elseif ($status == SOLD) {
            $btn = $btn.'
                    <div class="dropdown">
                      <button class="dropdown-toggle" type="button" id="dropdownMenuButton8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu top-0 " aria-labelledby="dropdownMenuButton8">
                          <a class="dropdown-item" href="'.route('product_view', encrypt($id)).'">'.__('View').'</a>
                      </div>
                    </div>
                    ';
        }
        return $btn;
    }

    public function productToAdmin($id)
    {
        $id = decrypt($id);
        $action = Service::whereId($id)->update(['status' => 1]);
        if(!empty($action)) {
            return redirect()->back()->with('success', 'Service submit to admin. you can not edit right now.');
        }
        else{
            return redirect()->back()->with('success', 'Something were wrong!');
        }
    }

    public function serviceEdit($id)
    {
        $service_id = decrypt($id);
        $service = Service::whereId($service_id)->first();
        $categories = Category::orderBy('title', 'ASC')->get();
        return view('user.pages.service-edit', ['title' => __('Edit Service'), 'service' => $service, 'categories' => $categories]);
    }

    public function serviceUpdate(Request $request, $id)
    {
        $service_id = decrypt($id);
        $service = Service::whereId($service_id)->first();
        if(is_null($request->expired_at)) {
            $expired_at = $service->expired_at;
        }
        else{
            $expired_at = Carbon::parse($request->expired_at)->format('Y-m-d H:i:s');
        }

        if (!empty($request->thumbnail)) {
            $thumb = uploadimage($request['thumbnail'], IMG_SERVICE_PATH);
        }
        else{
            $thumb = $service->thumbnail;
        }
        try {
            $action = Service::whereId($service_id)->update([
                'title' => is_null($request->title) ? $service->title :  $request->title,
                'description' => is_null($request->description) ? $service->description :  $request->description,
                'type' => is_null($request->type) ? $service->type :  $request->type,
                'expired_at' => $expired_at,
                'price_dollar' => is_null($request->price_dollar) ? $service->price_dollar :  $request->price_dollar,
                'fees_percentage' => 2,
                'fees_fixed' => 20,
                'fees_type' => FEES_FIXED,
                'available_item' => is_null($request->available_item) ? $service->available_item :  $request->available_item,
                'category_id' => is_null($request->category_id) ? $service->category_id :  $request->category_id,
                'created_by' => Auth::id(),
                'status' => DRAFT,
                'thumbnail' => $thumb,
                'video_link' => is_null($request->video_link) ? $service->video_link :  $request->video_link,
                'mint_address' => is_null($request->mint_address) ? $service->mint_address :  $request->mint_address,
                'color' => is_null($request->color) ? $service->color :  $request->color,
                'origin' => is_null($request->origin) ? $service->origin :  $request->origin,
                'max_bid_amount' => is_null($request->max_bid_amount) ? $service->max_bid_amount :  $request->max_bid_amount,
                'min_bid_amount' => is_null($request->min_bid_amount) ? $service->min_bid_amount :  $request->min_bid_amount,
                'is_unlockable' => is_null($request->is_unlockable) ? $service->is_unlockable :  $request->is_unlockable,
            ]);
        }
        catch (\Exception $e){
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }

        if(!empty($action)) {
            return response()->json(['success' => true, 'message' => __('Service Update Successfully'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('my_service_data')]]);
        }
        else{
            return ['status' => false, 'message' => __('Service not updated!')];
        }
    }

    public function serviceDelete($id)
    {
        $service_id = decrypt($id);
        try{
            $action = Service::find($service_id)->delete();
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }

        if(!empty($action)) {
            return redirect()->back()->with('success', __('Service Delete Successfully'));
        }
        else{
            return ['status' => false, 'message' => __('Service not deleted!')];
        }
    }

    public function userProductPurchase(UserProductPurchaseRequest $request)
    {

        DB::beginTransaction();
        try {

            if($request->mint_address != '') {

                $service = Service::whereId($request->service_id)->first();
                $result = $this->addedPinata($service->thumbnail, $service->title);
                $coin = Coin::whereId($request->coin_id)->first();

                Service::whereId($request->service_id)->update([
                    'mint_address' => $request->mint_address,
                    'chain_type' => $coin->full_name,
                    'ipfsHash' => 'https://gateway.pinata.cloud/ipfs/' . $result['IpfsHash'],
                    'pin_date' => $result['PinSize'],
                    'pinsize' => $result['Timestamp']
                ]);
                $earn_amount = $request->final_pay - $request->coin_amount;
                $coin_id = $request->coin_id;
                Wallet::where('user_id', Auth::user()->id)->where('coin_id', $coin_id)->decrement('balance', $earn_amount);
                Wallet::where('user_id', Auth::user()->id)->where('coin_id', $coin_id)->increment('on_hold', $earn_amount);

            }

            $service = Service::whereId($request->service_id)->first();
            $wallet = Wallet::whereId($request->wallet_id)->first();
            $available_items = $service->available_item - 1;
            $cut_coin = bcadd($request->before_fee_coin , $request->before_chain_price);
            if (bccomp($wallet->balance, $cut_coin) < 0) {
                DB::rollBack();
                return ['status' => false, 'message' => __('Insufficient Balance!')];
            }
            if($service->available_item <= 0) {
                DB::rollBack();
                return ['status' => false, 'message' => __('Stock out!')];
            }
            if($available_items == 0) {
                $service->whereId($request->service_id)->update([
                    'buyer_id' => $request->user_id,
                    'status' => SOLD,
                ]);
            }

            $wallet->decrement('balance', $cut_coin);
            $service->decrement('available_item', 1);
            $purchase = SellService::create([
                'price_amount' => $request->price,
                'coin_amount' => $request->coin_amount,
                'service_charge' => $request->on_service_fee,
                'service_charge_coin' => $request->service_charge_coin,
                'conversion_rate' => $request->conversion_rate,
                'service_id' => $request->service_id,
                'user_id' => $request->user_id,
                'is_sale_bid' => 0,
                'coin_type' => $request->coin_type,
                'coin_id' => $request->coin_id,
                'status' => 1,
                'refund_amount' => 0,
                'wallet_id' => $request->wallet_id,
            ]);
            $receiver_charge = serviceChargeSeller($request->coin_amount);
            $receiver_cut_coin = bcsub($request->coin_amount, $receiver_charge);
            $receiver_wallet = Wallet::where('coin_id', $request->coin_id)->where('user_id', $service->created_by)->first();
            $receiver_wallet->increment('balance', $receiver_cut_coin);
            Earning::create([
                'sell_id' => $purchase->id,
                'user_id' => Auth::id(),
                'coin_id' => $request->coin_id,
                'user_to_platform' => 1,
                'platform_to_user' => 0,
                'trans_amount' => $request->coin_amount,
                'amount' => $request->service_charge_coin,
                'coin_type' => $request->coin_type,
                'comments' => Auth::user()->first_name.' '.__('make a sell. SELLID: ').$purchase->id,
                'status' => STATUS_ACTIVE,
            ]);
            Earning::create([
                'sell_id' => $purchase->id,
                'user_id' => $receiver_wallet->user_id,
                'coin_id' => $request->coin_id,
                'user_to_platform' => 0,
                'platform_to_user' => 1,
                'trans_amount' => $request->coin_amount,
                'amount' => $receiver_charge,
                'coin_type' => $request->coin_type,
                'comments' => 'Transaction complete. SELLID: '. $purchase->id,
                'status' => STATUS_ACTIVE,
            ]);
            Transaction::create([
                'amount' => $request->coin_amount,
                'buyer_id' => $request->user_id,
                'seller_id' => $service->created_by,
                'transaction_hash' => randomString(8),
                'bid_id' => 0,
                'fees' => $request->service_charge_coin,
                'transaction_time' => Carbon::now()->toDateTimeString(),
                'status' => TRANS_SOLD,
                'coin_type' => $request->coin_type,
                'coin_id' => $request->coin_id,
            ]);

            if($service->is_resellable == 0) {
                TransferToken::create([
                    'service_id' => $service->id,
                    'prev_mint_address' => $service->mint_address,
                    'new_mint_address' => MINT_TOKEN_1,
                ]);
            }elseif($service->is_resellable == 1) {
                TransferToken::create([
                    'service_id' => $service->resell_service_id,
                    'resell_service_id' => $service->id,
                    'prev_mint_address' => $service->mint_address,
                    'new_mint_address' => MINT_TOKEN_1,
                ]);
            }
            Service::where('id', $request->service_id)->update([
                'mint_address' => $request->mint_address,
                'ipfsHash' => 'https://gateway.pinata.cloud/ipfs/QmP5ksKNsUez66X3aV3fT4fvZLi9Qg1n5oUR8kAYNXes7u',
                'pin_date' => '405442',
                'pinsize' => '2022-03-02T14:26:13.126Z',
                'chain_type' => 'Ethereum'
            ]);
            DB::commit();
        }
        catch(\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }
        if(!empty($purchase)) {
            return response()->json(['success' => true, 'message' => __('Product Successfully Purchased!'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('purchase_history')]]);
        }
        return ['status' => false, 'message' => __('Product not purchased!')];
    }

    public function userProductBid(UserProductBidRequest $request)
    {
        if (Bid::where('user_id', $request->user_id)->where('service_id', $request->service_id)->exists()) {
            return $this->updateProductBid($request);
        }
        else {
            return $this->createProductBid($request);
        }
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

    public function createProductBid($request)
    {
        DB::beginTransaction();
        try {
            $wallet = Wallet::whereId($request->wallet_id)->first();
            $service = Service::whereId($request->service_id)->first();
            $cut_coin = bcadd($request->coin_amount , $request->service_charge_coin);
            if (bccomp($wallet->balance, $cut_coin) < 0) {
                DB::rollBack();
                return ['status' => false, 'message' => __('Insufficient Balance!')];
            }
            $wallet->decrement('balance', $cut_coin);
            $wallet->increment('on_hold', $cut_coin);
            $purchase = BidHistory::create([
                'transaction_id' => generateBidHistoryTransaction(),
                'bid_amount' => $request->price,
                'coin_amount' => $request->coin_amount,
                'service_charge' => $request->on_service_fee,
                'service_charge_coin' => $request->service_charge_coin,
                'conversion_rate' => $request->conversion_rate,
                'service_id' => $request->service_id,
                'user_id' => $request->user_id,
                'coin_type' => $request->coin_type,
                'coin_id' => $request->coin_id,
                'status' => 1,
                'refund_amount' => 0,
                'wallet_id' => $request->wallet_id,
            ]);
            $bid = Bid::create([
                'transaction_id' => generateBidTransaction(),
                'bid_amount' => $request->price,
                'service_charge' => $request->on_service_fee,
                'service_id' => $request->service_id,
                'user_id' => $request->user_id,
                'is_sale_bid' => 0,
                'status' => 1,
            ]);
            Transaction::create([
                'amount' => $request->coin_amount,
                'buyer_id' => $request->user_id,
                'seller_id' => $service->created_by,
                'transaction_hash' => $bid->transaction_id,
                'bid_id' => $bid->id,
                'fees' => $request->service_charge_coin,
                'transaction_time' => Carbon::now()->toDateTimeString(),
                'status' => TRANS_BID_HOLD,
                'coin_type' => $request->coin_type,
                'coin_id' => $request->coin_id,
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }
        if(!empty($purchase)) {
            return response()->json(['success' => true, 'message' => __('Product Successfully Purchased!'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('bid_history')]]);
        }
        return ['status' => false, 'message' => __('Bid process not done!')];
    }

    public function updateProductBid($request)
    {
        DB::beginTransaction();
        try {
            $wallet = Wallet::whereId($request->wallet_id)->first();
            $service = Service::whereId($request->service_id)->first();
            $cut_coin = bcadd($request->coin_amount , $request->service_charge_coin);
            if (bccomp($wallet->balance, $cut_coin) < 0) {
                DB::rollBack();
                return ['status' => false, 'message' => __('Insufficient Balance!')];
            }
            $wallet->decrement('balance', $cut_coin);
            $wallet->increment('on_hold', $cut_coin);
            $bid = Bid::where('user_id', $request->user_id)->where('service_id', $request->service_id)->first();
            $bid->increment('bid_amount', $request->price);
            $purchase = BidHistory::create([
                'transaction_id' => generateBidHistoryTransaction(),
                'bid_amount' => $request->price,
                'coin_amount' => $request->coin_amount,
                'service_charge' => $request->on_service_fee,
                'service_charge_coin' => $request->service_charge_coin,
                'conversion_rate' => $request->conversion_rate,
                'service_id' => $request->service_id,
                'user_id' => $request->user_id,
                'coin_type' => $request->coin_type,
                'coin_id' => $request->coin_id,
                'status' => 1,
                'refund_amount' => 0,
                'wallet_id' => $request->wallet_id,
            ]);
            Transaction::create([
                'amount' => $request->coin_amount,
                'buyer_id' => $request->user_id,
                'seller_id' => $service->created_by,
                'transaction_hash' => $bid->transaction_id,
                'bid_id' => $bid->id,
                'fees' => $request->service_charge_coin,
                'transaction_time' => Carbon::now()->toDateTimeString(),
                'status' => TRANS_BID_HOLD,
                'coin_type' => $request->coin_type,
                'coin_id' => $request->coin_id,
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }
        if(!empty($purchase)) {
            return response()->json(['success' => true, 'message' => __('Product Successfully Purchased!'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('bid_history')]]);
        }
        return ['status' => false, 'message' => __('Bid process not done!')];
    }

    public function resellService(Request $request, $service_id)
    {
        $service_id = decrypt($service_id);
        $sell = Service::whereId($service_id)->with('latest_transfer')->first();
        if($sell->is_resellable == 1) {
            $service = Service::whereId($sell->resell_service_id)->with('latest_transfer')->first();
        }
        else {
            $service = $sell;
        }
        DB::beginTransaction();
        try {

            $action = Service::create([
                'title' => $service->title,
                'description' => $service->description,
                'type' => $request->type,
                'expired_at' => $service->expired_at,
                'price_dollar' => $request->price_dollar,
                'fees_percentage' => 2,
                'fees_fixed' => 20,
                'fees_type' => FEES_FIXED,
                'available_item' => 1,
                'category_id' => $service->category_id,
                'created_by' => Auth::id(),
                'status' => ON_ADMIN_APPROVAL,
                'thumbnail' => $service->thumbnail,
                'video_link' => $service->video_link,
                'color' => $service->color,
                'origin' => $service->origin,
                'mint_address' => $service->latest_transfer->new_mint_address,
                'max_bid_amount' => $request->max_bid_price,
                'min_bid_amount' => $request->min_bid_price,
                'is_unlockable' => $service->is_unlockable,
                'is_resellable' => 1,
                'resell_service_id' => $service->id,
            ]);

            ResellService::create([
                'new_service_id' => $action->id,
                'past_service_id' => $service->id,
            ]);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('dismiss', errorHandle($e->getMessage()));
        }

        if(!empty($action)) {
            return redirect()->back()->with('success', 'Your resell submission goes to admin queue. Artwork will available after Admin approval.');
        }
        else{
            return redirect()->back()->with('dismiss', 'Resell failed');
        }
    }
}
