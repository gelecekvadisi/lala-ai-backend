<?php

namespace Database\Seeders;

use App\Models\BuyCredits;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BuyCreditPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buy_credits = array(
            array('title' => 'Silver','price' => 10, 'reward' => 1000,'status' => 1,'description' => 'description','created_at' => now(),'updated_at' => now()),
            array('title' => 'Gold','price' => 20, 'reward' => 2500,'status' => 1,'description' => NULL,'created_at' => now(),'updated_at' => now())
        );

        BuyCredits::insert($buy_credits);
        Artisan::call('cache:clear');
    }
}
