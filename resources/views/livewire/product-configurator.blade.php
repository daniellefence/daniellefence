<div>
<div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
    <!-- Product Image Section -->
    <div class="lg:sticky lg:top-8 lg:self-start space-y-6">
        <!-- Main Product Image -->
        <div class="w-full" style="aspect-ratio: 1/1;">
            @if($currentPhotoUrl)
                <img src="{{ $currentPhotoUrl }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
            @else
                <div class="flex items-center justify-center w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg">
                    <div class="text-center">
                        <i class="fa-solid fa-image text-6xl text-gray-400"></i>
                        <p class="mt-4 text-sm text-gray-500">Product image coming soon</p>
                    </div>
                </div>
            @endif
        </div>


        <!-- Product Gallery Slider -->
        @php
            // Try to get photos from the related product's category, or fall back to any photos
            $galleryPhotos = collect();
            if ($product->product && $product->product->category_id) {
                $galleryPhotos = \App\Models\Photo::where('category_id', $product->product->category_id)->get();
            }
            // If no category photos, get any available photos
            if ($galleryPhotos->isEmpty()) {
                $galleryPhotos = \App\Models\Photo::inRandomOrder()->limit(12)->get();
            }
        @endphp
        @if($galleryPhotos->count() > 0)
            <div class="mt-6" x-data="{
                currentIndex: 0,
                photos: {{ $galleryPhotos->map(fn($p) => asset('storage/' . $p->path))->toJson() }},
                autoplayInterval: null,
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.photos.length;
                    }, 3000);
                },
                stopAutoplay() {
                    if (this.autoplayInterval) {
                        clearInterval(this.autoplayInterval);
                        this.autoplayInterval = null;
                    }
                }
            }" x-init="startAutoplay()">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">See It In Action</h3>
                <p class="text-sm text-gray-600 mb-4">Real installations from our customers</p>

                <!-- Full Width Slider -->
                <div class="relative w-full rounded-lg bg-gray-100 shadow-lg"
                     style="aspect-ratio: 4/3;">

                    <div class="absolute inset-0 overflow-hidden rounded-lg">
                        @foreach($galleryPhotos as $index => $photo)
                            <img x-show="currentIndex === {{ $index }}"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-out duration-300"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 src="{{ asset('storage/' . $photo->path) }}"
                                 alt="Product installation"
                                 class="absolute inset-0 w-full h-full object-cover">
                        @endforeach
                    </div>

                    <!-- Left Arrow -->
                    <button type="button"
                            @click.stop="currentIndex = currentIndex > 0 ? currentIndex - 1 : photos.length - 1; stopAutoplay(); startAutoplay();"
                            class="absolute top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white rounded-full p-3 shadow-lg transition-all duration-200 z-10"
                            style="left: 1rem;">
                        <i class="fa-solid fa-chevron-left text-xl" style="color: #8e2a2a;"></i>
                    </button>

                    <!-- Right Arrow -->
                    <button type="button"
                            @click.stop="currentIndex = (currentIndex + 1) % photos.length; stopAutoplay(); startAutoplay();"
                            class="absolute top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white rounded-full p-3 shadow-lg transition-all duration-200 z-10"
                            style="right: 1rem;">
                        <i class="fa-solid fa-chevron-right text-xl" style="color: #8e2a2a;"></i>
                    </button>

                    <!-- Navigation Dots -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                        @foreach($galleryPhotos as $index => $photo)
                            <button @click.stop="currentIndex = {{ $index }}; stopAutoplay(); startAutoplay();"
                                    class="w-2 h-2 rounded-full transition-all duration-200"
                                    :class="currentIndex === {{ $index }} ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/75'"></button>
                        @endforeach
                    </div>

                    <!-- Photo Counter -->
                    <div class="absolute top-4 right-4 bg-black bg-opacity-60 text-white text-sm px-3 py-1 rounded">
                        <span x-text="currentIndex + 1"></span> / {{ $galleryPhotos->count() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Configuration Section -->
    <div>
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('diy') }}" class="text-gray-400 hover:text-gray-500 text-sm">DIY Catalog</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right h-4 w-4 flex-shrink-0 text-gray-400"></i>
                        <a href="{{ route('diy.category', $product->diyCategory->id) }}" class="ml-4 text-sm font-medium text-gray-400 hover:text-gray-500">
                            {{ $product->diyCategory->name }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right h-4 w-4 flex-shrink-0 text-gray-400"></i>
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-4xl font-bold tracking-tight text-gray-900">{{ $product->name }}</h1>
        <p class="mt-4 text-lg text-gray-600">{{ $product->description }}</p>

        <!-- Pricing Display -->
        <div class="mt-8 bg-outdoor-primary/5 border-2 border-outdoor-primary/20 rounded-lg p-6">
            <div class="flex items-baseline justify-between">
                <div>
                    <p class="text-sm text-gray-600">Price per Panel</p>
                    <p class="text-3xl font-bold text-outdoor-primary">
                        ${{ number_format($pricePerPanel, 2) }}
                    </p>
                </div>
                @if($quantity > 1)
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Total Price</p>
                        <p class="text-2xl font-bold text-gray-900">
                            ${{ number_format($totalPrice, 2) }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fa-solid fa-check-circle"></i>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <!-- Configuration Form -->
        <form wire:submit.prevent="addToCart" class="mt-8 space-y-8">
            <!-- Color Selection -->
            <div>
                <label class="text-base font-medium text-gray-900">
                    Select Color <span class="text-red-500">*</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">Choose from {{ $availableColors->count() }} available colors</p>

                <div class="mt-4 flex gap-2 flex-wrap">
                    @foreach($availableColors as $color)
                        <div class="relative">
                            <button
                                type="button"
                                wire:click="$set('selectedColorId', {{ $color->id }})"
                                class="relative cursor-pointer transition-transform hover:scale-110"
                                title="{{ $color->name }}"
                            >
                                @if($color->hasMedia('color-swatches'))
                                    <img src="{{ $color->getFirstMediaUrl('color-swatches') }}"
                                         alt="{{ $color->name }}"
                                         class="w-12 h-12 rounded object-cover transition-all {{ $selectedColorId === $color->id ? 'border-2 border-blue-600' : 'border border-gray-300' }}">
                                @else
                                    <div class="w-12 h-12 rounded transition-all {{ $selectedColorId === $color->id ? 'border-2 border-blue-600' : 'border border-gray-300' }}"
                                         style="background-color: {{ $color->hex_code ?? '#e5e7eb' }}"></div>
                                @endif
                            </button>

                            <!-- Color name below swatch -->
                            <p class="text-xs text-center mt-1 text-gray-700">{{ $color->name }}</p>
                            @if($color->price_percentage > 0)
                                <p class="text-xs text-center text-gray-500">+{{ $color->price_percentage }}%</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                @error('selectedColorId') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Height Selection -->
            <div>
                <label class="text-base font-medium text-gray-900">
                    Select Height <span class="text-red-500">*</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">Available heights for your selection</p>

                <div class="mt-4 flex gap-3 flex-wrap">
                    @foreach($availableHeights as $height)
                        <button
                            type="button"
                            wire:click="$set('selectedHeightId', {{ $height->id }})"
                            class="relative rounded-lg border-2 px-6 py-3 hover:shadow-md transition-all duration-200
                                {{ $selectedHeightId === $height->id ? 'border-outdoor-primary bg-outdoor-primary text-white' : 'border-gray-300 bg-white text-gray-900' }}"
                        >
                            <p class="text-lg font-semibold">{{ $height->name }}</p>
                        </button>
                    @endforeach
                </div>
                @error('selectedHeightId') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Spacing Selection -->
            <div>
                <label class="text-base font-medium text-gray-900">
                    Select Spacing <span class="text-red-500">*</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">Choose your preferred spacing option</p>

                <div class="mt-4 flex gap-3 flex-wrap">
                    @foreach($availableSpacings as $spacing)
                        <button
                            type="button"
                            wire:click="$set('selectedSpacingId', {{ $spacing->id }})"
                            class="relative rounded-lg border-2 px-6 py-3 hover:shadow-md transition-all duration-200
                                {{ $selectedSpacingId === $spacing->id ? 'border-outdoor-primary bg-outdoor-primary text-white' : 'border-gray-300 bg-white text-gray-900' }}"
                        >
                            <p class="text-lg font-semibold">{{ $spacing->name }}</p>
                        </button>
                    @endforeach
                </div>
                @error('selectedSpacingId') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Panel Calculator -->
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200" x-data="{ linearFeet: '', panelWidth: 8, calculatedPanels: 0 }">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-calculator text-outdoor-primary"></i>
                    Panel Calculator
                </h3>
                <p class="text-sm text-gray-600 mb-4">Not sure how many panels you need? Enter your fence length below.</p>

                <div class="space-y-4">
                    <div>
                        <label for="linearFeet" class="block text-sm font-medium text-gray-700 mb-2">
                            Linear Feet of Fence Needed
                        </label>
                        <input
                            type="number"
                            id="linearFeet"
                            x-model="linearFeet"
                            @input="calculatedPanels = linearFeet > 0 ? Math.ceil(linearFeet / panelWidth) : 0"
                            placeholder="Enter feet (e.g., 100)"
                            min="1"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-outdoor-primary focus:ring-outdoor-primary"
                        >
                        <p class="mt-1 text-xs text-gray-500">
                            Each panel is 8 feet wide
                        </p>
                    </div>

                    <div x-show="calculatedPanels > 0" class="bg-white rounded-md p-4 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Panels Needed:</p>
                                <p class="text-2xl font-bold text-outdoor-primary" x-text="calculatedPanels"></p>
                            </div>
                            <button
                                type="button"
                                @click="$wire.set('quantity', calculatedPanels)"
                                class="rounded-md bg-outdoor-primary px-4 py-2 text-sm font-semibold text-white hover:bg-outdoor-primary/90 transition"
                            >
                                Use This Quantity
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="text-base font-medium text-gray-900">
                    Quantity (Panels) <span class="text-red-500">*</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">Number of fence panels needed</p>

                <div class="mt-4 flex items-center gap-4">
                    <button
                        type="button"
                        wire:click="$set('quantity', {{ max(1, $quantity - 1) }})"
                        class="rounded-md bg-gray-200 px-4 py-2 text-lg font-medium text-gray-700 hover:bg-gray-300"
                    >
                        <i class="fa-solid fa-minus"></i>
                    </button>

                    <input
                        type="number"
                        id="quantity"
                        wire:model.live="quantity"
                        min="1"
                        class="w-24 rounded-md border-gray-300 text-center text-lg font-medium shadow-sm focus:border-outdoor-primary focus:ring-outdoor-primary"
                    >

                    <button
                        type="button"
                        wire:click="$set('quantity', {{ $quantity + 1 }})"
                        class="rounded-md bg-gray-200 px-4 py-2 text-lg font-medium text-gray-700 hover:bg-gray-300"
                    >
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                @error('quantity') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Add to Cart Button -->
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="flex-1 rounded-md bg-outdoor-primary px-8 py-4 text-base font-semibold text-white shadow-sm hover:bg-outdoor-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-outdoor-primary transition-all duration-200"
                >
                    <i class="fa-solid fa-cart-plus mr-2"></i>
                    Add to Cart
                </button>

                <a
                    href="{{ route('request-a-quote') }}"
                    class="rounded-md bg-gray-200 px-8 py-4 text-base font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-200"
                >
                    <i class="fa-solid fa-comment-dots mr-2"></i>
                    Request Quote
                </a>
            </div>
        </form>

        <!-- Need Help Card -->
        <div class="mt-6 bg-outdoor-primary/10 rounded-lg p-6 border border-outdoor-primary/20">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Need Help?</h3>
            <p class="text-sm text-gray-700 mb-4">Our team is here to assist you with your project.</p>
            <a href="{{ route('request-a-quote') }}" class="block w-full text-center rounded-md bg-outdoor-primary hover:bg-outdoor-primary/90 px-4 py-2.5 text-sm font-semibold text-white transition-colors duration-200">
                Request a Quote
            </a>
        </div>

        <!-- Price Breakdown -->
        @if($selectedColorId || $selectedHeightId || $selectedSpacingId)
            <div class="mt-8 border-t pt-8">
                <h3 class="text-lg font-medium text-gray-900">Price Breakdown</h3>
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Base Price:</dt>
                        <dd class="font-medium text-gray-900">${{ number_format($product->base_price, 2) }}</dd>
                    </div>

                    @if($selectedHeightId)
                        @php $height = $availableHeights->firstWhere('id', $selectedHeightId); @endphp
                        @if($height && $height->price_per_panel > 0)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">{{ $height->name }}:</dt>
                                <dd class="font-medium text-gray-900">+${{ number_format($height->price_per_panel, 2) }}</dd>
                            </div>
                        @endif
                    @endif

                    @if($selectedSpacingId)
                        @php $spacing = $availableSpacings->firstWhere('id', $selectedSpacingId); @endphp
                        @if($spacing && $spacing->price_per_panel > 0)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">{{ $spacing->name }}:</dt>
                                <dd class="font-medium text-gray-900">+${{ number_format($spacing->price_per_panel, 2) }}</dd>
                            </div>
                        @endif
                    @endif

                    @if($selectedColorId)
                        @php $color = $availableColors->firstWhere('id', $selectedColorId); @endphp
                        @if($color && $color->price_percentage > 0)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">{{ $color->name }} Color:</dt>
                                <dd class="font-medium text-gray-900">+{{ $color->price_percentage }}%</dd>
                            </div>
                        @endif
                    @endif

                    <div class="flex justify-between border-t pt-2 text-base font-bold">
                        <dt class="text-gray-900">Total per Panel:</dt>
                        <dd class="text-outdoor-primary">${{ number_format($pricePerPanel, 2) }}</dd>
                    </div>

                    @if($quantity > 1)
                        <div class="flex justify-between text-base font-bold">
                            <dt class="text-gray-900">× {{ $quantity }} Panels:</dt>
                            <dd class="text-outdoor-primary">${{ number_format($totalPrice, 2) }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        @endif
    </div>
</div>
</div>