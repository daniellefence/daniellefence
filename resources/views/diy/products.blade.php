<x-app-layout>
    <!-- Breadcrumb Navigation -->
    <nav class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex py-4">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('welcome') }}" class="hover:text-danielle">Home</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('diy.index') }}" class="hover:text-danielle">DIY Solutions</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-900 font-medium">Products</li>
                </ol>
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-gray-50">
        <!-- Header Section -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        DIY Fence Products
                    </h1>
                    <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                        Professional-grade fencing materials designed for DIY installation. Browse by category to find the perfect solution for your project.
                    </p>
                </div>
            </div>
        </div>



        <!-- Main Content Area -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                
                <!-- Sidebar Filters -->
                <div class="hidden lg:block">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                        <!-- Search -->
                        <div class="mb-6">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                            <div class="relative">
                                <input type="text" id="search" name="search" 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-danielle focus:border-danielle"
                                       placeholder="Search fencing materials...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Categories Filter -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Categories</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle" checked>
                                    <span class="ml-2 text-sm text-gray-600">All Products</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Vinyl/PVC Fencing</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Aluminum Fencing</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Wood Fencing</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Chain Link</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Gates</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Hardware & Accessories</span>
                                </label>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Price Range</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-danielle focus:ring-danielle" checked>
                                    <span class="ml-2 text-sm text-gray-600">All Prices</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Under $50</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">$50 - $100</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">$100 - $200</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price" class="text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Over $200</span>
                                </label>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Availability</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle" checked>
                                    <span class="ml-2 text-sm text-gray-600">In Stock</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-danielle focus:ring-danielle">
                                    <span class="ml-2 text-sm text-gray-600">Special Order</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="lg:col-span-3">
                    <!-- Mobile Filters Button -->
                    <div class="lg:hidden mb-4">
                        <button type="button" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-filter mr-2"></i>
                            Filters
                        </button>
                    </div>

                    <!-- Sort and View Options -->
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ count($products ?? []) }}</span> products
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <label for="sort" class="text-sm font-medium text-gray-700 mr-2">Sort by:</label>
                                    <select id="sort" name="sort" class="border-gray-300 rounded-md text-sm focus:ring-danielle focus:border-danielle">
                                        <option>Featured</option>
                                        <option>Price: Low to High</option>
                                        <option>Price: High to Low</option>
                                        <option>Newest</option>
                                        <option>Best Rating</option>
                                    </select>
                                </div>
                                <div class="flex border border-gray-300 rounded-md">
                                    <button type="button" class="p-2 text-gray-400 hover:text-gray-500 border-r border-gray-300">
                                        <i class="fas fa-th-large"></i>
                                    </button>
                                    <button type="button" class="p-2 text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products ?? [] as $product)
                        <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden" 
                                 x-data="{
                                     selectedImage: '{{ $product->getFirstMediaUrl('products') }}',
                                     selectedColor: null,
                                     colors: [
                                         { name: 'White', value: '#FFFFFF', image: '{{ $product->getFirstMediaUrl('products') }}' },
                                         { name: 'Tan', value: '#D2B48C', image: '{{ $product->getFirstMediaUrl('products') }}' },
                                         { name: 'Gray', value: '#808080', image: '{{ $product->getFirstMediaUrl('products') }}' },
                                         { name: 'Brown', value: '#8B4513', image: '{{ $product->getFirstMediaUrl('products') }}' },
                                         { name: 'Black', value: '#000000', image: '{{ $product->getFirstMediaUrl('products') }}' }
                                     ]
                                 }" 
                                 x-init="selectedColor = colors[0]">
                            
                            <!-- Product Image -->
                            <div class="relative aspect-[4/3] overflow-hidden">
                                @if($product->getFirstMediaUrl('products'))
                                    <img :src="selectedImage" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover transition-opacity duration-300">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                
                                @if($product->is_featured)
                                    <div class="absolute top-3 left-3 bg-red-600 text-white px-2 py-1 rounded text-xs font-medium">
                                        Featured
                                    </div>
                                @endif
                                
                                <!-- Quick View Button -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-200 flex items-center justify-center opacity-0 hover:opacity-100">
                                    <button class="bg-white text-gray-900 px-4 py-2 rounded-md font-medium hover:bg-gray-100 transition-colors">
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-4">
                                <!-- Product Name -->
                                <h3 class="text-lg font-medium text-gray-900 hover:text-danielle transition-colors">
                                    <a href="{{ route('diy.product', $product->slug) }}" class="block">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                
                                <!-- Rating (placeholder) -->
                                <div class="mt-1 flex items-center">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-1 text-xs text-gray-500">({{ rand(50, 200) }})</span>
                                </div>
                                
                                <!-- Color Options -->
                                <div class="mt-3">
                                    <div class="text-xs text-gray-600 mb-2">Color: <span x-text="selectedColor?.name"></span></div>
                                    <div class="flex space-x-2">
                                        <template x-for="(color, index) in colors" :key="index">
                                            <button 
                                                @click="selectedImage = color.image; selectedColor = color"
                                                :class="{
                                                    'ring-2 ring-danielle ring-offset-2': selectedColor === color,
                                                    'ring-1 ring-gray-300': selectedColor !== color
                                                }"
                                                :style="{ backgroundColor: color.value }"
                                                class="w-6 h-6 rounded-full border-2 border-white shadow-sm transition-all duration-200 hover:scale-110"
                                                :title="color.name">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                
                                <!-- Price -->
                                <div class="mt-3">
                                    <div class="flex items-baseline">
                                        <span class="text-lg font-semibold text-gray-900">
                                            ${{ number_format($product->base_price, 2) }}
                                        </span>
                                        @if($product->price_unit)
                                            <span class="ml-1 text-sm text-gray-500">/ {{ $product->price_unit }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Stock Status -->
                                <div class="mt-2">
                                    @if($product->in_stock)
                                        <span class="inline-flex items-center text-xs font-medium text-green-700">
                                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                            In Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-xs font-medium text-red-700">
                                            <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="mt-4 space-y-2">
                                    <a href="{{ route('diy.product', $product->slug) }}" 
                                       class="w-full block text-center bg-danielle text-white py-2 px-4 rounded-md hover:bg-red-700 transition-colors font-medium text-sm">
                                        View Details
                                    </a>
                                    <button type="button" 
                                            class="w-full border border-danielle text-danielle py-2 px-4 rounded-md hover:bg-danielle hover:text-white transition-colors font-medium text-sm">
                                        Add to Quote
                                    </button>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <i class="fas fa-tools text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-500 mb-6">Try adjusting your filters or search terms to find what you're looking for.</p>
                            <button type="button" class="text-danielle hover:text-red-700 font-medium">
                                Clear all filters
                            </button>
                        </div>
                    @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8 flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 rounded-lg">
                        <div class="flex flex-1 justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">12</span> of <span class="font-medium">{{ count($products ?? []) }}</span> results
                                </p>
                            </div>
                            <div>
                                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left text-xs"></i>
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">1</a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">3</a>
                                    <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom CTA Section -->
        <div class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-danielle rounded-2xl px-6 py-16 sm:p-16">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            Need Help Planning Your Project?
                        </h2>
                        <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-white">
                            Our DIY experts can help you choose the right materials and calculate exactly what you need for your fence project.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('diy.quote') }}" class="rounded-md bg-white px-6 py-3 text-base font-semibold text-danielle shadow-sm hover:bg-gray-100">
                                Get Custom Quote
                            </a>
                            <a href="tel:863-425-3182" class="text-base font-semibold leading-6 text-white hover:text-gray-200">
                                Call (863) 425-3182 <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Color swatch functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Alpine.js components if needed
            if (typeof Alpine !== 'undefined') {
                Alpine.start();
            }
        });
    </script>
</x-app-layout>