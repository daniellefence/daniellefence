<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableHeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value_feet',
        'value_inches',
        'display_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value_feet' => 'integer',
        'value_inches' => 'integer',
    ];

    // Relationships
    public function modifiers()
    {
        return $this->hasMany(Modifier::class);
    }

    // Accessors
    public function getTotalInchesAttribute()
    {
        return ($this->value_feet * 12) + $this->value_inches;
    }

    public function getFormattedHeightAttribute()
    {
        if ($this->value_inches > 0) {
            return $this->value_feet . "'" . $this->value_inches . '"';
        }
        return $this->value_feet . "'";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('value_feet')->orderBy('value_inches');
    }
}
