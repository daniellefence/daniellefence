<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        if (ProductCategory::query()->exists()) return;

        $names = ['Vinyl Fencing', 'Wood Fencing', 'Aluminum Fencing', 'Chain Link', 'Outdoor Living'];
        foreach ($names as $name) {
            ProductCategory::factory()->create(['name' => $name]);
        }
    }
}
