<?php

namespace Tests\Feature\Livewire;

use App\Livewire\RequestQuote;
use App\Models\AreasWeServe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class RequestQuoteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        AreasWeServe::factory()->create([
            'title' => 'Tampa',
            'hidden' => false
        ]);
    }

    public function test_quote_request_form_renders()
    {
        Livewire::test(RequestQuote::class)
            ->assertSee('Request a Quote')
            ->assertSee('Tampa')
            ->assertStatus(200);
    }

    public function test_quote_request_validation()
    {
        Livewire::test(RequestQuote::class)
            ->call('submit')
            ->assertHasErrors([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'service_type' => 'required'
            ]);
    }

    public function test_quote_request_successful_submission()
    {
        Mail::fake();

        Livewire::test(RequestQuote::class)
            ->set('name', 'Sarah Johnson')
            ->set('email', 'sarah@example.com')
            ->set('phone', '555-9876')
            ->set('address', '456 Oak St')
            ->set('city', 'Tampa')
            ->set('state', 'FL')
            ->set('zip', '33101')
            ->set('service_type', 'residential_fencing')
            ->set('description', 'Need privacy fence for backyard')
            ->set('preferred_contact', 'phone')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect('/thanks');

        $this->assertDatabaseHas('quote_requests', [
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'service_type' => 'residential_fencing'
        ]);
    }

    public function test_quote_request_service_type_options()
    {
        Livewire::test(RequestQuote::class)
            ->assertSee('Residential Fencing')
            ->assertSee('Commercial Fencing')
            ->assertSee('Outdoor Kitchen')
            ->assertSee('Pavers');
    }

    public function test_quote_request_preferred_contact_validation()
    {
        Livewire::test(RequestQuote::class)
            ->set('preferred_contact', 'invalid_option')
            ->call('submit')
            ->assertHasErrors(['preferred_contact']);
    }

    public function test_quote_request_state_validation()
    {
        Livewire::test(RequestQuote::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('phone', '555-1234')
            ->set('state', 'InvalidState')
            ->set('service_type', 'residential_fencing')
            ->call('submit')
            ->assertHasErrors(['state']);
    }

    public function test_quote_request_zip_code_validation()
    {
        Livewire::test(RequestQuote::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('phone', '555-1234')
            ->set('zip', '123') // Too short
            ->set('service_type', 'residential_fencing')
            ->call('submit')
            ->assertHasErrors(['zip']);
    }

    public function test_quote_request_email_notification()
    {
        Mail::fake();

        Livewire::test(RequestQuote::class)
            ->set('name', 'Email Test User')
            ->set('email', 'emailtest@example.com')
            ->set('phone', '555-7777')
            ->set('service_type', 'commercial_fencing')
            ->set('description', 'Commercial fence installation needed')
            ->call('submit');

        Mail::assertSent(\App\Mail\QuoteRequestNotification::class);
    }

    public function test_quote_request_form_field_persistence()
    {
        Livewire::test(RequestQuote::class)
            ->set('name', 'Persistent User')
            ->set('email', 'persistent@example.com')
            ->assertSet('name', 'Persistent User')
            ->assertSet('email', 'persistent@example.com');
    }

    public function test_quote_request_description_length()
    {
        $longDescription = str_repeat('Very detailed project description. ', 50);

        Livewire::test(RequestQuote::class)
            ->set('name', 'Detailed User')
            ->set('email', 'detailed@example.com')
            ->set('phone', '555-4444')
            ->set('service_type', 'outdoor_kitchen')
            ->set('description', $longDescription)
            ->call('submit')
            ->assertHasNoErrors(['description']);
    }
}