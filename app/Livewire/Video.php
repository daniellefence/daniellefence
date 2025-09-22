<?php

namespace App\Livewire;

use Livewire\Component;

class Video extends Component
{
    public $video;

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function mount($video)
    {
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.video', [
            'video' => $this->video,
        ]);
    }
}
