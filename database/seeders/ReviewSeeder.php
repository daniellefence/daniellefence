<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 1;
        if (($handle = fopen('resources/csv/google-reviews.csv', 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                Review::create([
                    'name' => ucwords($data[1]),
                    'date' => $data[2],
                    'stars' => $data[3],
                    'content' => $data[4],
                ]);
            }
            fclose($handle);
        }
    }
}
