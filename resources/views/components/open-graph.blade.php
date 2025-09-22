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

@switch(\Illuminate\Support\Facades\Route::currentRouteName())
    @case("product-level-one")
    @case("product.slug")
        @php($product = \App\Models\Product::findOrFail(request('product_id') ?? request()->route('product_id')))
        <meta property="og:image" content="@if($product->photos()->count() > 0){{url($product->photos()->first()->path)}}@else{{Vite::asset('resources/images/logo.webp')}}@endif">
        <meta property="twitter:image" content="@if($product->photos()->count() > 0){{url($product->photos()->first()->path)}}@else{{Vite::asset('resources/images/logo.webp')}}@endif">
        <meta property="product:price:amount" content="{{ $product->price ?? '0' }}">
        <meta property="product:price:currency" content="USD">
        <meta property="product:availability" content="in stock">
        <meta property="product:condition" content="new">
        <meta property="product:retailer_item_id" content="{{ $product->id }}">
        @break
    @case("blog.read")
        @php($blog = \App\Models\Blog::findOrFail(request('id')))
        <meta property="og:image" content="@if($blog->photo()->count() > 0){{url($blog->photo->path)}}@else{{Vite::asset('resources/images/logo.webp')}}@endif">
        <meta property="twitter:image" content="@if($blog->photo()->count() > 0){{url($blog->photo->path)}}@else{{Vite::asset('resources/images/logo.webp')}}@endif">
        <meta property="article:published_time" content="{{ $blog->created_at->toISOString() }}">
        <meta property="article:modified_time" content="{{ $blog->updated_at->toISOString() }}">
        <meta property="article:author" content="Danielle Fence & Outdoor Living">
        <meta property="article:section" content="{{ $blog->blogCategory->title ?? 'General' }}">
        @if($blog->keywords)
            @foreach(explode(',', $blog->keywords) as $tag)
                <meta property="article:tag" content="{{ trim($tag) }}">
            @endforeach
        @endif
        @break
    @default
        <meta property="og:image" content="{{Vite::asset('resources/images/logo.webp')}}">
        <meta property="twitter:image" content="{{Vite::asset('resources/images/logo.webp')}}">
@endswitch

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

