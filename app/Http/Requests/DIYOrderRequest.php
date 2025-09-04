<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class DIYOrderRequest extends FormRequest
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
        // Check rate limiting
        $key = 'diy-order:' . $this->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'rate_limit' => "Too many order attempts. Please try again in {$seconds} seconds."
            ]);
        }

        RateLimiter::hit($key, 3600); // 1 hour window
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                function ($attribute, $value, $fail) {
                    $product = \App\Models\Product::find($value);
                    if ($product && !$product->is_diy) {
                        $fail('Selected product is not available for DIY orders.');
                    }
                    if ($product && !$product->published) {
                        $fail('Selected product is not currently available.');
                    }
                },
            ],
            'quantity' => 'required|integer|min:1|max:100',
            'height' => 'required|string|max:20|regex:/^[0-9\'\"\s\-ft]+$/i',
            'width' => 'required|string|max:100|regex:/^[0-9\'\"\s\-ftlinear]+$/i',
            'color' => 'required|string|max:50|alpha_dash',
            
            // Customer information with sanitization
            'customer_name' => 'required|string|max:255|min:2|regex:/^[a-zA-Z\s\-\.]+$/',
            'customer_email' => 'required|email:rfc,dns|max:255',
            'customer_phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[1-9][\d]{0,15}$|^\([0-9]{3}\)\s?[0-9]{3}[-\.]?[0-9]{4}$|^[0-9]{3}[-\.]?[0-9]{3}[-\.]?[0-9]{4}$/'
            ],
            'customer_address' => 'required|string|max:255|min:5',
            'customer_city' => 'required|string|max:100|regex:/^[a-zA-Z\s\-\.]+$/',
            'customer_state' => 'required|string|size:2|alpha',
            'customer_zip' => 'required|string|regex:/^\d{5}(-\d{4})?$/',
            
            'notes' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'customer_name.regex' => 'Name may only contain letters, spaces, hyphens, and periods.',
            'customer_phone.regex' => 'Please enter a valid phone number format.',
            'customer_city.regex' => 'City name may only contain letters, spaces, hyphens, and periods.',
            'customer_state.size' => 'State must be a 2-letter code.',
            'customer_zip.regex' => 'ZIP code must be in format 12345 or 12345-1234.',
            'height.regex' => 'Height must be in a valid format (e.g., 6ft, 8\', etc.).',
            'width.regex' => 'Width must be in a valid format (e.g., 100 linear feet).',
            'quantity.max' => 'Maximum quantity per order is 100 units.',
        ];
    }

    /**
     * Get custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'customer_name' => 'full name',
            'customer_email' => 'email address',
            'customer_phone' => 'phone number',
            'customer_address' => 'street address',
            'customer_city' => 'city',
            'customer_state' => 'state',
            'customer_zip' => 'ZIP code',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Log validation failures for security monitoring
        \Illuminate\Support\Facades\Log::warning('DIY Order validation failed', [
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent(),
            'errors' => $validator->errors()->toArray(),
            'input' => $this->except(['customer_email', 'customer_phone']), // Don't log sensitive info
        ]);

        parent::failedValidation($validator);
    }
}
