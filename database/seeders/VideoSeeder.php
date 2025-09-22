<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public $videos = [
        [
            'title' => 'Dr Fencestopher talks about the reflective qualities of our Vinyl fence.',
            'code' => 'https://www.youtube.com/embed/p3G2P_mTvtk?si=OCxED5I33DGA2ibj',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->videos as $video) {
            Video::create([
                'code' => $video['code'],
                'title' => $video['title'],
            ]);
        }
    }
}
