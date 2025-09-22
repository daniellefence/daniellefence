<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    public function definition()
    {
        return [
            'path' => '/images/' . $this->faker->word . '.jpg',
            'alt' => $this->faker->sentence(3),
            'title' => $this->faker->words(3, true),
        ];
    }
}