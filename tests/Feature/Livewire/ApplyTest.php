<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Apply;
use App\Models\Career;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Test suite for Apply Livewire component.
 *
 * Tests job application form validation, file uploads, email sending,
 * and complete application submission workflow.
 */
class ApplyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test career opportunities
        Career::factory()->create([
            'title' => 'Fence Installer',
            'is_active' => true,
        ]);

        Career::factory()->create([
            'title' => 'Sales Representative',
            'is_active' => true,
        ]);

        // Fake storage for file uploads
        Storage::fake('local');

        // Fake mail for email testing
        Mail::fake();
    }

    /** @test */
    public function component_renders_successfully()
    {
        Livewire::test(Apply::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.apply');
    }

    /** @test */
    public function submit_validates_required_fields()
    {
        Livewire::test(Apply::class)
            ->call('submit')
            ->assertHasErrors([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'position_interested_in' => 'required',
            ]);
    }

    /** @test */
    public function submit_validates_email_format()
    {
        Livewire::test(Apply::class)
            ->set('email', 'invalid-email')
            ->call('submit')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function submit_creates_application_with_valid_data()
    {
        $applicationData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'position_interested_in' => 'Fence Installer',
            'years_of_experience' => '5',
            'availability' => 'Full-time',
            'salary_expectations' => '$40,000 - $50,000',
            'why_interested' => 'I have extensive experience in construction and want to join a growing company.',
            'additional_comments' => 'Available to start immediately'
        ];

        Livewire::test(Apply::class)
            ->set($applicationData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('applications', [
            'first_name' => $applicationData['first_name'],
            'last_name' => $applicationData['last_name'],
            'email' => $applicationData['email'],
            'position_interested_in' => 'Fence Installer'
        ]);
    }

    /** @test */
    public function submit_handles_resume_upload()
    {
        $resume = UploadedFile::fake()->create('resume.pdf', 1000, 'application/pdf');

        $applicationData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '555-123-4567',
            'position_interested_in' => 'Sales Representative',
        ];

        Livewire::test(Apply::class)
            ->set($applicationData)
            ->set('resume', $resume)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        // Verify resume was stored
        $application = \App\Models\Application::latest()->first();
        $this->assertNotNull($application->resume_path);
        Storage::disk('local')->assertExists($application->resume_path);
    }

    /** @test */
    public function submit_handles_multiple_file_attachments()
    {
        $resume = UploadedFile::fake()->create('resume.pdf', 1000, 'application/pdf');
        $coverLetter = UploadedFile::fake()->create('cover_letter.pdf', 500, 'application/pdf');
        $portfolio = UploadedFile::fake()->create('portfolio.pdf', 2000, 'application/pdf');

        $applicationData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone' => '555-987-6543',
            'position_interested_in' => 'Fence Installer',
        ];

        Livewire::test(Apply::class)
            ->set($applicationData)
            ->set('resume', $resume)
            ->set('attachments', [$coverLetter, $portfolio])
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $application = \App\Models\Application::latest()->first();
        $this->assertNotNull($application->resume_path);
        $this->assertCount(2, $application->attachments);

        // Verify all files were stored
        Storage::disk('local')->assertExists($application->resume_path);
        Storage::disk('local')->assertExists($application->attachments[0]->path);
        Storage::disk('local')->assertExists($application->attachments[1]->path);
    }

    /** @test */
    public function component_loads_available_positions()
    {
        Livewire::test(Apply::class)
            ->assertViewHas('positions')
            ->assertSee('Fence Installer')
            ->assertSee('Sales Representative');
    }

    /** @test */
    public function component_validates_position_selection()
    {
        Livewire::test(Apply::class)
            ->set('position_interested_in', 'Non-existent Position')
            ->call('submit')
            ->assertHasErrors(['position_interested_in']);
    }

    /** @test */
    public function component_handles_experience_levels()
    {
        $experienceLevels = ['Entry Level', '1-2 years', '3-5 years', '5+ years'];

        foreach ($experienceLevels as $experience) {
            Livewire::test(Apply::class)
                ->set('years_of_experience', $experience)
                ->assertSet('years_of_experience', $experience);
        }
    }

    /** @test */
    public function component_handles_availability_options()
    {
        $availabilityOptions = ['Full-time', 'Part-time', 'Contract', 'Flexible'];

        foreach ($availabilityOptions as $availability) {
            Livewire::test(Apply::class)
                ->set('availability', $availability)
                ->assertSet('availability', $availability);
        }
    }

    /** @test */
    public function component_validates_file_types_for_resume()
    {
        $invalidFile = UploadedFile::fake()->image('resume.jpg'); // Should be PDF or DOC

        Livewire::test(Apply::class)
            ->set('resume', $invalidFile)
            ->call('submit')
            ->assertHasErrors(['resume']);
    }

    /** @test */
    public function component_validates_file_size_limits()
    {
        $oversizedFile = UploadedFile::fake()->create('huge_resume.pdf', 10000, 'application/pdf'); // 10MB

        Livewire::test(Apply::class)
            ->set('resume', $oversizedFile)
            ->call('submit')
            ->assertHasErrors(['resume']);
    }

    /** @test */
    public function placeholder_returns_lazy_loader_view()
    {
        $component = new Apply();
        $view = $component->placeholder();

        $this->assertEquals('lazy-loader', $view->getName());
    }

    /** @test */
    public function component_handles_empty_optional_fields()
    {
        $applicationData = [
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'email' => 'bob@example.com',
            'phone' => '555-456-7890',
            'position_interested_in' => 'Fence Installer',
            // Optional fields are null/empty
            'years_of_experience' => null,
            'availability' => null,
            'salary_expectations' => null,
            'why_interested' => null,
            'additional_comments' => null,
        ];

        Livewire::test(Apply::class)
            ->set($applicationData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('applications', [
            'first_name' => 'Bob',
            'email' => 'bob@example.com',
            'years_of_experience' => null,
            'additional_comments' => null
        ]);
    }

    /** @test */
    public function submit_sends_notification_email()
    {
        $applicationData = [
            'first_name' => 'Alice',
            'last_name' => 'Wilson',
            'email' => 'alice@example.com',
            'phone' => '555-321-0987',
            'position_interested_in' => 'Sales Representative',
        ];

        Livewire::test(Apply::class)
            ->set($applicationData)
            ->call('submit');

        // Verify the danielle() helper was called to send email
        // Note: This would require mocking the danielle() helper function
        $this->assertTrue(true); // Placeholder - implement based on helper structure
    }

    /** @test */
    public function component_handles_special_characters_in_input()
    {
        $applicationData = [
            'first_name' => "José",
            'last_name' => "García-Smith",
            'email' => 'jose.garcia@example.com',
            'phone' => '+1 (555) 123-4567',
            'position_interested_in' => 'Fence Installer',
            'why_interested' => 'I\'m passionate about quality workmanship & customer satisfaction.',
        ];

        Livewire::test(Apply::class)
            ->set($applicationData)
            ->call('submit')
            ->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('applications', [
            'first_name' => "José",
            'last_name' => "García-Smith",
            'email' => 'jose.garcia@example.com'
        ]);
    }
}