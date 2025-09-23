@props(['model' => null])

@php
    $hasHeroImage = $model && method_exists($model, 'hasHeroImage') && $model->hasHeroImage();
    $heroImageUrl = $hasHeroImage ? $model->getHeroImageUrl() : null;
@endphp

<div class="relative isolate pt-14 {{ $hasHeroImage ? 'bg-cover bg-center bg-no-repeat min-h-[500px] lg:min-h-[600px]' : 'bg-outdoor-primary' }}"
     @if($hasHeroImage) style="background-image: url('{{ $heroImageUrl }}')" @endif>

    @if($hasHeroImage)
        <!-- Lighter overlay with gradient for good text readability -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/30"></div>
        <!-- Subtle center overlay for text area -->
        <div class="absolute inset-0 bg-black/5"></div>
    @else
        <!-- Decorative Background Elements for non-image heroes -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-32 w-80 h-80 bg-white/5 rounded-full"></div>
            <div class="absolute top-1/2 -left-32 w-64 h-64 bg-outdoor-secondary/10 rounded-full"></div>
            <div class="absolute -bottom-20 right-1/4 w-48 h-48 bg-white/3 rounded-full"></div>
        </div>
    @endif

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8 py-16 {{ $hasHeroImage ? 'lg:py-24' : '' }}">
        <div class="mx-auto text-center">
            <h1 class="text-4xl font-bold tracking-tight {{ $hasHeroImage ? 'text-white drop-shadow-2xl' : 'text-white' }} sm:text-6xl font-display">
                {{ $heading ?? $slot }}
            </h1>
            @if(isset($subheading) && $subheading)
                <p class="mt-6 text-lg {{ $hasHeroImage ? 'text-white drop-shadow-xl font-medium' : 'text-white/90 font-medium' }} max-w-3xl mx-auto">{{ $subheading }}</p>
            @endif
        </div>
    </div>
</div>
