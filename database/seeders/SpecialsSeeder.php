<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SpecialsSeeder extends Seeder
{
    public $specials = [
        [
            'title' => 'DIY Aluminum Fence',
            'price' => 80,
            'images' => [
                'aluminum.jpg',
            ],
            'condition' => 'new',
            'content' => <<<'HTML'
48" Tall 3-Rail Avalon Aluminum Fence<br/>
$80.37 Per Panel<br/>
One Fence panel, one post and cap<br/>
Pickup only
HTML,

        ],
        [
            'title' => 'DIY Wood Fence',
            'price' => 69,
            'condition' => 'new',
            'images' => [
                'wood.jpg',
            ],
            'content' => <<<'HTML'
6 x 8 Board on Board Wood Fence<br/>
$69.95 Per Panel<br/>
**WHILE SUPPLIES LAST**<br/>
Material only<br/>
Pickup only<br/>
HTML,

        ],
        [
            'title' => 'DIY Vinyl Fence',
            'price' => 17,
            'condition' => 'new',
            'images' => [
                'vinyl.jpg',
            ],

            'content' => <<<'HTML'
72" Tall Lakeland Vinyl Fence<br/>
$17.40 Per Foot<br/>
Fence material only<br/>
Pickup only<br/>
HTML,

        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->specials as $special) {
            $s = Special::create([
                'title' => $special['title'],
                'price' => $special['price'],
                'condition' => $special['condition'],
                'content' => $special['content'],
            ]);
            foreach ($special['images'] as $image) {
                $path = Storage::disk('public')->putFile('resources/images/specials/'.$image);
                $s->photos()->create([
                    'path' => $path,
                ]);
            }
        }
    }
}
