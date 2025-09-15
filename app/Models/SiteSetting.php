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
        $requiredKeys = static::getRequiredKeys();
        
        // If this is a required key and it doesn't exist, create it
        if (array_key_exists($key, $requiredKeys)) {
            $setting = static::where('key', $key)->first();
            if (!$setting) {
                static::create(array_merge(['key' => $key], $requiredKeys[$key]));
                Cache::forget('site_settings');
            }
        }
        
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

    /**
     * Required site setting keys that must always exist
     */
    public static function getRequiredKeys(): array
    {
        return [
            'site_title' => [
                'value' => 'Danielle Fence Company',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Default Site Title',
                'description' => 'The default title for your website. Used when no specific page title is set.',
                'is_public' => true,
                'sort_order' => 1,
            ],
            'site_description' => [
                'value' => 'Professional fence installation and DIY supplies. Nearly 50 years of excellence serving Central Florida with quality American-made materials.',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Default Site Description',
                'description' => 'The default meta description for your website. Keep it under 160 characters.',
                'is_public' => true,
                'sort_order' => 2,
            ],
            'site_keywords' => [
                'value' => 'fence installation, DIY fence kits, fence repair, residential fencing, commercial fencing, fence contractor, Central Florida, Lakeland',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Default Site Keywords',
                'description' => 'Default meta keywords for your website. Separate with commas.',
                'is_public' => true,
                'sort_order' => 3,
            ],
        ];
    }

    /**
     * Ensure all required settings exist with default values
     */
    public static function ensureRequiredKeysExist(): void
    {
        $requiredKeys = static::getRequiredKeys();
        
        foreach ($requiredKeys as $key => $defaults) {
            static::updateOrCreate(
                ['key' => $key],
                $defaults
            );
        }
        
        // Clear cache after ensuring keys exist
        Cache::forget('site_settings');
    }

}
