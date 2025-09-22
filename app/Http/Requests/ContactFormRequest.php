<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Z\s\-\.]+$/', // Only letters, spaces, hyphens, and periods
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'not_regex:/\+.*\+/', // Prevent email with multiple + signs (spam indicator)
            ],
            'phone' => [
                'nullable',
                'string',
                'min:10',
                'max:20',
                'regex:/^[\+]?[\d\s\-\(\)\.]+$/', // Allow international format
            ],
            'service_area' => [
                'nullable',
                'string',
                'max:100',
                Rule::exists('areas_we_serves', 'title')->where('hidden', false),
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
                'not_regex:/https?:\/\//', // Prevent URLs in message
                'not_regex:/\b(?:viagra|cialis|casino|poker|loan|credit|debt)\b/i', // Spam keywords
            ],
            'subject' => [
                'nullable',
                'string',
                'max:200',
            ],
            // Honeypot fields
            'website' => 'prohibited',
            'url' => 'prohibited',
            'homepage' => 'prohibited',
            'bot_field' => 'prohibited',
            'spam_check' => 'prohibited',
            // Timing check
            'form_start_time' => 'nullable|integer',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'The name field may only contain letters, spaces, hyphens, and periods.',
            'email.email' => 'Please provide a valid email address.',
            'phone.regex' => 'Please provide a valid phone number.',
            'message.not_regex' => 'Please do not include URLs or inappropriate content in your message.',
            'message.min' => 'Your message must be at least 10 characters long.',
            'service_area.exists' => 'Please select a valid service area.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean and normalize input data
        $this->merge([
            'name' => $this->sanitizeInput($this->name),
            'email' => strtolower(trim($this->email)),
            'phone' => $this->sanitizePhone($this->phone),
            'message' => $this->sanitizeInput($this->message),
            'subject' => $this->sanitizeInput($this->subject),
        ]);
    }

    /**
     * Sanitize general input to prevent XSS and normalize content
     */
    private function sanitizeInput(?string $input): ?string
    {
        if (!$input) {
            return null;
        }

        // Remove HTML tags and normalize whitespace
        $clean = strip_tags(trim($input));
        $clean = preg_replace('/\s+/', ' ', $clean);

        return $clean;
    }

    /**
     * Sanitize phone number input
     */
    private function sanitizePhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        // Remove all non-digit characters except +, spaces, hyphens, and parentheses
        return preg_replace('/[^+\d\s\-\(\)]/', '', trim($phone));
    }
}