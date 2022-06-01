<?php

use Illuminate\Database\Seeder;
use App\Model\Slider;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slider::create([
            'short_description' => 'Buy and sell NFTs from the world’s top artists',
            'long_desc_header' => 'The',
            'long_desc_middle' => 'New World',
            'long_desc_footer' => 'of Digital Collectibles',
        ]);
    }
}
