<?php

namespace Tests\Feature;

use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_quote_request_form_submission()
    {
        Mail::fake();

        $quoteData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '555-1234',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'FL',
            'zip' => '12345',
            'service_type' => 'residential_fencing',
            'description' => 'Need a fence installed in my backyard',
            'preferred_contact' => 'email'
        ];

        $response = $this->post('/request-a-quote', $quoteData);

        $response->assertRedirect('/thanks');

        $this->assertDatabaseHas('quote_requests', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'service_type' => 'residential_fencing'
        ]);
    }

    public function test_quote_request_validation()
    {
        $response = $this->post('/request-a-quote', []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'phone'
        ]);
    }

    public function test_quote_request_email_validation()
    {
        $response = $this->post('/request-a-quote', [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'phone' => '555-1234'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_admin_can_view_quote_requests()
    {
        $admin = User::factory()->create();
        $admin->createPermission('QuoteRequestRead');

        QuoteRequest::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'service_type' => 'commercial_fencing'
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/quoterequest/read');

        $response->assertStatus(200);
        $response->assertSee('Test Customer');
        $response->assertSee('customer@example.com');
    }
}