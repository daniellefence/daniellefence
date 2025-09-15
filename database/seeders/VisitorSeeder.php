<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    public function run(): void
    {
        $visitors = [
            [
                'ip_address' => '192.168.1.1',
                'anonymized_ip' => '192.168.1.***',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'country' => 'United States',
                'city' => 'Tampa',
                'visited_at' => now()->subDays(1),
            ],
            [
                'ip_address' => '10.0.0.1',
                'anonymized_ip' => '10.0.0.***',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'country' => 'United States',
                'city' => 'Orlando',
                'visited_at' => now()->subDays(2),
            ],
            [
                'ip_address' => '172.16.0.1',
                'anonymized_ip' => '172.16.0.***',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1',
                'country' => 'United States',
                'city' => 'Miami',
                'visited_at' => now()->subDays(3),
            ],
            [
                'ip_address' => '203.0.113.1',
                'anonymized_ip' => '203.0.113.***',
                'user_agent' => 'Mozilla/5.0 (Android 11; Mobile; rv:89.0) Gecko/89.0 Firefox/89.0',
                'country' => 'United States',
                'city' => 'Jacksonville',
                'visited_at' => now()->subHours(12),
            ],
            [
                'ip_address' => '198.51.100.1',
                'anonymized_ip' => '198.51.100.***',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
                'country' => 'United States',
                'city' => 'Fort Lauderdale',
                'visited_at' => now()->subHours(6),
            ],
        ];

        foreach ($visitors as $visitor) {
            Visitor::create($visitor);
        }
    }
}