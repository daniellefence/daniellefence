<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

/**
 * Livewire component for the company showroom display.
 *
 * This component handles the presentation of the physical showroom,
 * displaying company information, location details, and serving as
 * a simple view component for the showroom page.
 *
 * @package App\Livewire
 * @author Shane Barron
 */
class Showroom extends Component
{
    /**
     * Render the showroom component.
     *
     * @return View The component's view
     */
    public function render()
    {
        return view('livewire.showroom');
    }
}
