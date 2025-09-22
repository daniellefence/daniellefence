<?php

namespace Database\Factories;

use App\Models\AreasWeServe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AreasWeServe>
 */
class AreasWeServeFactory extends Factory
{
    protected $model = AreasWeServe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->city();

        return [
            'title' => $title,
            'county' => $this->faker->randomElement(['Orange', 'Lake', 'Seminole', 'Osceola', 'Volusia', 'Polk']),
            'meta_title' => "Fence Installation in {$title}, FL | Danielle Fence",
            'meta_description' => "Professional fence installation services in {$title}, Florida. Commercial & residential fencing, vinyl, wood, chain link. Licensed & insured. Free estimates!",
            'page_content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(3)) . '</p>',
            'services_content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(2)) . '</p>',
            'latitude' => $this->faker->latitude(28.2, 29.0), // Central Florida coordinates
            'longitude' => $this->faker->longitude(-82.0, -80.8),
            'published' => $this->faker->boolean(80),
            'sort_order' => $this->faker->numberBetween(1, 1000),
        ];
    }

    /**
     * Indicate that the area is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'published' => true,
        ]);
    }

    /**
     * Indicate that the area is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published' => false,
        ]);
    }

    /**
     * Set specific county for the area.
     */
    public function inCounty(string $county): static
    {
        return $this->state(fn (array $attributes) => [
            'county' => $county,
        ]);
    }

    /**
     * Create area with coordinates.
     */
    public function withCoordinates(): static
    {
        return $this->state(fn (array $attributes) => [
            'latitude' => $this->faker->latitude(28.2, 29.0),
            'longitude' => $this->faker->longitude(-82.0, -80.8),
        ]);
    }

    /**
     * Create area without coordinates.
     */
    public function withoutCoordinates(): static
    {
        return $this->state(fn (array $attributes) => [
            'latitude' => null,
            'longitude' => null,
        ]);
    }
}