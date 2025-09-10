<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        if (ProductCategory::query()->exists()) return;

        $categories = [
            ['name' => 'Fence & Gates', 'description' => 'Premium fencing and gate solutions'],
            ['name' => 'Kitchens & Grills', 'description' => 'Outdoor kitchen and grilling accessories'],
            ['name' => 'Fire Features', 'description' => 'Fire pits, fireplaces, and accessories'],
            ['name' => 'Railings', 'description' => 'Deck and stair railing systems'],
            ['name' => 'Outdoor Living Spaces', 'description' => 'Complete outdoor living solutions'],
            ['name' => 'Specialty Products', 'description' => 'Custom and specialty outdoor products']
        ];
        
        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
