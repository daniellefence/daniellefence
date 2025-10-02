<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiyProductPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'diy_product_id',
        'diy_product_modifier_id',
        'name',
        'file_path',
        'description',
        'is_default',
        'order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'order' => 'integer',
    ];

    public function diyProduct(): BelongsTo
    {
        return $this->belongsTo(DiyProduct::class);
    }

    public function diyProductModifier(): BelongsTo
    {
        return $this->belongsTo(DiyProductModifier::class);
    }
}