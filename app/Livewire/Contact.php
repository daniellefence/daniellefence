<?php

namespace App\Livewire;

use Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ContactFormRequest;
use App\Models\GeneralSetting;
use App\Services\CacheService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Livewire component for handling contact form submissions.
 *
 * This component provides a secure contact form with comprehensive validation,
 * spam protection (honeypot, timing checks, rate limiting), reCAPTCHA integration,
 * and service area validation. It handles general inquiries and customer contact requests.
 *
 * @package App\Livewire
 * @author Shane Barron
 */
class Contact extends Component
{
    use WithFileUploads;

    /**
     * Customer's first name.
     *
     * @var string|null Required field with strict validation
     */
    public $first_name;

    /**
     * Customer's last name.
     *
     * @var string|null Required field with strict validation
     */
    public $last_name;

    /**
     * Company name (optional).
     *
     * @var string|null Optional field for business contacts
     */
    public $company;

    /**
     * Customer's email address.
     *
     * @var string|null Required field with RFC/DNS validation
     */
    public $email;

    /**
     * Customer's phone number (optional).
     *
     * @var string|null Optional field with format validation
     */
    public $phone;

    /**
     * Customer's message or inquiry.
     *
     * @var string|null Required field with URL blocking
     */
    public $message;

    /**
     * Google reCAPTCHA score.
     *
     * @var float Score from reCAPTCHA validation (0-1)
     */
    public $captcha = 0;

    /**
     * How the customer heard about the company.
     *
     * @var string|null Optional marketing tracking field
     */
    public $how_did_you_hear_about_us;

    /**
     * Service area selection.
     *
     * @var string|null Customer's location for service validation
     */
    public $service_area;

    // Security fields
    /**
     * Honeypot field for spam detection.
     *
     * @var string Should remain empty; filled values indicate bots
     */
    public $website = '';

    /**
     * Timestamp when form was loaded.
     *
     * @var int Used for timing-based spam detection
     */
    public $form_start_time;

    /**
     * Initialize the component.
     *
     * Sets the form start time for spam detection timing checks.
     *
     * @return void
     */
    public function mount()
    {
        $this->form_start_time = time();
    }

    /**
     * Return a placeholder view while the component loads.
     *
     * This method is used for lazy loading to improve page performance
     * by showing a loading indicator until the component is fully rendered.
     *
     * @return View The lazy loader placeholder view
     */
    public function placeholder()
    {
        return view('lazy-loader');
    }

    /**
     * Process the contact form submission.
     *
     * Implements comprehensive security measures including rate limiting,
     * honeypot spam detection, timing checks, enhanced validation,
     * service area verification, input sanitization, and email notifications.
     *
     * @return void|RedirectResponse
     * @throws ValidationException If validation fails
     */
    public function send()
    {
        // Rate limiting check - max 5 attempts per IP
        $key = 'contact_form_' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('general', 'Too many form submissions. Please try again later.');
            return;
        }

        // Honeypot check - bots often fill hidden fields
        if (!empty($this->website)) {
            // Log spam attempt and fake success to confuse bots
            Log::warning('Contact form honeypot triggered', [
                'ip' => request()->ip(),
                'website_field' => $this->website
            ]);
            return redirect(route('thanks'));
        }

        // Timing check - forms submitted too quickly are likely automated
        if (time() - $this->form_start_time < 3) {
            $this->addError('general', 'Please take a moment to fill out the form properly.');
            return;
        }

        // Enhanced validation with strict rules
        $this->validate([
            'first_name' => 'required|string|min:2|max:50|regex:/^[a-zA-Z\s\-\.]+$/',
            'last_name' => 'required|string|min:2|max:50|regex:/^[a-zA-Z\s\-\.]+$/',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'nullable|string|min:10|max:20|regex:/^[\+]?[\d\s\-\(\)\.]+$/',
            'message' => 'required|string|min:10|max:2000|not_regex:/https?:\/\//',
            'service_area' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'how_did_you_hear_about_us' => 'nullable|string|max:200',
        ], [
            'first_name.regex' => 'The first name may only contain letters, spaces, hyphens, and periods.',
            'last_name.regex' => 'The last name may only contain letters, spaces, hyphens, and periods.',
            'phone.regex' => 'Please provide a valid phone number.',
            'message.not_regex' => 'Please do not include URLs in your message.',
            'message.min' => 'Your message must be at least 10 characters long.',
        ]);

        // Validate service area against cached list of valid areas
        if ($this->service_area && !CacheService::isServiceAreaValid($this->service_area)) {
            $this->addError('service_area', 'Please select a valid service area.');
            return;
        }

        // Sanitize all inputs to prevent XSS and clean data
        $cleanData = [
            'first_name' => strip_tags(trim($this->first_name)),
            'last_name' => strip_tags(trim($this->last_name)),
            'company' => strip_tags(trim($this->company)),
            'email' => strtolower(trim($this->email)),
            'phone' => preg_replace('/[^+\d\s\-\(\)]/', '', trim($this->phone)),
            'message' => strip_tags(trim($this->message)),
            'service_area' => strip_tags(trim($this->service_area)),
            'how_did_you_hear_about_us' => strip_tags(trim($this->how_did_you_hear_about_us)),
        ];

        // Create contact record in database
        $contact = \App\Models\Contact::create($cleanData);

        // Send notification email using the Danielle helper
        danielle()->sendMail('contact', $contact);

        // Increment rate limiter counter (60 second window)
        RateLimiter::hit($key, 60);

        return redirect(route('thanks'));
    }

    /**
     * Handle reCAPTCHA token verification.
     *
     * This method is automatically called when the captcha property is updated.
     * It verifies the reCAPTCHA token with Google's API and processes the form
     * submission if the score is acceptable (>0.3).
     *
     * @param string $token The reCAPTCHA token from the frontend
     * @return void|RedirectResponse
     */
    public function updatedCaptcha($token)
    {
        // Get the reCAPTCHA secret key from settings
        $secretKey = GeneralSetting::where('key', 'google_recaptcha_secret_key')->first()->value;

        // Verify the token with Google's reCAPTCHA API
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$token);
        $this->captcha = $response->json()['score'];

        // If score is acceptable (higher than 0.3), proceed with submission
        if ($this->captcha > 0.3) {
            $this->send(); // Note: should be send() not submit()
        } else {
            // Score too low, likely a bot
            return session()->flash('success', 'Google thinks you are a bot, please refresh and try again');
        }
    }

    /**
     * Render the contact form component.
     *
     * Retrieves cached service areas for the dropdown and renders the form.
     *
     * @return View The component's view with service areas
     */
    public function render()
    {
        $areasWeServe = CacheService::getAreasWeServe();
        return view('livewire.contact', compact('areasWeServe'));
    }
}
