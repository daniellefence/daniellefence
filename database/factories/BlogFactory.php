<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use App\Models\Blogcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'blogcategory_id' => Blogcategory::factory(),
            'title' => $this->faker->sentence(),
            'content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(3)) . '</p>',
            'keywords' => implode(', ', $this->faker->words(5)),
            'show_date' => $this->faker->boolean(80),
            'published' => $this->faker->boolean(70),
        ];
    }

    /**
     * Indicate that the blog post is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'published' => true,
        ]);
    }

    /**
     * Indicate that the blog post is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published' => false,
        ]);
    }

    /**
     * Indicate that the blog post shows the date.
     */
    public function withDate(): static
    {
        return $this->state(fn (array $attributes) => [
            'show_date' => true,
        ]);
    }

    /**
     * Indicate that the blog post hides the date.
     */
    public function withoutDate(): static
    {
        return $this->state(fn (array $attributes) => [
            'show_date' => false,
        ]);
    }
}