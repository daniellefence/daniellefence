<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        if (ProductCategory::query()->exists()) return;

        // Root categories
        $fencing = ProductCategory::create([
            'name' => 'Fence & Gates',
            'description' => 'Premium fencing and gate solutions',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $kitchens = ProductCategory::create([
            'name' => 'Kitchens & Grills',
            'description' => 'Outdoor kitchen and grilling accessories',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $fire = ProductCategory::create([
            'name' => 'Fire Features',
            'description' => 'Fire pits, fireplaces, and accessories',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $railings = ProductCategory::create([
            'name' => 'Railings',
            'description' => 'Deck and stair railing systems',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $outdoor = ProductCategory::create([
            'name' => 'Outdoor Living Spaces',
            'description' => 'Complete outdoor living solutions',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        $specialty = ProductCategory::create([
            'name' => 'Specialty Products',
            'description' => 'Custom and specialty outdoor products',
            'sort_order' => 6,
            'is_active' => true,
        ]);

        // Fence & Gates subcategories
        ProductCategory::create([
            'name' => 'Residential Fencing',
            'description' => 'Fencing solutions for homes and residential properties',
            'parent_id' => $fencing->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Commercial Fencing',
            'description' => 'Professional fencing for businesses and institutions',
            'parent_id' => $fencing->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Pool Fencing',
            'description' => 'Safety-compliant pool and spa enclosures',
            'parent_id' => $fencing->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Gates & Access Control',
            'description' => 'Manual and automated gate systems',
            'parent_id' => $fencing->id,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // Kitchen & Grills subcategories
        ProductCategory::create([
            'name' => 'Outdoor Kitchens',
            'description' => 'Complete outdoor kitchen solutions',
            'parent_id' => $kitchens->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Grills & Smokers',
            'description' => 'Premium grilling and smoking equipment',
            'parent_id' => $kitchens->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Kitchen Accessories',
            'description' => 'Outdoor kitchen tools and accessories',
            'parent_id' => $kitchens->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}
