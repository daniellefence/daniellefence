<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-brand-primary to-brand-primary/90 text-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight sm:text-6xl mb-4">DIY Fence Materials</h1>
                <p class="text-xl text-brand-light/90 max-w-3xl mx-auto">Premium fence materials for your do-it-yourself projects. American-made quality with professional installation guides.</p>
            </div>
        </div>
    </div>

    <!-- DIY Shop Container with shared Alpine.js state -->
    <div x-data="{ activeTab: 'all' }">
        <!-- Navigation/Filter Bar -->
        <div class="bg-white shadow-sm sticky top-0 z-10">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <!-- Category Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex justify-center space-x-8 py-4" aria-label="Category Navigation">
                        <button
                            @click="activeTab = 'all'"
                            :class="activeTab === 'all' ? 'text-brand-primary font-semibold border-brand-primary' : 'text-gray-600 font-medium border-transparent hover:border-gray-200'"
                            class="hover:text-brand-primary transition-colors border-b-2 pb-4 -mb-px">
                            All Products
                        </button>
                        @foreach($diyCategories as $category)
                            <button
                                @click="activeTab = '{{ $category->slug }}'"
                                :class="activeTab === '{{ $category->slug }}' ? 'text-brand-primary font-semibold border-brand-primary' : 'text-gray-600 font-medium border-transparent hover:border-gray-200'"
                                class="hover:text-brand-primary transition-colors border-b-2 pb-4 -mb-px">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6 lg:px-8 py-8">
        <!-- Product Grid -->
        <div>
            <!-- All Products Tab Content -->
            <div x-show="activeTab === 'all'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if($diyProducts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($diyProducts as $product)
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow group">
                                <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                    @if($product->default_photo_url)
                                        <img src="{{ $product->default_photo_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $product->name }}</h3>
                                    @if($product->category)
                                        <p class="text-xs text-gray-500 mb-2">{{ $product->category->name }}</p>
                                    @endif
                                    @if($product->description)
                                        <p class="text-xs text-gray-600 mb-2 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->base_price, 2) }}</span>
                                    </div>
                                    <button class="w-full bg-brand-primary text-white py-2 px-4 rounded-md hover:bg-brand-primary/90 transition-colors font-medium text-sm">
                                        Add to Cart
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2">Free delivery on orders over $45</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No DIY Products Available</h3>
                        <p class="text-gray-600">Check back soon for DIY fence materials and supplies.</p>
                    </div>
                @endif
            </div>

            <!-- Category-specific Tab Content -->
            @foreach($diyCategories as $category)
                <div x-show="activeTab === '{{ $category->slug }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @php
                        $categoryProducts = $diyProducts->where('diy_product_category_id', $category->id);
                    @endphp

                    @if($categoryProducts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($categoryProducts as $product)
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow group">
                                    <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                        @if($product->default_photo_url)
                                            <img src="{{ $product->default_photo_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $product->name }}</h3>
                                        @if($product->description)
                                            <p class="text-xs text-gray-600 mb-2 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                                        @endif
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-lg font-bold text-gray-900">${{ number_format($product->base_price, 2) }}</span>
                                        </div>
                                        <button class="w-full bg-brand-primary text-white py-2 px-4 rounded-md hover:bg-brand-primary/90 transition-colors font-medium text-sm">
                                            Add to Cart
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2">Free delivery on orders over $45</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No {{ $category->name }} Products</h3>
                            <p class="text-gray-600">No products available in this category yet.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        </div>
    </div>

</x-app-layout>