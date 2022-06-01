<?php

use Illuminate\Database\Seeder;
use App\Model\SellService;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellService::create([
            'price_amount' => 2500.00000000,
            'coin_amount' => 0.05077500,
            'service_charge' => 0.00000000,
            'service_charge_coin' => 0.00000000,
            'conversion_rate' => 0.00002031,
            'service_id' => 5,
            'user_id' => 2,
            'is_sale_bid' => 0,
            'coin_type' => 'BTC',
            'coin_id' => 1,
            'status' => 1,
            'refund_amount' => 0.00000000,
            'wallet_id' => 1
        ]);
    }
}
