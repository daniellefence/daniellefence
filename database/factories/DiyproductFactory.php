<?php

namespace Database\Factories;

use App\Models\Diyproduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiyproductFactory extends Factory
{
    protected $model = Diyproduct::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'modifiers' => serialize([]),
            'active' => $this->faker->boolean(80),
        ];
    }
}