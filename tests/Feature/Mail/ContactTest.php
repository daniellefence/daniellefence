<?php

namespace Tests\Feature\Mail;

use App\Mail\Contact as ContactMail;
use App\Models\Contact as ContactModel;
use App\Models\GeneralSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Test suite for Contact Mailable class.
 *
 * This comprehensive test suite validates the contact form email functionality
 * including envelope configuration, content rendering, and proper data handling
 * for general customer inquiries.
 *
 * @package Tests\Feature\Mail
 * @author Generated via PhpStorm MCP connector
 */
class ContactTest extends TestCase
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
    }

    /** @test */
    public function it_can_be_instantiated_with_contact_model()
    {
        $contact = ContactModel::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'message' => 'I need information about fence installation.',
        ]);

        $mail = new ContactMail($contact);

        $this->assertInstanceOf(ContactMail::class, $mail);
        $this->assertEquals($contact->id, $mail->model->id);
    }

    /** @test */
    public function envelope_has_correct_from_address_and_subject()
    {
        $contact = ContactModel::factory()->create();
        $mail = new ContactMail($contact);

        $envelope = $mail->envelope();

        $this->assertEquals('noreply@daniellefence.com', $envelope->from[0]->address);
        $this->assertEquals('Danielle Fence', $envelope->from[0]->name);
        $this->assertEquals('Contact Request', $envelope->subject);
    }

    /** @test */
    public function content_uses_correct_markdown_template()
    {
        $contact = ContactModel::factory()->create();
        $mail = new ContactMail($contact);

        $content = $mail->content();

        $this->assertEquals('emails.contact-request', $content->markdown);
    }

    /** @test */
    public function attachments_returns_empty_array()
    {
        $contact = ContactModel::factory()->create();
        $mail = new ContactMail($contact);

        $attachments = $mail->attachments();

        $this->assertIsArray($attachments);
        $this->assertEmpty($attachments);
    }

    /** @test */
    public function mail_can_be_sent_successfully()
    {
        $contact = ContactModel::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company' => 'ABC Construction',
            'email' => 'jane@abcconstruction.com',
            'phone' => '555-987-6543',
            'message' => 'I am interested in getting a quote for commercial fencing.',
            'service_area' => 'Tampa',
            'how_did_you_hear_about_us' => 'Google search',
        ]);

        $mail = new ContactMail($contact);

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
        $contact = ContactModel::factory()->create([
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'email' => 'bob@example.com',
            'phone' => '555-123-4567',
            'message' => 'What types of vinyl fencing do you offer?',
            'company' => 'Johnson Industries',
        ]);

        $mail = new ContactMail($contact);

        // Verify the model is publicly accessible for template rendering
        $this->assertEquals('Bob', $mail->model->first_name);
        $this->assertEquals('Johnson', $mail->model->last_name);
        $this->assertEquals('bob@example.com', $mail->model->email);
        $this->assertEquals('What types of vinyl fencing do you offer?', $mail->model->message);
        $this->assertEquals('Johnson Industries', $mail->model->company);
    }

    /** @test */
    public function uses_queueable_and_serializes_models_traits()
    {
        $reflection = new \ReflectionClass(ContactMail::class);
        $traits = $reflection->getTraitNames();

        $this->assertContains('Illuminate\Bus\Queueable', $traits);
        $this->assertContains('Illuminate\Queue\SerializesModels', $traits);
    }

    /** @test */
    public function mail_handles_optional_fields()
    {
        $contact = ContactModel::factory()->create([
            'first_name' => 'Minimal',
            'last_name' => 'Contact',
            'email' => 'minimal@example.com',
            'message' => 'Simple inquiry message.',
            // Optional fields null
            'company' => null,
            'phone' => null,
            'service_area' => null,
            'how_did_you_hear_about_us' => null,
        ]);

        $mail = new ContactMail($contact);

        $this->assertEquals('Minimal', $mail->model->first_name);
        $this->assertEquals('Simple inquiry message.', $mail->model->message);
        $this->assertNull($mail->model->company);
        $this->assertNull($mail->model->phone);
        $this->assertNull($mail->model->service_area);
    }

    /** @test */
    public function mail_handles_different_inquiry_types()
    {
        $inquiryTypes = [
            'General information request',
            'Commercial fencing quote',
            'Residential repair inquiry',
            'Warranty claim question',
            'Installation timeline question'
        ];

        foreach ($inquiryTypes as $inquiry) {
            $contact = ContactModel::factory()->create([
                'first_name' => 'Test',
                'last_name' => 'Customer',
                'email' => 'test@example.com',
                'message' => $inquiry,
            ]);

            $mail = new ContactMail($contact);

            $this->assertEquals($inquiry, $mail->model->message);
        }
    }

    /** @test */
    public function mail_handles_long_messages()
    {
        $longMessage = str_repeat('This is a very detailed inquiry about fencing options and installation procedures. ', 100);

        $contact = ContactModel::factory()->create([
            'first_name' => 'Verbose',
            'last_name' => 'Customer',
            'email' => 'verbose@example.com',
            'message' => $longMessage,
        ]);

        $mail = new ContactMail($contact);

        $this->assertEquals($longMessage, $mail->model->message);
        $this->assertGreaterThan(1000, strlen($mail->model->message));
    }

    /** @test */
    public function mail_handles_special_characters_in_data()
    {
        $contact = ContactModel::factory()->create([
            'first_name' => 'José',
            'last_name' => 'García-Smith',
            'company' => 'Müller & Associates',
            'email' => 'jose@example.com',
            'message' => 'Inquiry about fencing: "What\'s the best option for my property?"',
        ]);

        $mail = new ContactMail($contact);

        $this->assertEquals('José', $mail->model->first_name);
        $this->assertEquals('García-Smith', $mail->model->last_name);
        $this->assertEquals('Müller & Associates', $mail->model->company);
        $this->assertStringContains('"What\'s the best option', $mail->model->message);
    }

    /** @test */
    public function mail_supports_different_contact_sources()
    {
        $sources = [
            'Google search',
            'Facebook',
            'Referral from friend',
            'Previous customer',
            'Yellow Pages',
            'Drive by',
            'Other'
        ];

        foreach ($sources as $source) {
            $contact = ContactModel::factory()->create([
                'first_name' => 'Test',
                'last_name' => 'Customer',
                'email' => 'test@example.com',
                'message' => 'General inquiry',
                'how_did_you_hear_about_us' => $source,
            ]);

            $mail = new ContactMail($contact);

            $this->assertEquals($source, $mail->model->how_did_you_hear_about_us);
        }
    }
}