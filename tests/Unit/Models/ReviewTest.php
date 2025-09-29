<?php

namespace Tests\Unit\Models;

use App\Models\Photo;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test suite for Review model.
 *
 * Tests model relationships, soft deletes, scopes, and business logic for customer reviews.
 */
class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $reviewData = [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'review_text' => 'Excellent work on our fence installation. Very professional team.',
            'rating' => 5,
            'project_type' => 'Fence Installation',
            'location' => 'Tampa, FL',
            'featured' => true,
            'approved' => true
        ];

        $review = Review::create($reviewData);

        $this->assertInstanceOf(Review::class, $review);
        $this->assertEquals('John Doe', $review->customer_name);
        $this->assertEquals(5, $review->rating);
        $this->assertTrue($review->featured);
        $this->assertTrue($review->approved);
    }

    /** @test */
    public function it_has_photos_relationship()
    {
        $review = Review::factory()->create();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $review->photos()
        );
    }

    /** @test */
    public function it_can_have_multiple_photos()
    {
        $review = Review::factory()->create();

        $photo1 = Photo::factory()->create([
            'review_id' => $review->id,
            'path' => 'reviews/photo1.jpg'
        ]);

        $photo2 = Photo::factory()->create([
            'review_id' => $review->id,
            'path' => 'reviews/photo2.jpg'
        ]);

        $this->assertCount(2, $review->photos);
        $this->assertTrue($review->photos->contains($photo1));
        $this->assertTrue($review->photos->contains($photo2));
    }

    /** @test */
    public function it_uses_soft_deletes()
    {
        $review = Review::factory()->create([
            'customer_name' => 'Test Customer'
        ]);

        $reviewId = $review->id;

        // Soft delete the review
        $review->delete();

        // Should not appear in normal queries
        $this->assertNull(Review::find($reviewId));

        // Should appear in withTrashed queries
        $this->assertNotNull(Review::withTrashed()->find($reviewId));

        // deleted_at should be set
        $trashedReview = Review::withTrashed()->find($reviewId);
        $this->assertNotNull($trashedReview->deleted_at);
    }

    /** @test */
    public function it_can_be_restored_after_soft_delete()
    {
        $review = Review::factory()->create([
            'customer_name' => 'Test Customer'
        ]);

        $reviewId = $review->id;

        // Soft delete and restore
        $review->delete();
        $review->restore();

        // Should appear in normal queries again
        $restoredReview = Review::find($reviewId);
        $this->assertNotNull($restoredReview);
        $this->assertNull($restoredReview->deleted_at);
    }

    /** @test */
    public function it_can_be_force_deleted()
    {
        $review = Review::factory()->create();
        $reviewId = $review->id;

        // Force delete permanently removes the record
        $review->forceDelete();

        $this->assertNull(Review::withTrashed()->find($reviewId));
    }

    /** @test */
    public function it_allows_mass_assignment_for_all_fields()
    {
        $reviewData = [
            'customer_name' => 'Jane Smith',
            'customer_email' => 'jane@example.com',
            'review_text' => 'Outstanding service and quality workmanship.',
            'rating' => 4,
            'project_type' => 'Outdoor Kitchen',
            'location' => 'Orlando, FL',
            'featured' => false,
            'approved' => true
        ];

        $review = Review::create($reviewData);

        foreach ($reviewData as $key => $value) {
            $this->assertEquals($value, $review->{$key});
        }
    }

    /** @test */
    public function it_handles_different_rating_values()
    {
        for ($rating = 1; $rating <= 5; $rating++) {
            $review = Review::factory()->create(['rating' => $rating]);
            $this->assertEquals($rating, $review->rating);
        }
    }

    /** @test */
    public function it_can_filter_approved_reviews()
    {
        Review::factory()->create(['approved' => true, 'customer_name' => 'Approved Customer']);
        Review::factory()->create(['approved' => false, 'customer_name' => 'Pending Customer']);
        Review::factory()->create(['approved' => true, 'customer_name' => 'Another Approved']);

        $approvedReviews = Review::where('approved', true)->get();
        $pendingReviews = Review::where('approved', false)->get();

        $this->assertCount(2, $approvedReviews);
        $this->assertCount(1, $pendingReviews);
    }

    /** @test */
    public function it_can_filter_featured_reviews()
    {
        Review::factory()->create(['featured' => true, 'customer_name' => 'Featured Customer']);
        Review::factory()->create(['featured' => false, 'customer_name' => 'Regular Customer']);
        Review::factory()->create(['featured' => true, 'customer_name' => 'Another Featured']);

        $featuredReviews = Review::where('featured', true)->get();
        $regularReviews = Review::where('featured', false)->get();

        $this->assertCount(2, $featuredReviews);
        $this->assertCount(1, $regularReviews);
    }

    /** @test */
    public function it_can_filter_by_project_type()
    {
        Review::factory()->create(['project_type' => 'Fence Installation']);
        Review::factory()->create(['project_type' => 'Outdoor Kitchen']);
        Review::factory()->create(['project_type' => 'Fence Installation']);
        Review::factory()->create(['project_type' => 'Pavers']);

        $fenceReviews = Review::where('project_type', 'Fence Installation')->get();
        $kitchenReviews = Review::where('project_type', 'Outdoor Kitchen')->get();

        $this->assertCount(2, $fenceReviews);
        $this->assertCount(1, $kitchenReviews);
    }

    /** @test */
    public function it_can_filter_by_rating()
    {
        Review::factory()->create(['rating' => 5]);
        Review::factory()->create(['rating' => 4]);
        Review::factory()->create(['rating' => 5]);
        Review::factory()->create(['rating' => 3]);

        $fiveStarReviews = Review::where('rating', 5)->get();
        $fourPlusReviews = Review::where('rating', '>=', 4)->get();

        $this->assertCount(2, $fiveStarReviews);
        $this->assertCount(3, $fourPlusReviews);
    }

    /** @test */
    public function it_has_timestamps()
    {
        $review = Review::factory()->create();

        $this->assertNotNull($review->created_at);
        $this->assertNotNull($review->updated_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $review->created_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $review->updated_at);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $review = Review::factory()->create([
            'rating' => 4,
            'approved' => false
        ]);

        $review->update([
            'rating' => 5,
            'approved' => true,
            'featured' => true
        ]);

        $this->assertEquals(5, $review->fresh()->rating);
        $this->assertTrue($review->fresh()->approved);
        $this->assertTrue($review->fresh()->featured);
    }

    /** @test */
    public function it_handles_null_optional_fields()
    {
        $review = Review::create([
            'customer_name' => 'Test Customer',
            'review_text' => 'Great service!',
            'rating' => 5,
            'approved' => true,
            'featured' => false,
            // Optional fields are null
            'customer_email' => null,
            'project_type' => null,
            'location' => null
        ]);

        $this->assertNull($review->customer_email);
        $this->assertNull($review->project_type);
        $this->assertNull($review->location);
    }

    /** @test */
    public function it_can_search_by_customer_name()
    {
        Review::factory()->create(['customer_name' => 'John Smith']);
        Review::factory()->create(['customer_name' => 'Jane Doe']);
        Review::factory()->create(['customer_name' => 'John Johnson']);

        $johnReviews = Review::where('customer_name', 'like', '%John%')->get();

        $this->assertCount(2, $johnReviews);
    }

    /** @test */
    public function it_can_search_by_review_text()
    {
        Review::factory()->create(['review_text' => 'Excellent fence installation work']);
        Review::factory()->create(['review_text' => 'Great outdoor kitchen design']);
        Review::factory()->create(['review_text' => 'Outstanding fence repair service']);

        $fenceReviews = Review::where('review_text', 'like', '%fence%')->get();

        $this->assertCount(2, $fenceReviews);
    }
}