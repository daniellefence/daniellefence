<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Contact;
use App\Models\Contact as ContactModel;
use App\Models\GeneralSetting;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Test suite for Contact Livewire component.
 *
 * Tests honeypot protection, rate limiting, form validation, spam protection,
 * reCAPTCHA integration, and contact form submission workflow.
 */
class ContactTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create required general settings for reCAPTCHA
        GeneralSetting::factory()->create([
            'key' => 'google_recaptcha_secret_key',
            'value' => 'test_secret_key'
        ]);

        // Fake mail for email testing
        Mail::fake();

        // Clear rate limiter
        RateLimiter::clear('contact_form_' . request()->ip());
    }

    /** @test */
    public function component_renders_successfully()
    {
        Livewire::test(Contact::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.contact');
    }

    /** @test */
    public function component_initializes_with_form_start_time()
    {
        $component = Livewire::test(Contact::class);

        $this->assertNotNull($component->get('form_start_time'));
        $this->assertIsInt($component->get('form_start_time'));
    }

    /** @test */
    public function send_validates_required_fields()
    {
        Livewire::test(Contact::class)
            ->call('send')
            ->assertHasErrors([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'message' => 'required',
            ]);
    }

    /** @test */
    public function send_validates_field_formats()
    {
        Livewire::test(Contact::class)
            ->set('first_name', '123')
            ->set('last_name', '456')
            ->set('email', 'invalid-email')
            ->set('phone', 'abc')
            ->set('message', 'http://spam.com')
            ->call('send')
            ->assertHasErrors([
                'first_name' => 'regex',
                'last_name' => 'regex',
                'email' => 'email',
                'phone' => 'regex',
                'message' => 'not_regex',
            ]);
    }

    /** @test */
    public function send_validates_minimum_lengths()
    {
        Livewire::test(Contact::class)
            ->set('first_name', 'A')
            ->set('last_name', 'B')
            ->set('email', 'test@example.com')
            ->set('message', 'short')
            ->call('send')
            ->assertHasErrors([
                'first_name' => 'min',
                'last_name' => 'min',
                'message' => 'min',
            ]);
    }

    /** @test */
    public function honeypot_protection_redirects_on_filled_website_field()
    {
        Livewire::test(Contact::class)
            ->set('website', 'spam-content')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('message', 'This is a test message')
            ->call('send')
            ->assertRedirect(route('thanks'));

        // Should not create contact record
        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function timing_check_prevents_fast_submissions()
    {
        Livewire::test(Contact::class)
            ->set('form_start_time', time()) // Set to current time
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('message', 'This is a test message')
            ->call('send')
            ->assertHasErrors(['general']);
    }

    /** @test */
    public function rate_limiting_prevents_excessive_submissions()
    {
        $ip = '192.168.1.1';
        $this->app['request']->server->set('REMOTE_ADDR', $ip);

        // Hit the rate limit
        for ($i = 0; $i < 6; $i++) {
            RateLimiter::hit('contact_form_' . $ip, 60);
        }

        Livewire::test(Contact::class)
            ->call('send')
            ->assertHasErrors(['general']);
    }

    /** @test */
    public function send_creates_contact_with_valid_data()
    {
        $contactData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company' => 'Test Company',
            'email' => 'john@example.com',
            'phone' => '555-123-4567',
            'message' => 'This is a test message with enough length',
            'service_area' => 'Tampa',
            'how_did_you_hear_about_us' => 'Google search',
            'form_start_time' => time() - 10, // Submitted 10 seconds after loading
        ];

        Livewire::test(Contact::class)
            ->set($contactData)
            ->call('send')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company' => 'Test Company',
            'email' => 'john@example.com',
            'phone' => '555-123-4567',
            'message' => 'This is a test message with enough length',
        ]);
    }

    /** @test */
    public function send_sanitizes_input_data()
    {
        $contactData = [
            'first_name' => '<script>alert("xss")</script>John',
            'last_name' => '<b>Doe</b>',
            'email' => ' JOHN@EXAMPLE.COM ',
            'phone' => '555-123-4567 ext. 123',
            'message' => '<p>This is a test message</p>',
            'form_start_time' => time() - 10,
        ];

        Livewire::test(Contact::class)
            ->set($contactData)
            ->call('send')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'John', // Sanitized
            'last_name' => 'Doe', // Sanitized
            'email' => 'john@example.com', // Lowercased and trimmed
            'phone' => '555-123-4567 ext. 123', // Special chars preserved
            'message' => 'This is a test message', // Tags stripped
        ]);
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

        Livewire::test(Contact::class)
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

        $contactData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message with enough length',
            'form_start_time' => time() - 10,
        ];

        Livewire::test(Contact::class)
            ->set($contactData)
            ->call('updatedCaptcha', 'test_token')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ]);
    }

    /** @test */
    public function component_validates_service_area()
    {
        // Mock CacheService to return false for invalid area
        $this->mock(CacheService::class, function ($mock) {
            $mock->shouldReceive('isServiceAreaValid')
                ->with('Invalid Area')
                ->andReturn(false);
        });

        Livewire::test(Contact::class)
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('message', 'This is a test message with enough length')
            ->set('service_area', 'Invalid Area')
            ->set('form_start_time', time() - 10)
            ->call('send')
            ->assertHasErrors(['service_area']);
    }

    /** @test */
    public function component_accepts_valid_service_area()
    {
        // Mock CacheService to return true for valid area
        $this->mock(CacheService::class, function ($mock) {
            $mock->shouldReceive('isServiceAreaValid')
                ->with('Tampa')
                ->andReturn(true);
            $mock->shouldReceive('getAreasWeServe')
                ->andReturn(collect());
        });

        Livewire::test(Contact::class)
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('message', 'This is a test message with enough length')
            ->set('service_area', 'Tampa')
            ->set('form_start_time', time() - 10)
            ->call('send')
            ->assertRedirect(route('thanks'));
    }

    /** @test */
    public function placeholder_returns_lazy_loader_view()
    {
        $component = new Contact();
        $view = $component->placeholder();

        $this->assertEquals('lazy-loader', $view->getName());
    }

    /** @test */
    public function render_passes_areas_we_serve_to_view()
    {
        $areasCollection = collect([
            (object) ['id' => 1, 'title' => 'Tampa'],
            (object) ['id' => 2, 'title' => 'Orlando'],
        ]);

        $this->mock(CacheService::class, function ($mock) use ($areasCollection) {
            $mock->shouldReceive('getAreasWeServe')
                ->andReturn($areasCollection);
        });

        Livewire::test(Contact::class)
            ->assertViewHas('areasWeServe', $areasCollection);
    }

    /** @test */
    public function component_handles_optional_fields()
    {
        $contactData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'message' => 'This is a test message with enough length',
            'form_start_time' => time() - 10,
            // Optional fields
            'company' => null,
            'phone' => null,
            'service_area' => null,
            'how_did_you_hear_about_us' => null,
        ];

        Livewire::test(Contact::class)
            ->set($contactData)
            ->call('send')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'company' => null,
            'phone' => null,
        ]);
    }

    /** @test */
    public function component_increments_rate_limiter_on_successful_submission()
    {
        $ip = '192.168.1.1';
        $this->app['request']->server->set('REMOTE_ADDR', $ip);

        $contactData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message with enough length',
            'form_start_time' => time() - 10,
        ];

        Livewire::test(Contact::class)
            ->set($contactData)
            ->call('send');

        // Verify rate limiter was incremented
        $this->assertTrue(RateLimiter::tooManyAttempts('contact_form_' . $ip, 0));
    }
}