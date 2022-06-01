<?php

use Illuminate\Database\Seeder;
use App\Model\Wallet;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wallet::create([
            'user_id' => 2,
            'coin_id' => 1,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 100.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 2,
            'coin_id' => 2,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 3,
            'coin_id' => 1,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 3,
            'coin_id' => 2,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 4,
            'coin_id' => 1,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 4,
            'coin_id' => 2,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 5,
            'coin_id' => 1,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 5,
            'coin_id' => 2,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 6,
            'coin_id' => 1,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
        Wallet::create([
            'user_id' => 6,
            'coin_id' => 2,
            'address' => '',
            'status' => 1,
            'is_primary' => 0,
            'balance' => 0.00000000,
            'on_hold' => 0.00000000,
        ]);
    }
}
