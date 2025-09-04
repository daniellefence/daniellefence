<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::query()->exists()) return;

        $categories = ProductCategory::all();
        foreach ($categories as $cat) {
            Product::factory()->count(3)->create([
                'product_category_id' => $cat->id,
            ]);
        }
    }
}
