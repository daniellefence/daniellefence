<?php

namespace Database\Seeders;

use App\Models\DiyProduct;
use Illuminate\Database\Seeder;

class DiyRelatedProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔗 Seeding related products and product relationships...');

        // First, link DIY products to their matching regular products for photo galleries
        $this->command->info('🖼️  Linking DIY products to Products for galleries...');

        $productMappings = [
            'Lakeland' => \App\Models\Product::where('title', 'like', '%Lakeland%')->first()?->id,
            'Sacramento Concave' => \App\Models\Product::where('title', 'like', '%Sacramento%')->first()?->id,
            'Sacramento Convex' => \App\Models\Product::where('title', 'like', '%Sacramento%')->first()?->id,
            'Sacramento Flat' => \App\Models\Product::where('title', 'like', '%Sacramento%')->first()?->id,
            'Sacramento Point Straight' => \App\Models\Product::where('title', 'like', '%Sacramento%')->first()?->id,
            'Sundance Concave' => \App\Models\Product::where('title', 'like', '%Sundance%')->first()?->id,
            'Sundance Convex' => \App\Models\Product::where('title', 'like', '%Sundance%')->first()?->id,
            'Sundance Flat' => \App\Models\Product::where('title', 'like', '%Sundance%')->first()?->id,
            'Sundance Point Straight' => \App\Models\Product::where('title', 'like', '%Sundance%')->first()?->id,
            'Hollingsworth' => \App\Models\Product::where('title', 'like', '%Lakeland%')->first()?->id,
        ];

        foreach ($productMappings as $diyProductName => $productId) {
            if ($productId) {
                $diyProduct = DiyProduct::where('name', $diyProductName)->first();
                if ($diyProduct) {
                    $diyProduct->update(['product_id' => $productId]);
                    $this->command->info("  ✓ Linked {$diyProductName} to Product #{$productId}");
                }
            }
        }

        // Get all products
        $products = DiyProduct::all()->keyBy('name');

        // Sacramento products - relate to other Sacramento variants
        if ($products->has('Sacramento Concave')) {
            $products['Sacramento Concave']->relatedProducts()->attach([
                $products['Sacramento Convex']->id => ['order' => 1],
                $products['Sacramento Flat']->id => ['order' => 2],
                $products['Sacramento Point Straight']->id => ['order' => 3],
            ]);
        }

        if ($products->has('Sacramento Convex')) {
            $products['Sacramento Convex']->relatedProducts()->attach([
                $products['Sacramento Concave']->id => ['order' => 1],
                $products['Sacramento Flat']->id => ['order' => 2],
                $products['Sacramento Point Straight']->id => ['order' => 3],
            ]);
        }

        if ($products->has('Sacramento Flat')) {
            $products['Sacramento Flat']->relatedProducts()->attach([
                $products['Sacramento Convex']->id => ['order' => 1],
                $products['Sacramento Concave']->id => ['order' => 2],
                $products['Sacramento Point Straight']->id => ['order' => 3],
            ]);
        }

        if ($products->has('Sacramento Point Straight')) {
            $products['Sacramento Point Straight']->relatedProducts()->attach([
                $products['Sacramento Flat']->id => ['order' => 1],
                $products['Sacramento Convex']->id => ['order' => 2],
                $products['Sacramento Concave']->id => ['order' => 3],
            ]);
        }

        // Sundance products - relate to other Sundance variants
        if ($products->has('Sundance Concave')) {
            $products['Sundance Concave']->relatedProducts()->attach([
                $products['Sundance Convex']->id => ['order' => 1],
                $products['Sundance Flat']->id => ['order' => 2],
                $products['Sundance Point Straight']->id => ['order' => 3],
            ]);
        }

        if ($products->has('Sundance Convex')) {
            $products['Sundance Convex']->relatedProducts()->attach([
                $products['Sundance Concave']->id => ['order' => 1],
                $products['Sundance Flat']->id => ['order' => 2],
                $products['Sundance Point Straight']->id => ['order' => 3],
            ]);
        }

        if ($products->has('Sundance Flat')) {
            $products['Sundance Flat']->relatedProducts()->attach([
                $products['Sundance Convex']->id => ['order' => 1],
                $products['Sundance Concave']->id => ['order' => 2],
                $products['Sundance Point Straight']->id => ['order' => 3],
            ]);
        }

        if ($products->has('Sundance Point Straight')) {
            $products['Sundance Point Straight']->relatedProducts()->attach([
                $products['Sundance Flat']->id => ['order' => 1],
                $products['Sundance Convex']->id => ['order' => 2],
                $products['Sundance Concave']->id => ['order' => 3],
            ]);
        }

        // Hollingsworth - relate to popular Sacramento and Sundance options
        if ($products->has('Hollingsworth')) {
            $products['Hollingsworth']->relatedProducts()->attach([
                $products['Lakeland']->id => ['order' => 1],
                $products['Sacramento Flat']->id => ['order' => 2],
                $products['Sundance Flat']->id => ['order' => 3],
            ]);
        }

        // Lakeland - relate to popular Sacramento and Sundance options
        if ($products->has('Lakeland')) {
            $products['Lakeland']->relatedProducts()->attach([
                $products['Hollingsworth']->id => ['order' => 1],
                $products['Sacramento Convex']->id => ['order' => 2],
                $products['Sundance Convex']->id => ['order' => 3],
            ]);
        }

        $this->command->info('✅ Related products seeded successfully');
    }
}
