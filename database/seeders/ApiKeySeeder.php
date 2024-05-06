<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $api_keys = array(
            array('key' => 'sk-dXc3j54hgwuq7324fsdT3BlbkFJg8Bxp4uvehwJ8WbyPYrZ', 'title' => 'Invalid api key', 'status' => 1, 'created_at' => now(), 'updated_at' => now()),
            array('key' => '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', 'title' => 'Valid api key', 'status' => 1, 'created_at' => now(), 'updated_at' => now())
        );
          
        ApiKey::insert($api_keys);
    }
}
