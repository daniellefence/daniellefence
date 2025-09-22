<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AreasWeServe extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title',
        'slug',
        'county',
        'meta_title',
        'meta_description',
        'page_content',
        'services_content',
        'latitude',
        'longitude',
        'published',
        'sort_order'
    ];

    protected $casts = [
        'published' => 'boolean',
        'sort_order' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function generateSlug()
    {
        $baseSlug = Str::slug($this->title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function getMetaTitleAttribute($value)
    {
        return $value ?: "Fence Installation in {$this->title}, FL | Danielle Fence";
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: "Professional fence installation services in {$this->title}, Florida. Commercial & residential fencing, vinyl, wood, chain link. Licensed & insured. Free estimates!";
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeByCounty($query, $county)
    {
        return $query->where('county', $county);
    }

    public function getMapBackgroundUrl($width = 1920, $height = 1080, $zoom = 11)
    {
        $apiKey = config('services.google_maps.api_key');
        if (!$apiKey) {
            return null;
        }

        // Use specific coordinates if available, otherwise fallback to Central Florida
        $latitude = $this->latitude ?: 28.0836; // Central Florida latitude (Orlando area)
        $longitude = $this->longitude ?: -81.2728; // Central Florida longitude (Orlando area)

        // Adjust zoom for fallback map to show more of Central Florida
        $mapZoom = ($this->latitude && $this->longitude) ? $zoom : 8;

        // Generate Google Static Maps API URL
        $params = http_build_query([
            'center' => "{$latitude},{$longitude}",
            'zoom' => $mapZoom,
            'size' => "{$width}x{$height}",
            'maptype' => 'roadmap',
            'style' => [
                'feature:administrative|element:labels.text.fill|color:0x444444',
                'feature:landscape|element:all|color:0xf2f2f2',
                'feature:poi|element:all|visibility:off',
                'feature:road|element:all|saturation:-100|lightness:45',
                'feature:road.highway|element:all|visibility:simplified',
                'feature:road.arterial|element:labels.icon|visibility:off',
                'feature:transit|element:all|visibility:off',
                'feature:water|element:all|color:0x46bcec|visibility:on'
            ],
            'key' => $apiKey
        ]);

        return "https://maps.googleapis.com/maps/api/staticmap?" . $params;
    }

    public function hasCoordinates()
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    public function hasMapDisplay()
    {
        // Always return true since we have fallback to Central Florida map
        return !is_null(config('services.google_maps.api_key'));
    }
}
