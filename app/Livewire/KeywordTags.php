<?php

namespace App\Livewire;

use Livewire\Component;

class KeywordTags extends Component
{
    public $keywords = [];

    public $count = 0;

    public $styles = [
        'bg-white text-danielle1',
    ];

    public $clickable = false;

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function mount($model, $clickable = false)
    {
        if (is_array($model)) {
            $this->keywords = $model;
            $this->clickable = false;
        } else {
            $this->keywords = danielle()->parseKeywords($model);
            $this->clickable = true;
        }
    }

    public function render()
    {
        return view('livewire.keyword-tags');
    }
}
