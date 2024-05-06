<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = array(
            array('category_id' => 1,'title' => 'Get Clear & Simple Answers','image' => 'uploads/23/08/1691483783.png','status' => 1,'created_at' => now(), 'updated_at' => now())
        );

        Banner::insert($banners);          
    }
}
