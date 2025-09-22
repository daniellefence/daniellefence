<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'diy_product_id',
        'available_color_id',
        'available_spacing_id',
        'available_height_id',
        'price_modification_type',
        'price_modification_value',
        'is_active'
    ];

    protected $casts = [
        'price_modification_value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function diyProduct()
    {
        return $this->belongsTo(DiyProduct::class);
    }

    public function availableColor()
    {
        return $this->belongsTo(AvailableColor::class);
    }

    public function availableSpacing()
    {
        return $this->belongsTo(AvailableSpacing::class);
    }

    public function availableHeight()
    {
        return $this->belongsTo(AvailableHeight::class);
    }

    public function photos()
    {
        return $this->hasMany(ModifierPhoto::class)->orderBy('sort_order');
    }

    public function primaryPhoto()
    {
        return $this->hasOne(ModifierPhoto::class)->where('is_primary', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('diy_product_id', $productId);
    }

    // Helper Methods
    public function getModifierDescription()
    {
        $parts = [];

        if ($this->availableColor) {
            $parts[] = $this->availableColor->name;
        }

        if ($this->availableHeight) {
            $parts[] = $this->availableHeight->formatted_height;
        }

        if ($this->availableSpacing) {
            $parts[] = $this->availableSpacing->formatted_spacing;
        }

        return implode(' - ', $parts);
    }

    public function getPriceModificationFormatted()
    {
        if ($this->price_modification_type === 'percentage') {
            return ($this->price_modification_value >= 0 ? '+' : '') . $this->price_modification_value . '%';
        } else {
            return ($this->price_modification_value >= 0 ? '+$' : '-$') . abs($this->price_modification_value);
        }
    }
}
