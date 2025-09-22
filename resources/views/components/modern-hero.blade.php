@props([
    'title',
    'subtitle' => null,
    'description' => null,
    'backgroundImage' => null,
    'overlay' => 'bg-black/40',
    'textColor' => 'text-white',
    'centered' => true,
    'cta' => null,
    'ctaUrl' => null,
    'breadcrumbs' => false
])

<section class="relative overflow-hidden">
    @if($backgroundImage)
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ $backgroundImage }}" alt="{{ $title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 {{ $overlay }}"></div>
        </div>
    @else
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-brand-primary-900 via-brand-primary-800 to-brand-secondary-900"></div>
    @endif

    <!-- Content -->
    <div class="relative z-10 py-24 md:py-32 lg:py-40">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            @if($breadcrumbs)
                <!-- Breadcrumbs -->
                <nav class="mb-8" data-aos="fade-down" data-aos-delay="0">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-white/70 hover:text-white transition-colors">Home</a></li>
                        <li><span class="text-white/50 mx-2">/</span></li>
                        <li><span class="text-white font-medium">{{ $title }}</span></li>
                    </ol>
                </nav>
            @endif

            <div class="{{ $centered ? 'text-center' : '' }}">
                @if($subtitle)
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                        <span class="inline-block px-4 py-2 bg-brand-accent-900/90 text-brand-light-100 text-sm font-semibold rounded-full backdrop-blur-sm">
                            {{ $subtitle }}
                        </span>
                    </div>
                @endif

                <h1 class="font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold tracking-tight {{ $textColor }} mb-6"
                    style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8)" data-aos="fade-up" data-aos-delay="400">
                    {{ $title }}
                </h1>

                @if($description)
                    <p class="text-lg md:text-xl {{ $textColor }}/90 max-w-3xl {{ $centered ? 'mx-auto' : '' }} mb-8 leading-relaxed"
                       data-aos="fade-up" data-aos-delay="600">
                        {{ $description }}
                    </p>
                @endif

                @if($cta && $ctaUrl)
                    <div data-aos="fade-up" data-aos-delay="800">
                        <a href="{{ $ctaUrl }}"
                           class="inline-flex items-center px-8 py-4 bg-brand-accent-900 text-brand-light-100 font-semibold text-lg rounded-xl hover:bg-brand-accent-800 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105 backdrop-blur-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            {{ $cta }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</section>