<?php

use Illuminate\Database\Seeder;
use App\Model\ServiceCharge;

class ServiceCharesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceCharge::create([
            'service_holder' => 'buyer',
            'type' => SERVICE_CHARGE_FIXED,
            'amount' => 1,
            'status' => STATUS_DEACTIVE,
        ]);
        ServiceCharge::create([
            'service_holder' => 'buyer',
            'type' => SERVICE_CHARGE_PERCENTAGE,
            'amount' => 2,
            'status' => STATUS_ACTIVE,
        ]);
        ServiceCharge::create([
            'service_holder' => 'seller',
            'type' => SERVICE_CHARGE_FIXED,
            'amount' => 2,
            'status' => STATUS_DEACTIVE,
        ]);
        ServiceCharge::create([
            'service_holder' => 'seller',
            'type' => SERVICE_CHARGE_PERCENTAGE,
            'amount' => 5,
            'status' => STATUS_ACTIVE,
        ]);
    }
}
