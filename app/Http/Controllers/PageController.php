<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }


    public function aboutUs()
    {
        return view('pages.about-us');
    }

    public function blog()
    {
        return view('pages.blog');
    }

    public function reviews()
    {
        return view('pages.reviews');
    }

    public function careers()
    {
        return view('pages.careers');
    }

    public function chat()
    {
        return view('pages.chat');
    }

    public function apply($id = false)
    {
        return view('pages.apply', ['id' => $id]);
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function blogRead($id)
    {
        return view('pages.blogRead', ['id' => $id]);
    }

    public function requestAQuote()
    {
        return view('pages.requestAQuote.index');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function productWarranties()
    {
        return view('pages.product-warranties');
    }

    public function easyFixes()
    {
        return view('pages.easy-fixes');
    }

    public function financing()
    {
        return view('pages.financing');
    }

    public function videos()
    {
        return view('pages.videos');
    }

    public function search()
    {
        return view('pages.search');
    }

    public function whyDanielleFence()
    {
        return view('pages.why-danielle-fence');
    }

    public function careerRead($id)
    {
        return view('pages.career.read', ['id' => $id]);
    }

    public function showroom()
    {
        return view('pages.showroom.read');
    }

    public function specials()
    {
        return view('pages.specials.read');
    }

    public function diy()
    {
        $diyProducts = \App\Models\DiyProduct::with('category')->where('is_active', true)->orderBy('sort_order')->get();
        $diyCategories = \App\Services\CacheService::getDiyCategories();

        return view('pages.diy.read', compact('diyProducts', 'diyCategories'));
    }

    public function thanks()
    {
        return view('pages.thanks.read');
    }

    public function special($id)
    {
        return view('pages.special.read', ['id' => $id]);
    }

    public function category($category_id)
    {
        return view('pages.productCategory.read', ['productCategory' => Category::find($category_id)]);
    }

    public function subcategory($subcategory_id)
    {
        return view('pages.productSubcategory.read', ['productSubcategory' => Category::find($subcategory_id)]);
    }

    public function product($product_id)
    {
        return view('pages.product.read', ['product' => Product::find($product_id)]);
    }

    // SEO-friendly slug-based routes
    public function categoryBySlug($category_slug)
    {
        $categories = Category::all();
        $category = $categories->first(function ($cat) use ($category_slug) {
            return Str::slug($cat->title) === $category_slug;
        });

        if (!$category) {
            abort(404);
        }

        return view('pages.productCategory.read', ['productCategory' => $category]);
    }

    public function productBySlug($category_slug, $product_slug)
    {
        $categories = Category::all();
        $category = $categories->first(function ($cat) use ($category_slug) {
            return Str::slug($cat->title) === $category_slug;
        });

        if (!$category) {
            abort(404);
        }

        $products = Product::where('category_id', $category->id)->get();
        $product = $products->first(function ($prod) use ($product_slug) {
            return Str::slug($prod->title) === $product_slug;
        });

        if (!$product) {
            abort(404);
        }

        return view('pages.product.read', ['product' => $product]);
    }

    public function cookiePolicy()
    {
        return view('pages.cookiePolicy.read');
    }

    public function terms()
    {
        return view('pages.terms.read');
    }

    public function privacy()
    {
        return view('pages.privacy.read');
    }

    public function returns()
    {
        return view('pages.returns.read');
    }

    public function disclaimer()
    {
        return view('pages.disclaimer.read');
    }

    public function acceptableUse()
    {
        return view('pages.acceptable-use.read');
    }

    public function resources()
    {
        return view('pages.resources.read');
    }

    public function fireFeatureCatalogs()
    {
        $catalogs = [
            [
                'label' => 'American Fyre Design',
                'image' => 'american-fyre-design.webp',
                'pdf' => 'american-fyre-design.pdf',
            ],
            [
                'label' => 'The Outdoor Plus (New)',
                'image' => 'outdoor-plus-new.webp',
                'pdf' => 'outdoor-plus-new.pdf',
            ],
            [
                'label' => 'The Outdoor Plus',
                'image' => 'outdoor-plus.webp',
                'pdf' => 'outdoor-plus.pdf',
            ],

        ];

        return view('pages.fire-feature-catalogs', [
            'catalogs' => $catalogs,
        ]);
    }

    public function pickettPals()
    {
        return view('pages.pickett-pals');
    }
}
