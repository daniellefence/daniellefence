<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Special;
use Carbon\Carbon;

class SpecialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specials = [
            [
                'title' => 'Spring Fence Special',
                'slug' => 'spring-fence-special',
                'description' => 'Get 15% off all vinyl fencing materials for your spring projects. Perfect time to upgrade your property!',
                'discount_percentage' => 15.00,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(60),
                'is_active' => true,
                'is_featured' => true,
                'promo_code' => 'SPRING15',
                'usage_limit' => 100,
                'usage_count' => 0,
                'min_purchase_amount' => 500.00,
                'applicable_categories' => ['vinyl-fencing'],
            ],
            [
                'title' => 'DIY Pool Fence Promotion',
                'slug' => 'diy-pool-fence-promotion',
                'description' => 'Save $200 on complete DIY pool fence kits. Safety and savings combined!',
                'discount_amount' => 200.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(45),
                'is_active' => true,
                'is_featured' => true,
                'promo_code' => 'POOLSAFE200',
                'usage_limit' => 50,
                'usage_count' => 0,
                'min_purchase_amount' => 1000.00,
                'applicable_products' => ['pool-fence-kit'],
            ],
            [
                'title' => 'Summer Chain Link Sale',
                'slug' => 'summer-chain-link-sale',
                'description' => '20% off all chain link fencing supplies. Commercial and residential options available.',
                'discount_percentage' => 20.00,
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(90),
                'is_active' => true,
                'is_featured' => false,
                'promo_code' => 'CHAINLINK20',
                'usage_limit' => 200,
                'usage_count' => 0,
                'min_purchase_amount' => 300.00,
                'applicable_categories' => ['chain-link'],
            ],
            [
                'title' => 'First-Time Customer Discount',
                'slug' => 'first-time-customer-discount',
                'description' => 'Welcome to Danielle Fence! Enjoy 10% off your first order.',
                'discount_percentage' => 10.00,
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => null, // Ongoing
                'is_active' => true,
                'is_featured' => false,
                'promo_code' => 'WELCOME10',
                'usage_limit' => null, // Unlimited
                'usage_count' => 0,
                'min_purchase_amount' => 200.00,
            ],
        ];

        foreach ($specials as $special) {
            Special::firstOrCreate(
                ['promo_code' => $special['promo_code']],
                $special
            );
        }
    }
}
