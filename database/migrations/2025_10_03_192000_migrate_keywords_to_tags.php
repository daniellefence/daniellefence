<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use App\Models\Blog;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Seo;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate Blog keywords
        $this->migrateKeywords(Blog::class, 'blogs');

        // Migrate Photo keywords
        $this->migrateKeywords(Photo::class, 'photos');

        // Migrate Product keywords
        $this->migrateKeywords(Product::class, 'products');

        // Migrate Seo keywords
        $this->migrateKeywords(Seo::class, 'seos');
    }

    private function migrateKeywords(string $modelClass, string $tableName): void
    {
        $items = DB::table($tableName)
            ->whereNotNull('keywords')
            ->where('keywords', '!=', '')
            ->get();

        foreach ($items as $item) {
            $keywords = $this->parseKeywords($item->keywords);

            foreach ($keywords as $keyword) {
                // Find or create tag
                $tag = Tag::firstOrCreate(
                    ['name' => $keyword],
                    ['slug' => \Illuminate\Support\Str::slug($keyword)]
                );

                // Attach tag to item if not already attached
                DB::table('taggables')->insertOrIgnore([
                    'tag_id' => $tag->id,
                    'taggable_id' => $item->id,
                    'taggable_type' => $modelClass,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function parseKeywords(string $keywords): array
    {
        // Handle both comma-separated and newline-separated keywords
        $keywords = str_replace(["\r\n", "\n", "\r"], ',', $keywords);
        $keywords = explode(',', $keywords);

        // Clean up each keyword
        $keywords = array_map('trim', $keywords);
        $keywords = array_filter($keywords); // Remove empty values
        $keywords = array_unique($keywords); // Remove duplicates

        return array_values($keywords);
    }

    public function down(): void
    {
        // Remove all taggable relationships (tags themselves remain)
        DB::table('taggables')->truncate();
    }
};
