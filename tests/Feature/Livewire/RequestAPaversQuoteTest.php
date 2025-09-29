<?php

namespace Tests\Feature\Livewire;

use App\Livewire\RequestAPaversQuote;
use App\Models\GeneralSetting;
use App\Models\QuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Test suite for RequestAPaversQuote Livewire component.
 *
 * Tests form validation, file uploads, email sending, spam protection,
 * and complete pavers quote request workflow.
 */
class RequestAPaversQuoteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create required general settings for reCAPTCHA
        GeneralSetting::factory()->create([
            'key' => 'google_recaptcha_site_key',
            'value' => 'test_site_key'
        ]);

        // Fake storage for file uploads
        Storage::fake('local');

        // Fake mail for email testing
        Mail::fake();
    }

    /** @test */
    public function component_renders_successfully()
    {
        Livewire::test(RequestAPaversQuote::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.request-a-pavers-quote');
    }

    /** @test */
    public function submit_validates_required_fields()
    {
        Livewire::test(RequestAPaversQuote::class)
            ->call('submit')
            ->assertHasErrors([
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_number' => 'required',
                'email' => 'required',
                'address_line_one' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
            ]);
    }

    /** @test */
    public function submit_creates_pavers_quote_request_with_valid_data()
    {
        $quoteData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address_line_one' => $this->faker->streetAddress,
            'address_line_two' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'square_footage' => '500',
            'paver_type' => 'Brick',
            'project_type' => 'Driveway',
            'additional_comments' => 'Need installation by summer'
        ];

        Livewire::test(RequestAPaversQuote::class)
            ->set($quoteData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('quote_requests', [
            'first_name' => $quoteData['first_name'],
            'last_name' => $quoteData['last_name'],
            'email' => $quoteData['email'],
            'quote_type' => 'pavers'
        ]);
    }

    /** @test */
    public function submit_handles_file_attachments()
    {
        $file1 = UploadedFile::fake()->image('property_photo.jpg');
        $file2 = UploadedFile::fake()->create('measurements.pdf', 1000, 'application/pdf');

        $quoteData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address_line_one' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
        ];

        Livewire::test(RequestAPaversQuote::class)
            ->set($quoteData)
            ->set('attachments', [$file1, $file2])
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $quoteRequest = QuoteRequest::latest()->first();
        $this->assertCount(2, $quoteRequest->attachments);

        // Verify files were stored
        Storage::disk('local')->assertExists($quoteRequest->attachments[0]->path);
        Storage::disk('local')->assertExists($quoteRequest->attachments[1]->path);
    }

    /** @test */
    public function updated_captcha_with_low_score_shows_bot_message()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify*' => Http::response([
                'success' => true,
                'score' => 0.2 // Low score indicating bot
            ])
        ]);

        Livewire::test(RequestAPaversQuote::class)
            ->call('updatedCaptcha', 'test_token')
            ->assertSessionHas('success', 'Google thinks you are a bot, please refresh and try again');
    }

    /** @test */
    public function updated_captcha_with_high_score_submits_form()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify*' => Http::response([
                'success' => true,
                'score' => 0.8 // High score indicating human
            ])
        ]);

        $quoteData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '555-123-4567',
            'email' => 'john@example.com',
            'address_line_one' => '123 Main St',
            'city' => 'Tampa',
            'state' => 'FL',
            'zip_code' => '33607',
        ];

        Livewire::test(RequestAPaversQuote::class)
            ->set($quoteData)
            ->call('updatedCaptcha', 'test_token')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('quote_requests', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'quote_type' => 'pavers'
        ]);
    }

    /** @test */
    public function component_handles_paver_types()
    {
        $paverTypes = ['Brick', 'Concrete', 'Natural Stone', 'Travertine', 'Porcelain'];

        foreach ($paverTypes as $paverType) {
            Livewire::test(RequestAPaversQuote::class)
                ->set('paver_type', $paverType)
                ->assertSet('paver_type', $paverType);
        }
    }

    /** @test */
    public function component_handles_project_types()
    {
        $projectTypes = ['Driveway', 'Patio', 'Pool Deck', 'Walkway', 'Other'];

        foreach ($projectTypes as $projectType) {
            Livewire::test(RequestAPaversQuote::class)
                ->set('project_type', $projectType)
                ->assertSet('project_type', $projectType);
        }
    }

    /** @test */
    public function component_handles_square_footage_input()
    {
        Livewire::test(RequestAPaversQuote::class)
            ->set('square_footage', '1500')
            ->assertSet('square_footage', '1500');
    }

    /** @test */
    public function placeholder_returns_lazy_loader_view()
    {
        $component = new RequestAPaversQuote();
        $view = $component->placeholder();

        $this->assertEquals('lazy-loader', $view->getName());
    }

    /** @test */
    public function component_handles_empty_optional_fields()
    {
        $quoteData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'phone_number' => '555-987-6543',
            'email' => 'jane@example.com',
            'address_line_one' => '456 Oak Ave',
            'city' => 'Orlando',
            'state' => 'FL',
            'zip_code' => '32801',
            // Optional fields are null/empty
            'address_line_two' => null,
            'square_footage' => null,
            'paver_type' => null,
            'project_type' => null,
            'additional_comments' => null,
        ];

        Livewire::test(RequestAPaversQuote::class)
            ->set($quoteData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('quote_requests', [
            'first_name' => 'Jane',
            'email' => 'jane@example.com',
            'quote_type' => 'pavers',
            'address_line_two' => null,
            'additional_comments' => null
        ]);
    }

    /** @test */
    public function submit_without_attachments_works_correctly()
    {
        $quoteData = [
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'phone_number' => '555-456-7890',
            'email' => 'bob@example.com',
            'address_line_one' => '789 Pine St',
            'city' => 'Miami',
            'state' => 'FL',
            'zip_code' => '33101',
        ];

        Livewire::test(RequestAPaversQuote::class)
            ->set($quoteData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $quoteRequest = QuoteRequest::latest()->first();
        $this->assertCount(0, $quoteRequest->attachments);
    }

    /** @test */
    public function component_handles_long_additional_comments()
    {
        $longComment = str_repeat('This is a detailed comment about paver installation requirements. ', 50);

        Livewire::test(RequestAPaversQuote::class)
            ->set('additional_comments', $longComment)
            ->assertSet('additional_comments', $longComment);
    }
}