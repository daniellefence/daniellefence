<?php

namespace Database\Factories;

use App\Models\QuoteRequest;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuoteRequest>
 */
class QuoteRequestFactory extends Factory
{
    protected $model = QuoteRequest::class;

    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory(),
            'source' => fake()->randomElement(['web', 'phone', 'walk-in', 'referral']),
            'status' => fake()->randomElement(['new', 'in_review', 'quoted', 'won', 'lost']),
            'details' => fake()->optional()->sentence(18),
        ];
    }
}
