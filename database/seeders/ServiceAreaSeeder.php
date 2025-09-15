<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceArea;
use Illuminate\Support\Str;

class ServiceAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceAreas = [
            [
                'name' => 'Lakeland',
                'slug' => 'lakeland',
                'description' => 'Professional fence installation and DIY supplies for Lakeland, Florida',
                'state' => 'Florida',
                'county' => 'Polk',
                'latitude' => 28.0395,
                'longitude' => -81.9498,
                'radius_miles' => 15,
                'is_primary' => true,
                'is_active' => true,
                'sort_order' => 1,
                'zip_codes' => ['33801', '33803', '33805', '33809', '33810', '33811', '33813'],
            ],
            [
                'name' => 'Tampa',
                'slug' => 'tampa',
                'description' => 'Fence services for the greater Tampa Bay area',
                'state' => 'Florida',
                'county' => 'Hillsborough',
                'latitude' => 27.9506,
                'longitude' => -82.4572,
                'radius_miles' => 20,
                'is_primary' => true,
                'is_active' => true,
                'sort_order' => 2,
                'zip_codes' => ['33602', '33603', '33604', '33605', '33606', '33607', '33609'],
            ],
            [
                'name' => 'Orlando',
                'slug' => 'orlando',
                'description' => 'Serving Orlando and surrounding communities with quality fencing',
                'state' => 'Florida',
                'county' => 'Orange',
                'latitude' => 28.5383,
                'longitude' => -81.3792,
                'radius_miles' => 25,
                'is_primary' => true,
                'is_active' => true,
                'sort_order' => 3,
                'zip_codes' => ['32801', '32803', '32804', '32805', '32806', '32807', '32808'],
            ],
            [
                'name' => 'Winter Haven',
                'slug' => 'winter-haven',
                'description' => 'Professional fencing services for Winter Haven residents',
                'state' => 'Florida',
                'county' => 'Polk',
                'latitude' => 28.0222,
                'longitude' => -81.7329,
                'radius_miles' => 10,
                'is_primary' => false,
                'is_active' => true,
                'sort_order' => 4,
                'zip_codes' => ['33880', '33881', '33884'],
            ],
            [
                'name' => 'Bartow',
                'slug' => 'bartow',
                'description' => 'Quality fence installation for Bartow and surrounding areas',
                'state' => 'Florida',
                'county' => 'Polk',
                'latitude' => 27.8964,
                'longitude' => -81.8431,
                'radius_miles' => 8,
                'is_primary' => false,
                'is_active' => true,
                'sort_order' => 5,
                'zip_codes' => ['33830', '33831'],
            ],
            [
                'name' => 'Plant City',
                'slug' => 'plant-city',
                'description' => 'Fence services for Plant City and eastern Hillsborough County',
                'state' => 'Florida',
                'county' => 'Hillsborough',
                'latitude' => 28.0181,
                'longitude' => -82.1087,
                'radius_miles' => 12,
                'is_primary' => false,
                'is_active' => true,
                'sort_order' => 6,
                'zip_codes' => ['33563', '33564', '33566'],
            ],
        ];

        foreach ($serviceAreas as $area) {
            ServiceArea::firstOrCreate(
                ['slug' => $area['slug']],
                $area
            );
        }
    }
}
