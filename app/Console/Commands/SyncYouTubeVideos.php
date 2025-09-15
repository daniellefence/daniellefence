<?php

namespace App\Console\Commands;

use App\Services\YouTubeService;
use Illuminate\Console\Command;

class SyncYouTubeVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:sync
                            {--delete-old : Delete videos that are no longer on YouTube}
                            {--limit=50 : Maximum number of videos to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync videos from Danielle Fence YouTube channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎥 Starting YouTube video sync...');

        $youtubeService = new YouTubeService();

        // First, try to get channel info
        $this->info('📡 Fetching channel information...');
        $channelInfo = $youtubeService->getChannelInfo();

        if ($channelInfo) {
            $this->info('✅ Channel: ' . $channelInfo['title']);
            $this->info('   Subscribers: ' . number_format($channelInfo['subscriber_count']));
            $this->info('   Total Videos: ' . number_format($channelInfo['video_count']));
            $this->info('   Total Views: ' . number_format($channelInfo['view_count']));
            $this->info('');
        } else {
            $this->warn('⚠️  Could not fetch channel information. Check API key and channel ID configuration.');
            $this->info('');
            $this->info('To configure YouTube integration:');
            $this->info('1. Get a YouTube API key from Google Cloud Console');
            $this->info('2. Find your channel ID (starts with UC...)');
            $this->info('3. Add to your .env file:');
            $this->info('   YOUTUBE_API_KEY=your_api_key_here');
            $this->info('   YOUTUBE_CHANNEL_ID=your_channel_id_here');
            $this->info('');
            $this->info('Your channel handle: @daniellefenceoutdoorliving8500');
            $this->info('Channel URL: https://www.youtube.com/@daniellefenceoutdoorliving8500');
            $this->info('');
        }

        // Sync videos
        $this->info('🔄 Syncing videos...');

        $deleteOld = $this->option('delete-old');
        if ($deleteOld) {
            $this->warn('⚠️  Will delete videos that are no longer on YouTube');
        }

        $stats = $youtubeService->syncVideos($deleteOld);

        // Display results
        $this->info('');
        $this->info('✨ Sync Complete!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Videos Fetched', $stats['fetched']],
                ['Created', $stats['created']],
                ['Updated', $stats['updated']],
                ['Deleted', $stats['deleted']],
                ['Errors', $stats['errors']],
            ]
        );

        if ($stats['errors'] > 0) {
            $this->warn('⚠️  Some videos had errors. Check the logs for details.');
        }

        return 0;
    }
}