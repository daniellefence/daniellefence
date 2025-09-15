<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user as default author
        $author = User::where('email', 'admin@daniellefence.com')->first() ?? User::first();
        
        // Get blog categories for relationships
        $fenceInstallation = BlogCategory::where('slug', 'fence-installation')->first();
        $diyProjects = BlogCategory::where('slug', 'diy-projects')->first();
        $maintenance = BlogCategory::where('slug', 'maintenance-repair')->first();
        $materialGuides = BlogCategory::where('slug', 'material-guides')->first();
        $companyNews = BlogCategory::where('slug', 'company-news')->first();

        $blogs = [
            [
                'title' => 'Complete Guide to DIY Vinyl Fence Installation',
                'slug' => 'complete-guide-diy-vinyl-fence-installation',
                'excerpt' => 'Everything you need to know about installing a vinyl fence yourself, from planning to finishing touches.',
                'content' => '<h2>Planning Your Vinyl Fence Installation</h2><p>Installing a vinyl fence is a rewarding DIY project that can save you thousands while adding value to your property. With proper planning and the right materials, most homeowners can complete a professional-looking installation.</p><h3>Tools You\'ll Need</h3><ul><li>Post hole digger</li><li>Level</li><li>Measuring tape</li><li>String line</li><li>Concrete mix</li></ul><p>Start by carefully measuring your property lines and marking post locations. Remember, vinyl fencing requires precise measurements for the best results.</p>',
                'blog_category_id' => $diyProjects?->id,
                'author_id' => $author?->id,
                'published' => true,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Why Aluminum Fencing is Perfect for Florida Properties',
                'slug' => 'why-aluminum-fencing-perfect-florida-properties',
                'excerpt' => 'Discover why aluminum fencing stands up to Florida\'s unique weather challenges and provides long-lasting value.',
                'content' => '<h2>Florida\'s Unique Fencing Challenges</h2><p>Florida\'s climate presents unique challenges for fencing materials. From hurricane-force winds to salt air and intense UV rays, your fence needs to withstand it all.</p><h3>Benefits of Aluminum Fencing</h3><p>Aluminum fencing offers exceptional durability in Florida\'s climate. Unlike iron, it won\'t rust, and unlike wood, it won\'t rot or warp in humidity.</p>',
                'blog_category_id' => $materialGuides?->id,
                'author_id' => $author?->id,
                'published' => true,
                'published_at' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Fence Maintenance Tips for Central Florida Weather',
                'slug' => 'fence-maintenance-tips-central-florida-weather',
                'excerpt' => 'Keep your fence looking great year-round with these essential maintenance tips for Florida\'s climate.',
                'content' => '<h2>Year-Round Fence Maintenance</h2><p>Central Florida\'s weather can be tough on fencing. Regular maintenance ensures your fence stays beautiful and functional for years to come.</p><h3>Seasonal Maintenance Schedule</h3><ul><li>Spring: Deep cleaning and inspection</li><li>Summer: Check for storm damage</li><li>Fall: Prepare for winter weather</li><li>Winter: Monitor for damage and plan repairs</li></ul>',
                'blog_category_id' => $maintenance?->id,
                'author_id' => $author?->id,
                'published' => true,
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Pool Safety: Choosing the Right Fence for Your Pool Area',
                'slug' => 'pool-safety-choosing-right-fence-pool-area',
                'excerpt' => 'Essential guide to pool fencing requirements and safety considerations for Florida homeowners.',
                'content' => '<h2>Pool Safety Regulations in Florida</h2><p>Florida law requires proper barriers around residential pools. Understanding these requirements helps you choose the right fencing solution.</p><h3>Height Requirements</h3><p>Pool fences must be at least 4 feet high, with specific gate and latch requirements for safety.</p>',
                'blog_category_id' => $fenceInstallation?->id,
                'author_id' => $author?->id,
                'published' => true,
                'published_at' => Carbon::now()->subDays(30),
            ],
            [
                'title' => 'Danielle Fence Celebrates 49 Years of Excellence',
                'slug' => 'danielle-fence-celebrates-49-years-excellence',
                'excerpt' => 'From humble beginnings to serving Disney World - the story of our nearly 50-year journey in Central Florida.',
                'content' => '<h2>Our Journey Since 1976</h2><p>What started as a small family business has grown into Central Florida\'s most trusted fencing company. From our first residential installation to major commercial projects with Disney World and SeaWorld, we\'ve built our reputation one fence at a time.</p><h3>Major Milestones</h3><p>Over the decades, we\'ve had the honor of working on some incredible projects, including theme park installations and major commercial developments throughout Central Florida.</p>',
                'blog_category_id' => $companyNews?->id,
                'author_id' => $author?->id,
                'published' => true,
                'published_at' => Carbon::now()->subDays(7),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::firstOrCreate(
                ['slug' => $blog['slug']],
                $blog
            );
        }
    }
}
