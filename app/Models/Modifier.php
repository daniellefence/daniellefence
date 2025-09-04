<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Modifier extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'product_id','type','attribute','value','operation'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['type','attribute','value','operation'])
            ->logOnlyDirty();
    }

    /**
     * operation: 'percent' or 'fixed'
     * attribute: 'color' | 'height' | 'picket_width'
     * value: e.g. 'white' or '6ft' or '3in'
     * type: 'add' | 'subtract'
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
