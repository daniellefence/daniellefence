<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Career;
use Carbon\Carbon;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $careers = [
            [
                'title' => 'Fence Installation Technician',
                'description' => 'Join our team as a Fence Installation Technician! We\'re looking for hardworking individuals to help install residential and commercial fencing throughout Central Florida. Full training provided for the right candidate.',
                'location' => 'Lakeland, FL',
                'requirements' => '<ul><li>Valid driver\'s license</li><li>Ability to lift 50+ lbs</li><li>Comfortable working outdoors in all weather</li><li>Basic hand tool experience preferred</li><li>Reliable transportation</li><li>Strong work ethic and attention to detail</li></ul>',
                'published' => true,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Sales Representative',
                'description' => 'Exciting opportunity for an experienced sales professional to join our growing team. Help homeowners and businesses find the perfect fencing solutions while earning competitive commissions.',
                'location' => 'Lakeland, FL',
                'requirements' => '<ul><li>2+ years sales experience</li><li>Excellent communication skills</li><li>Customer service oriented</li><li>Basic computer skills</li><li>Construction/home improvement knowledge preferred</li><li>Ability to work weekends as needed</li></ul>',
                'published' => true,
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Project Manager',
                'description' => 'We\'re seeking an experienced Project Manager to oversee our commercial fencing projects. This role involves coordinating with clients, managing installation crews, and ensuring projects are completed on time and within budget.',
                'location' => 'Lakeland, FL',
                'requirements' => '<ul><li>5+ years project management experience</li><li>Construction industry background preferred</li><li>Strong organizational and communication skills</li><li>Proficient in project management software</li><li>Valid driver\'s license and reliable transportation</li><li>Ability to read blueprints and technical drawings</li></ul>',
                'published' => true,
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Warehouse Associate',
                'description' => 'Join our warehouse team! We need a reliable individual to help with inventory management, order preparation, and material handling for our DIY and installation operations.',
                'location' => 'Lakeland, FL',
                'requirements' => '<ul><li>High school diploma or equivalent</li><li>Ability to lift up to 75 lbs</li><li>Forklift experience preferred</li><li>Basic math and computer skills</li><li>Attention to detail</li><li>Ability to work in a fast-paced environment</li></ul>',
                'published' => true,
                'published_at' => Carbon::now()->subDays(8),
            ],
        ];

        foreach ($careers as $career) {
            Career::create($career);
        }
    }
}
