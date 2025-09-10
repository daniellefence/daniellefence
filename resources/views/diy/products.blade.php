<x-app-layout>

    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-danielle to-daniellealt text-white w-full py-16">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                        Professional Fence Materials
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-white max-w-3xl mx-auto">
                        Professional-grade fencing materials with complete component lists. 
                        Choose from Vinyl/PVC, Aluminum, or Wood - panels, gates, and all hardware included.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('diy.quote') }}" class="w-full sm:w-auto rounded-md bg-white px-6 py-3 text-lg font-semibold text-danielle shadow-sm hover:bg-gray-100">
                            Get Custom Quote
                        </a>
                        <a href="tel:863-425-3182" class="w-full sm:w-auto text-lg font-semibold leading-6 text-white border border-white rounded-md px-6 py-3 hover:bg-white hover:text-danielle transition-colors">
                            Call Expert: (863) 425-3182
                        </a>
                    </div>
                </div>
            </div>
        </div>



        <!-- Products Grid -->
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Our DIY Product Line
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-gray-600">
                        High-quality fencing materials designed for easy installation by homeowners.
                    </p>
                </div>

                <!-- Loading State -->
                <div wire:loading class="mt-16 text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-danielle mx-auto"></div>
                    <p class="mt-2 text-gray-600">Loading products...</p>
                </div>

                <!-- Products Grid -->
                <div wire:loading.remove class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @forelse($products ?? [] as $product)
                        <article class="flex flex-col items-start justify-between bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            @if($product->getFirstMediaUrl('products'))
                                <div class="relative w-full">
                                    <img src="{{ $product->getFirstMediaUrl('products', 'responsive') }}" 
                                         alt="{{ $product->name }}" 
                                         class="aspect-[16/9] w-full rounded-t-lg bg-gray-50 object-cover">
                                    @if($product->is_featured)
                                        <div class="absolute top-4 left-4 bg-danielle text-white px-2 py-1 rounded-md text-sm font-semibold">
                                            Featured
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex-1 p-6">
                                <div class="group relative">
                                    <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-danielle">
                                        <a href="{{ route('diy.product', $product->slug) }}">
                                            <span class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ $product->description }}
                                    </p>
                                </div>
                                
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-2xl font-bold text-danielle">
                                            ${{ number_format($product->base_price, 2) }}
                                        </span>
                                        @if($product->price_unit)
                                            <span class="ml-1 text-sm text-gray-500">/ {{ $product->price_unit }}</span>
                                        @endif
                                    </div>
                                    @if($product->in_stock)
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            In Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-6 flex gap-3">
                                    <a href="{{ route('diy.product', $product->slug) }}" 
                                       class="flex-1 rounded-md bg-danielle px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-daniellealt focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danielle">
                                        View Details
                                    </a>
                                    <button type="button" 
                                            class="rounded-md border border-danielle px-3 py-2 text-sm font-semibold text-danielle hover:bg-danielle hover:text-white transition-colors">
                                        Add to Quote
                                    </button>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No products available</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding some DIY products to your catalog.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-danielle">
            <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Ready to start your fence project?
                    </h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-white">
                        Get a custom quote for your DIY fence project. Our team will help you calculate exactly what you need.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('diy.quote') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-danielle shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                            Get Free Quote
                        </a>
                        <a href="tel:863-425-3182" class="text-sm font-semibold leading-6 text-white">
                            Call (863) 425-3182 <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>