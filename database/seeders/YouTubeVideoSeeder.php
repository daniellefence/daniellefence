<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\YouTubeVideo;
use App\Services\YouTubeService;
use Carbon\Carbon;

class YouTubeVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, try to sync from YouTube API
        $this->syncFromYouTube();

        // Fallback to placeholder videos if API sync fails
        $videos = [
            [
                'title' => 'DIY Vinyl Fence Installation - Complete Guide',
                'youtube_id' => 'dQw4w9WgXcQ', // Placeholder YouTube ID
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'description' => 'Learn how to install a vinyl fence yourself with this comprehensive tutorial. From planning to finishing touches.',
                'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'duration' => 900, // 15 minutes
                'published_at' => Carbon::now()->subDays(10),
                'tags' => ['DIY', 'Vinyl Fence', 'Installation', 'Tutorial'],
                'show_on_videos_page' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'category' => 'DIY Tutorials',
            ],
            [
                'title' => 'Pool Fence Safety Requirements in Florida',
                'youtube_id' => 'oHg5SJYRHA0', // Placeholder YouTube ID
                'youtube_url' => 'https://www.youtube.com/watch?v=oHg5SJYRHA0',
                'description' => 'Understanding Florida pool fence regulations and safety requirements for homeowners.',
                'thumbnail_url' => 'https://img.youtube.com/vi/oHg5SJYRHA0/maxresdefault.jpg',
                'duration' => 480, // 8 minutes
                'published_at' => Carbon::now()->subDays(20),
                'tags' => ['Pool Fence', 'Safety', 'Florida Law', 'Regulations'],
                'show_on_videos_page' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'category' => 'Safety & Regulations',
            ],
            [
                'title' => 'Aluminum Fence Maintenance Tips',
                'youtube_id' => 'RgKAFK5djSk', // Placeholder YouTube ID
                'youtube_url' => 'https://www.youtube.com/watch?v=RgKAFK5djSk',
                'description' => 'Keep your aluminum fence looking great with these maintenance tips for Florida weather.',
                'thumbnail_url' => 'https://img.youtube.com/vi/RgKAFK5djSk/maxresdefault.jpg',
                'duration' => 360, // 6 minutes
                'published_at' => Carbon::now()->subDays(30),
                'tags' => ['Aluminum Fence', 'Maintenance', 'Florida Weather'],
                'show_on_videos_page' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'category' => 'Maintenance',
            ],
            [
                'title' => 'Chain Link Fence Installation Process',
                'youtube_id' => 'Ks-_Mh1QhMc', // Placeholder YouTube ID
                'youtube_url' => 'https://www.youtube.com/watch?v=Ks-_Mh1QhMc',
                'description' => 'Professional demonstration of chain link fence installation from start to finish.',
                'thumbnail_url' => 'https://img.youtube.com/vi/Ks-_Mh1QhMc/maxresdefault.jpg',
                'duration' => 720, // 12 minutes
                'published_at' => Carbon::now()->subDays(40),
                'tags' => ['Chain Link', 'Installation', 'Professional'],
                'show_on_videos_page' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'category' => 'Installation',
            ],
        ];

        foreach ($videos as $video) {
            YouTubeVideo::firstOrCreate(
                ['youtube_id' => $video['youtube_id']],
                $video
            );
        }
    }

    /**
     * Try to sync videos from YouTube API
     */
    private function syncFromYouTube(): void
    {
        try {
            $this->command->info('Attempting to sync videos from YouTube...');

            $youtubeService = new YouTubeService();
            $stats = $youtubeService->syncVideos();

            if ($stats['fetched'] > 0) {
                $this->command->info("✅ Synced {$stats['fetched']} videos from YouTube");
                $this->command->info("   Created: {$stats['created']}, Updated: {$stats['updated']}");
                return; // Skip fallback videos if sync was successful
            } else {
                $this->command->warn('⚠️  No videos fetched from YouTube API. Using fallback data...');
            }

        } catch (\Exception $e) {
            $this->command->warn('⚠️  YouTube sync failed: ' . $e->getMessage());
            $this->command->info('Using fallback video data...');
        }
    }
}
