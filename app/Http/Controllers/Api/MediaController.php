<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        // Check if user has permission to view media
        if (!auth()->check() || !auth()->user()->can('view_media')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Media::query()
            ->orderBy('created_at', 'desc');

        // Filter by collection if specified
        if ($request->has('collection') && $request->collection) {
            $query->where('collection_name', $request->collection);
        }

        // Filter by mime type if specified
        if ($request->has('type') && $request->type) {
            $query->where('mime_type', 'like', $request->type . '/%');
        }

        // Search by name or filename
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('custom_properties->alt', 'like', "%{$search}%");
            });
        }

        $media = $query->limit(100)->get();

        // Get unique collections for filter dropdown
        $collections = Media::select('collection_name')
            ->distinct()
            ->whereNotNull('collection_name')
            ->pluck('collection_name')
            ->filter()
            ->values();

        $mediaData = $media->map(function (Media $item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'file_name' => $item->file_name,
                'mime_type' => $item->mime_type,
                'size' => $item->size,
                'collection_name' => $item->collection_name,
                'original_url' => $item->getFullUrl(),
                'preview_url' => $this->getPreviewUrl($item),
                'alt_text' => $item->getCustomProperty('alt'),
                'description' => $item->getCustomProperty('description'),
                'created_at' => $item->created_at?->toISOString(),
            ];
        });

        return response()->json([
            'media' => $mediaData,
            'collections' => $collections,
            'total' => $media->count(),
        ]);
    }

    public function show(Media $media): JsonResponse
    {
        // Check if user has permission to view media
        if (!auth()->check() || !auth()->user()->can('view_media')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'id' => $media->id,
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'size' => $media->size,
            'collection_name' => $media->collection_name,
            'original_url' => $media->getFullUrl(),
            'preview_url' => $this->getPreviewUrl($media),
            'alt_text' => $media->getCustomProperty('alt'),
            'description' => $media->getCustomProperty('description'),
            'caption' => $media->getCustomProperty('caption'),
            'custom_properties' => $media->custom_properties,
            'created_at' => $media->created_at?->toISOString(),
            'updated_at' => $media->updated_at?->toISOString(),
        ]);
    }

    private function getPreviewUrl(Media $media): string
    {
        // For images, try to get a thumbnail/conversion, otherwise use original
        if (str_starts_with($media->mime_type ?? '', 'image/')) {
            try {
                // Try to get a thumb conversion if it exists
                return $media->getFullUrl('thumb');
            } catch (\Exception $e) {
                // Fall back to original if no conversion exists
                return $media->getFullUrl();
            }
        }

        // For non-images, return the original URL
        return $media->getFullUrl();
    }
}