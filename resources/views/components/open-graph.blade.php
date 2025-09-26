<!-- Open Graph / Facebook -->
<meta property="og:type" content="@switch(\Illuminate\Support\Facades\Route::currentRouteName()) @case('product-level-one') @case('product.slug') product @break @case('blog.read') article @break @default website @endswitch">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $pageTitle ?? seo()->meta('title') }}">
<meta property="og:description" content="{{ $pageDescription ?? seo()->meta('description') }}">
<meta property="og:site_name" content="Danielle Fence & Outdoor Living">
<meta property="og:locale" content="en_US">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $pageTitle ?? seo()->meta('title') }}">
<meta property="twitter:description" content="{{ $pageDescription ?? seo()->meta('description') }}">

@php
    $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
    $product = null;

    if ($currentRoute === 'product.slug') {
        $categorySlug = request()->route('category_slug');
        $productSlug = request()->route('product_slug');
        $categories = \App\Models\Category::all();
        $category = $categories->first(function ($cat) use ($categorySlug) {
            return \Illuminate\Support\Str::slug($cat->title) === $categorySlug;
        });

        if ($category) {
            $products = \App\Models\Product::where('category_id', $category->id)->get();
            $product = $products->first(function ($prod) use ($productSlug) {
                return \Illuminate\Support\Str::slug($prod->title) === $productSlug;
            });
        }
    }
@endphp

@if($product)
    @php
        $ogImage = $product->photos()->count() > 0 ? url($product->photos()->first()->path) : Vite::asset('resources/images/logo.webp');
    @endphp
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="twitter:image" content="{{ $ogImage }}">
    <meta property="product:price:amount" content="{{ $product->price ?? '0' }}">
    <meta property="product:price:currency" content="USD">
    <meta property="product:availability" content="in stock">
    <meta property="product:condition" content="new">
    <meta property="product:retailer_item_id" content="{{ $product->id }}">
@else
    <meta property="og:image" content="{{Vite::asset('resources/images/logo.webp')}}">
    <meta property="twitter:image" content="{{Vite::asset('resources/images/logo.webp')}}">
@endif

<!-- Image Properties -->
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Danielle Fence & Outdoor Living - Quality Fencing Solutions">

<!-- Business Information -->
<meta property="business:contact_data:street_address" content="4805 St Rd 60 West">
<meta property="business:contact_data:locality" content="Florida">
<meta property="business:contact_data:region" content="FL">
<meta property="business:contact_data:postal_code" content="33860">
<meta property="business:contact_data:country_name" content="United States">

