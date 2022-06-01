<?php

use App\Model\Coin;
use Illuminate\Database\Seeder;

class CoinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::insert(['coin_type'=>'BTC','full_name'=>'Bitcoin','deposit_status'=>1,'withdrawal_status'=>1,'active_status'=>1]);
        Coin::insert(['coin_type'=>'ETH','full_name'=>'Ethereum','deposit_status'=>1,'withdrawal_status'=>1,'active_status'=>1]);

    }
}
