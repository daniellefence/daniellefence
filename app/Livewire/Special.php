<?php

namespace App\Livewire;

use Livewire\Component;

class Special extends Component
{
    public $special;

    public function mount($id)
    {
        $this->special = \App\Models\Special::find($id);
    }

    public function render()
    {
        return view('livewire.special');
    }
}
