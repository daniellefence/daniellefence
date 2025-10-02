<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiyOrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'diy_order_id',
        'diy_product_modifier_id',
        'quantity',
        'unit_price',
        'line_total',
        'custom_notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function diyOrder(): BelongsTo
    {
        return $this->belongsTo(DiyOrder::class);
    }

    public function diyProductModifier(): BelongsTo
    {
        return $this->belongsTo(DiyProductModifier::class);
    }
}