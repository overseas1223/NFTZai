<?php

use Illuminate\Database\Seeder;
use App\Model\TopSeller;

class TopArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TopSeller::create([
            'user_id' => 2,
            'activate_date' => date("Y-m-d"),
        ]);
        TopSeller::create([
            'user_id' => 3,
            'activate_date' => date("Y-m-d"),
        ]);
        TopSeller::create([
            'user_id' => 4,
            'activate_date' => date("Y-m-d"),
        ]);
        TopSeller::create([
            'user_id' => 5,
            'activate_date' => date("Y-m-d"),
        ]);
    }
}
