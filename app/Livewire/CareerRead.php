<?php

namespace App\Livewire;

use App\Models\Career;
use Livewire\Component;

class CareerRead extends Component
{
    public $career;

    public function mount($id)
    {
        $this->career = Career::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.career-read');
    }
}
