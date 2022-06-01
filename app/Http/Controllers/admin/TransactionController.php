<?php
namespace App\Http\Controllers\admin;
use App\Jobs\WithdrawalApproveJob;
use App\Jobs\WithdrawalRejectJob;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\Earning;
use App\Model\Service;
use App\Model\ServiceCharge;
use App\Model\Subscriber;
use App\Model\Wallet;
use App\Model\WalletRecord;
use App\Model\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class TransactionController
 */
class TransactionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function adminWalletList(Request $request)
    {
        $data['title'] = __('Wallet List');
        if($request->ajax()){
            $data['wallets'] = Wallet::join('users','users.id','=','wallets.user_id')
                ->join('coins','coins.id','=','wallets.coin_id');
            return datatables()->of($data['wallets'])
                ->addColumn('user_name',function ($item){return $item->first_name.' '.$item->last_name;})
                ->make(true);
        }
        return view('admin.users.wallet',$data);
    }
    public function adminChainList(Request $request) {
        $data['title'] = __('ONChain Setting');
        if($request->ajax()){
            $data['service'] = Service::join('users','users.id','=','services.created_by')->where('services.ipfsHash', '<>', '')->where('mint_address', '<>', '')->where('chain_type', '<>', '')->where('state', 'waiting');
            return datatables()->of($data['service'])
                ->addColumn('user_name',function ($item){return $item->first_name.' '.$item->last_name;})
                ->addColumn('coin_type',function ($item){return $item->chain_type;})
                ->addColumn('nft_fee',function ($item){return $item->price_dollar*$item->fees_percentage/100;})
                ->addColumn('action', function ($item) {
                    return '<ul class="d-flex activity-menu">
                                <li class="viewuser" onclick="">
                                    <span  style="cursor: pointer" class="user-list-actions-icon" title="Mint" onclick="sendContract(\''.$item->ipfsHash.','.$item->mint_address . ','.$item->title . ','.$item->pinsize . ',' . $item->chain_type .'\')"><i class="fas fa-check"></i></span>
                                    </li>
                                    <li class="viewuser" onclick="">
                                    <span style="background-color: red;cursor: pointer" class="user-list-actions-icon" title="Cancel" onclick="cancel(\''. $item->title.','.$item->pinsize. '\')"><i class="fas fa-window-close"></i></span>
                                </li>
                             </ul>';
                })
                ->rawColumns(['action', 'coin_icon'])
                ->make(true);
        }
        return view('admin.users.chain',$data);
    }

    public function createMasterWallet (Request $request) {
        $address = $request->get('address');
        $exist = Wallet::where('user_id', 1)->exists();
        if ($address != '' && Auth::user()->id == 1 && $exist == false) {
            Wallet::create([
                'user_id' => 1,
                'coin_id' => 2,
                'address' => $address,
                'status' => 1,
                'is_primary' => 1
            ]);
            return response()->json(['message' => 'success']);
        }else {
            return response()->json(['message' => 'failed']);
        }
    }

    public function getwallet (Request $request) {
        try {
            if (Auth::user()->id == 1) {

                $coin_id_eth = Coin::where('coin_type', 'ETH')->first();
                $coin_id_sol = Coin::where('coin_type', 'SOL')->first();
                $coin_id_bnb = Coin::where('coin_type', 'BNB')->first();
                $eth_wallet = Wallet::where('user_id', 1)->where('coin_id', $coin_id_eth->id)->first();
                $sol_wallet = Wallet::where('user_id', 1)->where('coin_id', $coin_id_sol->id)->first();
                $bnb_wallet = Wallet::where('user_id', 1)->where('coin_id', $coin_id_bnb->id)->first();
                $ETHtransations = WalletRecord::where('wallet_id', $eth_wallet->id)->get();
                $SOLtransations = WalletRecord::where('wallet_id', $sol_wallet->id)->get();
                $BNBtransations = WalletRecord::where('wallet_id', $bnb_wallet->id)->get();
            }

        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }

        if ($eth_wallet == null) {
            return response()->json(['status' => false, 'message' => 'walletExist']);
        }
        return response()->json(['status' => true, 'ethbalance' => $eth_wallet->balance, 'ethaddress' => $eth_wallet->address,
            'ETHtransactions' => $ETHtransations, 'SOLtransations' => $SOLtransations, 'BNBtransations' => $BNBtransations,
            'bnbbalance' => $bnb_wallet->balance, 'bnbaddress' => $bnb_wallet->address, 'solbalance' => $sol_wallet->balance, 'soladdress' => $sol_wallet->address]);
    }

    public function mintCancel (Request $request) {
        $title = $request->get('title');
        $pinSize = $request->get('date');
        $state = $request->get('state');
        try {

            $service = Service::where('title', $title)->where('pinsize', $pinSize)->first();
            $coin = Coin::where('full_name', $service->chain_type)->first();

            if($service->buyer_id == null) {
                $wallet = Wallet::where('user_id', $service->created_by)->where('coin_id', $coin->id)->first();
                if ($wallet->on_hold != 0) {
                    if ($state == 'complete')
                        Wallet::where('user_id', Auth::user()->id)->where('coin_id', $coin->id)->increment('balance', $wallet->on_hold);
                    if ($state == 'cancel')
                        Wallet::where('user_id', $service->created_by)->where('coin_id', $coin->id)->increment('balance', $wallet->on_hold);
                    Wallet::where('user_id', $service->created_by)->where('coin_id', $coin->id)->decrement('on_hold', $wallet->on_hold);
                }
            }else {
                $wallet = Wallet::where('user_id', $service->buyer_id)->where('coin_id', $coin->id)->first();
                if ($wallet->on_hold != 0) {
                    if ($state == 'complete')
                        Wallet::where('user_id', Auth::user()->id)->where('coin_id', $coin->id)->increment('balance', $wallet->on_hold);
                    if ($state == 'cancel')
                        Wallet::where('user_id', $service->buyer_id)->where('coin_id', $coin->id)->increment('balance', $wallet->on_hold);
                    Wallet::where('user_id', $service->buyer_id)->where('coin_id', $coin->id)->decrement('on_hold', $wallet->on_hold);
                }
            }

            $action = Service::where('title', $title)->where('pinsize', $pinSize)->update(['state' => $state]);
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => errorHandle($e->getMessage())];
        }
        return response()->json(['status' => true, 'message' => 'success']);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function depositHistory(Request $request)
    {
        $data['title'] = __('Deposit History');
        if ($request->ajax()) {
            $deposit = Deposit::join('wallets',['deposits.receiver_wallet_id'=>'wallets.id'])
                ->join('users',['users.id' => 'wallets.user_id']);
            return datatables($deposit)
                ->editColumn('address_type', function ($dpst) {
                    return addressType($dpst->address_type);
                })
                ->addColumn('status', function ($dpst) {
                    return deposit_status($dpst->status);
                })
                ->addColumn('sender', function ($dpst) {
                    if($dpst->sender_wallet_id >0){
                        return  $dpst->senderWallet->user->email ;
                    }else {
                        return '';
                    }
                })
                ->rawColumns(['deposits.created_at'])
                ->make(true);
        }
        return view('admin.deposit.deposit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function adminPendingWithdrawal(Request $request)
    {
        $data['title'] = __('Withdrawal');
        if ($request->ajax()) {
            $withdrawal = Withdrawal::where(['withdrawals.status' => ON_ADMIN_APPROVAL]);

            return datatables($withdrawal)
                ->addColumn('address_type', function ($wdrl) {
                    return addressType($wdrl->address_type);
                })
                ->addColumn('sender', function ($wdrl) {
                    return isset($wdrl->wallet->user) ? $wdrl->wallet->user->first_name . ' ' . $wdrl->wallet->user->last_name : '';
                })
                ->addColumn('receiver', function ($wdrl) {
                    return isset($wdrl->receiverWallet->user) ? $wdrl->receiverWallet->user->first_name . ' ' . $wdrl->receiverWallet->user->last_name : '';
                })
                ->addColumn('actions', function ($wdrl) {
                    $action = '<ul class="pending-withdrawals-actions-wrap d-flex">';
                    $action .= accept_html('admin_accept_pending_withdrawal',encrypt($wdrl->id));
                    $action .= reject_html('admin_reject_pending_withdrawal',encrypt($wdrl->id));
                    $action .= '<ul>';
                    return $action;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.withdrawal.withdrawal', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function adminRejectedWithdrawal(Request $request)
    {
        $data['title'] = __('Rejected Withdrawal');
        if ($request->ajax()) {
            $withdrawal = Withdrawal::where(['withdrawals.status' => ADMIN_CANCEL]);
            return datatables($withdrawal)
                ->addColumn('address_type', function ($wdrl) {
                    return addressType($wdrl->address_type);
                })
                ->addColumn('sender', function ($wdrl) {
                    return isset($wdrl->wallet->user) ? $wdrl->wallet->user->first_name . ' ' . $wdrl->wallet->user->last_name : '';
                })
                ->addColumn('receiver', function ($wdrl) {
                    return isset($wdrl->receiverWallet->user) ? $wdrl->receiverWallet->user->first_name . ' ' . $wdrl->receiverWallet->user->last_name : '';
                })
                ->make(true);
        }
        return view('admin.withdrawal.withdrawal', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function adminSuccessWithdrawal(Request $request)
    {
        $data['title'] = __('Success Withdrawal');
        if ($request->ajax()) {
            $withdrawal = Withdrawal::where(['withdrawals.status' => SUCCESS]);
            return datatables($withdrawal)
                ->addColumn('address_type', function ($wdrl) {
                    return addressType($wdrl->address_type);
                })
                ->addColumn('sender', function ($wdrl) {
                    return isset($wdrl->wallet->user) ? $wdrl->wallet->user->first_name . ' ' . $wdrl->wallet->user->last_name : '';
                })
                ->addColumn('receiver', function ($wdrl) {
                    return isset($wdrl->receiverWallet->user) ? $wdrl->receiverWallet->user->first_name . ' ' . $wdrl->receiverWallet->user->last_name : '';
                })
                ->make(true);
        }
        return view('admin.withdrawal.withdrawal', $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminRejectPendingWithdrawal($id)
    {
        try {
            $id = decrypt($id);
            $withdrawalRequest = Withdrawal::where('id', $id)->where('status', ON_ADMIN_APPROVAL)->first();
            if (empty($withdrawalRequest)) {
                return redirect()->back()->with('dismiss', __('Withdrawal request is not found!'));
            }
            dispatch(new WithdrawalRejectJob($id))->onQueue('withdrawal')->delay(10);
            $withdrawalRequest->status = PROCESSING;
            $withdrawalRequest->in_queue = 1;
            $withdrawalRequest->save();
        }catch (\Exception $e){
            Log::info($e->getFile());
        }
        return redirect()->back()->with('success', __('Withdrawal cancel request is sent to queue.'));
    }
    public function adminAcceptPendingWithdrawal($id)
    {
        try {
            $id = decrypt($id);
            $withdrawalRequest = Withdrawal::where('id', $id)->where('status', ON_ADMIN_APPROVAL)->first();
            if (empty($withdrawalRequest)) {
                return redirect()->back()->with('dismiss', __('Withdrawal request is not found!'));
            }
            dispatch(new WithdrawalApproveJob($id, Auth::id()))->onQueue('withdrawal')->delay(10);
            $withdrawalRequest->status = ON_ADMIN_APPROVAL;
            $withdrawalRequest->in_queue = 1;
            $withdrawalRequest->save();
        }catch (\Exception $e){
            Log::info($e->getFile());
            Log::info($e->getLine());
        }
        return redirect()->back()->with('success', __('Withdrawal approval request is sent to queue.'));
    }

    public function transactionSettings()
    {
        return view('admin.transactions.settings', ['title' => __('Transaction')]);
    }

    public function serviceChargeUpdate(Request $request)
    {
        $this->serviceChargeUpdateMethod('buyer', SERVICE_CHARGE_FIXED, $request->buyer_sc_fixed);
        $this->serviceChargeUpdateMethod('buyer', SERVICE_CHARGE_PERCENTAGE, $request->buyer_sc_percent);
        $this->serviceChargeUpdateMethod('seller', SERVICE_CHARGE_FIXED, $request->seller_sc_fixed);
        $this->serviceChargeUpdateMethod('seller', SERVICE_CHARGE_PERCENTAGE, $request->seller_sc_percent);
        if($request->buyer_sc_active == 'buyer_fixed') {
            ServiceCharge::where('service_holder', 'buyer')->where('type', SERVICE_CHARGE_FIXED)->update([
                'status' => STATUS_ACTIVE
            ]);
            ServiceCharge::where('service_holder', 'buyer')->where('type', SERVICE_CHARGE_PERCENTAGE)->update([
                'status' => STATUS_DEACTIVE
            ]);
        }
        elseif($request->buyer_sc_active == 'buyer_percent') {
            ServiceCharge::where('service_holder', 'buyer')->where('type', SERVICE_CHARGE_FIXED)->update([
                'status' => STATUS_DEACTIVE
            ]);
            ServiceCharge::where('service_holder', 'buyer')->where('type', SERVICE_CHARGE_PERCENTAGE)->update([
                'status' => STATUS_ACTIVE
            ]);
        }

        if($request->sellerr_sc_active == 'seller_fixed') {
            ServiceCharge::where('service_holder', 'seller')->where('type', SERVICE_CHARGE_FIXED)->update([
                'status' => STATUS_ACTIVE
            ]);
            ServiceCharge::where('service_holder', 'seller')->where('type', SERVICE_CHARGE_PERCENTAGE)->update([
                'status' => STATUS_DEACTIVE
            ]);
        }
        elseif($request->sellerr_sc_active == 'seller_percent') {
            ServiceCharge::where('service_holder', 'seller')->where('type', SERVICE_CHARGE_FIXED)->update([
                'status' => STATUS_DEACTIVE
            ]);
            ServiceCharge::where('service_holder', 'seller')->where('type', SERVICE_CHARGE_PERCENTAGE)->update([
                'status' => STATUS_ACTIVE
            ]);
        }
        return redirect()->back()->with('success', __('Successfully Updated'));
    }

    public function serviceChargeUpdateMethod($holder, $type, $charge)
    {
        return ServiceCharge::where('service_holder', $holder)->where('type', $type)->update([
            'amount' => $charge,
        ]);
    }

    public function allTransaction(Request $request)
    {
        $data['title'] = __('Transactions');
        if($request->ajax()){
            $data['earnings'] = Earning::query();
            return datatables()->of($data['earnings'])
                ->addColumn('sell_bid', function($data) {
                    if($data->sell_id != null) {
                        return __('SOLD');
                    }
                    elseif($data->bid_id != null) {
                        return __('BID');
                    }
                })
                ->addColumn('holder',function ($data){
                    if($data->user_to_platform == 1) {
                        return 'From: '.$data->user->first_name.' '.$data->user->last_name;
                    }
                    elseif($data->platform_to_user == 1) {
                        return 'To: '.$data->user->first_name.' '.$data->user->last_name;
                    }
                })
                ->addColumn('amount',function ($data){
                    return $data->trans_amount.' '.$data->coin_type;
                })
                ->addColumn('earnings',function ($data){
                    return $data->amount.' '.$data->coin_type;
                })
                ->addColumn('type',function ($data){
                    if($data->user_to_platform == 1) {
                        return __('Credited');
                    }
                    elseif($data->platform_to_user == 1) {
                        return __('Debited');
                    }
                })
                ->addColumn('time', function ($data) {
                    return Carbon::parse($data->created_at)->format('F j, Y, g:i a');
                })
                ->make(true);
        }
        return view('admin.transactions.all-transaction', $data);
    }
}
