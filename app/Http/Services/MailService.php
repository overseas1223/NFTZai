<?php
/**
 * Created by PhpStorm.
 * User: masum
 * Date: 15/11/2021
 * Time: 5:19 PM
 */

namespace App\Http\Services;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class MailService
{
    protected $defaultEmail;
    protected $defaultName;

    public function __construct()
    {
        if (Schema::hasTable('admin_settings')) {
            $adm_setting = allsetting();

            $mail_driver = isset($adm_setting['mail_driver']) ? $adm_setting['mail_driver'] : env('MAIL_DRIVER');
            $mail_host = isset($adm_setting['mail_host']) ? $adm_setting['mail_host'] : env('MAIL_HOST');
            $mail_port = isset($adm_setting['mail_port']) ? $adm_setting['mail_port'] : env('MAIL_PORT');
            $mail_username = isset($adm_setting['mail_username']) ? $adm_setting['mail_username'] : env('MAIL_USERNAME');
            $mail_password = isset($adm_setting['mail_password']) ? $adm_setting['mail_password'] : env('MAIL_PASSWORD');
            $mail_encryption = isset($adm_setting['mail_encryption']) ? $adm_setting['mail_encryption'] : env('MAIL_ENCRYPTION');
            $mail_from_address = isset($adm_setting['mail_from_address']) ? $adm_setting['mail_from_address'] : env('MAIL_FROM_ADDRESS');

            config(['mail.driver' => $mail_driver]);
            config(['mail.host' => $mail_host]);
            config(['mail.port' => $mail_port]);
            config(['mail.username' => $mail_username]);
            config(['mail.password' => $mail_password]);
            config(['mail.encryption' => $mail_encryption]);
            config(['mail.address,address' => $mail_from_address]);
        }
        $this->defaultEmail = settings('mail_from_address');
        $this->defaultName = allsetting()['app_title'];
    }


    public function send($template = '', $data = [], $to = '', $name = '', $subject = '')
    {
        try {
            Mail::send($template, $data, function ($message) use ($name, $to, $subject) {
                $message->to($to, $name)->subject($subject)->replyTo(
                    $this->defaultEmail, $this->defaultName
                );
                $message->from($this->defaultEmail, $this->defaultName);
            });
        }catch (\Exception $e){
        }
    }

}
