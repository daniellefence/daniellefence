<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(asText: true);

        return [
            'product_category_id' => ProductCategory::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'base_price' => fake()->randomFloat(2, 50, 1000),
            'is_diy' => fake()->boolean(20),
            'description' => fake()->optional()->sentence(15),
        ];
    }
}
