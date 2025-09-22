<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ModifierPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'modifier_id',
        'photo_url',
        'alt_text',
        'sort_order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relationships
    public function modifier()
    {
        return $this->belongsTo(Modifier::class);
    }

    // Accessors
    public function getFullUrlAttribute()
    {
        if (str_starts_with($this->photo_url, 'http')) {
            return $this->photo_url;
        }
        return Storage::url($this->photo_url);
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
}
