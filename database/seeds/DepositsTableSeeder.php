<?php

use Illuminate\Database\Seeder;
use App\Model\Deposit;

class DepositsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deposit::create([
            'receiver_wallet_id' => 1,
            'amount' => 100.00000000,
            'address' => '',
            'sender_wallet_id' => 3,
            'doller' => 900.00000000,
            'transaction_id' => '',
            'deposit_by' => 2,
        ]);
        Deposit::create([
            'receiver_wallet_id' => 3,
            'amount' => 100.00000000,
            'address' => '',
            'sender_wallet_id' => 1,
            'doller' => 900.00000000,
            'transaction_id' => '',
            'deposit_by' => 3,
        ]);
    }
}
