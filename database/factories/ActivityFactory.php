<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'action' => $this->faker->randomElement(['created', 'updated', 'deleted', 'viewed']),
            'model_class' => $this->faker->randomElement(['Blog', 'Product', 'Category', 'User']),
            'model_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}