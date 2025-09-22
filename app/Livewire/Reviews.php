<?php

namespace App\Livewire;

use Livewire\Component;

class Reviews extends Component
{
    public $reviews;

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function mount()
    {
        $array = \App\Models\Review::with('photos')->where([['hidden', '==', 0]])->orderBy('order', 'asc')->take(30)->get()->toArray();
        $count = 10; // 10 reviews per column
        $this->reviews = array_chunk($array, $count);
    }

    public function render()
    {
        return view('livewire.reviews');
    }
}
