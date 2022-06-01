<?php

namespace App\Jobs;

use App\Model\Withdrawal;
use App\Model\WithdrawalCancelReason;
use App\Http\Services\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class WithdrawalRejectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $withdrawalId;
    public $logger;

    /**
     * Create a new job instance.
     *
     * @param $request
     */
    public function __construct($id)
    {
        $this->withdrawalId = $id;
        $this->logger = new Logger(env('WITHDRAWAL_LOG_PATH'));
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        $id = $this->withdrawalId;
        $withdrawalRequest = Withdrawal::where('id', $id)
            ->where(['status' =>  PROCESSING, 'in_queue' => 1])->first();
        if (empty($withdrawalRequest)) {
            $this->logger->log("Withdrawal[$withdrawalRequest->id]", 'Invalid withdrawal id');
            return;
        }

        $this->logger->log("Withdrawal[$withdrawalRequest->id]", 'This withdrawal is going to cancel');

        DB::beginTransaction();
        try {
            // return the amount to the wallet and set the withdraw status cancelled.
            $requestedAmountWithFees = bcadd(customNumberFormat($withdrawalRequest->amount), customNumberFormat($withdrawalRequest->fees));
            $withdrawalRequest->status = ADMIN_CANCEL;
            $withdrawalRequest->in_queue = 0;
            $wcr = WithdrawalCancelReason::where(['withdrawal_id' => $id])->first();
            if(!empty($wcr)){
                $wcr->delete();
            }
            WithdrawalCancelReason::create(['withdrawal_id' => $id, 'reason' => 'admin rejected']);
            if ($withdrawalRequest->update()) {
                $withdrawalRequest->wallet->increment('balance', $requestedAmountWithFees);
                DB::commit();
                $this->logger->log("Withdrawal[$withdrawalRequest->id]", 'This withdrawal is canceled successfully');
                // sending email
                $user = $withdrawalRequest->wallet->user;
                $coin = $withdrawalRequest->wallet->coin;
                $company = allsetting('app_title');
                $companyName = !empty($company) ? $company : __('Nftzai');
                $subject = __('Withdrawal Notification | :companyName', ['companyName' => $companyName]);
                $data = [
                    'user' => $user,
                    'reason' => 'admin reject',
                    'amount' => $withdrawalRequest->amount,
                    'fee' => $withdrawalRequest->fee,
                    'status' => 3,
                    'coinType' => strtoupper($coin->coin_type)
                ];

                dispatch(new CommonEmailSendJob($data, 'email.withdrawal_cancel_notification', $subject, $user))->onQueue('common-email-send');
                return;
            }
        } catch (\Exception $exception) {
            $this->logger->log("Withdrawal[$withdrawalRequest->id]", $exception->getFile() . ' ' . $exception->getLine() . ' ' . $exception->getMessage());
            DB::rollBack();
        }
        DB::commit();
    }
}
