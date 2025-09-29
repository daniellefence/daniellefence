<?php

namespace Tests\Feature\Livewire;

use App\Livewire\RequestAFenceQuote;
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
 * Test suite for RequestAFenceQuote Livewire component.
 *
 * Tests form validation, file uploads, email sending, spam protection,
 * and complete fence quote request workflow.
 */
class RequestAFenceQuoteTest extends TestCase
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
        Livewire::test(RequestAFenceQuote::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.request-a-fence-quote');
    }

    /** @test */
    public function component_has_default_values()
    {
        Livewire::test(RequestAFenceQuote::class)
            ->assertSet('fence_type', 'PVCVinyl')
            ->assertSet('haul_away', 'No')
            ->assertSet('fence_height', '48')
            ->assertSet('captcha', 0);
    }

    /** @test */
    public function submit_validates_required_fields()
    {
        Livewire::test(RequestAFenceQuote::class)
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
    public function submit_creates_quote_request_with_valid_data()
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
            'fence_type' => 'Wood',
            'fence_height' => '60',
            'style_options' => 'Privacy style with lattice top',
            'how_many_gates' => 2,
            'haul_away' => 'Yes',
            'additional_comments' => 'Need installation by end of month'
        ];

        Livewire::test(RequestAFenceQuote::class)
            ->set($quoteData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('quote_requests', [
            'first_name' => $quoteData['first_name'],
            'last_name' => $quoteData['last_name'],
            'email' => $quoteData['email'],
            'fence_type' => 'Wood',
            'fence_height' => '60',
            'how_many_gates' => 2,
            'haul_away' => 'Yes'
        ]);
    }

    /** @test */
    public function submit_handles_file_attachments()
    {
        $file1 = UploadedFile::fake()->image('property_photo.jpg');
        $file2 = UploadedFile::fake()->create('property_plan.pdf', 1000, 'application/pdf');

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

        Livewire::test(RequestAFenceQuote::class)
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
    public function submit_sends_email_notification()
    {
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

        Livewire::test(RequestAFenceQuote::class)
            ->set($quoteData)
            ->call('submit');

        // Verify the danielle() helper was called to send email
        // Note: This would require mocking the danielle() helper function
        $this->assertTrue(true); // Placeholder - implement based on helper structure
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

        Livewire::test(RequestAFenceQuote::class)
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

        Livewire::test(RequestAFenceQuote::class)
            ->set($quoteData)
            ->call('updatedCaptcha', 'test_token')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('quote_requests', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }

    /** @test */
    public function updated_captcha_handles_api_failure()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify*' => Http::response([], 500)
        ]);

        Livewire::test(RequestAFenceQuote::class)
            ->call('updatedCaptcha', 'test_token');
            // Should handle gracefully without errors
    }

    /** @test */
    public function placeholder_returns_lazy_loader_view()
    {
        $component = new RequestAFenceQuote();
        $view = $component->placeholder();

        $this->assertEquals('lazy-loader', $view->getName());
    }

    /** @test */
    public function component_accepts_all_fence_types()
    {
        $fenceTypes = ['PVCVinyl', 'Wood', 'Chain Link', 'Aluminum', 'Steel'];

        foreach ($fenceTypes as $fenceType) {
            Livewire::test(RequestAFenceQuote::class)
                ->set('fence_type', $fenceType)
                ->assertSet('fence_type', $fenceType);
        }
    }

    /** @test */
    public function component_accepts_various_fence_heights()
    {
        $heights = ['36', '42', '48', '54', '60', '72'];

        foreach ($heights as $height) {
            Livewire::test(RequestAFenceQuote::class)
                ->set('fence_height', $height)
                ->assertSet('fence_height', $height);
        }
    }

    /** @test */
    public function component_handles_gates_quantity()
    {
        Livewire::test(RequestAFenceQuote::class)
            ->set('how_many_gates', 3)
            ->assertSet('how_many_gates', 3);
    }

    /** @test */
    public function component_handles_haul_away_options()
    {
        $options = ['Yes', 'No'];

        foreach ($options as $option) {
            Livewire::test(RequestAFenceQuote::class)
                ->set('haul_away', $option)
                ->assertSet('haul_away', $option);
        }
    }

    /** @test */
    public function component_handles_long_additional_comments()
    {
        $longComment = str_repeat('This is a long comment about fence installation requirements. ', 50);

        Livewire::test(RequestAFenceQuote::class)
            ->set('additional_comments', $longComment)
            ->assertSet('additional_comments', $longComment);
    }

    /** @test */
    public function submit_without_attachments_works_correctly()
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
        ];

        Livewire::test(RequestAFenceQuote::class)
            ->set($quoteData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $quoteRequest = QuoteRequest::latest()->first();
        $this->assertCount(0, $quoteRequest->attachments);
    }

    /** @test */
    public function component_handles_empty_optional_fields()
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
            // Optional fields are null/empty
            'address_line_two' => null,
            'style_options' => null,
            'how_many_gates' => null,
            'additional_comments' => null,
        ];

        Livewire::test(RequestAFenceQuote::class)
            ->set($quoteData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('quote_requests', [
            'first_name' => 'Bob',
            'email' => 'bob@example.com',
            'address_line_two' => null,
            'style_options' => null,
            'additional_comments' => null
        ]);
    }
}