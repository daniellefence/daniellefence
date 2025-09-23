@props(['model' => null])

@php
    $hasHeroImage = $model && method_exists($model, 'hasHeroImage') && $model->hasHeroImage();
    $heroImageUrl = $hasHeroImage ? $model->getHeroImageUrl() : null;
@endphp

<div class="relative isolate pt-14 {{ $hasHeroImage ? 'bg-cover bg-center bg-no-repeat min-h-[500px] lg:min-h-[600px]' : 'bg-outdoor-primary' }}"
     @if($hasHeroImage) style="background-image: url('{{ $heroImageUrl }}')" @endif>

    @if($hasHeroImage)
        <!-- No overlay on image - let it show clearly -->
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
            <!-- Glassmorphism container for hero content -->
            <div class="bg-black/40 backdrop-blur-md border border-white/20 rounded-2xl p-8 lg:p-12 shadow-2xl max-w-4xl mx-auto">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl font-display">
                    {{ $heading ?? $slot }}
                </h1>
                @if(isset($subheading) && $subheading)
                    <div class="mt-6 text-lg text-white/90 font-medium max-w-3xl mx-auto leading-relaxed [&_p]:text-white/90 [&_p]:mb-4 [&_p]:leading-relaxed">{!! $subheading !!}</div>
                @endif
            </div>
        </div>
    </div>
</div>
