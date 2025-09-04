<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;

class CacheWarmupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warmup {--force : Force warmup even if cache exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up application caches with commonly used data';

    /**
     * Execute the console command.
     */
    public function handle(CacheService $cacheService)
    {
        $this->info('Starting cache warmup...');
        
        if ($this->option('force')) {
            $this->info('Clearing existing caches...');
            $cacheService->clearContentCaches();
        }

        $start = microtime(true);

        try {
            $cacheService->warmupCaches();
            
            $duration = round((microtime(true) - $start) * 1000, 2);
            $stats = $cacheService->getCacheStats();
            
            $this->info("Cache warmup completed in {$duration}ms");
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total Keys', $stats['total']],
                    ['Cached', $stats['cached']],
                    ['Missing', $stats['missing']],
                    ['Hit Rate', $stats['hit_rate'] . '%'],
                ]
            );

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Cache warmup failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
