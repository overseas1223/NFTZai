<?php

namespace App\Jobs;

use App\Http\Services\WalletService;
use App\Model\Withdrawal;
use App\Http\Services\Logger;
use App\Model\WithdrawalCancelReason;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class WithdrawalApproveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $withdrawalId;
    public $adminId;
    public $logger;

    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $adminId
     */
    public function __construct($id, $adminId)
    {
        $this->withdrawalId = $id;
        $this->adminId = $adminId;
        $this->logger = new Logger(env('WITHDRAWAL_LOG_PATH'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->logger->log("Withdrawal", '==========Start===============');
        $withdrawalRequest = Withdrawal::where(['id' => $this->withdrawalId, 'status' => ON_ADMIN_APPROVAL, 'in_queue' => 1])->with('wallet')->first();

        Log::info(json_encode($withdrawalRequest));
        if (empty($withdrawalRequest)) {
            $this->logger->log("Withdrawal[".$this->withdrawalId."]", 'Invalid Withdrawal Id');
            $this->logger->log("Withdrawal", '==========END ERROR===============');
            return ;
        }
        $this->logger->log('Withdrawal',json_encode($withdrawalRequest));

        $this->logger->log("Withdrawal wallet", json_encode($withdrawalRequest->wallet));

        $this->logger->log("Withdrawal coin", json_encode($withdrawalRequest->wallet->coin->coin_type));
        $this->logger->log("Withdrawal amount", json_encode($withdrawalRequest->amount));

        $this->logger->log("Withdrawal[$withdrawalRequest->id]", 'Going to approve this request by admin');

        try {
            $withdrawalRequest->status = APPROVED;
            $withdrawalRequest->in_queue = 0;
            $withdrawalRequest->update();
            $this->logger->log("Withdrawal[$withdrawalRequest->id]", 'Going to send from node');
            $service = new WalletService();
            if ($service->isInternalAddress($withdrawalRequest->address)) {
                $this->logger->log("Internal address found", $withdrawalRequest->address);
                $response = $service->internalWithdrawal($withdrawalRequest);
                $this->logger->log("Internal transaction ", json_encode($response));
            } else {
                $response = $service->_sendCoinToAddress($withdrawalRequest->userWallet->user_id, $withdrawalRequest, $withdrawalRequest->userWallet, $this->adminId);
            }
            $this->logger->log("RPC Return status", $response['status']);
            if ($response['status']) {
                try {
                    if (isset($response['coin_payment_transaction_id'])) {
                        $withdrawalRequest->coin_payment_transaction_id = $response['transaction'];
                    } else {
                        $withdrawalRequest->transaction_hash = $response['transaction'];
                    }
                    $withdrawalRequest->update();
                    $this->logger->log("Withdrawal", 'Hash Update Successfully');
                } catch (\Exception $exception) {
                    $this->logger->log("Withdrawal[$withdrawalRequest->id]", $exception->getMessage());
                    $this->logger->log("Withdrawal[$withdrawalRequest->id]", " Transaction Hash Update failed.");
                }
                // sending email
                $user = $withdrawalRequest->wallet->user;
                $coin = $withdrawalRequest->wallet->coin;
                $company = allsetting('app_title');
                $companyName = !empty($company) ? $company : __('Nftzai');
                $subject = __('Withdrawal Approve Notification | :companyName', ['companyName' => $companyName]);
                $data = [
                    'user' => $user,
                    'withdrawal' => $withdrawalRequest,
                    'status' => 1,
                    'coinType' => strtoupper($coin->coin_type)
                ];

                dispatch(new CommonEmailSendJob($data, 'email.withdrawal-approve-notification', $subject, $user))->onQueue('common-email-send');
                $this->logger->log("Withdrawal", '==========END===============');
                return ;
            } else {
                $this->logger->log("Withdrawal[".decrypt($this->withdrawalId)."]", "Request is not processed");
                $withdrawalObject = Withdrawal::find($withdrawalRequest->id);
                $withdrawalObject->status = STATUS_RECHECK;
                $withdrawalObject->in_queue = 0;
                $withdrawalObject->update();
                $wcr = WithdrawalCancelReason::where(['withdrawal_id' => $withdrawalRequest->id])->first();
                if(!empty($wcr)){
                    $wcr->delete();
                }
                $msg = isset($response['error_message']) ? $response['error_message'] : $response['message'];
                WithdrawalCancelReason::create(['withdrawal_id' => $withdrawalRequest->id, 'reason' => $msg]);
                $this->logger->log("Status Update Error", "Update Recheck status");
            }
            $this->logger->log("Withdrawal", '==========END===============');
        } catch (\Exception $exception) {
            $this->logger->log("Withdrawal[$withdrawalRequest->id]", $exception->getMessage() . ' ' . $exception->getLine().' '.$exception->getFile());
            $this->logger->log("Withdrawal", '==========END ERROR===============');

        }
    }



}
