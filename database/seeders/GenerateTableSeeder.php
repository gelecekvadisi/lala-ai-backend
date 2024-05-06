<?php

namespace Database\Seeders;

use App\Models\Generate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $text_generates = array(
            array('user_id' => 1, 'type' => 'text', 'category_id' => NULL, 'title' => 'About a cat', 'data' => '["Cats are one of"]','created_at' => '2023-01-07 10:37:09','updated_at' => '2023-08-07 10:37:09'),
            array('user_id' => 1, 'type' => 'text', 'category_id' => NULL, 'title' => 'About a goat', 'data' => '["Goats are members of"]','created_at' => '2023-02-07 10:40:21','updated_at' => '2023-08-07 10:40:21'),
          );

        Generate::insert($text_generates);
    }
}
