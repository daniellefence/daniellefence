<?php

namespace App\Livewire;

use Livewire\Component;

class KeywordTags extends Component
{
    public $tags = [];

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
            $this->tags = $model;
            $this->clickable = false;
        } else {
            // Load tags from the model's tags relationship
            if (method_exists($model, 'tags')) {
                $this->tags = $model->tags->pluck('name')->toArray();
                $this->clickable = true;
            } else {
                $this->tags = [];
                $this->clickable = false;
            }
        }
    }

    public function render()
    {
        return view('livewire.keyword-tags');
    }
}
