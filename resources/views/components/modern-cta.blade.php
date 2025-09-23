@props([
    'title',
    'description' => null,
    'buttonText' => 'Get Started',
    'buttonUrl' => '#',
    'secondaryText' => null,
    'secondaryUrl' => null,
    'background' => 'bg-outdoor-cedar',
    'textColor' => 'text-white',
    'centered' => true,
    'pattern' => false
])

<section class="relative {{ $background }} py-16 md:py-24 overflow-hidden">
    @if($pattern)
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
        </div>
    @endif

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="{{ $centered ? 'text-center' : '' }}">
            <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold {{ $textColor }} mb-6"
                data-aos="fade-up" data-aos-delay="0">
                {{ $title }}
            </h2>

            @if($description)
                <p class="text-lg md:text-xl {{ $textColor }}/90 max-w-3xl {{ $centered ? 'mx-auto' : '' }} mb-10 leading-relaxed"
                   data-aos="fade-up" data-aos-delay="200">
                    {{ $description }}
                </p>
            @endif

            <div class="flex flex-col sm:flex-row gap-4 {{ $centered ? 'justify-center' : '' }}"
                 data-aos="fade-up" data-aos-delay="400">

                <a href="{{ $buttonUrl }}"
                   class="inline-flex items-center justify-center px-8 py-4 bg-brand-accent-900 text-brand-light-100 font-semibold text-lg rounded-xl hover:bg-brand-accent-800 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                    {{ $buttonText }}
                </a>

                @if($secondaryText && $secondaryUrl)
                    <a href="{{ $secondaryUrl }}"
                       class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white/30 {{ $textColor }} font-semibold text-lg rounded-xl hover:bg-white/10 hover:border-white/50 transition-all duration-300 backdrop-blur-sm">
                        {{ $secondaryText }}
                    </a>
                @endif
            </div>

            {{ $slot }}
        </div>
    </div>
</section>