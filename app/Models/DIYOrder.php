<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DIYOrder extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'diy_orders';

    protected $fillable = [
        'order_number',
        'product_id',
        'quantity',
        'specifications',
        'customer_info',
        'notes',
        'status',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'specifications' => 'array',
        'customer_info' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Status options for DIY orders
     */
    const STATUS_OPTIONS = [
        'pending' => 'Pending Review',
        'processing' => 'Processing',
        'ready' => 'Ready for Pickup',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    /**
     * Get the product associated with this order
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who processed this order
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get customer name from JSON
     */
    public function getCustomerNameAttribute()
    {
        return $this->customer_info['name'] ?? 'Unknown';
    }

    /**
     * Get customer email from JSON
     */
    public function getCustomerEmailAttribute()
    {
        return $this->customer_info['email'] ?? null;
    }

    /**
     * Get customer phone from JSON
     */
    public function getCustomerPhoneAttribute()
    {
        return $this->customer_info['phone'] ?? null;
    }

    /**
     * Get full customer address
     */
    public function getCustomerAddressAttribute()
    {
        $info = $this->customer_info;
        
        if (!$info) {
            return null;
        }

        return sprintf(
            "%s, %s, %s %s",
            $info['address'] ?? '',
            $info['city'] ?? '',
            $info['state'] ?? '',
            $info['zip'] ?? ''
        );
    }

    /**
     * Check if order is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if order is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Mark order as processed
     */
    public function markAsProcessed($userId = null)
    {
        $this->status = 'processing';
        $this->processed_by = $userId;
        $this->processed_at = now();
        $this->save();

        return $this;
    }

    /**
     * Get formatted order specifications
     */
    public function getFormattedSpecifications()
    {
        $specs = $this->specifications;
        
        if (!$specs) {
            return 'No specifications provided';
        }

        $formatted = [];
        
        if (isset($specs['height'])) {
            $formatted[] = "Height: " . $specs['height'];
        }
        
        if (isset($specs['width'])) {
            $formatted[] = "Width: " . $specs['width'];
        }
        
        if (isset($specs['color'])) {
            $formatted[] = "Color: " . $specs['color'];
        }

        return implode(' | ', $formatted);
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for today's orders
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for this week's orders
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    /**
     * Activity Log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
