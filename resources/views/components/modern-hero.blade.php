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
            <!-- No overlay on image - let it show clearly -->
        </div>
    @else
        <!-- Solid Background with Orbs -->
        <div class="absolute inset-0 bg-outdoor-primary">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-32 w-80 h-80 bg-white/5 rounded-full"></div>
                <div class="absolute top-1/2 -left-32 w-64 h-64 bg-outdoor-secondary/10 rounded-full"></div>
                <div class="absolute -bottom-20 right-1/4 w-48 h-48 bg-white/3 rounded-full"></div>
            </div>
        </div>
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
                <!-- Glassmorphism container for hero content -->
                <div class="bg-black/40 backdrop-blur-md border border-white/20 rounded-2xl p-8 lg:p-12 shadow-2xl max-w-4xl {{ $centered ? 'mx-auto' : '' }}" data-aos="fade-up" data-aos-delay="200">
                    @if($subtitle)
                        <div class="mb-6">
                            <span class="inline-block px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-semibold rounded-full shadow-lg">
                                {{ $subtitle }}
                            </span>
                        </div>
                    @endif

                    <h1 class="font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold tracking-tight text-white mb-6"
                        data-aos="fade-up" data-aos-delay="400">
                        {{ $title }}
                    </h1>

                    @if($description)
                        <p class="text-lg md:text-xl text-white/90 max-w-3xl {{ $centered ? 'mx-auto' : '' }} mb-8 leading-relaxed"
                           data-aos="fade-up" data-aos-delay="600">
                            {{ $description }}
                        </p>
                    @endif

                    @if($cta && $ctaUrl)
                        <div data-aos="fade-up" data-aos-delay="800">
                            <a href="{{ $ctaUrl }}"
                               class="inline-flex items-center px-8 py-4 bg-white/15 backdrop-blur-md border border-white/30 text-white font-semibold text-lg rounded-xl hover:bg-white/20 hover:border-white/40 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105">
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
    </div>

</section>