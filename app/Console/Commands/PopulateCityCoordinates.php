<?php

namespace App\Console\Commands;

use App\Models\AreasWeServe;
use Illuminate\Console\Command;

class PopulateCityCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:populate-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate latitude and longitude coordinates for all cities in Central Florida';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Populating coordinates for Central Florida cities...');

        // Predefined coordinates for Central Florida cities
        $coordinates = [
            // DeSoto County
            'Arcadia' => [27.2164, -81.8584],
            'Brownville' => [27.1056, -81.8367],
            'Fort Ogden' => [27.0506, -81.8651],
            'Nocatee' => [27.1506, -81.9051],
            'Pine Level' => [27.1806, -81.8851],

            // Hernando County
            'Brooksville' => [28.5553, -82.3887],
            'Spring Hill' => [28.4769, -82.5301],
            'Weeki Wachee' => [28.5169, -82.4301],
            'Aripeka' => [28.4369, -82.4601],

            // Highlands County
            'Sebring' => [27.4956, -81.4409],
            'Avon Park' => [27.5959, -81.5065],
            'Lake Placid' => [27.2931, -81.3631],
            'Venus' => [27.0706, -81.2731],
            'Zolfo Springs' => [27.4931, -81.7965],

            // Hillsborough County
            'Tampa' => [27.9506, -82.4572],
            'Brandon' => [27.9378, -82.2859],
            'Riverview' => [27.8664, -82.3265],
            'Valrico' => [27.9389, -82.2437],
            'Lithia' => [27.8689, -82.1915],
            'Plant City' => [28.0181, -82.1129],
            'Temple Terrace' => [28.0356, -82.3890],
            'Seffner' => [27.9778, -82.2765],
            'Thonotosassa' => [28.0517, -82.2943],
            'Wesley Chapel' => [28.2420, -82.3271],
            'Carrollwood' => [28.0531, -82.5154],
            'Citrus Park' => [28.0781, -82.5765],
            'Westchase' => [28.0531, -82.5965],
            'Lutz' => [28.1542, -82.4612],
            'Odessa' => [28.1833, -82.5568],
            'Ruskin' => [27.7214, -82.4340],
            'Apollo Beach' => [27.7711, -82.4071],
            'Gibsonton' => [27.8581, -82.3740],
            'Wimauma' => [27.7147, -82.3190],

            // Lake County
            'Clermont' => [28.5492, -81.7729],
            'Leesburg' => [28.8108, -81.8776],
            'Eustis' => [28.8528, -81.6848],
            'Mount Dora' => [28.8039, -81.6445],
            'Tavares' => [28.8039, -81.7356],
            'Groveland' => [28.6000, -81.8400],

            // Manatee County
            'Bradenton' => [27.4989, -82.5748],
            'Palmetto' => [27.5214, -82.5729],
            'Anna Maria' => [27.5331, -82.7340],
            'Holmes Beach' => [27.4981, -82.7090],
            'Bradenton Beach' => [27.4681, -82.7090],
            'Longboat Key' => [27.4081, -82.6540],
            'Ellenton' => [27.5181, -82.5229],
            'Parrish' => [27.5581, -82.4129],
            'Terra Ceia' => [27.5881, -82.6229],
            'Cortez' => [27.4681, -82.6840],
            'Oneco' => [27.4481, -82.5129],

            // Orange County
            'Orlando' => [28.5383, -81.3792],
            'Winter Park' => [28.5999, -81.3393],
            'Apopka' => [28.6934, -81.5322],
            'Ocoee' => [28.5693, -81.5439],
            'Winter Garden' => [28.5653, -81.5861],
            'Windermere' => [28.4936, -81.5322],
            'Maitland' => [28.6278, -81.3631],
            'Eatonville' => [28.6167, -81.3839],
            'Edgewood' => [28.4828, -81.3700],
            'Oakland' => [28.5528, -81.6361],
            'Belle Isle' => [28.4628, -81.3661],
            'Bay Lake' => [28.3828, -81.5961],
            'Lake Buena Vista' => [28.3728, -81.5181],
            'Montverde' => [28.5928, -81.6761],

            // Osceola County
            'Kissimmee' => [28.2917, -81.4076],
            'St. Cloud' => [28.2489, -81.2815],
            'Celebration' => [28.3247, -81.5323],
            'Poinciana' => [28.1256, -81.4690],

            // Pasco County
            'New Port Richey' => [28.2439, -82.7193],
            'Port Richey' => [28.2739, -82.7193],
            'Dade City' => [28.3647, -82.1962],
            'Zephyrhills' => [28.2336, -82.1812],
            'Land O\' Lakes' => [28.2228, -82.4290],
            'Wesley Chapel' => [28.2420, -82.3271],
            'Trinity' => [28.1817, -82.6568],
            'Holiday' => [28.1864, -82.7434],
            'Hudson' => [28.3650, -82.6926],
            'Bayonet Point' => [28.3350, -82.6826],
            'Elfers' => [28.2150, -82.7326],
            'Moon Lake' => [28.2050, -82.6626],
            'Shady Hills' => [28.2450, -82.5826],
            'San Antonio' => [28.3347, -82.2612],
            'Saint Leo' => [28.3347, -82.2962],
            'Lacoochee' => [28.4547, -82.1912],

            // Pinellas County
            'St. Petersburg' => [27.7731, -82.6404],
            'Clearwater' => [27.9659, -82.8001],
            'Largo' => [27.9095, -82.7873],
            'Pinellas Park' => [27.8428, -82.6995],
            'Seminole' => [27.8378, -82.7895],
            'Safety Harbor' => [28.0028, -82.6895],
            'Dunedin' => [28.0197, -82.7718],
            'Tarpon Springs' => [28.1461, -82.7568],
            'Gulfport' => [27.7481, -82.7040],
            'Treasure Island' => [27.7681, -82.7740],
            'St. Pete Beach' => [27.7431, -82.7440],
            'Madeira Beach' => [27.7931, -82.7940],
            'Redington Beach' => [27.8131, -82.8140],
            'Indian Rocks Beach' => [27.8931, -82.8440],
            'Belleair' => [27.9381, -82.8140],
            'Belleair Beach' => [27.9181, -82.8540],
            'Belleair Bluffs' => [27.9381, -82.8340],
            'Kenneth City' => [27.8181, -82.7240],
            'South Pasadena' => [27.7581, -82.7540],
            'Oldsmar' => [28.0342, -82.6651],

            // Polk County
            'Lakeland' => [28.0395, -81.9498],
            'Winter Haven' => [28.0222, -81.7328],
            'Bartow' => [27.8964, -81.8431],
            'Auburndale' => [28.0653, -81.7887],
            'Haines City' => [28.1142, -81.6179],
            'Lake Wales' => [27.9014, -81.5859],
            'Mulberry' => [27.8953, -81.9731],
            'Fort Meade' => [27.7564, -81.8009],
            'Frostproof' => [27.7478, -81.5309],
            'Eagle Lake' => [27.9664, -81.7531],
            'Davenport' => [28.1614, -81.6031],
            'Dundee' => [28.0214, -81.6231],
            'Lake Alfred' => [28.0914, -81.7231],
            'Polk City' => [28.1756, -81.8298],
            'Babson Park' => [27.8314, -81.5531],
            'Bowling Green' => [27.6414, -81.8231],
            'Crooked Lake Park' => [27.8114, -81.6731],
            'Cypress Gardens' => [28.0314, -81.6931],
            'Eloise' => [28.0814, -81.7631],
            'Highland City' => [27.9614, -81.9131],
            'Hillcrest Heights' => [27.9814, -81.9331],
            'Homeland' => [27.8714, -81.8531],
            'Inwood' => [28.0314, -81.8731],
            'Jan Phyl Village' => [28.0414, -81.7831],
            'Kathleen' => [28.0214, -81.9831],
            'Wahneta' => [28.0314, -81.7431],

            // Sarasota County
            'Sarasota' => [27.3364, -82.5307],
            'Venice' => [27.0998, -82.4543],
            'North Port' => [27.0442, -82.2359],
            'Englewood' => [26.9614, -82.3526],

            // Additional missing cities - Round 2
            'DeSoto County' => [27.2164, -81.8584], // Using Arcadia as county center
            'Wauchula' => [27.5478, -81.8109],
            'Hernando County' => [28.5553, -82.3887], // Using Brooksville as county center
            'Highlands County' => [27.4956, -81.4409], // Using Sebring as county center
            'Lorida' => [27.1831, -81.2431],
            'Dover' => [28.0197, -82.2276],
            'Mango' => [27.9847, -82.3087],
            'Sun City Center' => [27.7189, -82.3515],
            'Sydney' => [28.0931, -82.1387],
            'Town \'n\' Country' => [28.0122, -82.5687],
            "Town 'n' Country" => [28.0122, -82.5687], // Alternative apostrophe style
            'Ferndale' => [28.8039, -81.7856],
            'Mascotte' => [28.5803, -81.8876],
            'Minneola' => [28.5708, -81.7448],
            'Lakewood Ranch' => [27.4031, -82.4040],
            'Clarcona' => [28.6167, -81.4831],
            'Goldenrod' => [28.6112, -81.2998],
            'Gotha' => [28.5361, -81.5181],
            'Killarney' => [28.3489, -81.4009],
            'Orlo Vista' => [28.5431, -81.4631],
            'Crystal Springs' => [28.1756, -82.1676],
            'Land o\' Lakes' => [28.2228, -82.4290], // Alternative spelling
            "Land o' Lakes" => [28.2228, -82.4290], // Alternative apostrophe style
            'St. Leo' => [28.3347, -82.2962], // Alternative for Saint Leo
            'Bay Pines' => [27.8031, -82.7831],
            'Crystal Beach' => [28.0631, -82.8331],
            'Ozona' => [28.0631, -82.7031],
            'Palm Harbor' => [28.0778, -82.7625],
            'Polk County' => [28.0395, -81.9498], // Using Lakeland as county center
            'Alturas' => [27.8714, -81.7131],
            'Bradley Junction' => [27.9314, -81.7831],
            'Indian Lake Estates' => [27.9214, -81.3631],
            'Lake Hamilton' => [28.0214, -81.6431],
            'Loughman' => [28.2414, -81.5631],
            'Nalcrest' => [27.9314, -81.4831],
            'Nichols' => [27.8614, -81.8331],
            'Waverly' => [27.9714, -81.6131],
            'Sarasota County' => [27.3364, -82.5307], // Using Sarasota as county center
            'Manasota' => [26.9714, -82.3826],
            'Osprey' => [27.2031, -82.4926],
            'Webster' => [28.6106, -82.0562],
        ];

        $areas = AreasWeServe::whereNull('latitude')->orWhereNull('longitude')->get();
        $progressBar = $this->output->createProgressBar($areas->count());
        $progressBar->start();

        $updated = 0;
        $errors = 0;

        foreach ($areas as $area) {
            try {
                if (isset($coordinates[$area->title])) {
                    $area->latitude = $coordinates[$area->title][0];
                    $area->longitude = $coordinates[$area->title][1];
                    $area->save();
                    $updated++;
                } else {
                    $this->warn("No coordinates found for: {$area->title}");
                    $errors++;
                }
            } catch (\Exception $e) {
                $this->error("Error updating {$area->title}: " . $e->getMessage());
                $errors++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Completed!");
        $this->info("Updated: {$updated} cities");

        if ($errors > 0) {
            $this->warn("Skipped: {$errors} cities");
        }

        // Show cities with coordinates
        $withCoordinates = AreasWeServe::whereNotNull('latitude')->whereNotNull('longitude')->count();
        $total = AreasWeServe::count();

        $this->info("Cities with coordinates: {$withCoordinates}/{$total}");

        return 0;
    }
}
