<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Jobs\CommonEmailSendJob;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\Wallet;
use App\Http\Services\Logger;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class WalletNotifier
 */
class WalletNotifier extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function coinPaymentDepositNotify(Request $request)
    {
        $log = new Logger(env('WALLET_NOTIFY_LOG_PATH'));
        $data['success'] = false;
        $data['message'] = __('Something went wong');
        $log->log('coin payment notifier called', '======================');
        $merchant_id = env('COIN_PAYMENT_IPN_MERCHANT_ID');
        $secret = env('COIN_PAYMENT_IPN_SECRET');
        if (env('APP_ENV') != "local") {
            if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
                $log->log('notifier controller start', 'No HMAC signature sent');
                $data['message'] = __('No HMAC signature sent');
                return $data;
            }
            $merchant = isset($_POST['merchant']) ? $_POST['merchant']:'';
            if (empty($merchant)) {
                $log->log('notifier controller start', 'No Merchant ID passed');
                $data['message'] = __('No Merchant ID passed');
                return $data;
            }
            if ($merchant != $merchant_id) {
                $log->log('notifier controller start', 'Invalid Merchant ID');
                $data['message'] = __('Invalid Merchant ID');
                return $data;
            }
            $request = file_get_contents('php://input');
            if ($request === FALSE || empty($request)) {
                $log->log('notifier controller start', 'Error reading POST data');
                $data['message'] = __('Error reading POST data');
                return $data;
            }
            $hmac = hash_hmac("sha512", $request, $secret);
            if ($hmac != $_SERVER['HTTP_HMAC']) {
                $log->log('notifier controller start', 'HMAC signature does not match');
                $data['message'] = __('HMAC signature does not match');
                return $data;
            }
        }
        $log->log('notifier request details', json_encode($request->all()));
        $transaction_id = $request->txn_id;
        if (Deposit::where('transaction_hash', $transaction_id)->exists()) {
            $data['message'] = __('Deposit already done '.$transaction_id);
            $log->log('Deposit already done',  $transaction_id);
            return $data;
        }
        try {
            $log->log("Con payment Notify start", '===========START Coin payment notify for ('.$request->currency.')===========');
            $log->log('Transaction Id',  $transaction_id);
            if (($request->ipn_type == "deposit") && ($request->status >= 100)) {
                $coinType = $request->currency;
                $coin = Coin::where(['coin_type' => $coinType])->first();
                $log->log('Coin Details From DB', json_encode($coin));
                $userWallet = Wallet::where(['address'=> $request->address, 'coin_id' => $coin->id])->first();
                $log->log('Wallet Details ', json_encode($userWallet));
                $log->log('address', $request->address);
                $log->log('Coin Type from Node', $coinType);
                if (!empty($userWallet)) {
                    DB::beginTransaction();
                    $log->log('Address Found', 'Address found and try to add balance');
                    $depositData['receiver_wallet_id'] = $userWallet->id;
                    $depositData['amount'] = $request->amount;
                    $log->log('Amount',$depositData['amount'].' will be added');
                    $depositData['transaction_hash'] = $transaction_id;
                    $depositData['transaction_id'] = $transaction_id;
                    $depositData['address'] = $userWallet->address;
                    $depositData['address_type'] = 1;
                    $depositData['deposit_by'] = $userWallet->user_id;
                    $log->log('Deposit Data',json_encode($depositData));
                    Deposit::create($depositData);
                    $log->log('Before Balance',$userWallet->balance);
                    $userWallet->increment('balance', $depositData['amount']);
                    $log->log('After Balance',$userWallet->balance);
                    $data['success'] = true;
                    $data['message'] = __('Deposit successfully ');
                    $log->log('Finish', 'Deposit successfully & Committed');
                    $log->log("Coin payment  Notify", '===========END notify for ('.$request->currency.')===========');
                    DB::commit();
                    $user = User::find($userWallet->user_id);
                    $subject = __("Coin received at address.");
                    $emailData = [
                        'user' => $user,
                        'amount' => $depositData['amount'],
                        'coin' => $userWallet->coin->coin_type,
                        'address' => $request->address
                    ];
                    dispatch(new CommonEmailSendJob($emailData, 'email.deposit_coin', $subject, $user))->onQueue('common-email-send');
                } else {
                    $log->log('Address', ' Address ('.$request->address.') Not found in wallet');
                    $log->log("AMZ Notify", '===========END CronJob Memo Not found===========');
                }
            }
            return $data;
        } catch (\Exception $e) {
            DB::rollback();
            $log->log('deposit ', 'failed-transaction-id=' . $transaction_id . 'issue--file=' . $e->getFile() . '---message' . errorHandle($e->getMessage()) . '----line=' . errorHandle($e->getLine()));
            $log->log("Coin payment Notify ", '=========== END coin payment notifier With Error notify for ('.$request->currency.') ===========');
        }
        return $data;
    }
}
