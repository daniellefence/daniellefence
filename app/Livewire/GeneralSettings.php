<?php

namespace App\Livewire;

use App\Models\GeneralSetting;
use Livewire\Component;

class GeneralSettings extends Component
{
    public $default_site_title;

    public $default_site_description;

    public $default_site_keywords;

    public $google_recaptcha_site_key;

    public $google_recaptcha_secret_key;

    public $fence_quote_recipient_emails;

    public $outdoor_kitchen_quote_recipient_emails;

    public $outdoor_spaces_quote_recipient_emails;

    public $pavers_quote_recipient_emails;

    public $contact_recipient_emails;

    public $career_recipient_email;

    public $from_email;

    public $app_title;

    public $analytics;

    public function mount()
    {
        foreach (GeneralSetting::all() as $setting) {
            $variable = $setting->key;
            $this->$variable = $setting->value;
        }
    }

    public function save()
    {
        foreach (GeneralSetting::all() as $setting) {
            $variable = $setting->key;
            $setting->value = $this->$variable;
            $setting->save();
        }
        $this->redirect(route('admin.general.read'));
    }

    public function render()
    {
        return view('livewire.general-settings', [
            'settings' => GeneralSetting::all(),
        ]);
    }
}
