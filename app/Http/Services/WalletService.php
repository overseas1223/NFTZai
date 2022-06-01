<?php
/**
 * Created by PhpStorm.
 * User: masum
 * Date: 15/11/2021
 * Time: 5:19 PM
 */

namespace App\Http\Services;

use App\Jobs\CommonEmailSendJob;
use App\Model\Coin;
use App\Model\CoinSetting;
use App\Model\Deposit;
use App\Model\Wallet;
use App\Model\Withdrawal2fa;
use App\Model\WithdrawalCoinLimitSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WalletService
{
    public $logger = null;

    public function __construct(){
        $this->logger = new Logger(env('WITHDRAWAL_LOG_PATH'));
    }

    public function verifyInternalAddress($address, $wallet_id)
    {
        $response['success'] = true;
        $receiverWallet = Wallet::where('address', $address)->first();
        if ($receiverWallet) {
            if (Auth::id() == $receiverWallet->user_id) {
                $response['success'] = false;
                $response['message'] = __("You can't place withdrawal to your own wallet.");
                return $response;
            }
            $senderWallet = Wallet::find($wallet_id);
            if ($receiverWallet->coin->coin_type != $senderWallet->coin->coin_type) {
                $response['success'] = false;
                $response['message'] = __("Invalid address found to place withdrawal");
                return $response;
            }
        }

        return $response;
    }

    public function withdrawalCoin($user, array $request)
    {
        Log::info(json_encode($request));
        $data['status'] = false;
        $userWallet = Wallet::select('wallets.id as wallet_id', 'wallets.user_id as user_id', 'wallets.balance as balance', 'coins.id as coin_id', 'coins.coin_type as coin_type', 'coins.withdrawal_status', 'coin_settings.api_service')
            ->where(['wallets.id' => $request['wallet_id'], 'user_id' => $user->id])
            ->join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->join('coin_settings', 'coin_settings.coin_id', '=', 'wallets.coin_id')
            ->first();

        if (empty($userWallet)) {
            $data['message'] = __('Your selected wallet is invalid.');
            return $data;
        }

        if (!$userWallet->withdrawal_status) {
            $data['message'] = __(':coinType is not available for withdrawal right now !!!', ['coinType' => $userWallet->coin_type]);
            return $data;
        }

        // calculate fees and check if the balance is available to withdraw
        $withdrawFees = $this->_calculateWithdrawFees(customNumberFormat($request['amount']), $userWallet->coin_id);
        $this->logger->log("Withdrawal Fees: ", json_encode($withdrawFees));

        if (!$withdrawFees['status']) {
            return $withdrawFees;
        }
        $this->logger->log("User balance: ", $userWallet->balance);
        $this->logger->log("Request Amount: ", bcadd(customNumberFormat($request['amount']), $withdrawFees['fees']));
        $this->logger->log("Compare: ", bccomp($userWallet->balance, bcadd(customNumberFormat($request['amount']), customNumberFormat($withdrawFees['fees']))));

        if (bccomp($userWallet->balance, bcadd(customNumberFormat($request['amount']), customNumberFormat($withdrawFees['fees']))) < 0) {
            $data['message'] = __('You don\'t have enough balance!');
            return $data;
        }

        $response = $this->_withdrawalValidationCheck((object)$request, $userWallet);
        $this->logger->log("User Level: ", $response);


        if($response['status'] == 0){
            $data['message']= $response['response']['message'];
            return $data;
        }

        if (!$response['status']) {
            $data['message'] = $response['response']['message'];
            return $data;
        }

        $service = app('CoinApiService', [$userWallet->api_service, $userWallet->coin_type]);
        $addressVerify = $service->verifyAddress($request['address']);
        if (empty($addressVerify)) {
            $data['message'] = __('Invalid address.');
            return $data;
        }
        $expire_minute = isset(allsetting()['withdrawal_2fa_code_validation_time']) ? allsetting()['withdrawal_2fa_code_validation_time'] : 1440; // time in minute
        $expire_time = Carbon::now()->addMinutes($expire_minute);
        $wallet = Wallet::find($userWallet->wallet_id);
        $uid = randomString(16);
        $input = [
            'wallet_id' => $wallet->id,
            'coin_id' => $wallet->coin_id,
            'address' => $request['address'],
            'amount' => customNumberFormat($request['amount']),
            'fees' => $withdrawFees,
            'transaction_hash' => '',
            'status' => PENDING,
            'ip' =>  '0.0.0.0',
            'withdrawal_coin_limit_setting_id' => $response['level']->id,
            'user_id' => Auth::id(),
            'url_validation_code' => $uid,
            'url_validation_url' => '',
            'verification_code' => randomNumber(6),
            'expire_at' => $expire_time
        ];

        $withdrawal2fa = Withdrawal2fa::create($input);

        if (!empty($withdrawal2fa)) {
            $sendMail = $this->sendWithdrawalVerificationCode($withdrawal2fa);
            #$withdrawal2fa->forceDelete();
            $data['message'] = 'Check your email';
            $data['status'] = true;
            $data['data'] = $withdrawal2fa->url_validation_code;
            return $data;
        }
    }
    public function _calculateWithdrawFees($amount, $coinId)
    {
        $data = $this->getWithdrawalFeesSettings($coinId);
        if (!$data['status']) {
            return [
                'status' => false,
                'message' => 'some.thing.went.wrong'
            ];
        }
        $fees = calculateFees($amount, $data['data']->withdrawal_fee_method, $data['data']->withdrawal_fee_percent, $data['data']->withdrawal_fee_fixed);
        if(($data['data']->withdrawal_fee_percent == 0 && $data['data']->withdrawal_fee_fixed == 0) || $fees != 0){
            return [
                'status' => true,
                'fees' => $fees
            ];
        }
        if($fees == 0){
            return [
                'status' => false,
                'message' => 'Amount is Too Small'
            ];
        }

    }
    public function getWithdrawalFeesSettings($coinId)
    {
        $data = CoinSetting::select('withdrawal_fee_percent', 'withdrawal_fee_fixed', 'withdrawal_fee_method')
            ->join('coins', 'coins.id', '=', 'coin_settings.coin_id')
            ->where(['coins.active_status' => 1, 'coins.withdrawal_status' => 1, 'coin_id' => $coinId])->first();

        if (empty($data)) {
            return [
                'status' => false,
                'message' => 'no.settings.found',
                'data' => null
            ];
        }

        return [
            'status' => true,
            'message' => '',
            'data' => $data
        ];
    }

    public function _withdrawalValidationCheck($request, $userWallet)
    {
        $amount = $request->amount;
        $level = $this->_checkLevel($userWallet->coin_id,$amount);

        if ($level == false) {
            $response['status'] = 0;
            $response['response']['message'] = __('Please recheck your amount or contact with support.');
            return $response;
        }

        $userStatus = $this->_checkUserStatus(Auth::user()->id);
        if (is_null($userStatus)) {
            $response['status'] = 0;
            $response['response']['message'] = __('Invalid User!');
            return $response;
        }

        $response = [
            'status' => 1,
            'level' => $level
        ];
        return $response;
    }

    public function _checkLevel($coin,$amount){
        $sendCoinLimits = WithdrawalCoinLimitSetting::where('coin_id',$coin)->orderBy('from', 'asc')->get();
        foreach ($sendCoinLimits as $sendCoinLimit) {
            if (bccomp($amount, $sendCoinLimit->from) >= 0 && bccomp($amount, $sendCoinLimit->to) <= 0) {
                return $sendCoinLimit;
            }
        }
        return false;
    }

    public function _checkUserStatus($id)
    {
        return User::where(['id' => $id,'status' => STATUS_ACTIVE])->first();
    }


    public function sendWithdrawalVerificationCode($withdrawal)
    {

        $user = User::where('id', $withdrawal->user_id)->select('email', 'first_name', 'last_name')->first();
        $withdrawal_data = [
            'email' => $user->email,
            'username' => $user->first_name . ' ' . $user->last_name,
            'vfcode' => $withdrawal->verification_code,
            'withdrawal_url' => $withdrawal->url_validation_url,
        ];

        $send_mail = $this->sendMail($withdrawal_data, 'email.user_withdrawal_confirmation', __('Withdrawal Confirmation.'));
        $data = [
            'message' => 'send.successful',
            'status' => true,
            'data' => null,
            'withdrawal_url' =>  $withdrawal->url_validation_url
        ];
        if ($send_mail['status'] == false) {
            $data['status'] = false;
            $data['message'] = 'failed to send email verification mail please contact with support.';
        }

        return $data;
    }
    public function sendMail($user_data, $template, $subject = '')
    {
        if (!empty($user_data)) {
            $user = (object)$user_data;
        } else {
            $user = Auth::user();
        }
        dispatch(new CommonEmailSendJob($user_data, $template, $subject, $user))->onQueue('common-email-send');

        $data['status'] = true;
        return $data;
    }
    // check internal address
    public function isInternalAddress($address)
    {
        return Wallet::where('address', $address)->first();
    }

    // save internal withdrawal data
    public function internalWithdrawal($withdrawal)
    {
        $this->logger->log("internal Withdrawal start : ");
        $response['status'] = false;
        $response['message'] = __('Something went wrong');
        try {
            $userWallet = Wallet::where(['address' => $withdrawal->address])->first();
            $this->logger->log("user wallet: ", json_encode($userWallet));
            $transaction_hash = 'Internal-f'.$withdrawal->user_wallet_id.'t'.$userWallet->id.'-'.random_int(111111,999999).time();
            $data = [
                'receiver_wallet_id' => $userWallet->id,
                'sender_wallet_id' => $withdrawal->wallet_id,
                'amount' => $withdrawal->amount,
                'address' => $withdrawal->address,
                'transaction_hash' => $transaction_hash,
                'transaction_id' => $transaction_hash,
                'fees' => $withdrawal->fees,
                'address_type' => 1,
            ];

            $deposit = Deposit::create($data);
            if ($deposit) {
                $this->logger->log("internal deposit: ", json_encode($deposit));
                $this->logger->log("balance before internal deposit: ", $userWallet->balance);
                $userWallet->increment('balance', $deposit->amount);
                $this->logger->log("balance after internal deposit: ", $userWallet->balance);

                $response['status'] = true;
                $response['message'] = __('Withdrawal approved');
                $response['transaction_hash'] = $deposit->transaction_hash;

                $this->logger->log(" internal deposit success : ");
            }

        } catch (\Exception $e) {
            $response['message'] = __('Something went wrong '.$e->getMessage());
        }

        return $response;
    }


    /**
     * Description: Send coin to address
     * @param $userId
     * @param $withdrawal
     * @param $userWallet
     * @param null $authId
     * @return array
     */

    public function _sendCoinToAddress($userId, $withdrawal, $userWallet, $authId = null){
        $toAddress = $withdrawal->address;
        $requestedAmount = $withdrawal->amount;
        $coin = Coin::where('coins.id', $userWallet->coin_id)->join('coin_settings', 'coins.id', '=', 'coin_settings.coin_id')->first();
        $coinService = app("CoinApiService", [$coin->api_service, $coin->coin_type]);
        $transaction = $coinService->sendToAddress($toAddress, customNumberFormat($requestedAmount), $userId, $authId);

        if($coin->api_service == 'CoinPaymentsApiService'){
            $this->logger->log("Coin API Service response Status", json_encode($transaction));
            if (!$transaction['success']) {
                $this->logger->log("Coin API Service response Error", $transaction['message']);
                return [
                    'status' => false,
                    'message' => __('Failed to approve withdrawal request! ').$transaction['message'],
                ];
            }
            $this->logger->log("Coin API Service response Hash", $transaction['transaction']);
            return [
                'status' => true,
                'message' => __('Withdrawal request is approved successfully.'),
                'transaction_hash' => $transaction['transaction'],
                'coin_payment_transaction_id' => $transaction['transaction'],
            ];
        }else{
            return [
                'status' => false,
                'message' => __('Withdrawal request is approved Field.'),
            ];
        }
    }

    /**
     * @param $user
     * @param $withdrawal
     * @param $coin
     * @param $emailMessage
     * @return array
     */
    public function _getMailData($user, $withdrawal, $emailMessage, $coin)
    {
        $data['data'] = $user;
        $data['amount'] = $withdrawal->amount;
        $data['fee'] = $withdrawal->fee;
        $data['status'] = $withdrawal->status;
        $data['coinType'] = strtoupper($coin->coin_type);
        $data['emailMessage'] = $emailMessage;
        $company = allsetting('app_title');
        $companyName = !empty($company) ? $company : __('Collubus PRO');
        $subject = __('Withdrawal Notification | :companyName', ['companyName' => $companyName]);
        $mailService = app(MailService::class);

        $emailData = [
            'data' => $data,
            'subject' => $subject,
            'mailService' => $mailService
        ];

        return $emailData;
    }

    /**
     * @param $user
     * @param $data
     * @param $subject
     * @param $mailService
     */
    public function _sendMailToUser($user, $data, $subject, $mailService)
    {
        $userName = $user->first_name . ' ' . $user->last_name;
        $userEmail = $user->email;
        $mailService->send('email.user-withdrawal-notification', $data, $userEmail, $userName, $subject);
    }

    /**
     * @param $data
     * @param $subject
     * @param $mailService
     */
    public function _sendMailToAdmin($data, $subject, $mailService)
    {
        $userName = 'Mr. Admin';
        $admins = User::where(['role' => USER_ROLE_ADMIN, 'status' => STATUS_ACTIVE])->get();
        if (!$admins->isEmpty()) {
            $email = [];
            foreach ($admins as $admin) {
                $email[] = $admin->email;
            }
            $mailService->send('email.admin-withdrawal-notification', $data, $email, $userName, $subject);
        }
    }
}
