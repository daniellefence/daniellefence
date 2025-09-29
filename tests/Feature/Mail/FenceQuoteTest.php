<?php

namespace Tests\Feature\Mail;

use App\Mail\FenceQuote;
use App\Models\Attachment;
use App\Models\GeneralSetting;
use App\Models\QuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Test suite for FenceQuote Mailable class.
 *
 * This comprehensive test suite validates the fence quote email functionality
 * including envelope configuration, content rendering, attachment handling,
 * and proper data serialization.
 *
 * @package Tests\Feature\Mail
 * @author Generated via PhpStorm MCP connector
 */
class FenceQuoteTest extends TestCase
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
            'fence_type' => 'Wood',
            'fence_height' => '72',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $mail = new FenceQuote($quoteRequest);

        $this->assertInstanceOf(FenceQuote::class, $mail);
        $this->assertEquals($quoteRequest->id, $mail->model->id);
    }

    /** @test */
    public function envelope_has_correct_from_address_and_subject()
    {
        $quoteRequest = QuoteRequest::factory()->create();
        $mail = new FenceQuote($quoteRequest);

        $envelope = $mail->envelope();

        $this->assertEquals('noreply@daniellefence.com', $envelope->from[0]->address);
        $this->assertEquals('Danielle Fence', $envelope->from[0]->name);
        $this->assertEquals('Fence Quote Request', $envelope->subject);
    }

    /** @test */
    public function content_uses_correct_markdown_template()
    {
        $quoteRequest = QuoteRequest::factory()->create();
        $mail = new FenceQuote($quoteRequest);

        $content = $mail->content();

        $this->assertEquals('emails.fence-quote-request', $content->markdown);
    }

    /** @test */
    public function attachments_returns_empty_array_when_no_attachments()
    {
        $quoteRequest = QuoteRequest::factory()->create();
        $mail = new FenceQuote($quoteRequest);

        $attachments = $mail->attachments();

        $this->assertIsArray($attachments);
        $this->assertEmpty($attachments);
    }

    /** @test */
    public function attachments_includes_uploaded_files()
    {
        $quoteRequest = QuoteRequest::factory()->create();

        // Create test files and attachments
        $file1Path = 'attachments/fence-photo.jpg';
        $file2Path = 'attachments/property-survey.pdf';

        Storage::put($file1Path, 'fake file content 1');
        Storage::put($file2Path, 'fake file content 2');

        Attachment::create([
            'quote_request_id' => $quoteRequest->id,
            'path' => $file1Path,
        ]);

        Attachment::create([
            'quote_request_id' => $quoteRequest->id,
            'path' => $file2Path,
        ]);

        $mail = new FenceQuote($quoteRequest->fresh());
        $attachments = $mail->attachments();

        $this->assertCount(2, $attachments);
        $this->assertInstanceOf(\Illuminate\Mail\Mailables\Attachment::class, $attachments[0]);
        $this->assertInstanceOf(\Illuminate\Mail\Mailables\Attachment::class, $attachments[1]);
    }

    /** @test */
    public function mail_can_be_sent_successfully()
    {
        $quoteRequest = QuoteRequest::factory()->create([
            'fence_type' => 'PVCVinyl',
            'fence_height' => '48',
            'haul_away' => 'Yes',
            'how_many_gates' => 2,
            'style_options' => 'Privacy fence with lattice',
            'additional_comments' => 'Need installation by summer',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone_number' => '555-987-6543',
            'address_line_one' => '456 Oak Ave',
            'city' => 'Tampa',
            'state' => 'FL',
            'zip_code' => '33601',
        ]);

        $mail = new FenceQuote($quoteRequest);

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
            'fence_type' => 'Aluminum',
            'fence_height' => '60',
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'email' => 'bob@example.com',
            'additional_comments' => 'Pool safety fence required',
        ]);

        $mail = new FenceQuote($quoteRequest);

        // Verify the model is publicly accessible for template rendering
        $this->assertEquals('Aluminum', $mail->model->fence_type);
        $this->assertEquals('60', $mail->model->fence_height);
        $this->assertEquals('Bob', $mail->model->first_name);
        $this->assertEquals('Pool safety fence required', $mail->model->additional_comments);
    }

    /** @test */
    public function attachments_handles_missing_files_gracefully()
    {
        $quoteRequest = QuoteRequest::factory()->create();

        // Create attachment record but don't create the actual file
        Attachment::create([
            'quote_request_id' => $quoteRequest->id,
            'path' => 'attachments/missing-file.jpg',
        ]);

        $mail = new FenceQuote($quoteRequest->fresh());

        // Should not throw an exception even if file doesn't exist
        $attachments = $mail->attachments();

        $this->assertIsArray($attachments);
        $this->assertCount(1, $attachments);
    }

    /** @test */
    public function uses_queueable_and_serializes_models_traits()
    {
        $reflection = new \ReflectionClass(FenceQuote::class);
        $traits = $reflection->getTraitNames();

        $this->assertContains('Illuminate\Bus\Queueable', $traits);
        $this->assertContains('Illuminate\Queue\SerializesModels', $traits);
    }

    /** @test */
    public function mail_supports_different_fence_types()
    {
        $fenceTypes = ['PVCVinyl', 'Wood', 'Aluminum', 'Chain Link', 'Steel'];

        foreach ($fenceTypes as $fenceType) {
            $quoteRequest = QuoteRequest::factory()->create([
                'fence_type' => $fenceType,
                'first_name' => 'Test',
                'last_name' => 'Customer',
                'email' => 'test@example.com',
            ]);

            $mail = new FenceQuote($quoteRequest);

            $this->assertEquals($fenceType, $mail->model->fence_type);
        }
    }

    /** @test */
    public function mail_handles_optional_fields()
    {
        $quoteRequest = QuoteRequest::factory()->create([
            'first_name' => 'Minimal',
            'last_name' => 'Data',
            'email' => 'minimal@example.com',
            'address_line_one' => '123 Street',
            'city' => 'City',
            'state' => 'State',
            'zip_code' => '12345',
            // Optional fields null
            'address_line_two' => null,
            'style_options' => null,
            'how_many_gates' => null,
            'additional_comments' => null,
        ]);

        $mail = new FenceQuote($quoteRequest);

        $this->assertEquals('Minimal', $mail->model->first_name);
        $this->assertNull($mail->model->address_line_two);
        $this->assertNull($mail->model->style_options);
        $this->assertNull($mail->model->additional_comments);
    }
}