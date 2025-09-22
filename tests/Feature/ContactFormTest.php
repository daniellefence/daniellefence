<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission()
    {
        Mail::fake();

        $contactData = [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '555-9876',
            'service_area' => 'Tampa',
            'message' => 'I need help with residential fencing'
        ];

        $response = $this->post('/contact', $contactData);

        $response->assertRedirect('/thanks');

        $this->assertDatabaseHas('contacts', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '555-9876'
        ]);
    }

    public function test_contact_form_validation()
    {
        $response = $this->post('/contact', []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'message'
        ]);
    }

    public function test_contact_form_email_validation()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'invalid-email-format',
            'message' => 'Test message'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_contact_form_phone_validation()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '123', // Too short
            'message' => 'Test message'
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    public function test_contact_data_formatting()
    {
        $contact = Contact::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'phone' => '555-1234',
            'message' => 'Need fence quote'
        ]);

        $this->assertEquals('Test Customer', $contact->name);
        $this->assertEquals('customer@test.com', $contact->email);
        $this->assertTrue(strlen($contact->phone) >= 10);
    }
}