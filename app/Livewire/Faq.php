<?php

namespace App\Livewire;

use Livewire\Component;

class Faq extends Component
{
    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function render()
    {
        return view('livewire.faq');
    }
}
