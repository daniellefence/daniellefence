<?php

namespace App\Services;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Conversions\ConversionCollection;

class MediaOptimizationService
{
    public static function addWebOptimizedConversions(ConversionCollection $conversions, string $collectionName = 'default'): void
    {
        // Thumbnail conversion (300px wide)
        $conversions->add('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Medium size (800px wide)
        $conversions->add('medium')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->quality(80)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Large size (1200px wide)
        $conversions->add('large')
            ->width(1200)
            ->height(900)
            ->sharpen(10)
            ->quality(80)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Hero/Banner size (1920px wide)
        $conversions->add('hero')
            ->width(1920)
            ->height(1080)
            ->sharpen(10)
            ->quality(75)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Mobile optimized (480px wide)
        $conversions->add('mobile')
            ->width(480)
            ->height(360)
            ->sharpen(10)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Original JPEG fallback (for browsers that don't support WebP)
        $conversions->add('large-jpg')
            ->width(1200)
            ->height(900)
            ->sharpen(10)
            ->quality(75)
            ->format('jpg')
            ->performOnCollections($collectionName);
    }

    public static function addGalleryConversions(ConversionCollection $conversions, string $collectionName = 'gallery'): void
    {
        // Gallery thumbnail (400px square)
        $conversions->add('gallery-thumb')
            ->crop('crop-center', 400, 400)
            ->sharpen(15)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Gallery medium (800px wide)
        $conversions->add('gallery-medium')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->quality(80)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Gallery large (lightbox view - 1600px wide)
        $conversions->add('gallery-large')
            ->width(1600)
            ->height(1200)
            ->sharpen(5)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);
    }

    public static function addAvatarConversions(ConversionCollection $conversions, string $collectionName = 'avatars'): void
    {
        // Small avatar (64px)
        $conversions->add('avatar-sm')
            ->crop('crop-center', 64, 64)
            ->sharpen(15)
            ->quality(90)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Medium avatar (128px)
        $conversions->add('avatar-md')
            ->crop('crop-center', 128, 128)
            ->sharpen(15)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Large avatar (256px)
        $conversions->add('avatar-lg')
            ->crop('crop-center', 256, 256)
            ->sharpen(10)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);
    }

    public static function addProductConversions(ConversionCollection $conversions, string $collectionName = 'products'): void
    {
        // Product thumbnail for listings (300px square)
        $conversions->add('product-thumb')
            ->crop('crop-center', 300, 300)
            ->sharpen(15)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Product card image (500px wide)
        $conversions->add('product-card')
            ->width(500)
            ->height(400)
            ->fit('crop', 500, 400)
            ->sharpen(10)
            ->quality(80)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Product detail view (800px wide)
        $conversions->add('product-detail')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->quality(80)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Product zoom view (1600px wide)
        $conversions->add('product-zoom')
            ->width(1600)
            ->height(1200)
            ->sharpen(5)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);

        // SEO/social sharing image (1200x630)
        $conversions->add('product-social')
            ->fit('crop', 1200, 630)
            ->sharpen(10)
            ->quality(80)
            ->format('jpg') // JPG for better social media compatibility
            ->performOnCollections($collectionName);
    }

    public static function addBlogConversions(ConversionCollection $conversions, string $collectionName = 'featured_image'): void
    {
        // Blog featured image thumbnail (400px wide)
        $conversions->add('blog-thumb')
            ->width(400)
            ->height(250)
            ->fit('crop', 400, 250)
            ->sharpen(15)
            ->quality(85)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Blog card image (600px wide)
        $conversions->add('blog-card')
            ->width(600)
            ->height(400)
            ->fit('crop', 600, 400)
            ->sharpen(10)
            ->quality(80)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Blog hero image (1200px wide)
        $conversions->add('blog-hero')
            ->width(1200)
            ->height(675)
            ->fit('crop', 1200, 675)
            ->sharpen(10)
            ->quality(80)
            ->format('webp')
            ->performOnCollections($collectionName);

        // Social sharing image (1200x630)
        $conversions->add('blog-social')
            ->fit('crop', 1200, 630)
            ->sharpen(10)
            ->quality(80)
            ->format('jpg') // JPG for better social media compatibility
            ->performOnCollections($collectionName);
    }

    public static function getResponsiveImageSrcSet(Media $media, string $conversion = 'large'): string
    {
        $srcSet = [];
        
        // Add different sizes for responsive images
        $sizes = [
            'mobile' => '480w',
            'medium' => '800w', 
            'large' => '1200w',
            'hero' => '1920w'
        ];

        foreach ($sizes as $size => $width) {
            if ($media->hasGeneratedConversion($size)) {
                $srcSet[] = $media->getUrl($size) . ' ' . $width;
            }
        }

        return implode(', ', $srcSet);
    }

    public static function getOptimizedImageUrl(Media $media, string $size = 'medium', bool $preferWebP = true): string
    {
        // Try WebP first if preferred and available
        if ($preferWebP && $media->hasGeneratedConversion($size)) {
            return $media->getUrl($size);
        }

        // Fallback to JPEG version
        $jpegSize = $size . '-jpg';
        if ($media->hasGeneratedConversion($jpegSize)) {
            return $media->getUrl($jpegSize);
        }

        // Final fallback to original
        return $media->getUrl();
    }

    public static function getImageMetadata(Media $media): array
    {
        return [
            'width' => $media->getCustomProperty('width'),
            'height' => $media->getCustomProperty('height'),
            'file_size' => $media->size,
            'mime_type' => $media->mime_type,
            'file_name' => $media->file_name,
            'alt_text' => $media->getCustomProperty('alt_text', ''),
            'caption' => $media->getCustomProperty('caption', ''),
        ];
    }

    public static function addImageMetadata(Media $media, array $metadata): void
    {
        foreach ($metadata as $key => $value) {
            $media->setCustomProperty($key, $value);
        }
        $media->save();
    }
}