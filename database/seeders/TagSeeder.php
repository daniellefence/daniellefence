<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // Fencing Categories
            ['name' => 'Vinyl Fencing', 'type' => 'product'],
            ['name' => 'Wood Fencing', 'type' => 'product'],
            ['name' => 'Aluminum Fencing', 'type' => 'product'],
            ['name' => 'Chain Link', 'type' => 'product'],
            ['name' => 'Ornamental Iron', 'type' => 'product'],
            
            // Installation Types
            ['name' => 'DIY Installation', 'type' => 'service'],
            ['name' => 'Professional Install', 'type' => 'service'],
            ['name' => 'Repair Service', 'type' => 'service'],
            
            // Blog Topics
            ['name' => 'Installation Tips', 'type' => 'blog'],
            ['name' => 'Maintenance', 'type' => 'blog'],
            ['name' => 'Design Ideas', 'type' => 'blog'],
            ['name' => 'Cost Guide', 'type' => 'blog'],
            ['name' => 'Material Comparison', 'type' => 'blog'],
            
            // Product Features
            ['name' => 'Privacy', 'type' => 'feature'],
            ['name' => 'Security', 'type' => 'feature'],
            ['name' => 'Decorative', 'type' => 'feature'],
            ['name' => 'Low Maintenance', 'type' => 'feature'],
            ['name' => 'Weather Resistant', 'type' => 'feature'],
            
            // Project Types
            ['name' => 'Residential', 'type' => 'project'],
            ['name' => 'Commercial', 'type' => 'project'],
            ['name' => 'Industrial', 'type' => 'project'],
            
            // Florida Specific
            ['name' => 'Hurricane Rated', 'type' => 'feature'],
            ['name' => 'Florida Building Code', 'type' => 'compliance'],
            ['name' => 'Pool Fence', 'type' => 'application'],
        ];

        foreach ($tags as $tagData) {
            Tag::findOrCreate($tagData['name'], $tagData['type']);
        }
    }
}