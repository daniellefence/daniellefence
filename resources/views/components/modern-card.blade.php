@props([
    'title',
    'description' => null,
    'image' => null,
    'imageAlt' => '',
    'url' => null,
    'badge' => null,
    'badgeColor' => 'bg-brand-accent-100 text-brand-accent-900',
    'hover' => true,
    'shadow' => 'shadow-lg',
    'rounded' => 'rounded-2xl',
    'overflow' => 'overflow-hidden',
    'aos' => 'fade-up',
    'delay' => '0'
])

<div class="bg-white {{ $rounded }} {{ $shadow }} {{ $overflow }} {{ $hover ? 'hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2' : '' }} border border-slate-200/50"
     data-aos="{{ $aos }}" data-aos-delay="{{ $delay }}">

    @if($image)
        <div class="aspect-w-16 aspect-h-9 {{ $hover ? 'group-hover:scale-105' : '' }} transition-transform duration-300">
            <img src="{{ $image }}" alt="{{ $imageAlt ?: $title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <div class="p-6 lg:p-8">
        @if($badge)
            <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 {{ $badgeColor }} text-sm font-medium rounded-full">
                    {{ $badge }}
                </span>
            </div>
        @endif

        <h3 class="text-xl lg:text-2xl font-bold text-brand-neutral-900 mb-3 group-hover:text-brand-primary-900 transition-colors">
            {{ $title }}
        </h3>

        @if($description)
            <p class="text-brand-neutral-700 leading-relaxed mb-6">
                {{ $description }}
            </p>
        @endif

        {{ $slot }}

        @if($url)
            <div class="mt-6">
                <a href="{{ $url }}"
                   class="inline-flex items-center text-brand-primary-900 font-semibold hover:text-brand-primary-700 transition-colors group">
                    Learn More
                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>