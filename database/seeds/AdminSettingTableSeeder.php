<?php

use App\Model\Setting;
use Illuminate\Database\Seeder;

class AdminSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert(['slug'=>'app_title','value'=>'Nftzai']);
        Setting::insert(['slug'=>'maximum_withdrawal_daily','value'=>'3']);
        Setting::insert(['slug'=>'mail_from','value'=>'noreply@ntfzi.com']);

        Setting::create(['slug' => 'maintenance_mode', 'value' => 'no']);
        Setting::create(['slug' => 'logo', 'value' => '']);
        Setting::create(['slug' => 'login_logo', 'value' => '']);
        Setting::create(['slug' => 'landing_logo', 'value' => '']);
        Setting::create(['slug' => 'favicon', 'value' => '']);
        Setting::create(['slug' => 'dashboard_image', 'value' => '']);
        Setting::create(['slug' => 'copyright_text', 'value' => 'Copyright@2020']);
        Setting::create(['slug' => 'pagination_count', 'value' => '10']);
        Setting::create(['slug' => 'point_rate', 'value' => '1']);
        //General Settings
        Setting::create(['slug' => 'lang', 'value' => 'en']);
        Setting::create(['slug' => 'company_name', 'value' => 'Test Company']);
        Setting::create(['slug' => 'primary_email', 'value' => 'test@email.com']);

        Setting::create(['slug' => 'sms_getway_name', 'value' => 'twillo']);
        Setting::create(['slug' => 'twillo_secret_key', 'value' => 'test']);
        Setting::create(['slug' => 'twillo_auth_token', 'value' => 'test']);
        Setting::create(['slug' => 'twillo_number', 'value' => 'test']);
        Setting::create(['slug' => 'ssl_verify', 'value' => '']);

        Setting::create(['slug' => 'mail_driver', 'value' => 'SMTP']);
        Setting::create(['slug' => 'mail_host', 'value' => 'smtp.mailtrap.io']);
        Setting::create(['slug' => 'mail_port', 'value' => 2525]);
        Setting::create(['slug' => 'mail_username', 'value' => '04bc2d327c43e7']);
        Setting::create(['slug' => 'mail_password', 'value' => 'de96fea5d103ca']);
        Setting::create(['slug' => 'mail_encryption', 'value' => 'tls']);
        Setting::create(['slug' => 'mail_from_address', 'value' => 'demo@demo.com']);


        Setting::create(['slug' => 'braintree_client_token', 'value' => 'test']);
        Setting::create(['slug' => 'braintree_environment', 'value' => 'sandbox']);
        Setting::create(['slug' => 'braintree_merchant_id', 'value' => 'test']);
        Setting::create(['slug' => 'braintree_public_key', 'value' => 'test']);
        Setting::create(['slug' => 'braintree_private_key', 'value' => 'test']);
        Setting::create(['slug' => 'sms_getway_name', 'value' => 'twillo']);
        Setting::create(['slug' => 'clickatell_api_key', 'value' => 'test']);
        Setting::create(['slug' => 'number_of_confirmation', 'value' => '6']);


        // Coin Api
        Setting::create(['slug' => 'coin_api_user', 'value' => 'test']);
        Setting::create(['slug' => 'coin_api_pass', 'value' => 'test']);
        Setting::create(['slug' => 'coin_api_host', 'value' => 'test5']);
        Setting::create(['slug' => 'coin_api_port', 'value' => 'test']);


        // Send Fees
        Setting::create(['slug' => 'send_fees_type', 'value' => 1]);
        Setting::create(['slug' => 'send_fees_fixed', 'value' => 0]);
        Setting::create(['slug' => 'send_fees_percentage', 'value' => 0]);
        Setting::create(['slug' => 'max_send_limit', 'value' => 0]);
        //order settings
        Setting::create(['slug' => 'deposit_time', 'value' => 1]);

        //coin payment
        Setting::create(['slug' => 'COIN_PAYMENT_PUBLIC_KEY', 'value' => 'test']);
        Setting::create(['slug' => 'COIN_PAYMENT_PRIVATE_KEY', 'value' => 'test']);
        Setting::create(['slug' => 'COIN_PAYMENT_CURRENCY', 'value' => 'BTC']);

        Setting::create(['slug' => 'payment_method_coin_payment', 'value' => 1]);

        Setting::create(['slug' => 'home_famous_title', 'value' => 'Top famous NFTs and authors all in one place']);
        Setting::create(['slug' => 'home_famous_content', 'value' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. ']);
        Setting::create(['slug' => 'home_latest_title', 'value' => 'Latest Collection']);
        Setting::create(['slug' => 'home_latest_content', 'value' => 'Meridian sun strikes the upper surface of the impenetrable foliage of my trees, and but a few stray gleams steal into the inner']);
        Setting::create(['slug' => 'home_explorer_title', 'value' => 'Explore More']);
        Setting::create(['slug' => 'home_explorer_content', 'value' => 'Meridian sun strikes the upper surface of the impenetrable foliatrees and but a few stray gleams steal into the inner']);
        Setting::create(['slug' => 'home_footer_title', 'value' => 'Get started with us today']);
        Setting::create(['slug' => 'home_footer_content', 'value' => 'Earn exciting points and free crypto by submitting your work.']);

        Setting::create(['slug' => 'counters_title', 'value' => 'Amazing traditional Artworks, which is trending now']);
        Setting::create(['slug' => 'counters_img_one', 'value' => '']);
        Setting::create(['slug' => 'counters_img_two', 'value' => '']);
        Setting::create(['slug' => 'counters_content_one', 'value' => 'Artwork']);
        Setting::create(['slug' => 'counters_count_one', 'value' => 20]);
        Setting::create(['slug' => 'counters_content_two', 'value' => 'Auction']);
        Setting::create(['slug' => 'counters_count_two', 'value' => 130]);
        Setting::create(['slug' => 'counters_content_three', 'value' => 'Artist']);
        Setting::create(['slug' => 'counters_count_three', 'value' => 14]);
        Setting::create(['slug' => 'service_charge', 'value' => 5]);
    }
}
