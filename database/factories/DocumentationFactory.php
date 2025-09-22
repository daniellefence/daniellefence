<?php

namespace Database\Factories;

use App\Models\Documentation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentationFactory extends Factory
{
    protected $model = Documentation::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->word,
            'published' => $this->faker->boolean,
        ];
    }
}