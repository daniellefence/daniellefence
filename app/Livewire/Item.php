<?php

namespace App\Livewire;

use Livewire\Component;

class Item extends Component
{
    public $item;

    public function mount($item)
    {
        $this->item = $item;
    }

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function render()
    {
        return view('livewire.item');
    }
}
