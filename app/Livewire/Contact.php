<?php

namespace App\Livewire;

use App\Http\Requests\ContactFormRequest;
use App\Models\GeneralSetting;
use App\Services\CacheService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\WithFileUploads;

class Contact extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $company;
    public $email;
    public $phone;
    public $message;
    public $captcha = 0;
    public $how_did_you_hear_about_us;
    public $service_area;

    // Security fields
    public $website = ''; // Honeypot field
    public $form_start_time;

    public function mount()
    {
        $this->form_start_time = time();
    }

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function send()
    {
        // Rate limiting check
        $key = 'contact_form_' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('general', 'Too many form submissions. Please try again later.');
            return;
        }

        // Honeypot check
        if (!empty($this->website)) {
            // Log spam attempt and fake success
            \Log::warning('Contact form honeypot triggered', [
                'ip' => request()->ip(),
                'website_field' => $this->website
            ]);
            return redirect(route('thanks'));
        }

        // Timing check
        if (time() - $this->form_start_time < 3) {
            $this->addError('general', 'Please take a moment to fill out the form properly.');
            return;
        }

        // Enhanced validation
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

        // Validate service area if provided
        if ($this->service_area && !CacheService::isServiceAreaValid($this->service_area)) {
            $this->addError('service_area', 'Please select a valid service area.');
            return;
        }

        // Sanitize inputs
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

        // Create contact record
        $contact = \App\Models\Contact::create($cleanData);

        // Send notification
        danielle()->sendMail('contact', $contact);

        // Increment rate limiter
        RateLimiter::hit($key, 60);

        return redirect(route('thanks'));
    }

    public function updatedCaptcha($token)
    {
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.GeneralSetting::where([['key', '=', 'google_recaptcha_secret_key']])->first()->value.'&response='.$token);
        $this->captcha = $response->json()['score'];

        if (! $this->captcha > .3) {
            $this->submit();
        } else {
            return session()->flash('success', 'Google thinks you are a bot, please refresh and try again');
        }
    }

    public function render()
    {
        $areasWeServe = CacheService::getAreasWeServe();
        return view('livewire.contact', compact('areasWeServe'));
    }
}
