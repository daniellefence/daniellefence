<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fence Installation',
                'slug' => 'fence-installation',
                'description' => 'Tips and guides for fence installation projects',
                'published' => true,
            ],
            [
                'name' => 'DIY Projects',
                'slug' => 'diy-projects',
                'description' => 'Do-it-yourself fence projects and tutorials',
                'published' => true,
            ],
            [
                'name' => 'Maintenance & Repair',
                'slug' => 'maintenance-repair',
                'description' => 'Fence maintenance and repair advice',
                'published' => true,
            ],
            [
                'name' => 'Material Guides',
                'slug' => 'material-guides',
                'description' => 'Comprehensive guides about fence materials',
                'published' => true,
            ],
            [
                'name' => 'Company News',
                'slug' => 'company-news',
                'description' => 'Latest news and updates from Danielle Fence',
                'published' => true,
            ],
            [
                'name' => 'Industry Insights',
                'slug' => 'industry-insights',
                'description' => 'Insights and trends in the fencing industry',
                'published' => true,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
