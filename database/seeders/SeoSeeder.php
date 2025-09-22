<?php

namespace Database\Seeders;

use App\Models\Seo;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (seeds()->routes() as $key => $title) {
            Seo::create([
                'route' => $key,
                'title' => $title,
            ]);
        }
    }
}
