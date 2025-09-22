<?php

namespace App\Livewire;

use Livewire\Component;

class Social extends Component
{
    public $social = [
        'facebook' => [
            'url' => 'https://www.facebook.com/DanielleFenceOutdoorLiving',
            'text' => 'Follow on Facebook',
        ],
        'google' => [
            'url' => 'https://g.page/r/CRf_8juw8RDYEB0/review',
            'text' => 'Leave us a Google Review',
        ],
        'x' => [
            'url' => 'https://twitter.com/DanielleFence',
            'text' => 'Follow us on X',
        ],
        'tiktok' => [
            'url' => 'https://www.tiktok.com/@daniellefence',
            'text' => 'Follow us on Tiktok',
        ],
        'youtube' => [
            'url' => 'https://www.youtube.com/@daniellefenceoutdoorliving8500',
            'text' => 'Follow us on Youtube',
        ],
        'linkedin' => [
            'url' => 'https://www.linkedin.com/company/danielle-fence',
            'text' => 'Follow us on LinkedIn',
        ],
        'instagram' => [
            'url' => 'https://www.instagram.com/danielle_fence/',
            'text' => 'Follow us on Instagram',
        ],
        'pinterest' => [
            'url' => 'https://www.pinterest.com/daniellefence/',
            'text' => 'Follow us on Pinterest',
        ],

    ];

    public $orientation = 'vertical';

    public function mount($orientation)
    {
        $this->orientation = $orientation;
    }

    public function render()
    {
        return view('livewire.social');
    }
}
