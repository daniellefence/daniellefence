<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (seeds()->faq() as $f) {
            Faq::create([
                'question' => $f['question'],
                'answer' => $f['answer'],
            ]);
        }
    }
}
