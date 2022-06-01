<?php

namespace App\Jobs;


use App\Http\Services\Logger;
use App\Http\Services\MailService;
use App\Http\Services\WalletService;
use App\Model\Wallet;
use App\Model\Withdrawal;
use App\Model\Withdrawal2fa;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tempWithdrawalId;
    protected $withdrawalCoinLimitSetting;
    protected $user_id;
    public $logger;
    /**
     * Create a new job instance.
     *
     * @param $tempWithdrawalId
     * @param $withdrawalCoinLimitSetting
     */
    public function __construct($tempWithdrawalId, $withdrawalCoinLimitSetting, $user_id)
    {
        $this->tempWithdrawalId = $tempWithdrawalId;
        $this->withdrawalCoinLimitSetting = $withdrawalCoinLimitSetting;
        $this->user_id = $user_id;
        $this->logger = new Logger(env('WITHDRAWAL_LOG_PATH'));

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $tempWithdrawal = Withdrawal2fa::find($this->tempWithdrawalId);
        $wallet = Wallet::find($tempWithdrawal->wallet_id);

        Log::info('user wallet '. json_encode($wallet));
        if (empty($wallet)) {
            Log::info('wallet not found');
            return ;
        }
        $user = $wallet->user;
        $coin = $wallet->coin;
        $sendAmount = bcadd($tempWithdrawal->amount, $tempWithdrawal->fees);
        if (bccomp($wallet->balance, $sendAmount) < 0) {
            $this->logger->log("Withdrawal[$tempWithdrawal->id]", "[FAILED] Withdrawal Amount: $tempWithdrawal->amount User Wallet Balance: $wallet->balance");
            $tempWithdrawal->delete();
            Log::info("You don't have enough balance!");
            return ;
        }

        DB::beginTransaction();
        try {
            Log::info('start try');
            $input = [
                'wallet_id' => $tempWithdrawal->wallet_id,
                'coin_id' => $wallet->coin_id,
                'address' => $tempWithdrawal->address,
                'amount' => customNumberFormat($tempWithdrawal->amount),
                'fees' => $tempWithdrawal->fees,
                'transaction_hash' => '',
                'status' => STATUS_PENDING,
                'address_type' => ADDRESS_TYPE_EXTERNAL,
                'withdraw_by' => $user->id,
            ];
            $updateUserWallet = $wallet->decrement('balance', $sendAmount);
            Log::info('decrement try');
            $withdrawal = Withdrawal::create($input);
            if (!$updateUserWallet) {
                DB::rollback();
                $tempWithdrawal->delete();
                Log::info("Fail to withdrawals. 300");
                return ;
            }
            Log::info('decrement try');
            // checking if the $request->amount need admin approval
            Log::info(json_encode($this->withdrawalCoinLimitSetting));
            if ((isset($this->withdrawalCoinLimitSetting) && $this->withdrawalCoinLimitSetting->admin_approval)) {
                $emailMessage = $message = __('Withdrawal request is now pending. It needs admin approval.');
                $withdrawal->status = ON_ADMIN_APPROVAL; //admin approval
                $adminApprove = true;
                Log::info($emailMessage);
            } else {
                $withdrawal->status = SUCCESS; //Withdrawal success
                $withdrawal->in_queue = 1;
                Log::info('before withdrawal approve job '. json_encode($withdrawal));
                dispatch(new WithdrawalApproveJob($withdrawal->id, 'self->'.$user->email))->onQueue('withdrawal')->delay(env('WITHDRAWAL_DELAY',60));
                $message = __(':amount :ctype has been withdrawn successfully.', ['amount' => $withdrawal->amount, 'ctype' => $coin->coin_type]);
                $emailMessage = null;
                $adminApprove = false;
            }

            if ($withdrawal->update()) {
                $this->logger->log("Withdrawal[$withdrawal->id]", 'withdrawal table update successfully');
            } else {
                $this->logger->log("Withdrawal[$withdrawal->id]", 'withdrawal table update failed');
            }
        } catch (\Exception $exception) {
            $this->logger->log("Withdrawal[$tempWithdrawal->id]", $exception->getMessage() . ' line: ' . $exception->getLine() . ' file: ' . $exception->getFile());
            DB::rollback();
            $tempWithdrawal->delete();
            return ;
        }
        DB::commit();

        $service = new WalletService();
        $emailData = $service->_getMailData($user, $withdrawal, $emailMessage, $coin);
        // sending email
        $service->_sendMailToUser($user, $emailData['data'], $emailData['subject'], $emailData['mailService']);
        if ($adminApprove) {
            $service->_sendMailToAdmin($emailData['data'], $emailData['subject'], $emailData['mailService']);
        }
        return ;
    }


}
