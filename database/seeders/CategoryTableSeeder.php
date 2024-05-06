<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array(
            array('name' => 'Email Writing','status' => 1, 'image' => 'uploads/23/08/1691649680.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Article Writer','status' => 1, 'image' => 'uploads/23/08/1691649797.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Technology','status' => 1, 'image' => 'uploads/23/08/1691649821.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Translates','status' => 1, 'image' => 'uploads/23/08/1691649847.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Foods','status' => 1, 'image' => 'uploads/23/08/1691649868.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Advertiser','status' => 1, 'image' => 'uploads/23/08/1691649891.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Pros & Cons','status' => 1, 'image' => 'uploads/23/08/1691649917.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Comedian','status' => 1, 'image' => 'uploads/23/08/1691649949.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Science','status' => 1, 'image' => 'uploads/23/08/1691649975.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Investment','status' => 1, 'image' => 'uploads/23/08/1691649990.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Write & Edit','status' => 1, 'image' => 'uploads/23/08/1691650020.png','created_at' => now(), 'updated_at' => now()),
            array('name' => 'Education','status' => 1, 'image' => 'uploads/23/08/1691650038.png','created_at' => now(), 'updated_at' => now())
        );

        Category::insert($categories);
    }
}
