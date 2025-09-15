<?php

namespace Database\Seeders;

use App\Models\Attachment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        $attachments = [
            [
                'attachable_type' => 'App\Models\Product',
                'attachable_id' => 1,
                'disk' => 'public',
                'path' => 'attachments/sample-product-manual.pdf',
                'name' => 'Product Installation Manual',
                'size' => 1024000,
                'mime' => 'application/pdf',
            ],
            [
                'attachable_type' => 'App\Models\Product',
                'attachable_id' => 1,
                'disk' => 'public',
                'path' => 'attachments/sample-warranty.pdf',
                'name' => 'Warranty Information',
                'size' => 512000,
                'mime' => 'application/pdf',
            ],
            [
                'attachable_type' => 'App\Models\Blog',
                'attachable_id' => 1,
                'disk' => 'public',
                'path' => 'attachments/sample-blog-image.jpg',
                'name' => 'Blog Featured Image',
                'size' => 2048000,
                'mime' => 'image/jpeg',
            ],
        ];

        foreach ($attachments as $attachment) {
            Attachment::create($attachment);
        }
    }
}