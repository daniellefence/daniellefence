<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DiyProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'diy_product_category_id',
        'name',
        'description',
        'slug',
        'base_price',
        'default_photo_url',
        'specifications',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(DiyProductCategory::class, 'diy_product_category_id');
    }

    public function modifiers()
    {
        return $this->hasMany(Modifier::class);
    }

    // Accessors & Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('diy_product_category_id', $categoryId);
    }

    // Helper Methods
    public function calculatePrice($colorId = null, $heightId = null, $spacingId = null)
    {
        $basePrice = $this->base_price;

        $modifier = $this->modifiers()
            ->where('available_color_id', $colorId)
            ->where('available_height_id', $heightId)
            ->where('available_spacing_id', $spacingId)
            ->where('is_active', true)
            ->first();

        if ($modifier) {
            if ($modifier->price_modification_type === 'percentage') {
                return $basePrice + ($basePrice * ($modifier->price_modification_value / 100));
            } else {
                return $basePrice + $modifier->price_modification_value;
            }
        }

        return $basePrice;
    }

    public function getAvailableColors()
    {
        return AvailableColor::whereHas('modifiers', function ($query) {
            $query->where('diy_product_id', $this->id)->where('is_active', true);
        })->where('is_active', true)->get();
    }

    public function getAvailableHeights()
    {
        return AvailableHeight::whereHas('modifiers', function ($query) {
            $query->where('diy_product_id', $this->id)->where('is_active', true);
        })->where('is_active', true)->get();
    }

    public function getAvailableSpacings()
    {
        return AvailableSpacing::whereHas('modifiers', function ($query) {
            $query->where('diy_product_id', $this->id)->where('is_active', true);
        })->where('is_active', true)->get();
    }
}
