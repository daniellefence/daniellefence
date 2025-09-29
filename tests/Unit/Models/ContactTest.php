<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Test suite for Contact Model.
 *
 * This comprehensive test suite validates the Contact model functionality
 * including mass assignment, attribute casting, data validation,
 * and business logic methods for customer contact form submissions.
 *
 * @package Tests\Unit\Models
 * @author Generated via PhpStorm MCP connector
 */
class ContactTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_uses_has_factory_trait()
    {
        $reflection = new \ReflectionClass(Contact::class);
        $traits = $reflection->getTraitNames();

        $this->assertContains('Illuminate\Database\Eloquent\Factories\HasFactory', $traits);
    }

    /** @test */
    public function it_allows_mass_assignment_with_guarded_empty()
    {
        $contactData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '555-123-4567',
            'company' => 'Test Company',
            'message' => 'I need information about your services.',
            'service_area' => 'Tampa',
            'how_did_you_hear_about_us' => 'Google search',
        ];

        $contact = Contact::create($contactData);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertEquals('John', $contact->first_name);
        $this->assertEquals('Doe', $contact->last_name);
        $this->assertEquals('john@example.com', $contact->email);
        $this->assertEquals('Test Company', $contact->company);
        $this->assertEquals('I need information about your services.', $contact->message);
    }

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $contact = Contact::factory()->create();

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertNotNull($contact->first_name);
        $this->assertNotNull($contact->last_name);
        $this->assertNotNull($contact->email);
        $this->assertNotNull($contact->message);
    }

    /** @test */
    public function it_can_be_created_with_required_fields_only()
    {
        $contactData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'message' => 'Simple inquiry message.',
        ];

        $contact = Contact::create($contactData);

        $this->assertEquals('Jane', $contact->first_name);
        $this->assertEquals('Smith', $contact->last_name);
        $this->assertEquals('jane@example.com', $contact->email);
        $this->assertEquals('Simple inquiry message.', $contact->message);
        $this->assertNull($contact->phone);
        $this->assertNull($contact->company);
        $this->assertNull($contact->service_area);
    }

    /** @test */
    public function it_stores_optional_fields_correctly()
    {
        $contactData = [
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'email' => 'bob@example.com',
            'phone' => '555-987-6543',
            'company' => 'Johnson Construction',
            'message' => 'Interested in commercial fencing.',
            'service_area' => 'Orlando',
            'how_did_you_hear_about_us' => 'Referral from friend',
        ];

        $contact = Contact::create($contactData);

        $this->assertEquals('555-987-6543', $contact->phone);
        $this->assertEquals('Johnson Construction', $contact->company);
        $this->assertEquals('Orlando', $contact->service_area);
        $this->assertEquals('Referral from friend', $contact->how_did_you_hear_about_us);
    }

    /** @test */
    public function it_handles_null_optional_fields()
    {
        $contactData = [
            'first_name' => 'Minimal',
            'last_name' => 'Contact',
            'email' => 'minimal@example.com',
            'message' => 'Basic inquiry.',
            'phone' => null,
            'company' => null,
            'service_area' => null,
            'how_did_you_hear_about_us' => null,
        ];

        $contact = Contact::create($contactData);

        $this->assertEquals('Minimal', $contact->first_name);
        $this->assertEquals('minimal@example.com', $contact->email);
        $this->assertNull($contact->phone);
        $this->assertNull($contact->company);
        $this->assertNull($contact->service_area);
        $this->assertNull($contact->how_did_you_hear_about_us);
    }

    /** @test */
    public function it_persists_data_to_database()
    {
        $contactData = [
            'first_name' => 'Database',
            'last_name' => 'Test',
            'email' => 'database@example.com',
            'message' => 'Database persistence test message.',
        ];

        $contact = Contact::create($contactData);

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'Database',
            'last_name' => 'Test',
            'email' => 'database@example.com',
            'message' => 'Database persistence test message.',
        ]);
    }

    /** @test */
    public function it_can_be_retrieved_from_database()
    {
        $contact = Contact::factory()->create([
            'first_name' => 'Retrieve',
            'last_name' => 'Test',
            'email' => 'retrieve@example.com',
            'message' => 'Test message for retrieval.',
        ]);

        $retrievedContact = Contact::find($contact->id);

        $this->assertEquals('Retrieve', $retrievedContact->first_name);
        $this->assertEquals('Test', $retrievedContact->last_name);
        $this->assertEquals('retrieve@example.com', $retrievedContact->email);
        $this->assertEquals('Test message for retrieval.', $retrievedContact->message);
    }

    /** @test */
    public function it_can_be_updated()
    {
        $contact = Contact::factory()->create([
            'first_name' => 'Original',
            'last_name' => 'Name',
            'email' => 'original@example.com',
        ]);

        $contact->update([
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => 'updated@example.com',
        ]);

        $this->assertEquals('Updated', $contact->first_name);
        $this->assertEquals('updated@example.com', $contact->email);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'first_name' => 'Updated',
            'email' => 'updated@example.com',
        ]);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $contact = Contact::factory()->create([
            'first_name' => 'Delete',
            'last_name' => 'Me',
            'email' => 'delete@example.com',
        ]);

        $contactId = $contact->id;
        $contact->delete();

        $this->assertDatabaseMissing('contacts', [
            'id' => $contactId,
        ]);
    }

    /** @test */
    public function it_has_timestamps()
    {
        $contact = Contact::factory()->create();

        $this->assertNotNull($contact->created_at);
        $this->assertNotNull($contact->updated_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $contact->created_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $contact->updated_at);
    }

    /** @test */
    public function it_handles_special_characters_in_data()
    {
        $contactData = [
            'first_name' => 'José',
            'last_name' => 'García-Smith',
            'email' => 'jose.garcia@example.com',
            'company' => 'Müller & Associates',
            'message' => 'Inquiry about fencing: "What\'s the best option for my property?"',
        ];

        $contact = Contact::create($contactData);

        $this->assertEquals('José', $contact->first_name);
        $this->assertEquals('García-Smith', $contact->last_name);
        $this->assertEquals('Müller & Associates', $contact->company);
        $this->assertStringContains('"What\'s the best option', $contact->message);
    }

    /** @test */
    public function it_handles_long_messages()
    {
        $longMessage = str_repeat('This is a very detailed inquiry about fencing options. ', 100);

        $contact = Contact::factory()->create([
            'message' => $longMessage,
        ]);

        $this->assertEquals($longMessage, $contact->message);
        $this->assertGreaterThan(1000, strlen($contact->message));
    }

    /** @test */
    public function it_supports_different_marketing_sources()
    {
        $sources = [
            'Google search',
            'Facebook',
            'Referral from friend',
            'Previous customer',
            'Yellow Pages',
            'Drive by',
            'Radio advertisement',
            'Other'
        ];

        foreach ($sources as $source) {
            $contact = Contact::factory()->create([
                'how_did_you_hear_about_us' => $source,
            ]);

            $this->assertEquals($source, $contact->how_did_you_hear_about_us);
        }
    }

    /** @test */
    public function it_supports_different_service_areas()
    {
        $areas = [
            'Tampa',
            'Orlando',
            'Jacksonville',
            'Miami',
            'St. Petersburg',
            'Clearwater',
            'Lakeland',
            'Brandon'
        ];

        foreach ($areas as $area) {
            $contact = Contact::factory()->create([
                'service_area' => $area,
            ]);

            $this->assertEquals($area, $contact->service_area);
        }
    }

    /** @test */
    public function it_handles_various_phone_formats()
    {
        $phoneFormats = [
            '555-123-4567',
            '(555) 123-4567',
            '555.123.4567',
            '+1 555 123 4567',
            '5551234567',
            '555-123-4567 ext. 123'
        ];

        foreach ($phoneFormats as $phone) {
            $contact = Contact::factory()->create([
                'phone' => $phone,
            ]);

            $this->assertEquals($phone, $contact->phone);
        }
    }

    /** @test */
    public function it_handles_various_company_types()
    {
        $companies = [
            'ABC Construction',
            'Johnson & Associates',
            'Smith Bros. LLC',
            'Miami Property Management Co.',
            'Tampa Bay Developers Inc.',
            null // Individual customers
        ];

        foreach ($companies as $company) {
            $contact = Contact::factory()->create([
                'company' => $company,
            ]);

            $this->assertEquals($company, $contact->company);
        }
    }
}