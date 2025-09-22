<?php

namespace App\Livewire;

use Livewire\Component;

class AreasWeServe extends Component
{
    public $areas = [];

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function mount()
    {
        $this->areas = \App\Models\AreasWeServe::published()
            ->whereNotNull('slug')
            ->orderBy('title', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.areas-we-serve');
    }
}
