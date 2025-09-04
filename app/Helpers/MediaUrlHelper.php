<?php

namespace App\Helpers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaUrlHelper
{
    /**
     * Get the full URL for a media item with fallback
     */
    public static function getMediaUrl(Media $media, string $conversion = ''): string
    {
        try {
            if ($conversion && $media->hasGeneratedConversion($conversion)) {
                return $media->getFullUrl($conversion);
            }
            return $media->getFullUrl();
        } catch (\Exception $e) {
            // Return a placeholder image if the media is not found
            return asset('images/placeholder.svg');
        }
    }

    /**
     * Get a responsive image srcset for different screen sizes
     */
    public static function getResponsiveSrcset(Media $media): string
    {
        $srcset = [];
        
        // Define different sizes for responsive images
        $sizes = [
            'thumb' => '150w',
            'small' => '300w', 
            'medium' => '600w',
            'large' => '1200w',
        ];

        foreach ($sizes as $conversion => $width) {
            try {
                if ($media->hasGeneratedConversion($conversion)) {
                    $srcset[] = $media->getFullUrl($conversion) . ' ' . $width;
                }
            } catch (\Exception $e) {
                // Skip if conversion doesn't exist
                continue;
            }
        }

        // Add original as fallback
        $srcset[] = $media->getFullUrl() . ' 2000w';

        return implode(', ', $srcset);
    }

    /**
     * Get the best image URL for a specific use case
     */
    public static function getImageUrl(Media $media, string $useCase = 'default'): string
    {
        $conversions = [
            'thumbnail' => 'thumb',
            'card' => 'medium',
            'hero' => 'large',
            'gallery' => 'medium',
            'default' => '',
        ];

        $conversion = $conversions[$useCase] ?? '';
        
        return static::getMediaUrl($media, $conversion);
    }

    /**
     * Get media information for rich text editor insertion
     */
    public static function getMediaForEditor(Media $media): array
    {
        return [
            'id' => $media->id,
            'name' => $media->name,
            'url' => $media->getFullUrl(),
            'alt' => $media->getCustomProperty('alt', $media->name),
            'title' => $media->getCustomProperty('title', $media->name),
            'caption' => $media->getCustomProperty('caption'),
            'type' => static::getMediaType($media),
            'mime_type' => $media->mime_type,
            'size' => static::formatFileSize($media->size),
            'dimensions' => static::getImageDimensions($media),
        ];
    }

    /**
     * Get the media type for categorization
     */
    public static function getMediaType(Media $media): string
    {
        $mimeType = $media->mime_type ?? '';
        
        return match (true) {
            str_starts_with($mimeType, 'image/') => 'image',
            str_starts_with($mimeType, 'video/') => 'video', 
            str_starts_with($mimeType, 'audio/') => 'audio',
            in_array($mimeType, [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'text/plain'
            ]) => 'document',
            default => 'file',
        };
    }

    /**
     * Format file size in human readable format
     */
    public static function formatFileSize(?int $bytes): string
    {
        if (!$bytes) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen((string) $bytes) - 1) / 3);
        
        return sprintf("%.1f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
    }

    /**
     * Get image dimensions if available
     */
    public static function getImageDimensions(Media $media): ?array
    {
        $width = $media->getCustomProperty('width');
        $height = $media->getCustomProperty('height');
        
        if ($width && $height) {
            return [
                'width' => $width,
                'height' => $height,
                'ratio' => round($width / $height, 2)
            ];
        }
        
        return null;
    }

    /**
     * Generate a placeholder image URL
     */
    public static function getPlaceholder(int $width = 300, int $height = 300, string $text = ''): string
    {
        // You can use a service like picsum.photos or generate your own
        return "https://via.placeholder.com/{$width}x{$height}/cccccc/666666?text=" . urlencode($text ?: 'Image');
    }

    /**
     * Check if media is an image
     */
    public static function isImage(Media $media): bool
    {
        return str_starts_with($media->mime_type ?? '', 'image/');
    }

    /**
     * Check if media is a document
     */
    public static function isDocument(Media $media): bool
    {
        return static::getMediaType($media) === 'document';
    }

    /**
     * Get download URL with proper headers
     */
    public static function getDownloadUrl(Media $media): string
    {
        return route('media.download', ['media' => $media->id]);
    }
}