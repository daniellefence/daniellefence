<?php

use App\AdminMenu;

if (! function_exists('danielle')) {
    function danielle()
    {

        return new \App\Danielle;
    }
}
if (! function_exists('toast')) {

    function toast()
    {
        return new \App\Toast;
    }
}
if (! function_exists('permission')) {
    function permission()
    {
        return new \App\Permission;
    }
}
if (! function_exists('productMenu')) {
    function productMenu()
    {
        return new \App\ProductMenu;
    }
}
if (! function_exists('products')) {
    function products()
    {
        return new \App\Products;
    }
}
if (! function_exists('seeds')) {
    function seeds()
    {
        return new \App\Seeds;
    }
}
if (! function_exists('adminMenu')) {
    function adminMenu()
    {
        return new AdminMenu;
    }
}
if (! function_exists('activity')) {
    function activity()
    {
        return new \App\Activity;
    }
}
if (! function_exists('seo')) {
    function seo()
    {
        return new \App\Seo;
    }
}
if (! function_exists('setting')) {
    function setting()
    {
        return new \App\Setting;
    }
}
/**
 * @return array
 */
function adminRoutes()
{
    $routes = [
        ['method' => 'get', 'uri' => '/orders', 'class' => \App\Livewire\Orders::class, 'middleware' => 'OrdersRead', 'name' => 'admin.orders.read', 'title' => 'Orders'],
        ['method' => 'get', 'uri' => '/dealers', 'class' => \App\Livewire\AdminDealers::class, 'middleware' => 'DealersRead', 'name' => 'admin.dealers.read', 'title' => 'Dealers', 'buttons' => [
            [
                'route' => 'admin/dealer/create',
                'label' => 'Add Dealer',
                'type' => 'secondary',
                'title' => 'Create a new Dealer.',
            ],
        ],
        ],
        ['method' => 'get', 'uri' => '/dealer/create', 'class' => \App\Livewire\AdminDealerCreate::class, 'middleware' => 'DealersCreate', 'name' => 'admin.dealers.create', 'title' => 'Create a new dealer'],
        ['method' => 'get', 'uri' => '/', 'class' => App\Livewire\AdminActivity::class, 'middleware' => 'ActivityRead', 'name' => 'admin.read', 'title' => 'Activity', 'buttons' => []],
        ['method' => 'get', 'uri' => '/diy/categories', 'class' => \App\Livewire\AdminDiyCategories::class, 'middleware' => 'DiyUpdate', 'name' => 'admin.diy.categories', 'title' => 'DIY Categories', 'buttons' => []],
        ['method' => 'get', 'uri' => '/diy/create', 'class' => \App\Livewire\AdminDiyCreate::class, 'middleware' => 'DiyCreate', 'name' => 'admin.diy.create', 'title' => 'Create DIY', 'buttons' => []],
        ['method' => 'get', 'uri' => '/diy/update/{id}', 'class' => \App\Livewire\AdminDiyUpdate::class, 'middleware' => 'DiyUpdate', 'name' => 'admin.diy.update', 'title' => 'Update DIY', 'buttons' => []],
        ['method' => 'get', 'uri' => '/diy', 'class' => App\Livewire\AdminDiyRead::class, 'middleware' => 'DiyRead', 'name' => 'admin.diy.read', 'title' => 'DIY',
            'buttons' => [
                [
                    'route' => 'admin/diy/categories',
                    'label' => 'Categories',
                    'type' => 'secondary',
                    'title' => 'Create a new DIY Category.',
                ],
                [
                    'route' => 'admin/diy/create',
                    'label' => 'Add DIY',
                    'type' => 'secondary',
                    'title' => 'Create a new DIY item.',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/google-analytics', 'class' => App\Livewire\AdminGoogleAnalytics::class, 'middleware' => 'GoogleAnalyticsRead', 'name' => 'admin.google-analytics.read', 'title' => 'Google Analytics', 'buttons' => []],
        ['method' => 'get', 'uri' => '/career', 'class' => App\Livewire\AdminCareers::class, 'middleware' => 'CareerRead', 'name' => 'admin.career.read', 'title' => 'Careers',
            'buttons' => [
                [
                    'route' => 'admin/career/create',
                    'label' => 'Add Career',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/career/create', 'class' => App\Livewire\AdminCareersCreate::class, 'middleware' => 'CareerCreate', 'name' => 'admin.career.create', 'title' => 'Create Career', 'buttons' => []],
        ['method' => 'get', 'uri' => '/career/update/{id}', 'class' => App\Livewire\AdminCareersUpdate::class, 'middleware' => 'CareerUpdate', 'name' => 'admin.career.update', 'title' => 'Update Career',
            'buttons' => [],
        ],
        ['method' => 'get', 'uri' => '/contact', 'class' => App\Livewire\AdminContacts::class, 'middleware' => 'ContactRead', 'name' => 'admin.contact.read', 'title' => 'Contacts', 'buttons' => []],
        ['method' => 'get', 'uri' => '/blog', 'class' => App\Livewire\AdminBlogs::class, 'middleware' => 'BlogRead', 'name' => 'admin.blog.read', 'title' => 'Blogs', 'buttons' => [
            [
                'route' => 'admin/blog/category',
                'label' => 'Categories',
                'type' => 'secondary',
            ],
            [
                'route' => 'admin/blog/create',
                'label' => 'Add Blog Post',
                'type' => 'secondary',
            ],
        ]],
        ['method' => 'get', 'uri' => '/blog/preview/{id}', 'class' => App\Livewire\AdminBlogPreviewPage::class, 'middleware' => 'BlogRead', 'name' => 'admin.blog.preview', 'title' => 'Blog Preview', 'buttons' => [
            [
                'route' => 'admin/blog',
                'label' => 'Back to List',
                'type' => 'secondary',
            ],
        ]],
        ['method' => 'get', 'uri' => '/blog/create', 'class' => App\Livewire\AdminBlogCreate::class, 'middleware' => 'BlogCreate', 'name' => 'admin.blog.create', 'title' => 'Create Blog',
            'buttons' => [],
        ],
        ['method' => 'get', 'uri' => '/blog/update/{id}', 'class' => App\Livewire\AdminBlogUpdate::class, 'middleware' => 'BlogUpdate', 'name' => 'admin.blog.update', 'title' => 'Update Blog', 'buttons' => []],
        ['method' => 'get', 'uri' => '/blog/category', 'class' => App\Livewire\AdminBlogCategories::class, 'middleware' => 'BlogCategoryRead', 'name' => 'admin.blog.category.read', 'title' => 'Blog Categories', 'buttons' => []],
        ['method' => 'get', 'uri' => '/documentation', 'class' => App\Livewire\AdminDocumentation::class, 'middleware' => 'DocumentationRead', 'name' => 'admin.documentation.read', 'title' => 'Documentation',
            'buttons' => [
                [
                    'route' => 'admin/documentation/category/read',
                    'label' => 'Categories',
                    'type' => 'secondary',
                ],
                [
                    'route' => 'admin/documentation/create',
                    'label' => 'Add Documentation',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/documentation/category', 'class' => App\Livewire\AdminDocumentationCategories::class, 'middleware' => 'DocumentationCategoryRead', 'name' => 'admin.documentation.category.read', 'title' => 'Documentation Categories', 'buttons' => []],
        ['method' => 'get', 'uri' => '/documentation/create', 'class' => App\Livewire\AdminDocumentationCreate::class, 'middleware' => 'DocumentationCreate', 'name' => 'admin.documentation.create', 'title' => 'Create Documentation', 'buttons' => []],
        ['method' => 'get', 'uri' => '/category/create', 'class' => App\Livewire\AdminDocumentationCategories::class, 'middleware' => 'DocumentationCreate', 'name' => 'admin.documentation.category.create', 'title' => 'Create Documentation Category', 'buttons' => []],
        ['method' => 'get', 'uri' => '/faq', 'class' => App\Livewire\AdminFaq::class, 'middleware' => 'FaqRead', 'name' => 'admin.faq.read', 'title' => 'FAQ',
            'buttons' => [
                [
                    'route' => 'admin/faq/create',
                    'label' => 'Faq',
                    'type' => 'secondary',
                    'icon' => 'add',
                    'title' => 'Create new F.A.Q.',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/faq/create', 'class' => App\Livewire\AdminFaqCreate::class, 'middleware' => 'FaqCreate', 'name' => 'admin.faq.create', 'title' => 'Create FAQ', 'buttons' => []],
        ['method' => 'get', 'uri' => '/faq/edit/{id}', 'class' => App\Livewire\AdminFaqUpdate::class, 'middleware' => 'FaqUpdate', 'name' => 'admin.faq.edit', 'title' => 'Edit FAQ', 'buttons' => []],
        ['method' => 'get', 'uri' => '/review', 'class' => App\Livewire\AdminReviews::class, 'middleware' => 'ReviewRead', 'name' => 'admin.review.read', 'title' => 'Reviews', 'buttons' => [
            [
                'route' => 'admin/review/create',
                'label' => 'Add Review',
                'type' => 'secondary',
            ],
        ],
        ],
        ['method' => 'get', 'uri' => '/review/update/{id}', 'class' => App\Livewire\AdminReviewUpdate::class, 'middleware' => 'ReviewUpdate', 'name' => 'admin.review.update', 'title' => 'Update Review', 'buttons' => []],
        ['method' => 'get', 'uri' => '/review/create', 'class' => App\Livewire\AdminReviewsCreate::class, 'middleware' => 'ReviewCreate', 'name' => 'admin.review.create', 'title' => 'Create Review', 'buttons' => []],
        ['method' => 'get', 'uri' => '/seo', 'class' => App\Livewire\AdminSeo::class, 'middleware' => 'SeoRead', 'name' => 'admin.seo.read', 'title' => 'SEO', 'buttons' => []],
        ['method' => 'get', 'uri' => '/seo/update/{id}', 'class' => App\Livewire\AdminSeoUpdate::class, 'middleware' => 'SeoUpdate', 'name' => 'admin.seo.update', 'title' => 'Update SEO', 'buttons' => []],
        ['method' => 'get', 'uri' => '/tags', 'class' => App\Livewire\AdminTags::class, 'middleware' => 'TagsRead', 'name' => 'admin.tags', 'title' => 'Tags', 'buttons' => []],
        ['method' => 'get', 'uri' => '/traffic', 'class' => App\Livewire\AdminTraffic::class, 'middleware' => 'TrafficRead', 'name' => 'admin.traffic.read', 'title' => 'Traffic', 'buttons' => []],
        ['method' => 'get', 'uri' => '/user', 'class' => App\Livewire\AdminUsers::class, 'middleware' => 'UserRead', 'name' => 'admin.user.read', 'title' => 'Users',
            'buttons' => [
                [
                    'route' => 'admin/user/create',
                    'label' => 'Add User',
                    'type' => 'secondary',
                ],
                [
                    'route' => 'admin/roles',
                    'label' => 'Roles',
                    'type' => 'secondary',
                ],
                [
                    'route' => 'admin/permissions',
                    'label' => 'Permissions',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/user/update/{id}', 'class' => App\Livewire\AdminUserUpdate::class, 'middleware' => 'UserUpdate', 'name' => 'admin.user.update', 'title' => 'Update User', 'buttons' => []],
        ['method' => 'get', 'uri' => '/user/create', 'class' => App\Livewire\AdminUsersCreate::class, 'middleware' => 'UserCreate', 'name' => 'admin.user.create', 'title' => 'Create User', 'buttons' => []],
        ['method' => 'get', 'uri' => '/roles', 'class' => App\Livewire\AdminRoles::class, 'middleware' => 'UserRead', 'name' => 'admin.roles.read', 'title' => 'Roles',
            'buttons' => [
                [
                    'route' => 'admin/roles/create',
                    'label' => 'Add Role',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/roles/create', 'class' => App\Livewire\AdminRolesCreate::class, 'middleware' => 'UserRead', 'name' => 'admin.roles.create', 'title' => 'Create Role', 'buttons' => []],
        ['method' => 'get', 'uri' => '/roles/edit/{id}', 'class' => App\Livewire\AdminRolesEdit::class, 'middleware' => 'UserRead', 'name' => 'admin.roles.edit', 'title' => 'Edit Role', 'buttons' => []],
        ['method' => 'get', 'uri' => '/permissions', 'class' => App\Livewire\AdminPermissions::class, 'middleware' => 'UserRead', 'name' => 'admin.permissions.read', 'title' => 'Permissions',
            'buttons' => [
                [
                    'route' => 'admin/permissions/create',
                    'label' => 'Add Permission',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/permissions/create', 'class' => App\Livewire\AdminPermissionsCreate::class, 'middleware' => 'UserRead', 'name' => 'admin.permissions.create', 'title' => 'Create Permission', 'buttons' => []],
        ['method' => 'get', 'uri' => '/permissions/edit/{id}', 'class' => App\Livewire\AdminPermissionsEdit::class, 'middleware' => 'UserRead', 'name' => 'admin.permissions.edit', 'title' => 'Edit Permission', 'buttons' => []],
        ['method' => 'get', 'uri' => '/areas-we-serve', 'class' => App\Livewire\AdminAreasWeServe::class, 'middleware' => 'AreaRead', 'name' => 'admin.areas-we-serve.read', 'title' => 'Areas We Serve',
            'buttons' => [
                [
                    'route' => 'admin/area/create',
                    'label' => 'Add Area',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/area/create', 'class' => App\Livewire\AdminAreasWeServeCreate::class, 'middleware' => 'AreaCreate', 'name' => 'admin.area.create', 'title' => 'Create An Area', 'buttons' => []],
        ['method' => 'get', 'uri' => '/general', 'class' => App\Livewire\GeneralSettings::class, 'middleware' => 'GeneralRead', 'name' => 'admin.general.read', 'title' => 'General', 'buttons' => []],
        ['method' => 'get', 'uri' => '/specials', 'class' => App\Livewire\AdminSpecials::class, 'middleware' => 'SpecialsRead', 'name' => 'admin.specials.read', 'title' => 'Specials',
            'buttons' => [
                [
                    'route' => 'admin/specials/create',
                    'label' => 'Add Special',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/specials/create', 'class' => App\Livewire\AdminSpecialsCreate::class, 'middleware' => 'SpecialsCreate', 'name' => 'admin.specials.create', 'title' => 'Create Special', 'buttons' => []],
        ['method' => 'get', 'uri' => '/specials/update/{id}', 'class' => App\Livewire\AdminSpecialsUpdate::class, 'middleware' => 'SpecialsUpdate', 'name' => 'admin.specials.update', 'title' => 'Update Special', 'buttons' => []],
        ['method' => 'get', 'uri' => '/products', 'class' => App\Livewire\AdminCategories::class, 'middleware' => 'ProductRead', 'name' => 'admin.products.read', 'title' => 'Products',
            'buttons' => [
                [
                    'route' => 'admin/products/category/create',
                    'label' => 'Add Category',
                    'type' => 'secondary',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/products/subcategories/{parent}/{parent_id}', 'class' => App\Livewire\AdminSubcategories::class, 'middleware' => 'SubcategoryRead', 'name' => 'admin.products.subcategories', 'title' => 'Subcategories',
            'buttons' => [
                [
                    'route' => 'admin/products/subcategories/create/'.request('parent').'/'.request('parent_id'),
                    'label' => 'Add Subcategory',
                    'type' => 'secondary',
                    'title' => 'Create new Subcategory.',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/products/products/{parent}/{parent_id}', 'class' => App\Livewire\AdminProducts::class, 'middleware' => 'ProductRead', 'name' => 'admin.products.products', 'title' => 'Products',
            'buttons' => [
                [
                    'route' => 'admin/products/product/create/'.request('parent').'/'.request('parent_id'),
                    'label' => 'Add Product',
                    'type' => 'secondary',
                    'icon' => 'add',
                    'title' => 'Create new Product.',
                ],
            ],
        ],
        ['method' => 'get', 'uri' => '/products/product/edit/{id}', 'class' => App\Livewire\AdminProductsProductEdit::class, 'middleware' => 'ProductUpdate', 'name' => 'admin.products.product.edit', 'title' => 'Update Product', 'buttons' => []],
        ['method' => 'get', 'uri' => '/products/product/photo/edit/{id}', 'class' => App\Livewire\AdminProductPhotoEdit::class, 'middleware' => 'ProductUpdate', 'name' => 'admin.products.product.photo.edit', 'title' => 'Update Photo', 'buttons' => []],
        ['method' => 'get', 'uri' => '/products/category/edit/{id}', 'class' => App\Livewire\AdminProductsCategoryEdit::class, 'middleware' => 'ProductUpdate', 'name' => 'admin.products.category.edit', 'title' => 'Update Category', 'buttons' => []],
        ['method' => 'get', 'uri' => '/products/subcategory/edit/{id}', 'class' => App\Livewire\AdminProductsSubcategoryEdit::class, 'middleware' => 'ProductUpdate', 'name' => 'admin.products.subcategory.edit', 'title' => 'Update Subcategory', 'buttons' => []],
        ['method' => 'get', 'uri' => '/products/category/create', 'class' => App\Livewire\AdminProductsCategoryCreate::class, 'middleware' => 'ProductCreate', 'name' => 'admin.products.category.create', 'title' => 'Create Category', 'buttons' => []],
        ['method' => 'get', 'uri' => '/products/subcategories/create/{parent}/{parent_id}', 'class' => App\Livewire\AdminProductsSubcategoryCreate::class, 'middleware' => 'ProductCreate', 'name' => 'admin.products.subcategories.create', 'title' => 'Create Subcategory', 'buttons' => []],
        ['method' => 'get', 'uri' => '/products/product/create/{parent}/{parent_id}', 'class' => App\Livewire\AdminProductsProductCreate::class, 'middleware' => 'ProductCreate', 'name' => 'admin.products.product.create', 'title' => 'Create Product', 'buttons' => []],
        ['method' => 'post', 'uri' => '/delete', 'class' => [App\Http\Controllers\DeleteController::class, 'delete'], 'middleware' => 'Delete', 'name' => 'admin.delete', 'title' => '', 'buttons' => []],
    ];

    return $routes;
}
