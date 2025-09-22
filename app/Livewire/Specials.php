<?php

namespace App\Livewire;

use App\Models\Special;
use Livewire\Component;

class Specials extends Component
{
    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function render()
    {
        return view('livewire.specials', [
            'specials' => Special::all(),
        ]);
    }
}
