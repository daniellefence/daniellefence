<?php

namespace App\Livewire;

use App\Models\GeneralSetting;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestAFenceQuote extends Component
{
    use WithFileUploads;

    public $fence_type = 'PVCVinyl';

    public $style_options;

    public $haul_away = 'No';

    public $fence_height = '48';

    public $how_many_gates;

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

    public $attachments = [];

    public $captcha = 0;

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
        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                $quoterequest->attachments()->create([
                    'path' => $attachment->store('attachments'),
                ]);
            }
        }
        danielle()->sendMail('fence_quote', $quoterequest);

        return redirect(route('thanks'));
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

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function render()
    {
        return view('livewire.request-a-fence-quote');
    }
}
