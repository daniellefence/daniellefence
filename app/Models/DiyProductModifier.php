<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiyProductModifier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'diy_product_id',
        'available_color_id',
        'available_height_id',
        'available_spacing_id',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function diyProduct(): BelongsTo
    {
        return $this->belongsTo(DiyProduct::class);
    }

    public function availableColor(): BelongsTo
    {
        return $this->belongsTo(AvailableColor::class);
    }

    public function availableHeight(): BelongsTo
    {
        return $this->belongsTo(AvailableHeight::class);
    }

    public function availableSpacing(): BelongsTo
    {
        return $this->belongsTo(AvailableSpacing::class);
    }

    public function diyProductPhotos(): HasMany
    {
        return $this->hasMany(DiyProductPhoto::class);
    }

    public function diyOrderItems(): HasMany
    {
        return $this->hasMany(DiyOrderItem::class);
    }

    // Calculate the final price for this configuration
    public function calculatePrice(): float
    {
        $product = $this->diyProduct;
        $color = $this->availableColor;
        $height = $this->availableHeight;
        $spacing = $this->availableSpacing;

        // Base + absolute costs
        $subtotal = $product->base_price
            + $height->price_per_panel
            + $spacing->price_per_panel;

        // Apply color percentage
        $finalPrice = $subtotal * (1 + ($color->price_percentage / 100));

        return round($finalPrice, 2);
    }
}