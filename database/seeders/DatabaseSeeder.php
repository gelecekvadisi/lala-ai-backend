<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanTableSeeder::class,
            PermissionSeeder::class,
            UserTableSeeder::class,
            ApiKeySeeder::class,
            GenerateTableSeeder::class,
            CategoryTableSeeder::class,
            BannerSeeder::class,
            OptionTableSeeder::class,
            SuggestionTableSeeder::class,
            FaqTableSeeder::class,
            BuyCreditPlanSeeder::class,
        ]);
    }
}
