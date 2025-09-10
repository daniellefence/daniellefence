<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $today = \Carbon\Carbon::create(2025, 8, 7);
        $json = file_get_contents(database_path('seeders/final_reviews_dataset.json'));
        $reviews = json_decode($json,true);

        foreach($reviews as $review) {
            \App\Models\Review::create([
                'author'=>$review['name'],
                'rating'=>$review['rating'],
                'content'=>$review['content'],
                'published'=>true
            ]);
        }
    }
}
