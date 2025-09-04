<?php

namespace Database\Factories;

use App\Models\DiyCombination;
use App\Models\Product;
use App\Models\DiyOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiyCombination>
 */
class DiyCombinationFactory extends Factory
{
    protected $model = DiyCombination::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'color_option_id' => DiyOption::factory(),
            'height_option_id' => DiyOption::factory(),
            'picket_width_option_id' => DiyOption::factory(),
            'price_modifier_percent' => fake()->randomFloat(2, -20, 50),
        ];
    }
}
