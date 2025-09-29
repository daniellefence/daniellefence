<?php

namespace Tests\Feature\Mail;

use App\Mail\OutdoorKitchenQuote;
use App\Models\Attachment;
use App\Models\GeneralSetting;
use App\Models\QuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Test suite for OutdoorKitchenQuote Mailable class.
 *
 * This comprehensive test suite validates the outdoor kitchen quote email functionality
 * including envelope configuration, content rendering, attachment handling,
 * and proper data serialization for outdoor kitchen quote requests.
 *
 * @package Tests\Feature\Mail
 * @author Generated via PhpStorm MCP connector
 */
class OutdoorKitchenQuoteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create general settings for email configuration
        GeneralSetting::create([
            'key' => 'from_email',
            'value' => 'noreply@daniellefence.com'
        ]);

        GeneralSetting::create([
            'key' => 'app_title',
            'value' => 'Danielle Fence'
        ]);

        // Fake storage for attachment testing
        Storage::fake('local');
    }

    /** @test */
    public function it_can_be_instantiated_with_quote_request_model()
    {
        $quoteRequest = QuoteRequest::factory()->create([
            'quote_type' => 'outdoor_kitchen',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $mail = new OutdoorKitchenQuote($quoteRequest);

        $this->assertInstanceOf(OutdoorKitchenQuote::class, $mail);
        $this->assertEquals($quoteRequest->id, $mail->model->id);
    }

    /** @test */
    public function envelope_has_correct_from_address_and_subject()
    {
        $quoteRequest = QuoteRequest::factory()->create(['quote_type' => 'outdoor_kitchen']);
        $mail = new OutdoorKitchenQuote($quoteRequest);

        $envelope = $mail->envelope();

        $this->assertEquals('noreply@daniellefence.com', $envelope->from[0]->address);
        $this->assertEquals('Danielle Fence', $envelope->from[0]->name);
        $this->assertEquals('Outdoor Kitchen Quote Request', $envelope->subject);
    }

    /** @test */
    public function content_uses_correct_markdown_template()
    {
        $quoteRequest = QuoteRequest::factory()->create(['quote_type' => 'outdoor_kitchen']);
        $mail = new OutdoorKitchenQuote($quoteRequest);

        $content = $mail->content();

        $this->assertEquals('emails.outdoor-kitchens-quote-request', $content->markdown);
    }

    /** @test */
    public function attachments_returns_empty_array_when_no_attachments()
    {
        $quoteRequest = QuoteRequest::factory()->create(['quote_type' => 'outdoor_kitchen']);
        $mail = new OutdoorKitchenQuote($quoteRequest);

        $attachments = $mail->attachments();

        $this->assertIsArray($attachments);
        $this->assertEmpty($attachments);
    }

    /** @test */
    public function attachments_includes_uploaded_files()
    {
        $quoteRequest = QuoteRequest::factory()->create(['quote_type' => 'outdoor_kitchen']);

        // Create test files and attachments
        $file1Path = 'attachments/outdoor-space-photo.jpg';
        $file2Path = 'attachments/kitchen-inspiration.pdf';

        Storage::put($file1Path, 'fake outdoor space photo content');
        Storage::put($file2Path, 'fake kitchen inspiration content');

        Attachment::create([
            'quote_request_id' => $quoteRequest->id,
            'path' => $file1Path,
        ]);

        Attachment::create([
            'quote_request_id' => $quoteRequest->id,
            'path' => $file2Path,
        ]);

        $mail = new OutdoorKitchenQuote($quoteRequest->fresh());
        $attachments = $mail->attachments();

        $this->assertCount(2, $attachments);
        $this->assertInstanceOf(\Illuminate\Mail\Mailables\Attachment::class, $attachments[0]);
        $this->assertInstanceOf(\Illuminate\Mail\Mailables\Attachment::class, $attachments[1]);
    }

    /** @test */
    public function mail_can_be_sent_successfully()
    {
        $quoteRequest = QuoteRequest::factory()->create([
            'quote_type' => 'outdoor_kitchen',
            'kitchen_size' => 'Large',
            'appliances_needed' => 'Grill, Refrigerator, Sink, Ice Maker',
            'countertop_preference' => 'Granite',
            'budget_range' => '$30,000 - $50,000',
            'additional_comments' => 'Need installation by summer entertaining season',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone_number' => '555-987-6543',
            'address_line_one' => '456 Oak Ave',
            'city' => 'Tampa',
            'state' => 'FL',
            'zip_code' => '33601',
        ]);

        $mail = new OutdoorKitchenQuote($quoteRequest);

        // Test that all envelope, content, and attachment methods work together
        $envelope = $mail->envelope();
        $content = $mail->content();
        $attachments = $mail->attachments();

        $this->assertNotNull($envelope);
        $this->assertNotNull($content);
        $this->assertIsArray($attachments);
    }

    /** @test */
    public function model_data_is_accessible_in_mail_template()
    {
        $quoteRequest = QuoteRequest::factory()->create([
            'quote_type' => 'outdoor_kitchen',
            'kitchen_size' => 'Medium',
            'appliances_needed' => 'Built-in grill, under-counter refrigerator',
            'countertop_preference' => 'Concrete',
            'budget_range' => '$20,000 - $30,000',
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'email' => 'bob@example.com',
            'additional_comments' => 'Must withstand Florida weather conditions',
        ]);

        $mail = new OutdoorKitchenQuote($quoteRequest);

        // Verify the model is publicly accessible for template rendering
        $this->assertEquals('outdoor_kitchen', $mail->model->quote_type);
        $this->assertEquals('Medium', $mail->model->kitchen_size);
        $this->assertEquals('Built-in grill, under-counter refrigerator', $mail->model->appliances_needed);
        $this->assertEquals('Concrete', $mail->model->countertop_preference);
        $this->assertEquals('Must withstand Florida weather conditions', $mail->model->additional_comments);
    }

    /** @test */
    public function attachments_handles_missing_files_gracefully()
    {
        $quoteRequest = QuoteRequest::factory()->create(['quote_type' => 'outdoor_kitchen']);

        // Create attachment record but don't create the actual file
        Attachment::create([
            'quote_request_id' => $quoteRequest->id,
            'path' => 'attachments/missing-outdoor-photo.jpg',
        ]);

        $mail = new OutdoorKitchenQuote($quoteRequest->fresh());

        // Should not throw an exception even if file doesn't exist
        $attachments = $mail->attachments();

        $this->assertIsArray($attachments);
        $this->assertCount(1, $attachments);
    }

    /** @test */
    public function uses_queueable_and_serializes_models_traits()
    {
        $reflection = new \ReflectionClass(OutdoorKitchenQuote::class);
        $traits = $reflection->getTraitNames();

        $this->assertContains('Illuminate\Bus\Queueable', $traits);
        $this->assertContains('Illuminate\Queue\SerializesModels', $traits);
    }

    /** @test */
    public function mail_supports_different_kitchen_sizes()
    {
        $kitchenSizes = ['Small', 'Medium', 'Large', 'Custom'];

        foreach ($kitchenSizes as $size) {
            $quoteRequest = QuoteRequest::factory()->create([
                'quote_type' => 'outdoor_kitchen',
                'kitchen_size' => $size,
                'first_name' => 'Test',
                'last_name' => 'Customer',
                'email' => 'test@example.com',
            ]);

            $mail = new OutdoorKitchenQuote($quoteRequest);

            $this->assertEquals($size, $mail->model->kitchen_size);
        }
    }

    /** @test */
    public function mail_handles_complex_appliance_requirements()
    {
        $complexAppliances = 'Built-in gas grill with rotisserie, under-counter refrigerator with freezer, ' .
                           'stainless steel sink with hot water, ice maker, wood-fired pizza oven, ' .
                           'offset smoker, side burner for wok cooking, warming drawer';

        $quoteRequest = QuoteRequest::factory()->create([
            'quote_type' => 'outdoor_kitchen',
            'appliances_needed' => $complexAppliances,
            'first_name' => 'Complex',
            'last_name' => 'Requirements',
            'email' => 'complex@example.com',
        ]);

        $mail = new OutdoorKitchenQuote($quoteRequest);

        $this->assertEquals($complexAppliances, $mail->model->appliances_needed);
        $this->assertGreaterThan(200, strlen($mail->model->appliances_needed));
    }

    /** @test */
    public function mail_supports_different_countertop_preferences()
    {
        $countertops = ['Granite', 'Concrete', 'Stainless Steel', 'Natural Stone', 'Tile', 'Quartz'];

        foreach ($countertops as $countertop) {
            $quoteRequest = QuoteRequest::factory()->create([
                'quote_type' => 'outdoor_kitchen',
                'countertop_preference' => $countertop,
                'first_name' => 'Test',
                'last_name' => 'Customer',
                'email' => 'test@example.com',
            ]);

            $mail = new OutdoorKitchenQuote($quoteRequest);

            $this->assertEquals($countertop, $mail->model->countertop_preference);
        }
    }

    /** @test */
    public function mail_handles_different_budget_ranges()
    {
        $budgetRanges = [
            'Under $10,000',
            '$10,000 - $20,000',
            '$20,000 - $30,000',
            '$30,000 - $50,000',
            'Over $50,000'
        ];

        foreach ($budgetRanges as $budget) {
            $quoteRequest = QuoteRequest::factory()->create([
                'quote_type' => 'outdoor_kitchen',
                'budget_range' => $budget,
                'first_name' => 'Budget',
                'last_name' => 'Conscious',
                'email' => 'budget@example.com',
            ]);

            $mail = new OutdoorKitchenQuote($quoteRequest);

            $this->assertEquals($budget, $mail->model->budget_range);
        }
    }

    /** @test */
    public function mail_handles_optional_fields()
    {
        $quoteRequest = QuoteRequest::factory()->create([
            'quote_type' => 'outdoor_kitchen',
            'first_name' => 'Minimal',
            'last_name' => 'Data',
            'email' => 'minimal@example.com',
            'address_line_one' => '123 Street',
            'city' => 'City',
            'state' => 'State',
            'zip_code' => '12345',
            // Optional fields null
            'address_line_two' => null,
            'kitchen_size' => null,
            'appliances_needed' => null,
            'countertop_preference' => null,
            'budget_range' => null,
            'additional_comments' => null,
        ]);

        $mail = new OutdoorKitchenQuote($quoteRequest);

        $this->assertEquals('outdoor_kitchen', $mail->model->quote_type);
        $this->assertEquals('Minimal', $mail->model->first_name);
        $this->assertNull($mail->model->kitchen_size);
        $this->assertNull($mail->model->appliances_needed);
        $this->assertNull($mail->model->additional_comments);
    }
}