<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = array(
            array('question' => 'How does ChatGPT work?','status' => 1,'answer' => 'ChatGPT uses advanced algorithms and natural language processing to understand your queries and provide accurate and personalized respons es. Simply type in your question, and ChatGPT will do the rest.','created_at' => now(),'updated_at' => now()),
        );
        Faq::insert($faqs);
    }
}
