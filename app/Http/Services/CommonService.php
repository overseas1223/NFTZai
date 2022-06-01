<?php
/**
 * Created by PhpStorm.
 * User: masum
 * Date: 15/11/2021
 * Time: 5:19 PM
 */

namespace App\Http\Services;

use App\Model\Notification;
use App\Model\SendMailRecord;
use App\Model\UserVerificationCode;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommonService
{
    // check id
    public function checkValidId($id){
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            return ['success'=>false];
        }
        return $id;
    }

    // mail verification process
    public function mailVarification($request)
    {
        try {
            $uvc = UserVerificationCode::join('users','users.id','=', 'user_verification_codes.user_id')
                ->where(['user_verification_codes.code' => $request->access_code,
                    'users.email'=>$request->email, 'user_verification_codes.status' => STATUS_PENDING])
                ->where('user_verification_codes.expired_at', '>=', date('Y-m-d'))
                ->first();
            if ($uvc) {
                UserVerificationCode::where(['id' => $uvc->id])->update(['status' => STATUS_SUCCESS]);
                User::where(['id' => $uvc->user_id])->update(['is_verified' => STATUS_SUCCESS]);

                return [
                    'success' => true,
                    'message' => __('Email verification successfull.')
                ];
            } else {
                return [
                    'success' => false,
                    'message' => __('Verification code expired or not found!')
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('Invalid request . Please try again!')
            ];
        }
    }

    // send forgot password code
    public function sendResetPasswordCode($request)
    {
        $user = User::where(['email' => $request->email])->first();

        if ($user) {
            $alreadyCode = UserVerificationCode::where(['user_id' =>$user->id,'status' => STATUS_PENDING])->first();
            if($alreadyCode) {
                $alreadyCode->update(['status' => STATUS_SUCCESS]);
            }
            $token = randomNumber(6);
            UserVerificationCode::create([
                'user_id' => $user->id,
                'code' => $token,
                'expired_at' => date('Y-m-d', strtotime('+10 days')),
                'status' => STATUS_PENDING
            ]);
            $user_data = [
                'email' => $user->email,
                'name' => $user->first_name.' '.$user->last_name,
                'token' => $token,
            ];
            try {
                Mail::send('email.password_reset', $user_data, function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject('Forgot Password');
                });
            } catch (\Exception $e) {
                $response = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
                return $response;
            }
            $response = [
                'message' => 'Mail sent Successfully to ' . $user->email . ' with password reset Code.',
                'success' => true
            ];

        } else {
            $response = [
                'message' => __('Sorry! The email could not be found'),
                'success' => false
            ];
        }
        return $response;
    }

    public function resetForgotPassword($request)
    {
        try {
            $vf_code = UserVerificationCode::join('users','users.id','=', 'user_verification_codes.user_id')
                ->where(['user_verification_codes.code' => $request->access_code,
                    'users.email'=>$request->email, 'user_verification_codes.status' => STATUS_PENDING])
                ->first();

            if (isset($vf_code)) {
                User::where(['id' => $vf_code->user_id])->update(['password' => bcrypt($request->password)]);
                UserVerificationCode::where(['id' => $vf_code->id])->update(['status' => STATUS_SUCCESS]);
                $data['success'] = true;
                $data['message'] = __('Password reset successfully');
            } else {
                $data['success'] = false;
                $data['message'] = __('Reset code not valid.');
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();

            return $data;
        }

        return $data;
    }

    public function sendNotificationProcess($request)
    {
        try {
            Log::info('send notification start');
            $users = User::where(['status'=>STATUS_ACTIVE, 'role'=> USER_ROLE_USER])->get();
            if (isset($users[0])) {
                foreach ($users as $user) {
                    Notification::create(['user_id'=>$user->id, 'title'=>$request->title, 'notification_body'=>$request->notification_body]);
                    $data['success'] = true;
                    $data['user_id'] = $user->id;
                    $data['message'] = $request->title;

                    $channel = 'usernotification_'.$user->id;
                    $config = config('broadcasting.connections.pusher');
                    $pusher = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options']);

                    $test =  $pusher->trigger($channel , 'receive_notification', $data);
                }
            }
            Log::info('send notification end');
            return true;
        } catch (\Exception $e) {
            Log::info('send notification exception');
            Log::info($e->getMessage());
        }
    }

    // send email to all users
    public function sendEmailToAlUser($datas)
    {
        log::info('mail send start');
        $mailService = app(MailService::class);

        $data['users'] = User::where(['status' => STATUS_ACTIVE, 'role'=> USER_ROLE_USER])->get();

        if(isset($data['users'][0])) {
            foreach ($data['users'] as $user) {
                $already_sent = SendMailRecord::where('user_id', $user->id)
                    ->where('email_type', $datas['type'])
                    ->first();

                if ($already_sent) {
                    log::info('already sent');
                    log::info($already_sent->user_id);
                    continue;
                }
                $input['user_id'] = $user->id;
                $input['status'] = STATUS_ACTIVE;
                $input['email_type'] = $datas['type'];
                $email = $user->email;
                $subject = $datas['subject'];
                $name = $user->first_name.' '.$user->last_name;
                try {
                    $mailSent = $mailService->send($datas['mailTemplate'], $datas, $email, $name, $subject);
                    log::info('Mail sent');
                    log::info($user->id);
                    if ($mailSent['error']) {
                        log::info($mailSent['message']);
                        throw new \Exception($mailSent['message'], '500');
                    }

                    SendMailRecord::create($input);
                } catch (\Exception $e) {
                    log::info( $e->getMessage());
                }
            }
            log::info('mail send end');

        }
    }

}
