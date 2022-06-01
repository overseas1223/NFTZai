<?php

use Illuminate\Database\Seeder;
use App\Model\Bid;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bid::create([
            'transaction_id' => 'nft_HvO253gT',
            'bid_amount' => 10.00000000,
            'service_charge' => 0.00000000,
            'service_id' => 3,
            'user_id' => 2,
            'is_sale_bid' => 0,
            'status' => 1,
        ]);
    }
}
