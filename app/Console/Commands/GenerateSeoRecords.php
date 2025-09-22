<?php

namespace App\Console\Commands;

use App\Models\Seo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class GenerateSeoRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:generate {--force : Force regeneration of existing SEO records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-generate SEO records based on public routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating SEO records from public routes...');

        $routes = Route::getRoutes();
        $publicRoutes = [];
        $created = 0;
        $skipped = 0;

        // Get all GET routes that are likely public pages
        foreach ($routes as $route) {
            $methods = $route->methods();
            $uri = $route->uri();
            $name = $route->getName();

            // Only include GET routes for public website pages
            if (in_array('GET', $methods) &&
                ! str_starts_with($uri, 'admin') &&
                ! str_starts_with($uri, 'api') &&
                ! str_starts_with($uri, 'panel') &&
                ! str_starts_with($uri, '_') &&
                ! str_starts_with($uri, 'login') &&
                ! str_starts_with($uri, 'register') &&
                ! str_starts_with($uri, 'password') &&
                ! str_starts_with($uri, 'two-factor') &&
                ! str_starts_with($uri, 'profile') &&
                ! str_starts_with($uri, 'pulse') &&
                ! str_starts_with($uri, 'sanctum') &&
                ! str_contains($uri, '{') && // Exclude parameterized routes
                ! str_contains($name, 'filament') &&
                ! str_contains($name, 'auth') &&
                ! str_contains($name, 'password') &&
                ! str_contains($name, 'verification') &&
                ! str_contains($name, 'two-factor') &&
                ! str_contains($name, 'profile') &&
                $name) {

                $publicRoutes[] = [
                    'name' => $name,
                    'uri' => $uri,
                ];
            }
        }

        // Create SEO records for each public route
        foreach ($publicRoutes as $routeData) {
            $routeName = $routeData['name'];
            $uri = $routeData['uri'];

            // Check if SEO record already exists
            $existingSeo = Seo::where('route', $routeName)->first();

            if ($existingSeo && ! $this->option('force')) {
                $skipped++;

                continue;
            }

            // Generate default title, description, and keywords
            $title = $this->generateTitle($routeName, $uri);
            $description = $this->generateDescription($routeName, $uri);
            $keywords = $this->generateKeywords($routeName, $uri);

            if ($existingSeo && $this->option('force')) {
                // Update existing record
                $existingSeo->update([
                    'title' => $existingSeo->title ?: $title,
                    'description' => $existingSeo->description ?: $description,
                    'keywords' => $existingSeo->keywords ?: $keywords,
                ]);
                $this->line("Updated SEO for route: {$routeName}");
            } else {
                // Create new record
                Seo::create([
                    'route' => $routeName,
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                ]);
                $created++;
                $this->line("Created SEO for route: {$routeName}");
            }
        }

        $this->info('SEO generation complete!');
        $this->info("Created: {$created} new records");
        $this->info("Skipped: {$skipped} existing records");
        $this->info('Total public routes found: '.count($publicRoutes));

        if ($skipped > 0 && ! $this->option('force')) {
            $this->comment('Use --force to update existing SEO records');
        }
    }

    private function generateTitle(string $routeName, string $uri): string
    {
        // Convert route name to human readable title
        $title = str_replace(['.', '-', '_'], ' ', $routeName);
        $title = ucwords($title);

        // Add company name
        return $title.' | Danielle Fence';
    }

    private function generateDescription(string $routeName, string $uri): string
    {
        $descriptions = [
            'home' => 'Professional fence installation and repair services. Quality fencing solutions for residential and commercial properties.',
            'about' => 'Learn about Danielle Fence - your trusted fencing experts with years of experience in quality fence installation.',
            'services' => 'Comprehensive fencing services including installation, repair, and maintenance for all fence types.',
            'products' => 'Explore our wide range of fencing products including vinyl, wood, aluminum, and chain link fences.',
            'gallery' => 'View our portfolio of completed fence installations and see the quality of our workmanship.',
            'contact' => 'Get in touch with Danielle Fence for a free estimate on your fencing project.',
            'careers' => 'Join the Danielle Fence team. Explore current job opportunities and career growth.',
            'reviews' => 'Read what our satisfied customers say about our fencing services and quality workmanship.',
            'faqs' => 'Frequently asked questions about our fencing services, installation process, and maintenance.',
            'quote' => 'Get a free quote for your fencing project. Quick and easy online estimation.',
        ];

        foreach ($descriptions as $key => $desc) {
            if (str_contains($routeName, $key)) {
                return $desc;
            }
        }

        return 'Quality fencing services and solutions by Danielle Fence - your trusted fencing professionals.';
    }

    private function generateKeywords(string $routeName, string $uri): string
    {
        $baseKeywords = 'fence, fencing, fence installation, fence repair, Danielle Fence';

        $specificKeywords = [
            'home' => 'residential fencing, commercial fencing, fence contractor',
            'about' => 'fence company, fence contractor, about us',
            'services' => 'fence services, fence installation, fence repair, fence maintenance',
            'products' => 'vinyl fence, wood fence, aluminum fence, chain link fence, fence materials',
            'gallery' => 'fence photos, fence portfolio, completed projects',
            'contact' => 'fence quote, contact fence company, fence estimate',
            'careers' => 'fence jobs, fence installer jobs, career opportunities',
            'reviews' => 'fence reviews, customer testimonials, fence ratings',
            'faqs' => 'fence questions, fence FAQ, fencing help',
            'quote' => 'free fence quote, fence estimate, fence pricing',
        ];

        foreach ($specificKeywords as $key => $keywords) {
            if (str_contains($routeName, $key)) {
                return $baseKeywords.', '.$keywords;
            }
        }

        return $baseKeywords;
    }
}
