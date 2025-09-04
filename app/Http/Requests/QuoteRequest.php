<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class QuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Check rate limiting for quote requests
        $key = 'quote-request:' . $this->ip();
        
        if (RateLimiter::tooManyAttempts($key, 2)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'rate_limit' => "Too many quote requests. Please try again in {$seconds} seconds."
            ]);
        }

        RateLimiter::hit($key, 3600); // 1 hour window

        // Sanitize input data
        $this->merge([
            'name' => strip_tags($this->input('name')),
            'message' => strip_tags($this->input('message')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-Z\s\-\.]+$/',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                // Block common spam domains
                'not_regex:/^.+@(tempmail|10minutemail|guerrillamail|mailinator)\..*$/i',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[1-9][\d]{0,15}$|^\([0-9]{3}\)\s?[0-9]{3}[-\.]?[0-9]{4}$|^[0-9]{3}[-\.]?[0-9]{3}[-\.]?[0-9]{4}$/'
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
                // Block obvious spam patterns
                'not_regex:/(viagra|casino|lottery|bitcoin|crypto|investment|loan)/i',
            ],
            'service_type' => 'nullable|string|max:100|in:residential,commercial,repair,diy',
            'budget' => 'nullable|string|max:50|in:under-1000,1000-5000,5000-10000,10000-plus',
            
            // Honeypot field - should always be empty
            'website' => 'nullable|size:0',
            
            // CAPTCHA or similar
            'terms_accepted' => 'required|accepted',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, hyphens, and periods.',
            'phone.regex' => 'Please enter a valid phone number format.',
            'email.not_regex' => 'Please use a valid business or personal email address.',
            'message.min' => 'Please provide more details about your project (minimum 10 characters).',
            'message.max' => 'Message is too long. Please keep it under 2000 characters.',
            'message.not_regex' => 'Message contains inappropriate content.',
            'website.size' => 'This field should be left empty.',
            'terms_accepted.accepted' => 'You must accept the terms and conditions.',
        ];
    }

    /**
     * Get custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'name' => 'full name',
            'phone' => 'phone number',
            'message' => 'project description',
            'service_type' => 'service type',
            'terms_accepted' => 'terms and conditions',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional spam detection
            $spamScore = 0;
            $message = strtolower($this->input('message', ''));
            
            // Check for spam indicators
            if (substr_count($message, 'http') > 1) $spamScore++;
            if (preg_match_all('/[A-Z]{3,}/', $this->input('message', '')) > 5) $spamScore++;
            if (str_contains($message, 'click here')) $spamScore++;
            
            if ($spamScore >= 2) {
                $validator->errors()->add('message', 'Message appears to be spam.');
            }
        });
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Log validation failures for security monitoring
        \Illuminate\Support\Facades\Log::warning('Quote request validation failed', [
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent(),
            'errors' => $validator->errors()->toArray(),
            'name' => $this->input('name'),
            'honeypot_filled' => !empty($this->input('website')),
        ]);

        parent::failedValidation($validator);
    }
}
