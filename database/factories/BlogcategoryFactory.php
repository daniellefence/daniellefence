<?php

namespace Database\Factories;

use App\Models\Blogcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blogcategory>
 */
class BlogcategoryFactory extends Factory
{
    protected $model = Blogcategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}