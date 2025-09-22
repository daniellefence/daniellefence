<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableSpacing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value_feet',
        'display_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value_feet' => 'decimal:2',
    ];

    // Relationships
    public function modifiers()
    {
        return $this->hasMany(Modifier::class);
    }

    // Accessors
    public function getFormattedSpacingAttribute()
    {
        return $this->value_feet . "' OC";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('value_feet');
    }
}
