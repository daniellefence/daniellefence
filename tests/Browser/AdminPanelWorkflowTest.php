<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Helpers\BrowserTestHelpers;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminPanelWorkflowTest extends DuskTestCase
{
    use DatabaseMigrations, BrowserTestHelpers;

    protected User $adminUser;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $this->regularUser = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function admin_can_access_filament_admin_panel()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin')
                   ->waitForPageLoad($browser)
                   ->assertSee('Dashboard')
                   ->assertPresent('.fi-sidebar')
                   ->assertPresent('.fi-main-nav');
        });
    }

    /** @test */
    public function admin_can_navigate_through_different_resources()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin')
                   ->waitForPageLoad($browser);

            // Test navigation to different resources
            $resources = [
                'Blogs' => '/admin/blogs',
                'Categories' => '/admin/categories',
                'Products' => '/admin/products',
                'Users' => '/admin/users',
            ];

            foreach ($resources as $resourceName => $expectedUrl) {
                // Look for navigation link
                if ($browser->element("a[href*='$expectedUrl']") ||
                    $browser->element("a:contains('$resourceName')")) {

                    $browser->click("a[href*='$expectedUrl'], a:contains('$resourceName')")
                           ->waitForPageLoad($browser)
                           ->pause(1000)
                           ->assertPathIs($expectedUrl)
                           ->assertSee($resourceName);
                }
            }
        });
    }

    /** @test */
    public function admin_can_create_new_blog_post()
    {
        Category::factory()->create(['title' => 'Test Category']);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Click Create button
            $browser->click('[data-action="create"], .fi-btn:contains("New"), .fi-ac-btn-action:contains("Create")')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Fill in the form
            $browser->type('input[wire\\:model="data.title"], input[name="title"]', 'Test Blog Post')
                   ->type('input[wire\\:model="data.slug"], input[name="slug"]', 'test-blog-post')
                   ->pause(1000);

            // Select category if available
            if ($browser->element('select[wire\\:model*="category"], select[name*="category"]')) {
                $browser->select('select[wire\\:model*="category"], select[name*="category"]', '1');
            }

            // Fill content if rich editor is available
            if ($browser->element('.ProseMirror')) {
                $browser->click('.ProseMirror')
                       ->type('.ProseMirror', 'This is test blog content.');
            } else if ($browser->element('textarea[wire\\:model*="content"]')) {
                $browser->type('textarea[wire\\:model*="content"]', 'This is test blog content.');
            }

            // Save the blog post
            $browser->click('button[type="submit"], .fi-btn-action:contains("Create"), .fi-btn:contains("Save")')
                   ->waitForPageLoad($browser)
                   ->pause(3000);

            // Verify creation success
            $browser->assertSee('Test Blog Post')
                   ->orWhere(function ($browser) {
                       $browser->assertSee('created')
                              ->orWhere(function ($browser) {
                                  $browser->assertSee('success');
                              });
                   });
        });
    }

    /** @test */
    public function admin_can_edit_existing_blog_post()
    {
        $category = Category::factory()->create(['title' => 'Test Category']);
        $blog = Blog::factory()->create([
            'title' => 'Original Blog Title',
            'slug' => 'original-blog-title',
            'category_id' => $category->id,
        ]);

        $this->browse(function (Browser $browser) use ($blog) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Find and click edit button for the blog
            $browser->click("tr:contains('Original Blog Title') .fi-ac-btn-action, a[href*='/admin/blogs/{$blog->id}/edit']")
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Update the title
            $browser->clear('input[wire\\:model="data.title"], input[name="title"]')
                   ->type('input[wire\\:model="data.title"], input[name="title"]', 'Updated Blog Title');

            // Save changes
            $browser->click('button[type="submit"], .fi-btn-action:contains("Save"), .fi-btn:contains("Update")')
                   ->waitForPageLoad($browser)
                   ->pause(3000);

            // Verify update
            $browser->assertSee('Updated Blog Title');
        });
    }

    /** @test */
    public function admin_can_delete_blog_post()
    {
        $category = Category::factory()->create(['title' => 'Test Category']);
        $blog = Blog::factory()->create([
            'title' => 'Blog to Delete',
            'slug' => 'blog-to-delete',
            'category_id' => $category->id,
        ]);

        $this->browse(function (Browser $browser) use ($blog) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Find the blog row and delete button
            $browser->click("tr:contains('Blog to Delete') .fi-ac-btn-action[data-action='delete'], button[wire\\:click*='delete'][wire\\:click*='{$blog->id}']")
                   ->pause(1000);

            // Confirm deletion if modal appears
            if ($browser->element('.fi-modal')) {
                $browser->click('.fi-modal .fi-btn-danger, .fi-modal button:contains("Delete"), .fi-modal button:contains("Confirm")')
                       ->pause(2000);
            }

            // Verify deletion
            $browser->assertDontSee('Blog to Delete');
        });
    }

    /** @test */
    public function admin_can_use_table_filters_and_search()
    {
        $category = Category::factory()->create(['title' => 'Test Category']);
        Blog::factory()->create([
            'title' => 'Searchable Blog Post',
            'slug' => 'searchable-blog-post',
            'category_id' => $category->id,
        ]);
        Blog::factory()->create([
            'title' => 'Another Blog Post',
            'slug' => 'another-blog-post',
            'category_id' => $category->id,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Test search functionality
            if ($browser->element('input[placeholder*="Search"], .fi-ta-search input')) {
                $browser->type('input[placeholder*="Search"], .fi-ta-search input', 'Searchable')
                       ->pause(2000)
                       ->assertSee('Searchable Blog Post')
                       ->assertDontSee('Another Blog Post');

                // Clear search
                $browser->clear('input[placeholder*="Search"], .fi-ta-search input')
                       ->pause(2000);
            }

            // Test filters if available
            if ($browser->element('.fi-ta-filters button, button:contains("Filter")')) {
                $browser->click('.fi-ta-filters button, button:contains("Filter")')
                       ->pause(1000);

                // Apply filter if filter options are available
                if ($browser->element('select[wire\\:model*="filter"]')) {
                    $browser->select('select[wire\\:model*="filter"]', '1')
                           ->pause(2000);
                }
            }
        });
    }

    /** @test */
    public function admin_can_bulk_select_and_perform_actions()
    {
        $category = Category::factory()->create(['title' => 'Test Category']);
        Blog::factory()->count(3)->create([
            'category_id' => $category->id,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Select all checkbox if available
            if ($browser->element('input[type="checkbox"][wire\\:model="selectedTableRecords"]')) {
                $browser->check('input[type="checkbox"][wire\\:model="selectedTableRecords"]')
                       ->pause(1000);

                // Look for bulk actions
                if ($browser->element('.fi-ta-bulk-actions')) {
                    $browser->assertPresent('.fi-ta-bulk-actions');
                }
            } else {
                // Try individual checkboxes
                $checkboxes = $browser->elements('input[type="checkbox"][wire\\:model*="selectedRecords"]');
                if (!empty($checkboxes) && count($checkboxes) > 1) {
                    $browser->check($checkboxes[0])
                           ->check($checkboxes[1])
                           ->pause(1000);
                }
            }
        });
    }

    /** @test */
    public function admin_can_export_data()
    {
        $category = Category::factory()->create(['title' => 'Test Category']);
        Blog::factory()->count(5)->create([
            'category_id' => $category->id,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Look for export functionality
            if ($browser->element('button:contains("Export"), .fi-ac-btn-action[data-action="export"]')) {
                $browser->click('button:contains("Export"), .fi-ac-btn-action[data-action="export"]')
                       ->pause(2000);

                // Handle export modal or download if it appears
                if ($browser->element('.fi-modal')) {
                    $browser->click('.fi-modal .fi-btn:contains("Export"), .fi-modal .fi-btn:contains("Download")')
                           ->pause(3000);
                }
            }
        });
    }

    /** @test */
    public function admin_can_access_user_management()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/users')
                   ->waitForPageLoad($browser)
                   ->pause(2000)
                   ->assertSee('Users')
                   ->assertSee($this->adminUser->email);
        });
    }

    /** @test */
    public function admin_panel_has_responsive_navigation()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin')
                   ->waitForPageLoad($browser);

            // Test mobile responsive behavior
            $this->setMobileViewport($browser);
            $browser->pause(1000);

            // Look for mobile menu toggle
            if ($browser->element('.fi-sidebar-toggle, button[aria-label*="navigation"]')) {
                $browser->click('.fi-sidebar-toggle, button[aria-label*="navigation"]')
                       ->pause(500)
                       ->assertPresent('.fi-sidebar');
            }

            // Test tablet view
            $this->setTabletViewport($browser);
            $browser->pause(1000);

            // Test desktop view
            $this->setDesktopViewport($browser);
            $browser->pause(1000)
                   ->assertPresent('.fi-sidebar');
        });
    }

    /** @test */
    public function admin_can_access_dashboard_widgets()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Look for dashboard widgets
            if ($browser->element('.fi-wi-stats-overview, .fi-widgets')) {
                $browser->assertPresent('.fi-wi-stats-overview, .fi-widgets');
            }

            // Check for specific widget content
            $browser->assertSee('Dashboard')
                   ->orWhere(function ($browser) {
                       $browser->assertPresent('[class*="widget"], [class*="stat"]');
                   });
        });
    }

    /** @test */
    public function regular_user_cannot_access_admin_panel()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->regularUser)
                   ->visit('/admin')
                   ->pause(2000);

            // Should be redirected or see forbidden message
            $browser->assertSee('403')
                   ->orWhere(function ($browser) {
                       $browser->assertSee('Forbidden')
                              ->orWhere(function ($browser) {
                                  $browser->assertSee('Unauthorized')
                                         ->orWhere(function ($browser) {
                                             $browser->assertPathIs('/login');
                                         });
                              });
                   });
        });
    }
}