<?php

namespace Database\Factories;

use App\Models\Career;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CareerFactory extends Factory
{
    protected $model = Career::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'position' => $this->faker->jobTitle,
            'experience' => $this->faker->paragraph,
            'resume_path' => '/uploads/resumes/' . $this->faker->word . '.pdf',
        ];
    }
}