<?php

namespace Database\Seeders;

use App\Models\AreasWeServe;
use Illuminate\Database\Seeder;

class AreasWeServeSeeder extends Seeder
{
    public $areas_we_serve = [
        'Arcadia',
        'Bowling Green',
        'Wauchula',
        'Zolfo Springs',
        'Brooksville',
        'Spring Hill',
        'Weeki Wachee',
        'Avon Park',
        'Lake Placid',
        'Lorida',
        'Sebring',
        'Apollo Beach',
        'Brandon',
        'Dover',
        'Gibsonton',
        'Lithia',
        'Lutz',
        'Mango',
        'Plant City',
        'Riverview',
        'Ruskin',
        'Seffner',
        'Sun City Center',
        'Sydney',
        'Tampa',
        'Temple Terrace',
        'Thonotosassa',
        'Town \'n\' Country',
        'Valrico',
        'Wimauma',
        'Clermont',
        'Ferndale',
        'Groveland',
        'Mascotte',
        'Minneola',
        'Montverde',
        'Anna Maria',
        'Bradenton',
        'Bradenton Beach',
        'Cortez',
        'Ellenton',
        'Holmes Beach',
        'Lakewood Ranch',
        'Longboat Key',
        'Oneco',
        'Palmetto',
        'Parrish',
        'Apopka',
        'Belle Isle',
        'Clarcona',
        'Goldenrod',
        'Gotha',
        'Killarney',
        'Lake Buena Vista',
        'Oakland',
        'Ocoee',
        'Orlando',
        'Orlo Vista',
        'Windermere',
        'Winter Garden',
        'Winter Park',
        'Celebration',
        'Kissimmee',
        'Poinciana',
        'St. Cloud',
        'Bayonet Point',
        'Crystal Springs',
        'Dade City',
        'Elfers',
        'Holiday',
        'Hudson',
        'Lacoochee',
        'Land o\' Lakes',
        'New Port Richey',
        'Odessa',
        'Port Richey',
        'St. Leo',
        'San Antonio',
        'Trinity',
        'Wesley Chapel',
        'Zephyrhills',
        'Bay Pines',
        'Belleair',
        'Belleair Bluffs',
        'Clearwater',
        'Crystal Beach',
        'Dunedin',
        'Gulfport',
        'Largo',
        'Madeira Beach',
        'Oldsmar',
        'Ozona',
        'Palm Harbor',
        'Pinellas Park',
        'Redington Beach',
        'Safety Harbor',
        'St. Pete Beach',
        'St. Petersburg',
        'Seminole',
        'Tarpon Springs',
        'Treasure Island',
        'Alturas',
        'Auburndale',
        'Babson Park',
        'Bartow',
        'Bradley Junction',
        'Davenport',
        'Dundee',
        'Eagle Lake',
        'Fort Meade',
        'Frostproof',
        'Haines City',
        'Highland City',
        'Homeland',
        'Indian Lake Estates',
        'Kathleen',
        'Lake Alfred',
        'Lake Hamilton',
        'Lake Wales',
        'Lakeland',
        'Loughman',
        'Mulberry',
        'Nalcrest',
        'Nichols',
        'Polk City',
        'Waverly',
        'Winter Haven',
        'Manasota',
        'Osprey',
        'Sarasota',
        'Webster',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = array_unique($this->areas_we_serve);
        $sortOrder = 0;

        foreach ($areas as $area) {
            $areaRecord = AreasWeServe::create([
                'title' => trim($area),
                'slug' => \Illuminate\Support\Str::slug(trim($area)),
                'published' => true,
                'sort_order' => $sortOrder++,
            ]);

            // Generate slug if it wasn't automatically created
            if (empty($areaRecord->slug)) {
                $areaRecord->slug = $areaRecord->generateSlug();
                $areaRecord->save();
            }
        }

        $this->command->info('Created ' . count($areas) . ' areas we serve records.');
    }
}
