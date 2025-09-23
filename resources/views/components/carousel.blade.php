@props(['page'])

@php
    // Get photos based on the page parameter
    $photos = collect();

    switch($page) {
        case 'showroom':
            // Get photos that might be related to showroom/showcase
            $photos = \App\Models\Photo::where('title', 'LIKE', '%showroom%')
                     ->orWhere('title', 'LIKE', '%showcase%')
                     ->orWhereNotNull('carousel_id')
                     ->orderBy('order', 'asc')
                     ->get();
            break;
        default:
            // For commercial sections, try to find photos by title or get general photos
            $photos = \App\Models\Photo::where('title', 'LIKE', '%' . $page . '%')
                     ->orWhereNotNull('carousel_id')
                     ->orderBy('order', 'asc')
                     ->get();
            break;
    }

    // If no photos found, get some default photos that have no specific association
    if ($photos->isEmpty()) {
        $photos = \App\Models\Photo::whereNull('product_id')
                 ->whereNull('blog_id')
                 ->whereNull('review_id')
                 ->orderBy('order', 'asc')
                 ->limit(6)
                 ->get();
    }

    // If still no photos, get any photos
    if ($photos->isEmpty()) {
        $photos = \App\Models\Photo::orderBy('order', 'asc')->limit(6)->get();
    }
@endphp

@if($photos->count() > 0)
<div class="relative">
    <!-- Modern Carousel Container -->
    <div class="swiffy-slider slider-item-show3 slider-item-reveal slider-nav-outside slider-nav-round slider-nav-visible slider-indicators-outside slider-indicators-round slider-nav-animation slider-nav-animation-fadein modern-carousel">
        <ul class="slider-container">
            @foreach($photos as $photo)
                <li class="slide-visible px-2">
                    <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-outdoor-primary/20">
                        <!-- Image Container with Gradient Overlay -->
                        <div class="relative overflow-hidden aspect-[4/3]">
                            <a data-fslightbox="gallery-{{ $page }}" href="{{ asset('storage/' . $photo->path) }}" class="block">
                                <img
                                    src="{{ asset('storage/' . $photo->path) }}"
                                    alt="{{ $photo->title ?? 'Gallery Image' }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    loading="lazy"
                                >
                                <!-- Subtle overlay for better text readability -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <!-- Expand Icon on Hover -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 shadow-lg transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                        <i class="fa-solid fa-magnifying-glass-plus text-outdoor-primary text-xl"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @if($photo->title)
                            <!-- Modern Title Card -->
                            <div class="p-4 bg-gradient-to-r from-white to-gray-50">
                                <h3 class="text-sm font-semibold text-gray-900 group-hover:text-outdoor-primary transition-colors duration-300 line-clamp-2">
                                    {{ $photo->title }}
                                </h3>
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

        <!-- Modern Navigation Buttons -->
        <button type="button" class="slider-nav !bg-outdoor-primary hover:!bg-outdoor-primary/90 !text-white !border-outdoor-primary shadow-lg" aria-label="Go to previous">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button type="button" class="slider-nav slider-nav-next !bg-outdoor-primary hover:!bg-outdoor-primary/90 !text-white !border-outdoor-primary shadow-lg" aria-label="Go to next">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <!-- Modern Indicators -->
        <div class="slider-indicators">
            @foreach($photos->chunk(3) as $chunk)
                <button class="!bg-outdoor-primary/30 hover:!bg-outdoor-primary {{ $loop->first ? 'active !bg-outdoor-primary' : '' }}" aria-label="Go to slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>
    </div>
</div>

<!-- Custom Styles for Modern Look -->
<style>
.modern-carousel .slider-nav {
    width: 48px !important;
    height: 48px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.3s ease !important;
    backdrop-filter: blur(8px) !important;
}

.modern-carousel .slider-nav:hover {
    transform: scale(1.1) !important;
}

.modern-carousel .slider-indicators button {
    width: 12px !important;
    height: 12px !important;
    margin: 0 6px !important;
    transition: all 0.3s ease !important;
    border: 2px solid transparent !important;
}

.modern-carousel .slider-indicators button.active {
    transform: scale(1.2) !important;
    border-color: white !important;
}

.modern-carousel .slider-indicators button:hover {
    transform: scale(1.1) !important;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@else
<div class="text-center py-16">
    <div class="max-w-md mx-auto">
        <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-images text-2xl text-gray-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Images Available</h3>
        <p class="text-gray-600">This gallery is currently empty. Check back soon for updates!</p>
    </div>
</div>
@endif