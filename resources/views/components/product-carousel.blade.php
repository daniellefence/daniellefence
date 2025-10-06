@if($product->photos->count() > 0)
<div class="swiffy-slider slider-item-show1 slider-nav-outside slider-nav-round slider-nav-visible slider-indicators-outside slider-indicators-round slider-indicators-dark slider-nav-animation slider-nav-animation-fadein">
    <ul class="slider-container">
        @foreach($product->photos()->orderBy('order','asc')->get() as $photo)
            <li class="slide-visible">
                <div class="bg-white rounded-lg overflow-hidden">
                    @if($photo->title)
                        <div class="bg-gray-50 px-4 py-3 border-b">
                            <h3 class="text-sm font-medium text-gray-900 text-center">{{ $photo->title }}</h3>
                        </div>
                    @endif
                    <div class="p-4">
                        <a data-fslightbox="product-gallery" href="{{ asset('storage/' . $photo->path) }}">
                            <img
                                src="{{ asset('storage/' . $photo->path) }}"
                                alt="{{ $photo->title ?? $product->title }}"
                                class="w-full h-auto object-cover rounded hover:scale-105 transition-transform duration-300"
                                loading="lazy"
                            >
                        </a>
                    </div>
                    @if($photo->tags && $photo->tags->count() > 0)
                        <div class="px-4 pb-4">
                            <livewire:keyword-tags wire:key="photo_keyword_tags{{ $photo->id }}" :model="$photo"/>
                        </div>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>

    <button type="button" class="slider-nav" aria-label="Go to previous image"></button>
    <button type="button" class="slider-nav slider-nav-next" aria-label="Go to next image"></button>

    <div class="slider-indicators">
        @foreach($product->photos as $photo)
            <button class="{{ $loop->first ? 'active' : '' }}" aria-label="Go to image {{ $loop->iteration }}"></button>
        @endforeach
    </div>
</div>
@else
<div class="bg-gray-100 rounded-lg p-8 text-center">
    <div class="text-gray-400 mb-4">
        <i class="fa-solid fa-image text-4xl"></i>
    </div>
    <p class="text-gray-600">No product images available</p>
</div>
@endif
