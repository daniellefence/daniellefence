<?php

namespace Database\Factories;

use App\Models\DiyOption;
use App\Models\DiyAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiyOption>
 */
class DiyOptionFactory extends Factory
{
    protected $model = DiyOption::class;

    public function definition(): array
    {
        return [
            'diy_attribute_id' => DiyAttribute::factory(),
            'value' => fake()->unique()->word(),
            'sort' => fake()->numberBetween(0, 10),
        ];
    }
}
