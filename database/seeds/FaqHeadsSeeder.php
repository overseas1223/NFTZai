<?php

use Illuminate\Database\Seeder;
use App\Model\FaqHead;

class FaqHeadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqHead::create([
            'title' => 'General',
            'icon' => 'fas fa-home',
        ]);

        FaqHead::create([
            'title' => 'Support',
            'icon' => 'fas fa-life-ring',
        ]);

        FaqHead::create([
            'title' => 'Hosting',
            'icon' => 'fas fa-bolt',
        ]);

        FaqHead::create([
            'title' => 'Products',
            'icon' => 'fas fa-pen-nib',
        ]);
    }
}
