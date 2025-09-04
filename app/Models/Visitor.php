<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Visitor extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'ip_address',
        'anonymized_ip',
        'user_agent',
        'country',
        'city',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['ip_address', 'country', 'city', 'visited_at'])
            ->logOnlyDirty();
    }

    public function scopeFromCountry($query, string $country)
    {
        return $query->where('country', $country);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('visited_at', now()->month);
    }
}
