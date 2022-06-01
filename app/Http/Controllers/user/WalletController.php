<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawalRequest;
use App\Http\Services\Logger;
use App\Http\Services\WalletService;
use App\Jobs\WithdrawalJob;
use App\Model\Bid;
use App\Model\SellService;
use App\Model\Service;
use App\Model\Transaction;
use App\Model\Deposit;
use App\Model\Wallet;
use App\Model\Coin;
use App\Model\Withdrawal;
use App\Model\WithdrawalCoinLimitSetting;
use App\Model\Withdrawal2fa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public $logger = null;

    public function __construct()
    {
        $this->logger = new Logger(env('WITHDRAWAL_LOG_PATH'));
    }
    public function myWallets()
    {
        $wallets = Wallet::with('coin')->where('user_id', Auth::id())->get();
        return view('user.pages.my-wallets', ['title' => __('My wallets'), 'wallets' => $wallets, 'menu' => 'my-wallet']);
    }
    public function getWalletAddress(Request $request)
    {
        $walletId = $request->get('wallet_id','');
        if (!$wallet = Wallet::where(['id' => $walletId, 'user_id' => Auth::id()])->first()) {
             return response()->json( [
                'status'  => false,
                'message' => 'wallet not found',
                'data'    => null
            ]);
        }
        $coin = Coin::select('coins.coin_type', 'coins.deposit_status', 'coin_settings.api_service')
            ->where('coins.id', $wallet->coin_id)
            ->join('coin_settings', 'coin_settings.coin_id', '=', 'coins.id')->first();
        if ($coin) {
            if (!$coin->deposit_status) {
                 return response()->json( [
                    'status' => false,
                    'message' => 'deposit is disabled',
                    'data' => null
                ]);
            }
        } else {
             return response()->json( [
                'status' => false,
                'message' => 'deposit is disabled',
                'data' => null
            ]);
        }

        if (empty($wallet)) {
             return response()->json( [
                'status' => false,
                'message' => 'invalid wallet',
                'data' => null
            ]);
        }

        $data['coin_type'] = $coin->coin_type;
        if (!empty($wallet->address)) {
            $data['address'] = $wallet->address;
        } else {
            $service = app('CoinApiService', [$coin->api_service, $coin->coin_type]);
            $newAddress = $service->getNewAddress();
            if ($newAddress == false) {
                 return response()->json( [
                    'status' => false,
                    'message' => 'something went wrong.',
                    'data' => null
                ]);
            }
            $data['address'] = $newAddress;
            $wallet->address = $newAddress;
            $wallet->update();
        }
         return response()->json( [
            'status' => true,
            'message' => '',
            'data' => $data
        ]);
    }

    public function withdrawal(WithdrawalRequest $request)
    {
        $userWallet = Wallet::where(['id' => $request->wallet_id, 'user_id' => Auth::id()])->first();
        if (empty($userWallet)) {
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => __("User wallet account not found"),
            ]);
        }
        $coin = Coin::find($userWallet->coin_id);

        if($coin->withdrawal_status < 1){
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => __("Withdrawal is disabled"),
            ]);
        }
        $receiverAddress = $request->address;
        $service = new WalletService();
        $checkInternal = $service->verifyInternalAddress($receiverAddress, $request->wallet_id);
        if($checkInternal['success'] == false) {
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => $checkInternal['message']
            ]);
        }
        $user = Auth::user();

        $data = $service->withdrawalCoin($user, $request->only('wallet_id', 'address', 'amount'));

        if (isset($data['status']) && $data['status'] == false) {
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => $data['message'],
            ]);
        } elseif (isset($data['status']) && $data['status'] == true) {
            return response()->json([
                'status' => true,
                'message' => $data['message'],
                'data' => $data['data'],
            ]);
        }else{
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => __('Invalid data'),
            ]);
        }
    }


    public function withdrawalTwoFactorAuthentication(Request $request)
    {
            $wcode = $request->get('w-code',0);
            $whash = $request->get('w-hash','0');
            $tempWithdrawal = Withdrawal2fa::where(['user_id'=>Auth::id(),'verification_code'=>$wcode,'url_validation_code'=>$whash])->first();
            if (!empty($tempWithdrawal)) {
                try {
                    $exp = Carbon::parse($tempWithdrawal->expire_at);
                    if ($exp->lt(Carbon::now()) ) {
                        if (!empty($tempWithdrawal)) {
                            $tempWithdrawal->delete();
                        }
                        return response()->json( [
                            'status' => false,
                            'message' => __('Code expired, Failed to place withdrawal. Please try again.')
                        ]);
                    }

                    $withdrawalCoinLimitSetting = WithdrawalCoinLimitSetting::where('id', $tempWithdrawal->withdrawal_coin_limit_setting_id)->first();
                    dispatch(new WithdrawalJob($tempWithdrawal->id, $withdrawalCoinLimitSetting, Auth::id()))->onQueue('withdrawal')->delay(env('WITHDRAWAL_DELAY',60));
                    return response()->json(['success' => true,  'message' =>  __('Withdrawal has been placed successfully'), 'data' => ['redirect' => true, 'type' => 'success','returnRoute' => route('my_wallets')]]);
                } catch (\Exception $exception) {
                    $this->logger->log("Withdrawal Error: ", errorHandle($exception->getMessage()));
                    return response()->json( [
                        'status' => false,
                        'message' => __('Failed to place withdrawal. Please try again.')
                    ]);
                }
            } else {
                return response()->json( [
                    'status' => false,
                    'message' => __('Code Mismatch. Please try again.')
                ]);
            }

    }

    public function depositData(Request $request)
    {
        if ($request->ajax()) {
            $items = Deposit::where('deposit_by', Auth::id());
            return datatables($items)
                ->addColumn('wallet', function($data) {
                    return $data->receiverWallet->coin->coin_type;
                })
                ->editColumn('address', function($data) {
                    return $data->address;
                })
                ->editColumn('tansaction_hash', function($data) {
                    return $data->transaction_hash;
                })
                ->editColumn('amount', function($data) {
                    return $data->amount;
                })
                ->make(true);
        }
        return view('user.pages.deposit-data', ['title' => __('Deposit History'), 'menu' => 'deposit-data']);
    }
    public function activityLog(Request $request, $coin_id)
    {
        if ($request->ajax()) {
            $items = Transaction::where('buyer_id', Auth::id())->where('coin_id', $coin_id);
            return datatables($items)
                ->editColumn('amount', function($data) {
                    return visual_number_format($data->amount).' '.$data->coin_type;
                })
                ->addColumn('is_bid', function($data) {
                    if ($data->bid_id == 0) {
                        return 'Yes';
                    }
                    else {
                        return 'No';
                    }
                })
                ->addColumn('time', function($data) {
                    return Carbon::parse($data->time)->diffForHumans();
                })
                ->editColumn('status', function($data) {
                    $status = '';
                    if($data->status == TRANS_DEPOSIT) {
                        $status = 'Deposited';
                    }
                    elseif ($data->status == TRANS_WITHDRAW) {
                        $status = 'Withdrawed';
                    }
                    elseif ($data->status == TRANS_SOLD) {
                        $status = 'Artwork Purchased';
                    }
                    elseif ($data->status == TRANS_BID_HOLD) {
                        $status = 'Bid (Coin Holded)';
                    }
                    elseif ($data->status == TRANS_BID_WIN) {
                        $status = 'Bid (Win)';
                    }
                    elseif ($data->status == TRANS_BID_REFUND) {
                        $status = 'Bid (Refunded)';
                    }
                    return $status;
                })
                ->rawColumns([])
                ->make(true);
        }
        return view('user.pages.activity-log', ['title' => __('Activity Log'), 'menu' => 'my-wallet', 'coin_id' => $coin_id]);
    }

    public function myEarnings(Request $request)
    {
        $seller_id = Auth::id();
        if ($request->ajax()) {
            $items = SellService::with('service', 'buyer')->whereHas('service', function($query) use($seller_id) {
                $query->where('created_by', $seller_id);
            });
            return datatables($items)
                ->addColumn('artwork', function($data) {
                    return $data->service->title;
                })
                ->addColumn('thumb', function($data) {
                    return '<img src="'.asset(IMG_SERVICE_PATH.$data->service->thumbnail).'" class="img-50" />';
                })
                ->addColumn('buyer', function($data) {
                    return $data->buyer->first_name.' '.$data->buyer->first_name;
                })
                ->addColumn('earning', function($data) {
                    return visual_number_format($data->price_amount);
                })
                ->rawColumns(['thumb'])
                ->make(true);
        }
        $purchase_earning = SellService::with('service', 'buyer')->whereHas('service', function($query) use($seller_id) {
            $query->where('created_by', $seller_id);
                })->sum('price_amount');
        $bid_earning = Bid::with('service', 'bid_holder')->whereHas('service', function($query) use($seller_id) {
            $query->where('created_by', $seller_id);
        })->where('is_sale_bid', 1)->sum('bid_amount');
        return view('user.pages.my-earnings', ['title' => __('My Earnings'), 'menu' => 'my-earnings', 'purchase_earning' => $purchase_earning, 'bid_earning' => $bid_earning]);
    }

    public function myEarningsBid(Request $request)
    {
        if ($request->ajax()) {
            $seller_id = Auth::id();
            $items = Bid::with('service', 'bid_holder')->whereHas('service', function($query) use($seller_id) {
                $query->where('created_by', $seller_id);
            })->where('is_sale_bid', 1);
            return datatables($items)
                ->addColumn('artwork', function($data) {
                    return $data->service->title;
                })
                ->addColumn('thumb', function($data) {
                    return '<img src="'.asset(IMG_SERVICE_PATH.$data->service->thumbnail).'" class="img-50" />';
                })
                ->addColumn('buyer', function($data) {
                    return $data->bid_holder->first_name.' '.$data->bid_holder->first_name;
                })
                ->addColumn('earning', function($data) {
                    return visual_number_format($data->bid_amount);
                })
                ->rawColumns(['thumb'])
                ->make(true);
        }
    }


    public function withdrawData(Request $request)
    {
        if ($request->ajax()) {
            $items = Withdrawal::where('withdraw_by', Auth::id());
            return datatables($items)
                ->addColumn('wallet', function($data) {
                    return $data->wallet->coin->full_name;
                })
                ->addColumn('receiver_wallet', function($data) {
                    return $data->receiverWallet->coin->full_name;
                })
                ->editColumn('address', function($data) {
                    return $data->address;
                })
                ->editColumn('tansaction_hash', function($data) {
                    return $data->transaction_hash;
                })
                ->editColumn('amount', function($data) {
                    return $data->amount;
                })
                ->make(true);
        }
        return view('user.pages.withdraw-data', ['title' => __('Withdraw History'), 'menu' => 'withdraw-data']);
    }
}
