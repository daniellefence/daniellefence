<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class HelperFunctionsTest extends TestCase
{
    /** @test */
    public function danielle_helper_function_returns_danielle_instance()
    {
        $result = danielle();

        $this->assertInstanceOf(\App\Danielle::class, $result);
    }

    /** @test */
    public function toast_helper_function_returns_toast_instance()
    {
        $result = toast();

        $this->assertInstanceOf(\App\Toast::class, $result);
    }

    /** @test */
    public function permission_helper_function_returns_permission_instance()
    {
        $result = permission();

        $this->assertInstanceOf(\App\Permission::class, $result);
    }

    /** @test */
    public function product_menu_helper_function_returns_product_menu_instance()
    {
        $result = productMenu();

        $this->assertInstanceOf(\App\ProductMenu::class, $result);
    }

    /** @test */
    public function products_helper_function_returns_products_instance()
    {
        $result = products();

        $this->assertInstanceOf(\App\Products::class, $result);
    }

    /** @test */
    public function seeds_helper_function_returns_seeds_instance()
    {
        $result = seeds();

        $this->assertInstanceOf(\App\Seeds::class, $result);
    }

    /** @test */
    public function admin_menu_helper_function_returns_admin_menu_instance()
    {
        $result = adminMenu();

        $this->assertInstanceOf(\App\AdminMenu::class, $result);
    }

    /** @test */
    public function activity_helper_function_returns_activity_instance()
    {
        $result = activity();

        $this->assertInstanceOf(\App\Activity::class, $result);
    }

    /** @test */
    public function seo_helper_function_returns_seo_instance()
    {
        $result = seo();

        $this->assertInstanceOf(\App\Seo::class, $result);
    }

    /** @test */
    public function setting_helper_function_returns_setting_instance()
    {
        $result = setting();

        $this->assertInstanceOf(\App\Setting::class, $result);
    }

    /** @test */
    public function admin_routes_function_returns_array_of_routes()
    {
        $routes = adminRoutes();

        $this->assertIsArray($routes);
        $this->assertNotEmpty($routes);

        // Check structure of first route
        $firstRoute = $routes[0];
        $this->assertArrayHasKey('method', $firstRoute);
        $this->assertArrayHasKey('uri', $firstRoute);
        $this->assertArrayHasKey('class', $firstRoute);
        $this->assertArrayHasKey('middleware', $firstRoute);
        $this->assertArrayHasKey('name', $firstRoute);
        $this->assertArrayHasKey('title', $firstRoute);
        $this->assertArrayHasKey('buttons', $firstRoute);
    }

    /** @test */
    public function admin_routes_contains_expected_routes()
    {
        $routes = adminRoutes();
        $routeNames = array_column($routes, 'name');

        $expectedRoutes = [
            'admin.read',
            'admin.blog.read',
            'admin.user.read',
            'admin.contact.read',
            'admin.faq.read',
            'admin.products.read'
        ];

        foreach ($expectedRoutes as $expectedRoute) {
            $this->assertContains($expectedRoute, $routeNames);
        }
    }

    /** @test */
    public function admin_routes_blog_routes_have_correct_structure()
    {
        $routes = adminRoutes();
        $blogRoutes = array_filter($routes, function ($route) {
            return str_contains($route['name'], 'blog');
        });

        $this->assertNotEmpty($blogRoutes);

        // Find blog read route
        $blogReadRoute = collect($routes)->firstWhere('name', 'admin.blog.read');
        $this->assertNotNull($blogReadRoute);
        $this->assertEquals('get', $blogReadRoute['method']);
        $this->assertEquals('/blog', $blogReadRoute['uri']);
        $this->assertEquals('Blogs', $blogReadRoute['title']);
        $this->assertIsArray($blogReadRoute['buttons']);
    }

    /** @test */
    public function admin_routes_user_routes_have_correct_middleware()
    {
        $routes = adminRoutes();
        $userReadRoute = collect($routes)->firstWhere('name', 'admin.user.read');

        $this->assertNotNull($userReadRoute);
        $this->assertEquals('UserRead', $userReadRoute['middleware']);
    }

    /** @test */
    public function admin_routes_create_routes_have_correct_middleware()
    {
        $routes = adminRoutes();
        $createRoutes = array_filter($routes, function ($route) {
            return str_contains($route['name'], 'create');
        });

        foreach ($createRoutes as $route) {
            $this->assertStringContains('Create', $route['middleware']);
        }
    }

    /** @test */
    public function admin_routes_update_routes_have_correct_middleware()
    {
        $routes = adminRoutes();
        $updateRoutes = array_filter($routes, function ($route) {
            return str_contains($route['name'], 'update');
        });

        foreach ($updateRoutes as $route) {
            $this->assertStringContains('Update', $route['middleware']);
        }
    }

    /** @test */
    public function admin_routes_delete_route_has_post_method()
    {
        $routes = adminRoutes();
        $deleteRoute = collect($routes)->firstWhere('name', 'admin.delete');

        $this->assertNotNull($deleteRoute);
        $this->assertEquals('post', $deleteRoute['method']);
        $this->assertEquals('/delete', $deleteRoute['uri']);
    }

    /** @test */
    public function admin_routes_routes_with_buttons_have_correct_structure()
    {
        $routes = adminRoutes();
        $routesWithButtons = array_filter($routes, function ($route) {
            return !empty($route['buttons']);
        });

        foreach ($routesWithButtons as $route) {
            foreach ($route['buttons'] as $button) {
                $this->assertArrayHasKey('route', $button);
                $this->assertArrayHasKey('label', $button);
                $this->assertArrayHasKey('type', $button);
            }
        }
    }

    /** @test */
    public function admin_routes_products_routes_have_dynamic_parameters()
    {
        $routes = adminRoutes();
        $productSubcategoryRoute = collect($routes)->firstWhere('name', 'admin.products.subcategories');

        $this->assertNotNull($productSubcategoryRoute);
        $this->assertStringContains('{parent}', $productSubcategoryRoute['uri']);
        $this->assertStringContains('{parent_id}', $productSubcategoryRoute['uri']);
    }

    /** @test */
    public function admin_routes_all_routes_have_required_fields()
    {
        $routes = adminRoutes();

        $requiredFields = ['method', 'uri', 'class', 'middleware', 'name', 'title', 'buttons'];

        foreach ($routes as $route) {
            foreach ($requiredFields as $field) {
                $this->assertArrayHasKey($field, $route, "Route {$route['name']} missing {$field}");
            }
        }
    }

    /** @test */
    public function admin_routes_methods_are_valid_http_methods()
    {
        $routes = adminRoutes();
        $validMethods = ['get', 'post', 'put', 'patch', 'delete'];

        foreach ($routes as $route) {
            $this->assertContains($route['method'], $validMethods, "Invalid HTTP method: {$route['method']}");
        }
    }

    /** @test */
    public function admin_routes_uris_start_with_slash_or_are_empty()
    {
        $routes = adminRoutes();

        foreach ($routes as $route) {
            if (!empty($route['uri'])) {
                $this->assertStringStartsWith('/', $route['uri'], "URI should start with slash: {$route['uri']}");
            }
        }
    }

    /** @test */
    public function admin_routes_names_follow_naming_convention()
    {
        $routes = adminRoutes();

        foreach ($routes as $route) {
            if (!empty($route['name'])) {
                $this->assertStringStartsWith('admin.', $route['name'], "Route name should start with 'admin.': {$route['name']}");
            }
        }
    }

    /** @test */
    public function admin_routes_contains_all_crud_operations()
    {
        $routes = adminRoutes();
        $routeNames = array_column($routes, 'name');

        // Check for CRUD operations on common entities
        $entities = ['blog', 'user', 'faq', 'career', 'review'];

        foreach ($entities as $entity) {
            $readRoute = "admin.{$entity}.read";
            $createRoute = "admin.{$entity}.create";

            $this->assertContains($readRoute, $routeNames, "Missing read route for {$entity}");
            $this->assertContains($createRoute, $routeNames, "Missing create route for {$entity}");
        }
    }

    /** @test */
    public function helper_functions_exist_and_are_callable()
    {
        $helperFunctions = [
            'danielle',
            'toast',
            'permission',
            'productMenu',
            'products',
            'seeds',
            'adminMenu',
            'activity',
            'seo',
            'setting',
            'adminRoutes'
        ];

        foreach ($helperFunctions as $function) {
            $this->assertTrue(function_exists($function), "Helper function {$function} does not exist");
            $this->assertTrue(is_callable($function), "Helper function {$function} is not callable");
        }
    }
}