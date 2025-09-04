<?php

namespace Database\Factories;

use App\Models\DiyAttribute;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiyAttribute>
 */
class DiyAttributeFactory extends Factory
{
    protected $model = DiyAttribute::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'name' => fake()->randomElement(['color','height','picket_width']),
            'sort' => fake()->numberBetween(0, 10),
        ];
    }
}
