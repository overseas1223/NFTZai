<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AdminSettingTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(FaqHeadsSeeder::class);
        $this->call(FaqTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(ServiceCharesTableSeeder::class);
    }
}
