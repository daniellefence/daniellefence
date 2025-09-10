<?php

namespace Database\Seeders;

use App\Models\ServiceArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public $areas_we_serve = [
        "DeSoto County",
"Arcadia",
"Bowling Green",
"Wauchula",
        "Zolfo Springs",
"Hernando County",
"Brooksville","Spring Hill","Weeki Wachee",
"Highlands County",
"Avon Park","Lake Placid","Lorida","Sebring",
"Apollo Beach","Brandon","Dover",
        "Gibsonton","Lithia","Lutz", "Mango", "Plant City", "Riverview", "Ruskin", "Seffner", "Sun City Center", "Sydney" ,"Tampa",
        "Temple Terrace","Thonotosassa","Town ‘n’ Country","Valrico","Wimauma","Lithia","Clermont","Ferndale","Groveland","Mascotte","Minneola","Montverde","Anna Maria",
        "Bradenton","Bradenton Beach","Cortez","Ellenton","Holmes Beach","Lakewood Ranch","Longboat Key","Oneco","Palmetto","Parrish","Apopka",
        "Belle Isle","Clarcona","Goldenrod","Gotha","Killarney","Lake Buena Vista","Oakland",
        "Ocoee","Orlando","Orlo Vista","Windermere","Winter Garden","Winter Park","Celebration","Kissimmee","Poinciana","St. Cloud",
"Bayonet Point","Crystal Springs","Dade City","Elfers","Holiday","Hudson","Lacoochee","Land o’ Lakes","New Port Richey",
        "Odessa","Port Richey","St. Leo","San Antonio","Trinity","Wesley Chapel","Zephyrhills",
"Bay Pines","Belleair","Belleair Bluffs","Clearwater","Crystal Beach","Dunedin","Gulfport","Largo","Madeira Beach","Oldsmar","Ozona",
        "Palm Harbor","Pinellas Park","Redington Beach","Safety Harbor","St. Pete Beach","St. Petersburg","Seminole","Tarpon Springs","Treasure Island",
"Polk County",
"Alturas","Auburndale","Babson Park","Bartow","Bradley Junction","Davenport","Dundee","Eagle Lake","Fort Meade","Frostproof","Haines City","Highland City","Homeland",
        "Indian Lake Estates","Kathleen","Lake Alfred","Lake Hamilton","Lake Wales","Lakeland","Loughman","Mulberry","Nalcrest",
        "Nichols","Polk City","Waverly","Winter Haven",
"Sarasota County",
"Manasota","Osprey","Sarasota","Webster"
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = array_unique($this->areas_we_serve);
        foreach($areas as $area) {
            ServiceArea::create([
                'name'=>$area,
                'slug'=>Str::slug($area)
            ]);
        }
    }
}
