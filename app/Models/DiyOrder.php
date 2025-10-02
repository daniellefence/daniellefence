<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiyOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'tax_amount',
        'total_amount',
        'status',
        'notes',
        'ordered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'ordered_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function diyOrderItems(): HasMany
    {
        return $this->hasMany(DiyOrderItem::class);
    }

    // Generate unique order number
    public static function generateOrderNumber(): string
    {
        $year = now()->year;
        $lastOrder = self::whereYear('created_at', $year)->latest()->first();
        $number = $lastOrder ? intval(substr($lastOrder->order_number, -4)) + 1 : 1;

        return 'DF-' . $year . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}