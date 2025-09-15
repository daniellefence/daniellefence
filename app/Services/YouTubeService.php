<?php

namespace App\Services;

use App\Models\YouTubeVideo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class YouTubeService
{
    /**
     * YouTube API key
     */
    private string $apiKey;

    /**
     * YouTube Channel ID
     */
    private string $channelId;

    /**
     * Base URL for YouTube API
     */
    private string $apiBaseUrl = 'https://www.googleapis.com/youtube/v3';

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key', '');
        $this->channelId = config('services.youtube.channel_id', '');
    }

    /**
     * Fetch videos from YouTube channel
     *
     * @param int $maxResults Maximum number of videos to fetch
     * @return array|null
     */
    public function fetchChannelVideos(int $maxResults = 50): ?array
    {
        try {
            if (empty($this->apiKey) || empty($this->channelId)) {
                Log::warning('YouTube API key or Channel ID not configured');
                return null;
            }

            // First, get the uploads playlist ID
            $channelResponse = Http::get("{$this->apiBaseUrl}/channels", [
                'part' => 'contentDetails',
                'id' => $this->channelId,
                'key' => $this->apiKey,
            ]);

            if (!$channelResponse->successful()) {
                Log::error('Failed to fetch YouTube channel info', [
                    'status' => $channelResponse->status(),
                    'body' => $channelResponse->body()
                ]);
                return null;
            }

            $channelData = $channelResponse->json();

            if (empty($channelData['items'][0]['contentDetails']['relatedPlaylists']['uploads'])) {
                Log::error('Could not find uploads playlist for channel');
                return null;
            }

            $uploadsPlaylistId = $channelData['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

            // Now fetch videos from the uploads playlist
            $videosResponse = Http::get("{$this->apiBaseUrl}/playlistItems", [
                'part' => 'snippet,contentDetails',
                'playlistId' => $uploadsPlaylistId,
                'maxResults' => $maxResults,
                'key' => $this->apiKey,
            ]);

            if (!$videosResponse->successful()) {
                Log::error('Failed to fetch YouTube videos', [
                    'status' => $videosResponse->status(),
                    'body' => $videosResponse->body()
                ]);
                return null;
            }

            $videosData = $videosResponse->json();
            $videos = [];

            foreach ($videosData['items'] as $item) {
                $snippet = $item['snippet'];

                // Get video statistics (views, likes, etc.)
                $videoId = $item['contentDetails']['videoId'];
                $statsResponse = Http::get("{$this->apiBaseUrl}/videos", [
                    'part' => 'statistics,contentDetails',
                    'id' => $videoId,
                    'key' => $this->apiKey,
                ]);

                $stats = [];
                $duration = null;

                if ($statsResponse->successful()) {
                    $statsData = $statsResponse->json();
                    if (!empty($statsData['items'][0])) {
                        $stats = $statsData['items'][0]['statistics'] ?? [];
                        $duration = $this->parseISO8601Duration($statsData['items'][0]['contentDetails']['duration'] ?? '');
                    }
                }

                $videos[] = [
                    'youtube_id' => $videoId,
                    'title' => $snippet['title'],
                    'description' => $snippet['description'],
                    'thumbnail_url' => $snippet['thumbnails']['high']['url'] ?? $snippet['thumbnails']['default']['url'],
                    'published_at' => $snippet['publishedAt'],
                    'view_count' => $stats['viewCount'] ?? 0,
                    'like_count' => $stats['likeCount'] ?? 0,
                    'comment_count' => $stats['commentCount'] ?? 0,
                    'duration' => $duration,
                    'embed_url' => "https://www.youtube.com/embed/{$videoId}",
                    'watch_url' => "https://www.youtube.com/watch?v={$videoId}",
                ];
            }

            Log::info('Successfully fetched ' . count($videos) . ' videos from YouTube');
            return $videos;

        } catch (Exception $e) {
            Log::error('Error fetching YouTube videos: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Sync YouTube videos with database
     *
     * @param bool $deleteOld Delete videos that are no longer on YouTube
     * @return array Statistics about the sync
     */
    public function syncVideos(bool $deleteOld = false): array
    {
        $stats = [
            'fetched' => 0,
            'created' => 0,
            'updated' => 0,
            'deleted' => 0,
            'errors' => 0,
        ];

        $videos = $this->fetchChannelVideos();

        if (!$videos) {
            Log::error('No videos fetched from YouTube');
            return $stats;
        }

        $stats['fetched'] = count($videos);
        $youtubeIds = [];

        foreach ($videos as $videoData) {
            try {
                $youtubeIds[] = $videoData['youtube_id'];

                $video = YouTubeVideo::updateOrCreate(
                    ['youtube_id' => $videoData['youtube_id']],
                    [
                        'title' => $videoData['title'],
                        'description' => $videoData['description'],
                        'thumbnail_url' => $videoData['thumbnail_url'],
                        'embed_url' => $videoData['embed_url'],
                        'watch_url' => $videoData['watch_url'],
                        'published_at' => $videoData['published_at'],
                        'view_count' => $videoData['view_count'],
                        'like_count' => $videoData['like_count'],
                        'comment_count' => $videoData['comment_count'],
                        'duration' => $videoData['duration'],
                        'is_active' => true,
                    ]
                );

                if ($video->wasRecentlyCreated) {
                    $stats['created']++;
                } else {
                    $stats['updated']++;
                }

            } catch (Exception $e) {
                $stats['errors']++;
                Log::error('Error syncing video: ' . $videoData['youtube_id'], [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Delete videos that are no longer on YouTube
        if ($deleteOld && !empty($youtubeIds)) {
            $deleted = YouTubeVideo::whereNotIn('youtube_id', $youtubeIds)->delete();
            $stats['deleted'] = $deleted;
        }

        return $stats;
    }

    /**
     * Parse ISO 8601 duration to seconds
     *
     * @param string $duration ISO 8601 duration string (e.g., PT4M13S)
     * @return int|null Duration in seconds
     */
    private function parseISO8601Duration(string $duration): ?int
    {
        if (empty($duration)) {
            return null;
        }

        try {
            $interval = new \DateInterval($duration);
            return ($interval->h * 3600) + ($interval->i * 60) + $interval->s;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get channel information
     *
     * @return array|null
     */
    public function getChannelInfo(): ?array
    {
        try {
            if (empty($this->apiKey) || empty($this->channelId)) {
                return null;
            }

            $response = Http::get("{$this->apiBaseUrl}/channels", [
                'part' => 'snippet,statistics',
                'id' => $this->channelId,
                'key' => $this->apiKey,
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            if (empty($data['items'][0])) {
                return null;
            }

            $channel = $data['items'][0];

            return [
                'title' => $channel['snippet']['title'],
                'description' => $channel['snippet']['description'],
                'thumbnail' => $channel['snippet']['thumbnails']['high']['url'] ?? null,
                'subscriber_count' => $channel['statistics']['subscriberCount'] ?? 0,
                'video_count' => $channel['statistics']['videoCount'] ?? 0,
                'view_count' => $channel['statistics']['viewCount'] ?? 0,
            ];

        } catch (Exception $e) {
            Log::error('Error fetching channel info: ' . $e->getMessage());
            return null;
        }
    }
}