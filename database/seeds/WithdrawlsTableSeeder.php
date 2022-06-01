<?php

use Illuminate\Database\Seeder;
use App\Model\Withdrawal;

class WithdrawlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Withdrawal::create([
            'wallet_id' => 1,
            'address' => '',
            'amount' => 20.00000000,
            'address_type' => ADDRESS_TYPE_INTERNAL,
            'receiver_wallet_id' => 3,
            'fees' => 0,
            'status' => ON_ADMIN_APPROVAL,
            'doller' => 198.00000000,
            'withdraw_by' => 2
        ]);
    }
}
