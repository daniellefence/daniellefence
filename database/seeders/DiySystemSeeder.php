<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiyProductCategory;
use App\Models\DiyProduct;
use App\Models\AvailableColor;
use App\Models\AvailableHeight;
use App\Models\AvailableSpacing;
use App\Models\Modifier;

class DiySystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create DIY Product Categories
        $categories = [
            [
                'name' => 'Fence Panels',
                'slug' => 'fence-panels',
                'description' => 'Various styles of fence panels for DIY installation',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Gate Hardware',
                'slug' => 'gate-hardware',
                'description' => 'Hardware components for gates and fence installations',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Posts & Rails',
                'slug' => 'posts-rails',
                'description' => 'Fence posts and rail systems',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            DiyProductCategory::create($categoryData);
        }

        // Create Available Colors
        $colors = [
            ['name' => 'White', 'display_order' => 1, 'is_active' => true],
            ['name' => 'Black', 'display_order' => 2, 'is_active' => true],
            ['name' => 'Brown', 'display_order' => 3, 'is_active' => true],
            ['name' => 'Green', 'display_order' => 4, 'is_active' => true],
            ['name' => 'Gray', 'display_order' => 5, 'is_active' => true],
            ['name' => 'Beige', 'display_order' => 6, 'is_active' => true],
        ];

        foreach ($colors as $colorData) {
            AvailableColor::create($colorData);
        }

        // Create Available Heights
        $heights = [
            ['name' => '3 Feet', 'value_feet' => 3, 'value_inches' => 0, 'display_order' => 1, 'is_active' => true],
            ['name' => '4 Feet', 'value_feet' => 4, 'value_inches' => 0, 'display_order' => 2, 'is_active' => true],
            ['name' => '5 Feet', 'value_feet' => 5, 'value_inches' => 0, 'display_order' => 3, 'is_active' => true],
            ['name' => '6 Feet', 'value_feet' => 6, 'value_inches' => 0, 'display_order' => 4, 'is_active' => true],
            ['name' => '8 Feet', 'value_feet' => 8, 'value_inches' => 0, 'display_order' => 5, 'is_active' => true],
        ];

        foreach ($heights as $heightData) {
            AvailableHeight::create($heightData);
        }

        // Create Available Spacings
        $spacings = [
            ['name' => '6 Feet OC', 'value_feet' => 6.0, 'display_order' => 1, 'is_active' => true],
            ['name' => '8 Feet OC', 'value_feet' => 8.0, 'display_order' => 2, 'is_active' => true],
            ['name' => '10 Feet OC', 'value_feet' => 10.0, 'display_order' => 3, 'is_active' => true],
        ];

        foreach ($spacings as $spacingData) {
            AvailableSpacing::create($spacingData);
        }

        // Create DIY Products
        $fencePanelsCategory = DiyProductCategory::where('slug', 'fence-panels')->first();
        $gateHardwareCategory = DiyProductCategory::where('slug', 'gate-hardware')->first();
        $postsRailsCategory = DiyProductCategory::where('slug', 'posts-rails')->first();

        $products = [
            [
                'diy_product_category_id' => $fencePanelsCategory->id,
                'name' => 'Privacy Fence Panel',
                'slug' => 'privacy-fence-panel',
                'description' => 'Solid privacy fence panel for complete privacy',
                'base_price' => 89.99,
                'specifications' => 'Made from pressure-treated lumber. Pre-assembled for easy installation.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'diy_product_category_id' => $fencePanelsCategory->id,
                'name' => 'Picket Fence Panel',
                'slug' => 'picket-fence-panel',
                'description' => 'Traditional picket fence panel with decorative spacing',
                'base_price' => 79.99,
                'specifications' => 'Classic design with pointed pickets. Weather-resistant finish.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'diy_product_category_id' => $gateHardwareCategory->id,
                'name' => 'Gate Hinge Set',
                'slug' => 'gate-hinge-set',
                'description' => 'Heavy-duty hinges for gate installation',
                'base_price' => 24.99,
                'specifications' => 'Galvanized steel construction. Includes mounting hardware.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'diy_product_category_id' => $gateHardwareCategory->id,
                'name' => 'Gate Latch',
                'slug' => 'gate-latch',
                'description' => 'Self-closing gate latch with lock capability',
                'base_price' => 19.99,
                'specifications' => 'Spring-loaded mechanism. Weather-resistant coating.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'diy_product_category_id' => $postsRailsCategory->id,
                'name' => 'Fence Post',
                'slug' => 'fence-post',
                'description' => 'Pressure-treated fence post',
                'base_price' => 12.99,
                'specifications' => 'Pressure-treated for ground contact. 4"x4" cross-section.',
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            DiyProduct::create($productData);
        }

        // Create some sample modifiers
        $privacyPanel = DiyProduct::where('slug', 'privacy-fence-panel')->first();
        $picketPanel = DiyProduct::where('slug', 'picket-fence-panel')->first();

        $whiteColor = AvailableColor::where('name', 'White')->first();
        $blackColor = AvailableColor::where('name', 'Black')->first();
        $brownColor = AvailableColor::where('name', 'Brown')->first();

        $height4ft = AvailableHeight::where('value_feet', 4)->first();
        $height6ft = AvailableHeight::where('value_feet', 6)->first();

        $spacing6ft = AvailableSpacing::where('value_feet', 6.0)->first();
        $spacing8ft = AvailableSpacing::where('value_feet', 8.0)->first();

        $modifiers = [
            // Privacy Panel modifiers
            [
                'diy_product_id' => $privacyPanel->id,
                'available_color_id' => $whiteColor->id,
                'available_height_id' => $height6ft->id,
                'available_spacing_id' => $spacing6ft->id,
                'price_modification_type' => 'fixed',
                'price_modification_value' => 0.00,
                'is_active' => true,
            ],
            [
                'diy_product_id' => $privacyPanel->id,
                'available_color_id' => $blackColor->id,
                'available_height_id' => $height6ft->id,
                'available_spacing_id' => $spacing6ft->id,
                'price_modification_type' => 'fixed',
                'price_modification_value' => 15.00,
                'is_active' => true,
            ],
            [
                'diy_product_id' => $privacyPanel->id,
                'available_color_id' => $brownColor->id,
                'available_height_id' => $height4ft->id,
                'available_spacing_id' => $spacing8ft->id,
                'price_modification_type' => 'percentage',
                'price_modification_value' => -10.0,
                'is_active' => true,
            ],
            // Picket Panel modifiers
            [
                'diy_product_id' => $picketPanel->id,
                'available_color_id' => $whiteColor->id,
                'available_height_id' => $height4ft->id,
                'available_spacing_id' => $spacing6ft->id,
                'price_modification_type' => 'fixed',
                'price_modification_value' => 0.00,
                'is_active' => true,
            ],
            [
                'diy_product_id' => $picketPanel->id,
                'available_color_id' => $blackColor->id,
                'available_height_id' => $height4ft->id,
                'available_spacing_id' => $spacing6ft->id,
                'price_modification_type' => 'fixed',
                'price_modification_value' => 10.00,
                'is_active' => true,
            ],
        ];

        foreach ($modifiers as $modifierData) {
            Modifier::create($modifierData);
        }

        $this->command->info('DIY System seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . count($categories) . ' product categories');
        $this->command->info('- ' . count($colors) . ' colors');
        $this->command->info('- ' . count($heights) . ' heights');
        $this->command->info('- ' . count($spacings) . ' spacings');
        $this->command->info('- ' . count($products) . ' products');
        $this->command->info('- ' . count($modifiers) . ' modifiers');
    }
}