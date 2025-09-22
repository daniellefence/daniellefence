<?php

namespace App\Console\Commands;

use App\Models\AreasWeServe;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCitySitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate-city';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap for all city landing pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating city sitemap...');

        $areas = AreasWeServe::published()->whereNotNull('slug')->get();

        if ($areas->isEmpty()) {
            $this->error('No published areas with slugs found. Run cities:generate-slugs first.');
            return 1;
        }

        $xml = $this->generateSitemap($areas);

        // Save to public directory
        $sitemapPath = public_path('sitemap-cities.xml');
        file_put_contents($sitemapPath, $xml);

        $this->info("Generated sitemap with " . ($areas->count() * 6) . " city URLs");
        $this->info("Sitemap saved to: {$sitemapPath}");

        // Show sample URLs
        $this->newLine();
        $this->info("Sample URLs generated:");
        $sampleArea = $areas->first();
        $this->line("  /fencing-{$sampleArea->slug}");
        $this->line("  /fence-installation-{$sampleArea->slug}");
        $this->line("  /vinyl-fencing-{$sampleArea->slug}");
        $this->line("  /wood-fencing-{$sampleArea->slug}");
        $this->line("  /chain-link-fencing-{$sampleArea->slug}");
        $this->line("  /commercial-fencing-{$sampleArea->slug}");

        return 0;
    }

    private function generateSitemap($areas)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Add service areas index page
        $xml .= $this->addUrl('/service-areas', '1.0', 'weekly');

        foreach ($areas as $area) {
            // Main city landing page
            $xml .= $this->addUrl("/fencing-{$area->slug}", '0.9', 'monthly');

            // Service-specific pages
            $services = [
                'fence-installation',
                'vinyl-fencing',
                'wood-fencing',
                'chain-link-fencing',
                'commercial-fencing'
            ];

            foreach ($services as $service) {
                $xml .= $this->addUrl("/{$service}-{$area->slug}", '0.8', 'monthly');
            }
        }

        $xml .= '</urlset>' . PHP_EOL;

        return $xml;
    }

    private function addUrl($path, $priority = '0.5', $changefreq = 'monthly')
    {
        $baseUrl = config('app.url', 'https://newdaniellefence.test');
        $lastmod = now()->format('Y-m-d');

        return "  <url>" . PHP_EOL .
               "    <loc>{$baseUrl}{$path}</loc>" . PHP_EOL .
               "    <lastmod>{$lastmod}</lastmod>" . PHP_EOL .
               "    <changefreq>{$changefreq}</changefreq>" . PHP_EOL .
               "    <priority>{$priority}</priority>" . PHP_EOL .
               "  </url>" . PHP_EOL;
    }
}
