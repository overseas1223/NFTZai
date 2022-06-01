<?php

use Illuminate\Database\Seeder;
use App\Model\Service;

class SevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'title' => 'Northern Light',
            'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
            'type' => 1,
            'expired_at' => '2021-12-15 12:00:00',
            'price_dollar' => 2500.00000000,
            'fees_percentage' => 2.00000000,
            'fees_fixed' => 20.00000000,
            'fees_type' => 1,
            'available_item' => 1.00000000,
            'thumbnail' => '1.jpg',
            'color' => 'Black',
            'origin' => 'Bangladesh',
            'mint_address' => '0xd288ed20c41c21dedc5f054d9a3a2aa74556ad5e',
            'category_id' => 1,
            'created_by' => 2,
            'status' => 2,
            'isSlider' => 1,
        ]);

        Service::create([
            'title' => 'Southern Light',
            'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
            'type' => 2,
            'expired_at' => '2021-12-15 12:00:00',
            'price_dollar' => 0.00000000,
            'fees_percentage' => 2.00000000,
            'fees_fixed' => 0.00000000,
            'fees_type' => 1,
            'available_item' => 1.00000000,
            'thumbnail' => '2.jpg',
            'color' => 'Black',
            'origin' => 'Bangladesh',
            'mint_address' => '0xd288ed20c41c21dedc5f054d9a3a2aa74556ad5e',
            'category_id' => 2,
            'created_by' => 2,
            'status' => 2,
            'isSlider' => 1,
        ]);

        Service::create([
            'title' => 'Bit Card',
            'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
            'type' => 2,
            'expired_at' => '2021-12-15 12:00:00',
            'price_dollar' => 0.00000000,
            'fees_percentage' => 2.00000000,
            'fees_fixed' => 0.00000000,
            'fees_type' => 1,
            'available_item' => 1.00000000,
            'thumbnail' => '3.jpg',
            'color' => 'Black',
            'origin' => 'Bangladesh',
            'mint_address' => '0xd288ed20c41c21dedc5f054d9a3a2aa74556ad5e',
            'category_id' => 3,
            'created_by' => 3,
            'status' => 2,
            'isSlider' => 0,
        ]);

        Service::create([
            'title' => 'Redeemable Logo',
            'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
            'type' => 1,
            'expired_at' => '2021-12-15 12:00:00',
            'price_dollar' => 2500.00000000,
            'fees_percentage' => 2.00000000,
            'fees_fixed' => 20.00000000,
            'fees_type' => 1,
            'available_item' => 1.00000000,
            'thumbnail' => '4.jpg',
            'color' => 'Black',
            'origin' => 'Bangladesh',
            'mint_address' => '0xd288ed20c41c21dedc5f054d9a3a2aa74556ad5e',
            'category_id' => 1,
            'created_by' => 3,
            'status' => 2,
            'isSlider' => 0,
        ]);

        Service::create([
            'title' => 'Sparklight 2.0',
            'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
            'type' => 1,
            'expired_at' => '2021-12-15 12:00:00',
            'price_dollar' => 2500.00000000,
            'fees_percentage' => 2.00000000,
            'fees_fixed' => 20.00000000,
            'fees_type' => 1,
            'available_item' => 1.00000000,
            'thumbnail' => '6.jpg',
            'color' => 'Black',
            'origin' => 'Bangladesh',
            'mint_address' => '0xd288ed20c41c21dedc5f054d9a3a2aa74556ad5e',
            'category_id' => 1,
            'created_by' => 4,
            'status' => 2,
            'isSlider' => 0,
        ]);
    }
}
