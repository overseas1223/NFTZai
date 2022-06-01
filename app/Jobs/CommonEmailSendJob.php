<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class CommonEmailSendJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $template;
    protected $data;
    protected $user;
    protected $subject;
    protected $defaultEmail;
    protected $defaultName;



    /**
     * CommonEmailSendJob constructor.
     * @param $data
     * @param $template
     * @param $subject
     * @param $user
     */
    public function __construct($data, $template, $subject, $user) {

        $this->defaultEmail = settings('mail_from_address');
        $this->defaultName = allsetting()['app_title'];
        $this->data = $data;
        $this->template = $template;
        $this->subject = $subject;
        $this->user = $user;
        $this->defaultEmail = settings('mail_from_address');
        $this->defaultName = allsetting()['app_title'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $user = $this->user;
        $subject = $this->subject;

        try {
            Mail::send($this->template, $this->data, function ($message) use ($user, $subject) {
                $message->to($user->email, $user->username)->subject($subject)->from(
                    $this->defaultEmail, $this->defaultName
                );
            });

        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
