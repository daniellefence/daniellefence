<?php

namespace App\Livewire;

use App\Models\Career;
use Livewire\Component;

class Careers extends Component
{
    public $selectedCareer;

    public $showModal = false;

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function showModalFunction($id)
    {
        $this->selectedCareer = Career::findOrFail($id);
        $this->showModal = true;
    }

    public function hideModalFunction()
    {
        $this->reset();
    }

    public function render()
    {
        $careers = Career::where('published', 1)
            ->orderBy('order', 'asc')
            ->get();

        return view('livewire.careers', [
            'careers' => $careers
        ]);
    }
}
