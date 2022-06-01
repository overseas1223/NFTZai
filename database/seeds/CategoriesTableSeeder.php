<?php

use Illuminate\Database\Seeder;
use \App\Model\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'Game',
            'Description' => 'Game Category',
            'priority' => 1,
            'status' => STATUS_ACTIVE
        ]);

        Category::create([
            'title' => 'Photography',
            'Description' => 'Photography Category',
            'priority' => 2,
            'status' => STATUS_ACTIVE
        ]);

        Category::create([
            'title' => 'Music',
            'Description' => 'Music Category',
            'priority' => 3,
            'status' => STATUS_ACTIVE
        ]);
    }
}
