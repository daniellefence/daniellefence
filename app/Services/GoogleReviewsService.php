<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GoogleReviewsService
{
    protected string $placeId;
    protected string $apiKey;

    public function __construct()
    {
        $this->placeId = config('services.google.places.place_id', '');
        $this->apiKey = config('services.google.places.api_key', '');
    }

    /**
     * Fetch and store latest Google reviews
     */
    public function fetchLatestReviews(): array
    {
        try {
            if (empty($this->placeId) || empty($this->apiKey)) {
                return [
                    'success' => false,
                    'message' => 'Google Places API configuration missing. Please set GOOGLE_PLACES_API_KEY and GOOGLE_PLACES_PLACE_ID in your environment file.',
                    'imported' => 0,
                    'skipped' => 0
                ];
            }

            $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $this->placeId,
                'fields' => 'reviews,rating,user_ratings_total',
                'key' => $this->apiKey,
                'language' => 'en'
            ]);

            if (!$response->successful()) {
                throw new \Exception('Google Places API request failed: ' . $response->body());
            }

            $data = $response->json();

            if ($data['status'] !== 'OK') {
                throw new \Exception('Google Places API error: ' . ($data['error_message'] ?? $data['status']));
            }

            $reviews = $data['result']['reviews'] ?? [];
            
            return $this->processReviews($reviews);

        } catch (\Exception $e) {
            Log::error('Google Reviews fetch failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to fetch reviews: ' . $e->getMessage(),
                'imported' => 0,
                'skipped' => 0
            ];
        }
    }

    /**
     * Process and store reviews in database
     */
    protected function processReviews(array $reviews): array
    {
        $imported = 0;
        $skipped = 0;

        foreach ($reviews as $reviewData) {
            // Skip reviews with rating less than 4 stars
            if (($reviewData['rating'] ?? 0) < 4) {
                $skipped++;
                continue;
            }

            // Create a unique identifier for the review
            $googleReviewId = $reviewData['author_name'] . '_' . $reviewData['time'];
            
            // Check if review already exists
            $existingReview = Review::where('source', 'google')
                ->where('google_review_id', $googleReviewId)
                ->first();

            if ($existingReview) {
                $skipped++;
                continue;
            }

            // Create new review
            Review::create([
                'author' => $reviewData['author_name'],
                'rating' => $reviewData['rating'],
                'content' => $reviewData['text'] ?? '',
                'source' => 'google',
                'google_review_id' => $googleReviewId,
                'review_date' => Carbon::createFromTimestamp($reviewData['time']),
                'is_published' => true, // Auto-publish 4+ star reviews
                'is_featured' => $reviewData['rating'] >= 5, // Feature 5-star reviews
            ]);

            $imported++;
        }

        return [
            'success' => true,
            'message' => "Successfully imported {$imported} new reviews. Skipped {$skipped} existing or low-rated reviews.",
            'imported' => $imported,
            'skipped' => $skipped
        ];
    }

    /**
     * Test the Google Places API connection
     */
    public function testConnection(): array
    {
        try {
            if (empty($this->placeId) || empty($this->apiKey)) {
                return [
                    'success' => false,
                    'message' => 'Google Places API configuration missing.'
                ];
            }

            $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $this->placeId,
                'fields' => 'name,rating,user_ratings_total',
                'key' => $this->apiKey
            ]);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => 'API connection failed: ' . $response->status()
                ];
            }

            $data = $response->json();
            
            if ($data['status'] !== 'OK') {
                return [
                    'success' => false,
                    'message' => 'API error: ' . ($data['error_message'] ?? $data['status'])
                ];
            }

            $result = $data['result'];
            
            return [
                'success' => true,
                'message' => "Connected successfully to '{$result['name']}' - {$result['rating']} stars ({$result['user_ratings_total']} reviews)"
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ];
        }
    }
}