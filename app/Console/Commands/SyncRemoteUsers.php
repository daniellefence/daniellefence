<?php

namespace App\Console\Commands;

use App\Services\RemoteUserService;
use Illuminate\Console\Command;

class SyncRemoteUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:sync
                            {--update : Update existing users}
                            {--create : Create new users}
                            {--dry-run : Show what would be synced without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users from remote API (it.daniellehub.com)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting remote user sync...');

        $remoteUserService = new RemoteUserService();

        try {
            // Fetch remote users
            $this->info('📡 Fetching encrypted user data from API...');
            $remoteUsers = $remoteUserService->fetchRemoteUsers();

            if (!$remoteUsers) {
                $this->error('❌ Failed to fetch or decrypt remote users.');
                return 1;
            }

            $this->info('✅ Successfully decrypted ' . count($remoteUsers) . ' users');

            // Check for dry-run mode
            if ($this->option('dry-run')) {
                $this->info('🔍 DRY RUN MODE - No changes will be made');
                $this->table(
                    ['Email', 'Name', 'Status'],
                    collect($remoteUsers)->map(function ($user) use ($remoteUserService) {
                        $exists = \App\Models\User::where('email', $user['email'] ?? '')->exists();
                        $protected = $remoteUserService->isProtectedEmail($user['email'] ?? '');

                        return [
                            $user['email'] ?? 'N/A',
                            $user['name'] ?? 'N/A',
                            $protected ? '🔒 Protected' : ($exists ? '✏️ Update' : '➕ Create')
                        ];
                    })->toArray()
                );
                return 0;
            }

            // Determine sync options
            $updateExisting = $this->option('update') !== false;
            $createNew = $this->option('create') !== false;

            // If neither option is specified, enable both
            if (!$this->option('update') && !$this->option('create')) {
                $updateExisting = true;
                $createNew = true;
            }

            $this->info('🚀 Syncing users...');
            $this->info('  Update existing: ' . ($updateExisting ? 'Yes' : 'No'));
            $this->info('  Create new: ' . ($createNew ? 'Yes' : 'No'));

            // Perform sync
            $stats = $remoteUserService->syncUsers($remoteUsers, $updateExisting, $createNew);

            // Display results
            $this->info('');
            $this->info('✨ Sync Complete!');
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Total Remote Users', $stats['total']],
                    ['Created', $stats['created']],
                    ['Updated', $stats['updated']],
                    ['Protected (Skipped)', $stats['protected']],
                    ['Other Skipped', $stats['skipped']],
                    ['Errors', $stats['errors']],
                ]
            );

            // Show protected emails
            $protectedEmails = $remoteUserService->getProtectedEmails();
            if (!empty($protectedEmails)) {
                $this->info('');
                $this->info('🔒 Protected Emails (never modified):');
                foreach ($protectedEmails as $email) {
                    $this->line('  - ' . $email);
                }
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());

            if ($this->option('verbose')) {
                $this->error($e->getTraceAsString());
            }

            return 1;
        }
    }
}