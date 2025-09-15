<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-brand-cream/20">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-white to-brand-cream/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                        {{ $category->name }}
                    </h1>
                    @if($category->description)
                        <div class="mt-6 text-xl text-gray-600 max-w-4xl mx-auto prose prose-gray">
                            {!! $category->description !!}
                        </div>
                    @else
                        <p class="mt-6 text-xl text-gray-600 max-w-4xl mx-auto">
                            Explore our professional-grade {{ strtolower($category->name) }} products designed for both DIY installation and professional use.
                        </p>
                    @endif

                </div>
            </div>
        </div>


        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-danielle/30 transition-all duration-200 group">
                            <!-- Product Image -->
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                @if($product->getFirstMediaUrl())
                                    <img src="{{ $product->getFirstMediaUrl() }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-200">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-danielle transition-colors">
                                    {{ $product->name }}
                                </h3>

                                @if($product->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {!! Str::limit(strip_tags($product->description), 120) !!}
                                    </p>
                                @endif

                                <!-- Price -->
                                @if($product->base_price)
                                    <div class="mb-4">
                                        <span class="text-2xl font-bold text-danielle">
                                            ${{ number_format($product->base_price, 2) }}
                                        </span>
                                        <span class="text-gray-500 text-sm ml-1">per unit</span>
                                    </div>
                                @endif

                                <!-- Product Tags/Features -->
                                @if($product->tags->count() > 0)
                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach($product->tags->take(3) as $tag)
                                            <span class="inline-block bg-danielle/10 text-danielle px-2 py-1 rounded-full text-xs font-medium">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('diy.product', $product->slug) }}"
                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-danielle text-white font-bold text-sm rounded-lg hover:bg-daniellealt transition-colors">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Details
                                    </a>
                                    <a href="{{ route('diy.quote') }}?product={{ $product->slug }}"
                                       class="inline-flex items-center justify-center px-4 py-2 border border-danielle text-danielle font-bold text-sm rounded-lg hover:bg-danielle hover:text-white transition-colors">
                                        <i class="fas fa-calculator"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- No Products State -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-boxes text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Products Available</h3>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                        We're currently updating our {{ strtolower($category->name) }} product lineup. Check back soon or contact us for current availability.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('contact') }}?subject=Inquiry%20about%20{{ urlencode($category->name) }}%20Products"
                           class="inline-flex items-center px-8 py-4 bg-danielle text-white font-bold text-lg rounded-lg hover:bg-daniellealt transition-colors">
                            <i class="fas fa-envelope mr-3"></i>
                            Contact Us
                        </a>
                        <a href="{{ route('diy.index') }}"
                           class="inline-flex items-center px-8 py-4 border border-danielle text-danielle font-bold text-lg rounded-lg hover:bg-danielle hover:text-white transition-colors">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Browse All Products
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Call to Action Section -->
        <div class="bg-gradient-to-r from-danielle to-daniellealt">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Your {{ $category->name }} Project?</h2>
                    <p class="text-xl text-white mb-8 max-w-3xl mx-auto">
                        Get a free quote today or speak with our fencing experts about your specific needs.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('diy.quote') }}" class="inline-flex items-center px-8 py-4 bg-white text-danielle font-bold text-lg rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-calculator mr-3"></i>
                            Get Free Quote
                        </a>
                        <a href="tel:8634253182" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold text-lg rounded-lg hover:bg-white hover:text-danielle transition-colors">
                            <i class="fas fa-phone mr-3"></i>
                            (863) 425-3182
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>