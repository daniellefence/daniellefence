<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Residential Fencing',
                'slug' => 'residential-fencing',
                'description' => 'High-quality fencing solutions for residential properties',
                'parent_id' => null,
                'published' => true,
            ],
            [
                'name' => 'Commercial Fencing',
                'slug' => 'commercial-fencing',
                'description' => 'Professional fencing solutions for commercial and industrial properties',
                'parent_id' => null,
                'published' => true,
            ],
            [
                'name' => 'Privacy Fences',
                'slug' => 'privacy-fences',
                'description' => 'Complete privacy fencing solutions',
                'parent_id' => 1,
                'published' => true,
            ],
            [
                'name' => 'Decorative Fences',
                'slug' => 'decorative-fences',
                'description' => 'Beautiful decorative fencing options',
                'parent_id' => 1,
                'published' => true,
            ],
            [
                'name' => 'Security Fencing',
                'slug' => 'security-fencing',
                'description' => 'Heavy-duty security fencing solutions',
                'parent_id' => 2,
                'published' => true,
            ],
            [
                'name' => 'Chain Link',
                'slug' => 'chain-link',
                'description' => 'Durable chain link fencing',
                'parent_id' => 2,
                'published' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}