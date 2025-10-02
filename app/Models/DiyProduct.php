<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DiyProduct extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'diy_category_id',
        'product_id',
        'name',
        'description',
        'base_price',
        'is_best_seller',
        'order',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_best_seller' => 'boolean',
        'order' => 'integer',
    ];

    public function diyCategory(): BelongsTo
    {
        return $this->belongsTo(DiyCategory::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function diyProductPhotos(): HasMany
    {
        return $this->hasMany(DiyProductPhoto::class)->orderBy('order');
    }

    public function diyProductModifiers(): HasMany
    {
        return $this->hasMany(DiyProductModifier::class);
    }

    public function defaultPhoto()
    {
        return $this->hasOne(DiyProductPhoto::class)->where('is_default', true);
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            DiyProduct::class,
            'diy_product_related',
            'diy_product_id',
            'related_product_id'
        )->withPivot('order')->orderBy('diy_product_related.order');
    }
}