<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Career;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first career for sample applications
        $career = Career::first();
        
        if (!$career) return;

        $applications = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'john.smith@example.com',
                'phone' => '(555) 123-4567',
                'cover_letter' => 'I am very interested in the fence installation position. I have 3 years of construction experience and am eager to learn.',
                'status' => 'pending',
                'career_id' => $career->id,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'email' => 'sarah.j@example.com',
                'phone' => '(555) 987-6543',
                'cover_letter' => 'Looking for an opportunity to join your team. I have experience in customer service and am hardworking.',
                'status' => 'pending',
                'career_id' => $career->id,
            ],
        ];

        foreach ($applications as $application) {
            Application::create($application);
        }
    }
}
