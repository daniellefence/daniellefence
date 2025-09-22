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
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="3" cy="3" r="3"/><circle cx="13" cy="13" r="1"/><circle cx="33" cy="5" r="4"/><circle cx="3" cy="23" r="4"/><circle cx="13" cy="27" r="1"/><circle cx="23" cy="15" r="2"/><circle cx="43" cy="15" r="2"/><circle cx="33" cy="23" r="4"/><circle cx="53" cy="25" r="2"/><circle cx="23" cy="35" r="4"/><circle cx="43" cy="35" r="4"/><circle cx="13" cy="43" r="2"/><circle cx="33" cy="43" r="1"/><circle cx="53" cy="43" r="2"/><circle cx="3" cy="53" r="1"/><circle cx="23" cy="53" r="1"/><circle cx="43" cy="53" r="1"/></g></g></svg>')"></div>
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