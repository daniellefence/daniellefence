<?php

namespace App\Livewire;

use Livewire\Component;

class Footer extends Component
{
    public $show_mascot = true;

    public $show_text = true;

    public $show_map = false;

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function mount()
    {
        // Only show map on home page
        if (\Illuminate\Support\Facades\Route::currentRouteName() == 'home') {
            $this->show_map = true;
        }

        if (\Illuminate\Support\Facades\Route::currentRouteName() == 'showroom') {
            $this->show_mascot = false;
            $this->show_text = false;
        }
    }

    public function render()
    {
        return view('livewire.footer');
    }
}
