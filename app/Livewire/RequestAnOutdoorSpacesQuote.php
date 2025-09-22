<?php

namespace App\Livewire;

use App\Models\GeneralSetting;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestAnOutdoorSpacesQuote extends Component
{
    use WithFileUploads;

    public $product_name;

    public $design_options;

    public $size_of_area;

    public $will_you_need_pavers = 'No';

    public $features;

    public $additional_comments;

    public $first_name;

    public $last_name;

    public $phone_number;

    public $email;

    public $address_line_one;

    public $address_line_two;

    public $city;

    public $state;

    public $zip_code;

    public $captcha = 0;

    public $attachments = [];

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function submit()
    {
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
        $quoterequest = QuoteRequest::create([
            'product_name' => $this->product_name,
            'design_options' => $this->design_options,
            'size_of_area' => $this->size_of_area,
            'will_you_need_pavers' => $this->will_you_need_pavers,
            'features' => $this->features,
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
        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                $quoterequest->attachments()->create([
                    'path' => $attachment->store('attachments'),
                ]);
            }
        }
        danielle()->sendMail('outdoor_spaces_quote', $quoterequest);
        $this->redirect(route('thanks'));
    }

    public function updatedCaptcha($token)
    {
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.GeneralSetting::where([['key', '=', 'google_recaptcha_site_key']])->first()->value.'&response='.$token);
        $this->captcha = $response->json()['score'];

        if (! $this->captcha > .3) {
            $this->submit();
        } else {
            return session()->flash('success', 'Google thinks you are a bot, please refresh and try again');
        }
    }

    public function render()
    {
        return view('livewire.request-an-outdoor-spaces-quote');
    }
}
