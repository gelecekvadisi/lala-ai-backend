<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = array(
            array('title' => 'Free', 'subtitle' => 'Get Started with the Essentials', 'price' => 0, 'duration' => 'weekly', 'status' => 1, 'created_at' => now(), 'updated_at' => now()),
            array('title' => 'Entry', 'subtitle' => 'Our Most Popular Choice', 'price' => 25, 'duration' => 'monthly', 'status' => 1, 'created_at' => now(), 'updated_at' => now()),
        );

        Plan::insert($plans);
    }
}
