<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $category->name }}
        </h2>
    </x-slot>
    <div class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="{{ route('diy') }}" class="text-gray-400 hover:text-gray-500">
                                <span>DIY Catalog</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fa-solid fa-chevron-right h-5 w-5 flex-shrink-0 text-gray-400"></i>
                                <span class="ml-4 text-sm font-medium text-gray-500">{{ $category->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="mt-8 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">{{ $category->name }}</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">{{ $category->description }}</p>
            </div>

            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-4 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3 xl:grid-cols-4">
                @forelse($category->diyProducts as $product)
                    @php
                        // Get unique available colors, heights, and spacings for this product
                        $availableColors = $product->diyProductModifiers->pluck('availableColor')->unique('id')->filter()->take(4);
                        $availableHeights = $product->diyProductModifiers->pluck('availableHeight')->unique('id')->filter()->sortBy('name');
                        $availableSpacings = $product->diyProductModifiers->pluck('availableSpacing')->unique('id')->filter()->sortBy('name');
                    @endphp

                    @php
                        // Get the first available color's photo as default
                        $firstColor = $availableColors->first();
                        $defaultPhoto = null;
                        if ($firstColor) {
                            $defaultPhoto = $product->getMedia('product-photos')->first(function($media) use ($firstColor) {
                                $colorName = $media->custom_properties['color_name'] ?? null;
                                return $colorName && strtolower($colorName) === strtolower($firstColor->name);
                            });
                        }
                        $defaultPhotoUrl = $defaultPhoto ? $defaultPhoto->getUrl() : $product->getFirstMediaUrl('product-photos');
                        $defaultColorPrice = $firstColor ? $firstColor->price_percentage : 0;
                    @endphp

                    <div class="flex flex-col bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-shadow duration-200 overflow-hidden"
                         x-data="{
                             currentImage: '{{ $defaultPhotoUrl }}',
                             selectedColorIndex: 0,
                             selectedColorId: {{ $firstColor ? $firstColor->id : 'null' }},
                             selectedColorPrice: {{ $defaultColorPrice }},
                             basePrice: {{ $product->base_price }},
                             get totalPrice() {
                                 return this.basePrice * (1 + (this.selectedColorPrice / 100));
                             }
                         }">
                        <!-- Bestseller Badge (optional) -->
                        <div class="p-3">
                            <span class="inline-block bg-yellow-400 text-gray-900 text-sm font-semibold px-4 py-1.5 rounded-md">
                                Bestseller
                            </span>
                        </div>

                        <!-- Product Image -->
                        @if($product->hasMedia('product-photos'))
                            <div class="bg-gray-50 w-full overflow-hidden" style="aspect-ratio: 4/3;">
                                <img :src="currentImage"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition-opacity duration-300">
                            </div>
                        @else
                            <div class="bg-gray-50 w-full flex items-center justify-center" style="aspect-ratio: 4/3;">
                                <span class="text-gray-400">No image</span>
                            </div>
                        @endif

                        <!-- Color Swatches -->
                        @if($availableColors->count() > 0)
                            <div class="px-4 pt-4 pb-4">
                                <div class="flex gap-2 flex-wrap justify-center">
                                    @foreach($availableColors as $index => $color)
                                        @php
                                            // Find product photo with this color name (matches Adobe, Almond, Gray, White)
                                            $colorPhoto = $product->getMedia('product-photos')->first(function($media) use ($color) {
                                                // Match by color name in custom properties (case insensitive)
                                                $colorName = $media->custom_properties['color_name'] ?? null;
                                                return $colorName && strtolower($colorName) === strtolower($color->name);
                                            });

                                            // If no exact color match, try by color_id
                                            if (!$colorPhoto) {
                                                $colorPhoto = $product->getMedia('product-photos')->first(function($media) use ($color) {
                                                    return isset($media->custom_properties['color_id']) && $media->custom_properties['color_id'] == $color->id;
                                                });
                                            }

                                            // Fallback to first product photo
                                            $colorPhotoUrl = $colorPhoto ? $colorPhoto->getUrl() : $product->getFirstMediaUrl('product-photos');
                                        @endphp
                                        <div class="relative" x-data="{ showTooltip: false }">
                                            @if($color->hasMedia('color-swatches'))
                                                <button type="button"
                                                        class="relative group cursor-pointer transition-transform hover:scale-110"
                                                        @mouseenter="showTooltip = true"
                                                        @mouseleave="showTooltip = false"
                                                        @click="currentImage = '{{ $colorPhotoUrl }}'; selectedColorIndex = {{ $index }}; selectedColorId = {{ $color->id }}; selectedColorPrice = {{ $color->price_percentage }}">
                                                    <img src="{{ $color->getFirstMediaUrl('color-swatches') }}"
                                                         alt="{{ $color->name }}"
                                                         class="w-12 h-12 rounded object-cover transition-all"
                                                         :class="selectedColorIndex === {{ $index }} ? 'border-2 border-blue-600' : 'border border-gray-300'">
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="w-12 h-12 rounded cursor-pointer transition-all hover:scale-110"
                                                        style="background-color: {{ $color->hex_code ?? '#e5e7eb' }}"
                                                        @mouseenter="showTooltip = true"
                                                        @mouseleave="showTooltip = false"
                                                        @click="currentImage = '{{ $colorPhotoUrl }}'; selectedColorIndex = {{ $index }}; selectedColorId = {{ $color->id }}; selectedColorPrice = {{ $color->price_percentage }}"
                                                        :class="selectedColorIndex === {{ $index }} ? 'border-2 border-blue-600' : 'border border-gray-300'"></button>
                                            @endif

                                            <!-- Tooltip Popover -->
                                            <div x-show="showTooltip"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 transform scale-90"
                                                 x-transition:enter-end="opacity-100 transform scale-100"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 transform scale-100"
                                                 x-transition:leave-end="opacity-0 transform scale-90"
                                                 class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1.5 bg-gray-900 text-white text-xs font-medium rounded shadow-lg whitespace-nowrap z-10"
                                                 style="display: none;">
                                                {{ $color->name }}
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                    <div class="border-4 border-transparent border-t-gray-900"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Product Details -->
                        <div class="flex flex-col px-4 pb-4 flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $product->name }}</h3>

                            <!-- Price -->
                            <div class="mb-4">
                                <p class="flex items-baseline">
                                    <span class="text-lg font-bold text-gray-900">$</span>
                                    <span class="text-4xl font-bold text-gray-900" x-text="Math.floor(totalPrice)"></span>
                                    <span class="text-xl font-bold text-gray-900" x-text="'.' + (Math.round((totalPrice - Math.floor(totalPrice)) * 100)).toString().padStart(2, '0')"></span>
                                </p>
                            </div>

                            <!-- Available Options -->
                            <div class="mb-4 space-y-2">
                                @if($availableHeights->count() > 0)
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Heights:</span>
                                        {{ $availableHeights->pluck('name')->join(', ') }}
                                    </p>
                                @endif
                                @if($availableSpacings->count() > 0)
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Spacing:</span>
                                        {{ $availableSpacings->pluck('name')->join(', ') }}
                                    </p>
                                @endif
                            </div>

                            <!-- Call to Action Button -->
                            <div class="mt-auto">
                                <a :href="`{{ route('diy.product', $product->id) }}?color=${selectedColorId}`"
                                   class="block w-full text-center rounded-md bg-outdoor-primary hover:bg-outdoor-primary/90 px-4 py-3 text-base font-semibold text-white transition-colors duration-200">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">No products available in this category yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>