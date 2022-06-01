<?php

use Illuminate\Database\Seeder;
use App\Model\Follow;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Follow::create([
            'follower_id' => 3,
            'following_id' => 4,
        ]);

        Follow::create([
            'follower_id' => 3,
            'following_id' => 5,
        ]);

        Follow::create([
            'follower_id' => 4,
            'following_id' => 3,
        ]);
    }
}
