<?php

namespace App\Console\Commands;

use Exception;
use App\Models\AreasWeServe;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateCitySlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate URL slugs for all existing cities and populate county data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating slugs and county data for all cities...');

        // County mapping for Central Florida cities
        $countyMapping = [
            // DeSoto County
            'Arcadia' => 'DeSoto',
            'Brownville' => 'DeSoto',
            'Fort Ogden' => 'DeSoto',
            'Nocatee' => 'DeSoto',
            'Pine Level' => 'DeSoto',

            // Hernando County
            'Brooksville' => 'Hernando',
            'Spring Hill' => 'Hernando',
            'Weeki Wachee' => 'Hernando',
            'Aripeka' => 'Hernando',

            // Highlands County
            'Sebring' => 'Highlands',
            'Avon Park' => 'Highlands',
            'Lake Placid' => 'Highlands',
            'Venus' => 'Highlands',
            'Zolfo Springs' => 'Highlands',

            // Hillsborough County
            'Tampa' => 'Hillsborough',
            'Brandon' => 'Hillsborough',
            'Riverview' => 'Hillsborough',
            'Valrico' => 'Hillsborough',
            'Lithia' => 'Hillsborough',
            'Plant City' => 'Hillsborough',
            'Temple Terrace' => 'Hillsborough',
            'Seffner' => 'Hillsborough',
            'Thonotosassa' => 'Hillsborough',
            'Wesley Chapel' => 'Hillsborough',
            'Carrollwood' => 'Hillsborough',
            'Citrus Park' => 'Hillsborough',
            'Westchase' => 'Hillsborough',
            'Lutz' => 'Hillsborough',
            'Odessa' => 'Hillsborough',
            'Ruskin' => 'Hillsborough',
            'Apollo Beach' => 'Hillsborough',
            'Gibsonton' => 'Hillsborough',
            'Wimauma' => 'Hillsborough',

            // Lake County
            'Clermont' => 'Lake',
            'Leesburg' => 'Lake',
            'Eustis' => 'Lake',
            'Mount Dora' => 'Lake',
            'Tavares' => 'Lake',
            'Groveland' => 'Lake',

            // Manatee County
            'Bradenton' => 'Manatee',
            'Palmetto' => 'Manatee',
            'Anna Maria' => 'Manatee',
            'Holmes Beach' => 'Manatee',
            'Bradenton Beach' => 'Manatee',
            'Longboat Key' => 'Manatee',
            'Ellenton' => 'Manatee',
            'Parrish' => 'Manatee',
            'Terra Ceia' => 'Manatee',
            'Cortez' => 'Manatee',
            'Oneco' => 'Manatee',

            // Orange County
            'Orlando' => 'Orange',
            'Winter Park' => 'Orange',
            'Apopka' => 'Orange',
            'Ocoee' => 'Orange',
            'Winter Garden' => 'Orange',
            'Windermere' => 'Orange',
            'Maitland' => 'Orange',
            'Eatonville' => 'Orange',
            'Edgewood' => 'Orange',
            'Oakland' => 'Orange',
            'Belle Isle' => 'Orange',
            'Bay Lake' => 'Orange',
            'Lake Buena Vista' => 'Orange',
            'Montverde' => 'Orange',

            // Osceola County
            'Kissimmee' => 'Osceola',
            'St. Cloud' => 'Osceola',
            'Celebration' => 'Osceola',
            'Poinciana' => 'Osceola',

            // Pasco County
            'New Port Richey' => 'Pasco',
            'Port Richey' => 'Pasco',
            'Dade City' => 'Pasco',
            'Zephyrhills' => 'Pasco',
            'Land O\' Lakes' => 'Pasco',
            'Wesley Chapel' => 'Pasco',
            'Trinity' => 'Pasco',
            'Holiday' => 'Pasco',
            'Hudson' => 'Pasco',
            'Bayonet Point' => 'Pasco',
            'Elfers' => 'Pasco',
            'Moon Lake' => 'Pasco',
            'Shady Hills' => 'Pasco',
            'San Antonio' => 'Pasco',
            'Saint Leo' => 'Pasco',
            'Lacoochee' => 'Pasco',

            // Pinellas County
            'St. Petersburg' => 'Pinellas',
            'Clearwater' => 'Pinellas',
            'Largo' => 'Pinellas',
            'Pinellas Park' => 'Pinellas',
            'Seminole' => 'Pinellas',
            'Safety Harbor' => 'Pinellas',
            'Dunedin' => 'Pinellas',
            'Tarpon Springs' => 'Pinellas',
            'Gulfport' => 'Pinellas',
            'Treasure Island' => 'Pinellas',
            'St. Pete Beach' => 'Pinellas',
            'Madeira Beach' => 'Pinellas',
            'Redington Beach' => 'Pinellas',
            'Indian Rocks Beach' => 'Pinellas',
            'Belleair' => 'Pinellas',
            'Belleair Beach' => 'Pinellas',
            'Belleair Bluffs' => 'Pinellas',
            'Kenneth City' => 'Pinellas',
            'South Pasadena' => 'Pinellas',
            'Oldsmar' => 'Pinellas',

            // Polk County
            'Lakeland' => 'Polk',
            'Winter Haven' => 'Polk',
            'Bartow' => 'Polk',
            'Auburndale' => 'Polk',
            'Haines City' => 'Polk',
            'Lake Wales' => 'Polk',
            'Mulberry' => 'Polk',
            'Fort Meade' => 'Polk',
            'Frostproof' => 'Polk',
            'Eagle Lake' => 'Polk',
            'Davenport' => 'Polk',
            'Dundee' => 'Polk',
            'Lake Alfred' => 'Polk',
            'Polk City' => 'Polk',
            'Babson Park' => 'Polk',
            'Bowling Green' => 'Polk',
            'Crooked Lake Park' => 'Polk',
            'Cypress Gardens' => 'Polk',
            'Eloise' => 'Polk',
            'Highland City' => 'Polk',
            'Hillcrest Heights' => 'Polk',
            'Homeland' => 'Polk',
            'Inwood' => 'Polk',
            'Jan Phyl Village' => 'Polk',
            'Kathleen' => 'Polk',
            'Wahneta' => 'Polk',

            // Sarasota County
            'Sarasota' => 'Sarasota',
            'Venice' => 'Sarasota',
            'North Port' => 'Sarasota',
            'Englewood' => 'Sarasota',
        ];

        $areas = AreasWeServe::all();
        $progressBar = $this->output->createProgressBar($areas->count());
        $progressBar->start();

        $updated = 0;
        $errors = 0;

        foreach ($areas as $area) {
            try {
                // Generate slug if not exists
                if (!$area->slug) {
                    $area->slug = $area->generateSlug();
                }

                // Set county if not exists
                if (!$area->county && isset($countyMapping[$area->title])) {
                    $area->county = $countyMapping[$area->title];
                }

                $area->save();
                $updated++;
            } catch (Exception $e) {
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
            $this->error("Errors: {$errors}");
        }

        // Show summary by county
        $this->newLine();
        $this->info("Cities by County:");
        $byCounty = AreasWeServe::selectRaw('county, COUNT(*) as count')
            ->whereNotNull('county')
            ->groupBy('county')
            ->orderBy('county')
            ->get();

        foreach ($byCounty as $county) {
            $this->line("  {$county->county}: {$county->count} cities");
        }

        return 0;
    }
}
