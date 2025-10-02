<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvailableSpacing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price_per_panel',
        'order',
    ];

    protected $casts = [
        'price_per_panel' => 'decimal:2',
        'order' => 'integer',
    ];

    public function diyProductModifiers(): HasMany
    {
        return $this->hasMany(DiyProductModifier::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}