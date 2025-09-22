<?php

namespace App\Livewire;

use Livewire\Component;

class RequestAQuote extends Component
{
    public $type = 'fence';

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function setType($type)
    {
        $this->type = $type;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.request-a-quote');
    }
}
