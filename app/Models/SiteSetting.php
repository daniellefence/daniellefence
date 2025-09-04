<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SiteSetting extends Model
{
    use LogsActivity;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_public',
        'sort_order',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['key', 'value', 'type', 'group'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('site_settings');
        });

        static::deleted(function () {
            Cache::forget('site_settings');
        });
    }

    public static function get(string $key, $default = null)
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return static::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, $value, array $attributes = []): static
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            array_merge($attributes, ['value' => $value])
        );

        Cache::forget('site_settings');
        
        return $setting;
    }

    public function getProcessedValueAttribute()
    {
        if ($this->type === 'boolean') {
            return (bool) $this->value;
        } elseif ($this->type === 'json') {
            return json_decode($this->value, true);
        } elseif ($this->type === 'integer') {
            return (int) $this->value;
        } elseif ($this->type === 'float') {
            return (float) $this->value;
        } else {
            return $this->value;
        }
    }

    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('group')->orderBy('sort_order')->orderBy('label');
    }
}
