<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Video;
use Livewire\Component;

class Read extends Component
{
    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function render()
    {
        return view('livewire.admin.videos.read', [
            'videos' => Video::all(),
        ]);
    }
}
