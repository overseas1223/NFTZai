<?php

namespace App\Jobs;

use App\Http\Services\CommonService;
use App\Http\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class SendVerifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->data = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('any_key')->allow(2)->every(1)->then(function () {

            Log::info('mail send start');

            try {
                $dt['data'] =  $this->data['data'];
                $dt['key'] =  $this->data['key'];
                app(MailService::class)->send($this->data['template'], $dt, $this->data['userEmail'], $this->data['userName'], $this->data['subject']);
            } catch (\Exception $e) {
                Log::info( $e->getMessage());
            }
            Log::info('mail send end');

        }, function () {
            // Could not obtain lock; this job will be re-queued
            return $this->release(2);
        });

    }
}
