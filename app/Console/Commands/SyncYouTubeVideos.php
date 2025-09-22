<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncYouTubeVideos extends Command
{
    protected $signature = 'youtube:sync {--limit=50 : Maximum number of videos to fetch}';

    protected $description = 'Sync videos from YouTube channel';

    public function handle()
    {
        $apiKey = config('services.youtube.api_key') ?: env('YOUTUBE_API_KEY');
        $channelId = config('services.youtube.channel_id') ?: env('YOUTUBE_CHANNEL_ID');

        if (! $apiKey || ! $channelId) {
            $this->error('YouTube API key or channel ID not configured.');
            $this->info('Please set YOUTUBE_API_KEY and YOUTUBE_CHANNEL_ID in your .env file.');

            return 1;
        }

        $limit = $this->option('limit');

        $this->info("Fetching up to {$limit} videos from YouTube channel...");

        try {
            // First, get the uploads playlist ID
            $channelResponse = Http::get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'contentDetails',
                'id' => $channelId,
                'key' => $apiKey,
            ]);

            if (! $channelResponse->successful()) {
                $this->error('Failed to fetch channel information from YouTube API.');

                return 1;
            }

            $channelData = $channelResponse->json();

            if (empty($channelData['items'])) {
                $this->error('Channel not found or no access to channel.');

                return 1;
            }

            $uploadsPlaylistId = $channelData['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

            // Now fetch videos from the uploads playlist
            $response = Http::get('https://www.googleapis.com/youtube/v3/playlistItems', [
                'part' => 'snippet',
                'playlistId' => $uploadsPlaylistId,
                'maxResults' => $limit,
                'key' => $apiKey,
            ]);

            if (! $response->successful()) {
                $this->error('Failed to fetch videos from YouTube API.');

                return 1;
            }

            $data = $response->json();

            if (empty($data['items'])) {
                $this->warning('No videos found in the channel.');

                return 0;
            }

            $syncedCount = 0;
            $skippedCount = 0;

            foreach ($data['items'] as $item) {
                $videoId = $item['snippet']['resourceId']['videoId'];
                $title = $item['snippet']['title'];

                // Check if video already exists
                $existingVideo = Video::where('code', $videoId)->first();

                if ($existingVideo) {
                    $skippedCount++;
                    $this->line("Skipped: {$title} (already exists)");

                    continue;
                }

                // Create new video record
                Video::create([
                    'title' => $title,
                    'code' => $videoId,
                ]);

                $syncedCount++;
                $this->info("Synced: {$title}");
            }

            $this->info("Sync completed! {$syncedCount} videos synced, {$skippedCount} skipped.");

            return 0;

        } catch (\Exception $e) {
            $this->error("Error syncing videos: {$e->getMessage()}");

            return 1;
        }
    }
}
