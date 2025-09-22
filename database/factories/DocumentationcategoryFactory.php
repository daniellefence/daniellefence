<?php

namespace Database\Factories;

use App\Models\Documentationcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentationcategoryFactory extends Factory
{
    protected $model = Documentationcategory::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}