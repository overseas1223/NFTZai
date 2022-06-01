<?php
namespace App\Http\Services;

use App\Model\Setting;
use Illuminate\Support\Facades\DB;

class SettingService
{

    // save general setting
    public function saveCommonSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            if (isset($request->lang)) {
                Setting::where('slug', 'lang')->update(['value' => $request->lang]);
            }
            if (isset($request->coin_price)) {
                Setting::where('slug', 'coin_price')->update(['value' => $request->coin_price]);
            }
            if (isset($request->coin_name)) {
                Setting::where('slug', 'coin_name')->update(['value' => $request->coin_name]);
            }
            if (isset($request->logo)) {

                Setting::where('slug', 'logo')->update(['value' => uploadFile($request->logo,IMG_PATH,allsetting()['logo'])]);
            }
            if (isset($request->favicon)) {
                Setting::where('slug', 'favicon')->update(['value' => uploadFile($request->favicon,IMG_PATH,allsetting()['favicon'])]);
            }
            if (isset($request->login_logo)) {
                Setting::where('slug', 'login_logo')->update(['value' => uploadFile($request->login_logo,IMG_PATH,allsetting()['login_logo'])]);
            }
            if (isset($request->dashboard_image)) {
                Setting::where('slug', 'dashboard_image')->update(['value' => uploadFile($request->dashboard_image,IMG_PATH,allsetting()['dashboard_image'])]);
            }
            if (isset($request->company_name)) {
                Setting::where('slug', 'company_name')->update(['value' => $request->company_name]);
                Setting::where('slug', 'app_title')->update(['value' => $request->company_name]);
            }
            if (isset($request->copyright_text)) {
                Setting::where('slug', 'copyright_text')->update(['value' => $request->copyright_text]);
            }
            if (isset($request->primary_email)) {
                Setting::where('slug', 'primary_email')->update(['value' => $request->primary_email]);
            }
            if (isset($request->mail_from)) {
                Setting::where('slug', 'mail_from')->update(['value' => $request->mail_from]);
            }
            if (isset($request->twilo_id)) {
                Setting::where('slug', 'twilo_id')->update(['value' => $request->twilo_id]);
            }
            if (isset($request->twilo_token)) {
                Setting::where('slug', 'twilo_token')->update(['value' => $request->twilo_token]);
            }
            if (isset($request->sender_phone_no)) {
                Setting::where('slug', 'sender_phone_no')->update(['value' => $request->sender_phone_no]);
            }
            if (isset($request->ssl_verify)) {
                Setting::where('slug', 'ssl_verify')->update(['value' => $request->ssl_verify]);
            }

            if (isset($request->maintenance_mode)) {
                Setting::where('slug', 'maintenance_mode')->update(['value' => $request->maintenance_mode]);
            }
            if (isset($request->admin_coin_address)) {
                Setting::updateOrCreate(['slug' => 'admin_coin_address'], ['value' => $request->admin_coin_address]);
            }
            if (isset($request->base_coin_type)) {
                Setting::updateOrCreate(['slug' => 'base_coin_type'], ['value' => $request->base_coin_type]);
            }
            if (isset($request->admin_usdt_account_no)) {
                Setting::updateOrCreate(['slug' => 'admin_usdt_account_no'], ['value' => $request->admin_usdt_account_no]);
            }
            if (isset($request->number_of_confirmation)) {
                Setting::updateOrCreate(['slug' => 'number_of_confirmation'], ['value' => $request->number_of_confirmation]);
            }
            if (isset($request->home_famous_title)) {
                Setting::updateOrCreate(['slug' => 'home_famous_title'], ['value' => $request->home_famous_title]);
            }
            if (isset($request->home_famous_content)) {
                Setting::updateOrCreate(['slug' => 'home_famous_content'], ['value' => $request->home_famous_content]);
            }
            if (isset($request->home_latest_title)) {
                Setting::updateOrCreate(['slug' => 'home_latest_title'], ['value' => $request->home_latest_title]);
            }
            if (isset($request->home_latest_content)) {
                Setting::updateOrCreate(['slug' => 'home_latest_content'], ['value' => $request->home_latest_content]);
            }
            if (isset($request->home_explorer_title)) {
                Setting::updateOrCreate(['slug' => 'home_explorer_title'], ['value' => $request->home_explorer_title]);
            }
            if (isset($request->home_explorer_content)) {
                Setting::updateOrCreate(['slug' => 'home_explorer_content'], ['value' => $request->home_explorer_content]);
            }
            if (isset($request->home_footer_title)) {
                Setting::updateOrCreate(['slug' => 'home_footer_title'], ['value' => $request->home_footer_title]);
            }
            if (isset($request->home_footer_content)) {
                Setting::updateOrCreate(['slug' => 'home_footer_content'], ['value' => $request->home_footer_content]);
            }
            if (isset($request->counters_img_one)) {
                Setting::where('slug', 'counters_img_one')->update(['value' => uploadFile($request->counters_img_one,IMG_PATH,allsetting()['counters_img_one'])]);
            }
            if (isset($request->counters_img_two)) {
                Setting::where('slug', 'counters_img_two')->update(['value' => uploadFile($request->counters_img_two,IMG_PATH,allsetting()['counters_img_two'])]);
            }
            if (isset($request->counters_title)) {
                Setting::updateOrCreate(['slug' => 'counters_title'], ['value' => $request->counters_title]);
            }
            if (isset($request->counters_content_one)) {
                Setting::updateOrCreate(['slug' => 'counters_content_one'], ['value' => $request->counters_content_one]);
            }
            if (isset($request->counters_count_one)) {
                Setting::updateOrCreate(['slug' => 'counters_count_one'], ['value' => $request->counters_count_one]);
            }
            if (isset($request->counters_content_two)) {
                Setting::updateOrCreate(['slug' => 'counters_content_two'], ['value' => $request->counters_content_two]);
            }
            if (isset($request->counters_count_two)) {
                Setting::updateOrCreate(['slug' => 'counters_count_two'], ['value' => $request->counters_count_two]);
            }
            if (isset($request->counters_content_three)) {
                Setting::updateOrCreate(['slug' => 'counters_content_three'], ['value' => $request->counters_content_three]);
            }
            if (isset($request->counters_count_three)) {
                Setting::updateOrCreate(['slug' => 'counters_count_three'], ['value' => $request->counters_count_three]);
            }
            $response = [
                'success' => true,
                'message' => __('General setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save email setting
    public function saveEmailSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {

            if (isset($request->mail_host)) {
                Setting::updateOrCreate(['slug' => 'mail_host'], ['value' => $request->mail_host]);
            }
            if (isset($request->mail_port)) {
                Setting::updateOrCreate(['slug' => 'mail_port'], ['value' => $request->mail_port]);
            }
            if (isset($request->mail_username)) {
                Setting::updateOrCreate(['slug' => 'mail_username'], ['value' => $request->mail_username]);
            }
            if (isset($request->mail_password)) {
                Setting::updateOrCreate(['slug' => 'mail_password'], ['value' => $request->mail_password]);
            }
            if (isset($request->mail_encryption)) {
                Setting::updateOrCreate(['slug' => 'mail_encryption'], ['value' => $request->mail_encryption]);
            }
            if (isset($request->mail_from_address)) {
                Setting::updateOrCreate(['slug' => 'mail_from_address'], ['value' => $request->mail_from_address]);
            }
            $response = [
                'success' => true,
                'message' => __('Email setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save email setting
    public function saveTwilloSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {

            if (isset($request->twillo_secret_key)) {
                Setting::updateOrCreate(['slug' => 'twillo_secret_key'], ['value' => $request->twillo_secret_key]);
            }
            if (isset($request->twillo_auth_token)) {
                Setting::updateOrCreate(['slug' => 'twillo_auth_token'], ['value' => $request->twillo_auth_token]);
            }
            if (isset($request->twillo_number)) {
                Setting::updateOrCreate(['slug' => 'twillo_number'], ['value' => $request->twillo_number]);
            }

            $response = [
                'success' => true,
                'message' => __('Twillo setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }


    // save payment setting
    public function savePaymentSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {

            if (isset($request->COMPARE_WEBSITE)) {
                Setting::updateOrCreate(['slug' => 'COMPARE_WEBSITE'], ['value' => $request->COMPARE_WEBSITE]);
            }
            if (isset($request->COIN_PAYMENT_PUBLIC_KEY)) {
                Setting::updateOrCreate(['slug' => 'COIN_PAYMENT_PUBLIC_KEY'], ['value' => $request->COIN_PAYMENT_PUBLIC_KEY]);
            }
            if (isset($request->COIN_PAYMENT_PRIVATE_KEY)) {
                Setting::updateOrCreate(['slug' => 'COIN_PAYMENT_PRIVATE_KEY'], ['value' => $request->COIN_PAYMENT_PRIVATE_KEY]);
            }
            if (isset($request->COINPAYMENT_CURRENCY)) {
                Setting::updateOrCreate(['slug' => 'COINPAYMENT_CURRENCY'], ['value' => $request->COINPAYMENT_CURRENCY]);
            }
            if (isset($request->base_coin_type)) {
                Setting::updateOrCreate(['slug' => 'base_coin_type'], ['value' => $request->base_coin_type]);
            }
            if (isset($request->service_charge)) {
                Setting::updateOrCreate(['slug' => 'service_charge'], ['value' => $request->service_charge]);
            }

            $response = [
                'success' => true,
                'message' => __('Payment setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save withdraw setting
    public function saveWithdrawSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            Setting::updateOrCreate(['slug' => 'minimum_withdrawal_amount'], ['value' => $request->minimum_withdrawal_amount]);
            Setting::updateOrCreate(['slug' => 'maximum_withdrawal_amount'], ['value' => $request->maximum_withdrawal_amount]);
            Setting::updateOrCreate(['slug' => 'max_send_limit'], ['value' => $request->max_send_limit]);
            Setting::updateOrCreate(['slug' => 'send_fees_type'], ['value' => $request->send_fees_type]);
            Setting::updateOrCreate(['slug' => 'send_fees_fixed'], ['value' => $request->send_fees_type]);
            Setting::updateOrCreate(['slug' => 'send_fees_percentage'], ['value' => $request->send_fees_percentage]);

            $response = [
                'success' => true,
                'message' => __('Withdrawal setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }
}
