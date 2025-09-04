<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductVariant extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'color',
        'height',
        'picket_width',
        'material',
        'finish',
        'price_modifier',
        'price_modifier_type',
        'stock_quantity',
        'low_stock_threshold',
        'weight',
        'dimensions',
        'is_active',
        'sort_order',
        'meta_data',
        'images',
        'gallery',
        'technical_drawings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_modifier' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'meta_data' => 'array',
        'images' => 'array',
        'gallery' => 'array',
        'technical_drawings' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'sku', 'color', 'height', 'picket_width', 'price_modifier', 'is_active'])
            ->logOnlyDirty();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFullNameAttribute(): string
    {
        $parts = array_filter([
            $this->product?->name,
            $this->color,
            $this->height,
            $this->picket_width,
            $this->material,
            $this->finish,
        ]);

        return implode(' - ', $parts);
    }

    public function getCalculatedPriceAttribute(): float
    {
        $basePrice = $this->product?->base_price ?? 0;
        
        if ($this->price_modifier_type === 'percentage') {
            return $basePrice + ($basePrice * ($this->price_modifier / 100));
        }
        
        return $basePrice + $this->price_modifier;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->useDisk(config('media-library.disk_name', 'public'));

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->useDisk(config('media-library.disk_name', 'public'));

        $this->addMediaCollection('technical_drawings')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
            ->useDisk(config('media-library.disk_name', 'public'));
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->optimize()
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->optimize()
            ->nonQueued();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByColor($query, $color)
    {
        return $query->where('color', $color);
    }

    public function scopeByHeight($query, $height)
    {
        return $query->where('height', $height);
    }

    public function scopeByPicketWidth($query, $picketWidth)
    {
        return $query->where('picket_width', $picketWidth);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
    }
}