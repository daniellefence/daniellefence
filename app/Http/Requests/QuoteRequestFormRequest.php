<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuoteRequestFormRequest extends FormRequest
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
                'regex:/^[a-zA-Z\s\-\.]+$/',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'not_regex:/\+.*\+/',
            ],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:20',
                'regex:/^[\+]?[\d\s\-\(\)\.]+$/',
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:200',
            ],
            'city' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Z\s\-\.]+$/',
            ],
            'state' => [
                'required',
                'string',
                'size:2',
                'regex:/^[A-Z]{2}$/',
            ],
            'zip' => [
                'required',
                'string',
                'regex:/^\d{5}(-\d{4})?$/', // US ZIP code format
            ],
            'service_type' => [
                'required',
                'string',
                Rule::in([
                    'residential_fencing',
                    'commercial_fencing',
                    'outdoor_kitchen',
                    'pavers',
                    'fire_features',
                    'outdoor_living',
                    'deck_building',
                    'other'
                ]),
            ],
            'description' => [
                'required',
                'string',
                'min:20',
                'max:3000',
                'not_regex:/https?:\/\//',
                'not_regex:/\b(?:viagra|cialis|casino|poker|loan|credit|debt)\b/i/',
            ],
            'preferred_contact' => [
                'required',
                'string',
                Rule::in(['phone', 'email', 'text']),
            ],
            'budget_range' => [
                'nullable',
                'string',
                Rule::in([
                    'under_5000',
                    '5000_10000',
                    '10000_25000',
                    '25000_50000',
                    'over_50000'
                ]),
            ],
            'timeline' => [
                'nullable',
                'string',
                Rule::in([
                    'asap',
                    'within_month',
                    'within_3_months',
                    'within_6_months',
                    'flexible'
                ]),
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
            'city.regex' => 'The city field may only contain letters, spaces, hyphens, and periods.',
            'state.regex' => 'Please provide a valid 2-letter state code.',
            'zip.regex' => 'Please provide a valid ZIP code (e.g., 12345 or 12345-6789).',
            'description.not_regex' => 'Please do not include URLs or inappropriate content in your description.',
            'description.min' => 'Please provide a more detailed description (at least 20 characters).',
            'service_type.in' => 'Please select a valid service type.',
            'preferred_contact.in' => 'Please select a valid contact preference.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->sanitizeInput($this->name),
            'email' => strtolower(trim($this->email)),
            'phone' => $this->sanitizePhone($this->phone),
            'address' => $this->sanitizeInput($this->address),
            'city' => $this->sanitizeInput($this->city),
            'state' => strtoupper(trim($this->state)),
            'zip' => trim($this->zip),
            'description' => $this->sanitizeInput($this->description),
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

        return preg_replace('/[^+\d\s\-\(\)]/', '', trim($phone));
    }
}