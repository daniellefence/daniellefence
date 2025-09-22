<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Contact;
use App\Models\AreasWeServe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        AreasWeServe::factory()->create([
            'title' => 'Tampa',
            'hidden' => false
        ]);

        AreasWeServe::factory()->create([
            'title' => 'Orlando',
            'hidden' => false
        ]);
    }

    public function test_contact_form_renders_correctly()
    {
        Livewire::test(Contact::class)
            ->assertSee('Contact Us')
            ->assertSee('Tampa')
            ->assertSee('Orlando')
            ->assertStatus(200);
    }

    public function test_contact_form_validation()
    {
        Livewire::test(Contact::class)
            ->call('submit')
            ->assertHasErrors([
                'name' => 'required',
                'email' => 'required',
                'message' => 'required'
            ]);
    }

    public function test_contact_form_email_validation()
    {
        Livewire::test(Contact::class)
            ->set('email', 'invalid-email')
            ->call('submit')
            ->assertHasErrors(['email' => 'email']);
    }

    public function test_contact_form_successful_submission()
    {
        Mail::fake();

        Livewire::test(Contact::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '555-1234')
            ->set('service_area', 'Tampa')
            ->set('message', 'I need a fence quote')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect('/thanks');

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'service_area' => 'Tampa'
        ]);
    }

    public function test_contact_form_phone_formatting()
    {
        Livewire::test(Contact::class)
            ->set('phone', '5551234567')
            ->assertSet('phone', '5551234567');
    }

    public function test_contact_form_service_area_selection()
    {
        Livewire::test(Contact::class)
            ->set('service_area', 'Orlando')
            ->assertSet('service_area', 'Orlando');
    }

    public function test_contact_form_message_length_validation()
    {
        $longMessage = str_repeat('This is a very long message. ', 100);

        Livewire::test(Contact::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('message', $longMessage)
            ->call('submit')
            ->assertHasErrors(['message']);
    }

    public function test_contact_form_clears_after_submission()
    {
        Mail::fake();

        Livewire::test(Contact::class)
            ->set('name', 'Jane Smith')
            ->set('email', 'jane@example.com')
            ->set('message', 'Test message')
            ->call('submit')
            ->assertSet('name', '')
            ->assertSet('email', '')
            ->assertSet('message', '');
    }

    public function test_contact_form_spam_protection()
    {
        // Test honeypot field
        Livewire::test(Contact::class)
            ->set('website', 'spam-content') // honeypot field
            ->set('name', 'Spammer')
            ->set('email', 'spam@example.com')
            ->set('message', 'Spam message')
            ->call('submit')
            ->assertHasErrors();
    }
}