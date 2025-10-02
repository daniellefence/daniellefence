<?php

namespace App\Livewire;

use App\Models\AvailableColor;
use App\Models\AvailableHeight;
use App\Models\AvailableSpacing;
use App\Models\DiyProduct;
use App\Models\DiyProductModifier;
use Livewire\Component;

class ProductConfigurator extends Component
{
    public DiyProduct $product;
    public $selectedColorId = null;
    public $selectedHeightId = null;
    public $selectedSpacingId = null;
    public $quantity = 1;
    public $currentPhotoUrl = null;

    // Available options based on product modifiers
    public $availableColors = [];
    public $availableHeights = [];
    public $availableSpacings = [];

    public function mount(DiyProduct $product)
    {
        $this->product = $product->load([
            'diyCategory',
            'diyProductPhotos',
            'diyProductModifiers.availableColor',
            'diyProductModifiers.availableHeight',
            'diyProductModifiers.availableSpacing',
            'product.photos',
        ]);

        // Get unique available options from modifiers
        $this->availableColors = $this->product->diyProductModifiers
            ->pluck('availableColor')
            ->unique('id')
            ->sortBy('name')
            ->values();

        $this->availableHeights = $this->product->diyProductModifiers
            ->pluck('availableHeight')
            ->unique('id')
            ->sortBy('name')
            ->values();

        $this->availableSpacings = $this->product->diyProductModifiers
            ->pluck('availableSpacing')
            ->unique('id')
            ->sortBy('name')
            ->values();

        // Check if color was passed via URL parameter
        $colorId = request()->query('color');
        if ($colorId && $this->availableColors->contains('id', $colorId)) {
            $this->selectedColorId = (int) $colorId;
            $this->updatePhoto();
        } else {
            // Set default photo from media library
            $this->currentPhotoUrl = $this->product->hasMedia('product-photos')
                ? $this->product->getFirstMediaUrl('product-photos')
                : null;
        }
    }

    public function updatedSelectedColorId()
    {
        $this->updatePhoto();
        $this->updateAvailableOptions();
    }

    public function updatedSelectedHeightId()
    {
        $this->updatePhoto();
        $this->updateAvailableOptions();
    }

    public function updatedSelectedSpacingId()
    {
        $this->updatePhoto();
    }

    public function updateAvailableOptions()
    {
        // When color is selected, filter available heights
        if ($this->selectedColorId) {
            $this->availableHeights = $this->product->diyProductModifiers
                ->where('available_color_id', $this->selectedColorId)
                ->pluck('availableHeight')
                ->unique('id')
                ->sortBy('name')
                ->values();
        }

        // When color and height are selected, filter available spacings
        if ($this->selectedColorId && $this->selectedHeightId) {
            $this->availableSpacings = $this->product->diyProductModifiers
                ->where('available_color_id', $this->selectedColorId)
                ->where('available_height_id', $this->selectedHeightId)
                ->pluck('availableSpacing')
                ->unique('id')
                ->sortBy('name')
                ->values();
        }
    }

    public function updatePhoto()
    {
        // If color is selected, find photo matching that color
        if ($this->selectedColorId) {
            $selectedColor = AvailableColor::find($this->selectedColorId);

            if ($selectedColor) {
                // Find product photo with matching color name in custom properties
                $colorPhoto = $this->product->getMedia('product-photos')->first(function($media) use ($selectedColor) {
                    $colorName = $media->custom_properties['color_name'] ?? null;
                    return $colorName && strtolower($colorName) === strtolower($selectedColor->name);
                });

                // If found, use color-specific photo
                if ($colorPhoto) {
                    $this->currentPhotoUrl = $colorPhoto->getUrl();
                    return;
                }
            }
        }

        // Fallback to first product photo
        $this->currentPhotoUrl = $this->product->hasMedia('product-photos')
            ? $this->product->getFirstMediaUrl('product-photos')
            : null;
    }

    public function calculatePrice()
    {
        // Base price
        $basePrice = $this->product->base_price;

        // Get selected options
        $color = $this->selectedColorId ? AvailableColor::find($this->selectedColorId) : null;
        $height = $this->selectedHeightId ? AvailableHeight::find($this->selectedHeightId) : null;
        $spacing = $this->selectedSpacingId ? AvailableSpacing::find($this->selectedSpacingId) : null;

        // Calculate using the correct order: base + absolute amounts, then apply percentage
        $subtotalBeforeColor = $basePrice;

        if ($height) {
            $subtotalBeforeColor += $height->price_per_panel;
        }

        if ($spacing) {
            $subtotalBeforeColor += $spacing->price_per_panel;
        }

        // Apply color percentage to subtotal
        $pricePerPanel = $subtotalBeforeColor;
        if ($color && $color->price_percentage > 0) {
            $pricePerPanel = $subtotalBeforeColor * (1 + ($color->price_percentage / 100));
        }

        return $pricePerPanel;
    }

    public function getTotalPrice()
    {
        return $this->calculatePrice() * $this->quantity;
    }

    public function addToCart()
    {
        // Validate that all options are selected
        $this->validate([
            'selectedColorId' => 'required',
            'selectedHeightId' => 'required',
            'selectedSpacingId' => 'required',
            'quantity' => 'required|integer|min:1',
        ], [
            'selectedColorId.required' => 'Please select a color',
            'selectedHeightId.required' => 'Please select a height',
            'selectedSpacingId.required' => 'Please select a spacing',
            'quantity.required' => 'Please enter a quantity',
            'quantity.min' => 'Quantity must be at least 1',
        ]);

        // TODO: Implement cart functionality
        session()->flash('message', 'Product added to cart! (Cart functionality coming soon)');
    }

    public function render()
    {
        return view('livewire.product-configurator', [
            'pricePerPanel' => $this->calculatePrice(),
            'totalPrice' => $this->getTotalPrice(),
        ]);
    }
}