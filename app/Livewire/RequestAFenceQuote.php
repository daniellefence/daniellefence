<?php

namespace App\Livewire;

use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\GeneralSetting;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Livewire component for handling fence quote requests.
 *
 * This component provides a comprehensive form for customers to request fence installation quotes,
 * including fence specifications, customer information, file attachments, and reCAPTCHA validation.
 * Upon submission, it creates a quote request record and sends notification emails.
 *
 * @package App\Livewire
 * @author Shane Barron
 */
class RequestAFenceQuote extends Component
{
    use WithFileUploads;

    /**
     * The type of fence being requested.
     *
     * @var string Default fence type is PVC/Vinyl
     */
    public $fence_type = 'PVCVinyl';

    /**
     * Style options for the fence.
     *
     * @var string|null Additional style preferences
     */
    public $style_options;

    /**
     * Whether customer wants old fence hauled away.
     *
     * @var string Default is 'No'
     */
    public $haul_away = 'No';

    /**
     * Height of the fence in inches.
     *
     * @var string Default is 48 inches
     */
    public $fence_height = '48';

    /**
     * Number of gates needed.
     *
     * @var int|null Number of gates to install
     */
    public $how_many_gates;

    /**
     * Additional comments or special requests.
     *
     * @var string|null Customer's additional requirements
     */
    public $additional_comments;

    /**
     * Customer's first name.
     *
     * @var string|null Required field for quote request
     */
    public $first_name;

    /**
     * Customer's last name.
     *
     * @var string|null Required field for quote request
     */
    public $last_name;

    /**
     * Customer's phone number.
     *
     * @var string|null Required field for contact
     */
    public $phone_number;

    /**
     * Customer's email address.
     *
     * @var string|null Required field for communication
     */
    public $email;

    /**
     * First line of customer's address.
     *
     * @var string|null Required for project location
     */
    public $address_line_one;

    /**
     * Second line of customer's address (optional).
     *
     * @var string|null Optional address line for apartments, suites, etc.
     */
    public $address_line_two;

    /**
     * City of the project location.
     *
     * @var string|null Required for service area verification
     */
    public $city;

    /**
     * State of the project location.
     *
     * @var string|null Required for service area verification
     */
    public $state;

    /**
     * ZIP code of the project location.
     *
     * @var string|null Required for accurate quotes
     */
    public $zip_code;

    /**
     * File attachments (photos, plans, etc.).
     *
     * @var array Collection of uploaded files
     */
    public $attachments = [];

    /**
     * Google reCAPTCHA score.
     *
     * @var float Score from reCAPTCHA validation (0-1)
     */
    public $captcha = 0;

    /**
     * Submit the fence quote request form.
     *
     * Validates the form data, creates a quote request record, handles file attachments,
     * sends notification emails, and redirects to the thank you page.
     *
     * @return RedirectResponse Redirects to thank you page
     * @throws ValidationException If validation fails
     */
    public function submit()
    {
        // Validate required customer information
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'address_line_one' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
        ]);

        // Create the quote request record
        $quoterequest = QuoteRequest::create([
            'haul_away' => $this->haul_away,
            'fence_height' => $this->fence_height,
            'fence_type' => $this->fence_type,
            'style_options' => $this->style_options,
            'how_many_gates' => $this->how_many_gates,
            'additional_comments' => $this->additional_comments,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address_line_one' => $this->address_line_one,
            'address_line_two' => $this->address_line_two,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ]);

        // Handle file attachments if any were uploaded
        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                $quoterequest->attachments()->create([
                    'path' => $attachment->store('attachments'),
                ]);
            }
        }

        // Send notification email using the Danielle helper
        danielle()->sendMail('fence_quote', $quoterequest);

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
        $secretKey = GeneralSetting::where('key', 'google_recaptcha_site_key')->first()->value;

        // Verify the token with Google's reCAPTCHA API
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$token);
        $this->captcha = $response->json()['score'];

        // If score is acceptable (higher than 0.3), proceed with submission
        if ($this->captcha > 0.3) {
            $this->submit();
        } else {
            // Score too low, likely a bot
            return session()->flash('success', 'Google thinks you are a bot, please refresh and try again');
        }
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
     * Render the fence quote request form component.
     *
     * @return View The component's view
     */
    public function render()
    {
        return view('livewire.request-a-fence-quote');
    }
}
