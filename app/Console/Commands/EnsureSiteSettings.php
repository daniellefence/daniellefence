<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteSetting;

class EnsureSiteSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:ensure-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure required site settings (site_title, site_description, site_keywords) exist with default values';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Ensuring required site settings exist...');
        
        $requiredKeys = SiteSetting::getRequiredKeys();
        $created = 0;
        $existing = 0;
        
        foreach ($requiredKeys as $key => $defaults) {
            $setting = SiteSetting::where('key', $key)->first();
            
            if (!$setting) {
                SiteSetting::create(array_merge(['key' => $key], $defaults));
                $this->line("✅ Created setting: <fg=green>{$key}</fg=green>");
                $created++;
            } else {
                $this->line("✓ Setting exists: <fg=yellow>{$key}</fg=yellow>");
                $existing++;
            }
        }
        
        $this->newLine();
        $this->info("Summary:");
        $this->line("• Created: {$created} settings");
        $this->line("• Existing: {$existing} settings");
        
        if ($created > 0) {
            $this->info('Site settings cache cleared.');
        }
        
        $this->newLine();
        $this->info('✅ All required site settings are now available!');
    }
}
