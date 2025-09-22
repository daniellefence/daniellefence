@php
$currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "{{ url('/') }}#organization",
      "name": "Danielle Fence & Outdoor Living",
      "url": "{{ url('/') }}",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ Vite::asset('resources/images/logo.webp') }}",
        "width": "300",
        "height": "100"
      },
      "description": "{{ seo()->defaultDescription() }}",
      "telephone": "(863) 425-3182",
      "additionalType": "https://schema.org/FenceContractor",
      "sameAs": [
        "https://www.facebook.com/daniellefence",
        "https://www.instagram.com/daniellefence"
      ],
      "areaServed": {
        "@type": "State",
        "name": "Florida"
      },
      "serviceType": [
        "Fence Installation",
        "Commercial Fencing",
        "Residential Fencing",
        "Vinyl Fencing",
        "Wood Fencing",
        "Chain Link Fencing",
        "Outdoor Kitchen Installation",
        "Fire Features",
        "Railings",
        "Pavers"
      ],
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "5.0",
        "reviewCount": "100+"
      },
      "founder": {
        "@type": "Person",
        "name": "Danielle"
      },
      "foundingDate": "1976",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "4805 St Rd 60 West",
        "addressLocality": "Florida",
        "addressRegion": "FL",
        "postalCode": "33860",
        "addressCountry": "US"
      }
    },
    {
      "@type": "WebSite",
      "@id": "{{ url('/') }}#website",
      "url": "{{ url('/') }}",
      "name": "Danielle Fence & Outdoor Living",
      "description": "{{ seo()->defaultDescription() }}",
      "publisher": {
        "@id": "{{ url('/') }}#organization"
      },
      "potentialAction": [
        {
          "@type": "SearchAction",
          "target": {
            "@type": "EntryPoint",
            "urlTemplate": "{{ route('search') }}?q={search_term_string}"
          },
          "query-input": "required name=search_term_string"
        }
      ]
    }
    @switch($currentRoute)
      @case('product-level-one')
      @case('product.slug')
        @php($product = \App\Models\Product::findOrFail(request('product_id') ?? request()->route('product_id')))
        ,{
          "@type": "Product",
          "@id": "{{ url()->current() }}#product",
          "name": "{{ $product->title }}",
          "description": "{{ $product->description ?? $product->title }}",
          "category": "{{ $product->category->title }}",
          "brand": {
            "@type": "Brand",
            "name": "{{ $product->brand ?? 'Danielle Fence' }}"
          },
          "manufacturer": {
            "@id": "{{ url('/') }}#organization"
          },
          @if($product->photos()->count() > 0)
          "image": "{{ url($product->photos()->first()->path) }}",
          @endif
          "url": "{{ url()->current() }}",
          @if($product->price)
          "offers": {
            "@type": "Offer",
            "price": "{{ $product->price }}",
            "priceCurrency": "USD",
            "availability": "https://schema.org/InStock",
            "seller": {
              "@id": "{{ url('/') }}#organization"
            }
          },
          @endif
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "5.0",
            "reviewCount": "10"
          }
        }
        @break
      @case('blog.read')
        @php($blog = \App\Models\Blog::findOrFail(request('id')))
        ,{
          "@type": "Article",
          "@id": "{{ url()->current() }}#article",
          "headline": "{{ $blog->title }}",
          "description": "{{ Str::limit(strip_tags($blog->content), 200) }}",
          "datePublished": "{{ $blog->created_at->toISOString() }}",
          "dateModified": "{{ $blog->updated_at->toISOString() }}",
          "author": {
            "@type": "Person",
            "name": "Danielle Fence & Outdoor Living",
            "url": "{{ url('/about-us') }}"
          },
          "publisher": {
            "@id": "{{ url('/') }}#organization"
          },
          @if($blog->photo()->count() > 0)
          "image": {
            "@type": "ImageObject",
            "url": "{{ url($blog->photo->path) }}",
            "width": "1200",
            "height": "630"
          },
          @endif
          "mainEntityOfPage": "{{ url()->current() }}",
          "articleSection": "{{ $blog->blogCategory->title ?? 'General' }}"
        }
        @break
      @case('home')
        ,{
          "@type": "LocalBusiness",
          "@id": "{{ url('/') }}#localbusiness",
          "name": "Danielle Fence & Outdoor Living",
          "description": "{{ seo()->defaultDescription() }}",
          "url": "{{ url('/') }}",
          "telephone": "(863) 425-3182",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "4805 St Rd 60 West",
            "addressLocality": "Florida",
            "addressRegion": "FL",
            "postalCode": "33860",
            "addressCountry": "US"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": "27.7663",
            "longitude": "-82.6404"
          },
          "openingHoursSpecification": [
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
              "opens": "08:00",
              "closes": "17:00"
            },
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": "Saturday",
              "opens": "08:00",
              "closes": "16:00"
            }
          ],
          "priceRange": "$$",
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "5.0",
            "reviewCount": "100+"
          }
        }
        @break
    @endswitch
  ]
}
</script>

<!-- Breadcrumb Schema -->
@if(request()->routeIs(['product.slug', 'category.slug', 'product-level-one', 'category']))
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Products",
      "item": "{{ url('/') }}#products"
    }
    @if(request()->routeIs(['product.slug', 'product-level-one']))
      @php($product = \App\Models\Product::findOrFail(request('product_id') ?? request()->route('product_id')))
      ,{
        "@type": "ListItem",
        "position": 3,
        "name": "{{ $product->category->title }}",
        "item": "{{ $product->category->getRoute() }}"
      },
      {
        "@type": "ListItem",
        "position": 4,
        "name": "{{ $product->title }}",
        "item": "{{ url()->current() }}"
      }
    @endif
  ]
}
</script>
@endif