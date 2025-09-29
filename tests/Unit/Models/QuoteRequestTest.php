<?php

namespace Tests\Unit\Models;

use App\Models\Attachment;
use App\Models\QuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test suite for QuoteRequest model.
 *
 * Tests model relationships, validation, and business logic for quote requests.
 */
class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $quoteData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number' => '555-123-4567',
            'address_line_one' => '123 Main St',
            'city' => 'Tampa',
            'state' => 'FL',
            'zip_code' => '33607',
            'fence_type' => 'PVCVinyl',
            'fence_height' => '48',
            'quote_type' => 'fence'
        ];

        $quoteRequest = QuoteRequest::create($quoteData);

        $this->assertInstanceOf(QuoteRequest::class, $quoteRequest);
        $this->assertEquals('John', $quoteRequest->first_name);
        $this->assertEquals('Doe', $quoteRequest->last_name);
        $this->assertEquals('fence', $quoteRequest->quote_type);
    }

    /** @test */
    public function it_has_attachments_relationship()
    {
        $quoteRequest = QuoteRequest::factory()->create();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $quoteRequest->attachments()
        );
    }

    /** @test */
    public function it_can_have_multiple_attachments()
    {
        $quoteRequest = QuoteRequest::factory()->create();

        $attachment1 = Attachment::factory()->create([
            'quote_request_id' => $quoteRequest->id,
            'path' => 'attachments/photo1.jpg'
        ]);

        $attachment2 = Attachment::factory()->create([
            'quote_request_id' => $quoteRequest->id,
            'path' => 'attachments/photo2.jpg'
        ]);

        $this->assertCount(2, $quoteRequest->attachments);
        $this->assertTrue($quoteRequest->attachments->contains($attachment1));
        $this->assertTrue($quoteRequest->attachments->contains($attachment2));
    }

    /** @test */
    public function it_allows_mass_assignment_for_all_fields()
    {
        $quoteData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone_number' => '555-987-6543',
            'address_line_one' => '456 Oak Ave',
            'address_line_two' => 'Apt 2B',
            'city' => 'Orlando',
            'state' => 'FL',
            'zip_code' => '32801',
            'fence_type' => 'Wood',
            'fence_height' => '60',
            'style_options' => 'Privacy with lattice',
            'how_many_gates' => 2,
            'haul_away' => 'Yes',
            'additional_comments' => 'Need installation by end of month',
            'quote_type' => 'fence'
        ];

        $quoteRequest = QuoteRequest::create($quoteData);

        foreach ($quoteData as $key => $value) {
            $this->assertEquals($value, $quoteRequest->{$key});
        }
    }

    /** @test */
    public function it_handles_fence_quote_specific_fields()
    {
        $quoteRequest = QuoteRequest::create([
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'email' => 'bob@example.com',
            'phone_number' => '555-456-7890',
            'address_line_one' => '789 Pine St',
            'city' => 'Miami',
            'state' => 'FL',
            'zip_code' => '33101',
            'fence_type' => 'Chain Link',
            'fence_height' => '72',
            'how_many_gates' => 3,
            'haul_away' => 'No'
        ]);

        $this->assertEquals('Chain Link', $quoteRequest->fence_type);
        $this->assertEquals('72', $quoteRequest->fence_height);
        $this->assertEquals(3, $quoteRequest->how_many_gates);
        $this->assertEquals('No', $quoteRequest->haul_away);
    }

    /** @test */
    public function it_handles_pavers_quote_specific_fields()
    {
        $quoteRequest = QuoteRequest::create([
            'first_name' => 'Alice',
            'last_name' => 'Wilson',
            'email' => 'alice@example.com',
            'phone_number' => '555-321-0987',
            'address_line_one' => '321 Cedar Blvd',
            'city' => 'Tampa',
            'state' => 'FL',
            'zip_code' => '33606',
            'quote_type' => 'pavers',
            'square_footage' => '500',
            'paver_type' => 'Brick',
            'project_type' => 'Driveway'
        ]);

        $this->assertEquals('pavers', $quoteRequest->quote_type);
        $this->assertEquals('500', $quoteRequest->square_footage);
        $this->assertEquals('Brick', $quoteRequest->paver_type);
        $this->assertEquals('Driveway', $quoteRequest->project_type);
    }

    /** @test */
    public function it_handles_outdoor_kitchen_quote_specific_fields()
    {
        $quoteRequest = QuoteRequest::create([
            'first_name' => 'Charlie',
            'last_name' => 'Brown',
            'email' => 'charlie@example.com',
            'phone_number' => '555-654-3210',
            'address_line_one' => '654 Maple Ave',
            'city' => 'Orlando',
            'state' => 'FL',
            'zip_code' => '32802',
            'quote_type' => 'outdoor_kitchen',
            'kitchen_size' => 'Large',
            'appliances_needed' => 'Grill, Refrigerator, Sink',
            'countertop_preference' => 'Granite',
            'budget_range' => '$20,000 - $30,000'
        ]);

        $this->assertEquals('outdoor_kitchen', $quoteRequest->quote_type);
        $this->assertEquals('Large', $quoteRequest->kitchen_size);
        $this->assertEquals('Grill, Refrigerator, Sink', $quoteRequest->appliances_needed);
        $this->assertEquals('Granite', $quoteRequest->countertop_preference);
        $this->assertEquals('$20,000 - $30,000', $quoteRequest->budget_range);
    }

    /** @test */
    public function it_has_timestamps()
    {
        $quoteRequest = QuoteRequest::factory()->create();

        $this->assertNotNull($quoteRequest->created_at);
        $this->assertNotNull($quoteRequest->updated_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $quoteRequest->created_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $quoteRequest->updated_at);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $quoteRequest = QuoteRequest::factory()->create([
            'first_name' => 'Original Name'
        ]);

        $quoteRequest->update([
            'first_name' => 'Updated Name',
            'additional_comments' => 'Updated comments'
        ]);

        $this->assertEquals('Updated Name', $quoteRequest->fresh()->first_name);
        $this->assertEquals('Updated comments', $quoteRequest->fresh()->additional_comments);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $quoteRequest = QuoteRequest::factory()->create();
        $quoteRequestId = $quoteRequest->id;

        $quoteRequest->delete();

        $this->assertDatabaseMissing('quote_requests', ['id' => $quoteRequestId]);
    }

    /** @test */
    public function it_handles_null_optional_fields()
    {
        $quoteRequest = QuoteRequest::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone_number' => '555-000-0000',
            'address_line_one' => 'Test Address',
            'city' => 'Test City',
            'state' => 'TS',
            'zip_code' => '00000',
            // All optional fields are null
            'address_line_two' => null,
            'fence_type' => null,
            'fence_height' => null,
            'style_options' => null,
            'how_many_gates' => null,
            'haul_away' => null,
            'additional_comments' => null,
            'quote_type' => null
        ]);

        $this->assertNull($quoteRequest->address_line_two);
        $this->assertNull($quoteRequest->fence_type);
        $this->assertNull($quoteRequest->style_options);
        $this->assertNull($quoteRequest->additional_comments);
    }

    /** @test */
    public function it_can_retrieve_quotes_by_type()
    {
        QuoteRequest::factory()->create(['quote_type' => 'fence']);
        QuoteRequest::factory()->create(['quote_type' => 'pavers']);
        QuoteRequest::factory()->create(['quote_type' => 'outdoor_kitchen']);
        QuoteRequest::factory()->create(['quote_type' => 'fence']);

        $fenceQuotes = QuoteRequest::where('quote_type', 'fence')->get();
        $paversQuotes = QuoteRequest::where('quote_type', 'pavers')->get();

        $this->assertCount(2, $fenceQuotes);
        $this->assertCount(1, $paversQuotes);
    }

    /** @test */
    public function it_can_search_by_customer_information()
    {
        $quoteRequest1 = QuoteRequest::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com'
        ]);

        $quoteRequest2 = QuoteRequest::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com'
        ]);

        $johnQuotes = QuoteRequest::where('first_name', 'John')->get();
        $emailQuotes = QuoteRequest::where('email', 'john.doe@example.com')->get();

        $this->assertCount(1, $johnQuotes);
        $this->assertEquals($quoteRequest1->id, $johnQuotes->first()->id);
        $this->assertCount(1, $emailQuotes);
        $this->assertEquals($quoteRequest1->id, $emailQuotes->first()->id);
    }
}