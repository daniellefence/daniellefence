<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;

class QuoteRequest extends Model
{
    use HasFactory, LogsActivity, HasTags;

    protected $fillable = [
        'contact_id','product_id','status','details','color','height','picket_width','base_price','calculated_price','customer_satisfaction_rating','service_notes'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'calculated_price' => 'decimal:2',
        'customer_satisfaction_rating' => 'decimal:1',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status','details','color','height','picket_width','calculated_price'])
            ->logOnlyDirty();
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
