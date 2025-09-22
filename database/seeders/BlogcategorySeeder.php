<?php

namespace Database\Seeders;

use App\Models\Blogcategory;
use Illuminate\Database\Seeder;

class BlogcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (seeds()->blogCategories() as $category) {
            Blogcategory::create([
                'title' => $category,
            ]);
        }

    }
}
