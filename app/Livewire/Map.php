<?php

namespace App\Livewire;

use Livewire\Component;

class Map extends Component
{
    public $show_text = true;

    public function mount($show_text = true)
    {
        $this->show_text = $show_text;
    }

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function render()
    {
        return view('livewire.map');
    }
}
