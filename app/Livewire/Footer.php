<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * Livewire component for rendering the website footer.
 *
 * This component dynamically adjusts footer elements based on the current page,
 * controlling the display of mascot images, text content, and interactive maps.
 * It provides responsive footer content that adapts to different page contexts.
 *
 * @package App\Livewire
 * @author Shane Barron
 */
class Footer extends Component
{
    /**
     * Whether to show the company mascot in the footer.
     *
     * @var bool Default true, disabled on showroom page
     */
    public $show_mascot = true;

    /**
     * Whether to show text content in the footer.
     *
     * @var bool Default true, disabled on showroom page
     */
    public $show_text = true;

    /**
     * Whether to show the interactive map in the footer.
     *
     * @var bool Default false, enabled only on home page
     */
    public $show_map = false;

    /**
     * Return a placeholder view while the component loads.
     *
     * This method is used for lazy loading to improve page performance
     * by showing a loading indicator until the component is fully rendered.
     *
     * @return \Illuminate\View\View The lazy loader placeholder view
     */
    public function placeholder()
    {
        return view('lazy-loader');
    }

    /**
     * Initialize the component based on the current route.
     *
     * Configures which footer elements to display based on the current page:
     * - Home page: Shows map for location display
     * - Showroom page: Minimizes footer by hiding mascot and text
     * - Other pages: Shows standard footer elements
     *
     * @return void
     */
    public function mount()
    {
        // Only show map on home page for location awareness
        if (\Illuminate\Support\Facades\Route::currentRouteName() == 'home') {
            $this->show_map = true;
        }

        // Minimize footer on showroom page to focus on products
        if (\Illuminate\Support\Facades\Route::currentRouteName() == 'showroom') {
            $this->show_mascot = false;
            $this->show_text = false;
        }
    }

    /**
     * Render the footer component.
     *
     * @return \Illuminate\View\View The component's view
     */
    public function render()
    {
        return view('livewire.footer');
    }
}
