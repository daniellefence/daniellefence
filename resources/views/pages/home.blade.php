<x-app-layout>
    <div class="relative">
        <div class="hidden sm:block relative min-h-[600px] lg:min-h-[700px] overflow-hidden">
            <!-- Hero image as img element for faster LCP -->
            <img src="{{ Vite::asset('resources/images/home_hero.webp') }}"
                 alt="Danielle Fence & Outdoor Living - Central Florida's Premier Fence Company"
                 class="absolute inset-0 w-full h-full object-cover"
                 width="1920"
                 height="1080"
                 fetchpriority="high"
                 decoding="sync"
                 loading="eager">
            <div class="relative z-10 min-h-[600px] lg:min-h-[700px]">
                <div class="max-w-[1920px] mx-auto flex">
                    <!-- Left column -->
                    <div class="w-1/2 flex items-center justify-center p-8 lg:p-12 2xl:p-16">
                        <div class="mx-auto max-w-2xl 2xl:max-w-3xl text-center bg-black/30 backdrop-blur-sm rounded-3xl p-8 lg:p-10 2xl:p-12" data-aos="fade-up" data-aos-delay="200">
                            <div class="mb-2" data-aos="fade-right" data-aos-delay="400">
                                <span class="inline-block px-4 py-2 bg-outdoor-primary text-white text-sm lg:text-base font-semibold rounded-full">
                                    Since 1976 • Family-Owned &amp; Operated
                                </span>
                            </div>
                            <h1 class="mx-auto font-display text-5xl font-bold tracking-tight text-white sm:text-7xl lg:text-7xl 2xl:text-8xl hero-title-shadow" data-aos="fade-up" data-aos-delay="600">
                                <span class="text-2xl sm:text-3xl lg:text-3xl 2xl:text-4xl">Central Florida's</span>
                                <span class="relative whitespace-nowrap text-outdoor-gold block text-6xl sm:text-8xl lg:text-8xl 2xl:text-9xl">
                                    <svg aria-hidden="true" viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-white/80" preserveAspectRatio="none">
                                        <path d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"></path>
                                    </svg>
                                    <span class="relative">Five Star</span>
                                </span>
                                <div class="flex items-center justify-center gap-4 mt-2" data-aos="zoom-in" data-aos-delay="800">
                                    <i class="fas fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg"></i>
                                    <i class="fas fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg"></i>
                                    <i class="fas fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg"></i>
                                    <i class="fas fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg"></i>
                                    <i class="fas fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg"></i>
                                </div>
                                <span class="text-2xl sm:text-3xl lg:text-3xl 2xl:text-4xl -mt-4">Fence Company</span>
                            </h1>
                            <p class="mx-auto mt-6 max-w-lg lg:max-w-xl 2xl:max-w-2xl text-lg lg:text-xl 2xl:text-2xl tracking-tight text-white font-medium animate-fade-in-up animate-delay-500 hero-text-shadow">
                                {{ date('Y') - 1976 }}+ years of quality craftsmanship. From Disney World to your backyard - professional installation with premium American-made materials.
                            </p>
                            <div class="mt-10 animate-fade-in-up animate-delay-600">
                                <a href="{{route('request-a-quote')}}" class="group block w-full text-center rounded-3xl py-4 px-12 lg:py-5 lg:px-14 2xl:py-6 2xl:px-16 text-lg lg:text-xl 2xl:text-2xl font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 bg-outdoor-primary text-white hover:bg-outdoor-primary/80 focus-visible:outline-outdoor-primary transform hover:scale-105 transition-transform duration-200">
                                    Get Free Quote
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="w-1/2 flex flex-col items-center justify-center p-8 lg:p-12 2xl:p-16 space-y-4 lg:space-y-6">
                        <!-- Speech bubble -->
                        <div class="relative bg-brand-light rounded-3xl px-6 py-4 lg:px-8 lg:py-5 2xl:px-10 2xl:py-6 shadow-lg">
                            <p class="text-brand-primary font-semibold text-lg lg:text-xl 2xl:text-2xl text-center">
                                <span class="block">Questions?</span>
                                <span class="block">Chat with Grillbert!</span>
                            </p>
                            <!-- Speech bubble tail -->
                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-[10px] border-r-[10px] border-t-[10px] lg:border-l-[12px] lg:border-r-[12px] lg:border-t-[12px] 2xl:border-l-[14px] 2xl:border-r-[14px] 2xl:border-t-[14px] border-l-transparent border-r-transparent border-t-brand-light"></div>
                        </div>

                        <!-- Video - Lazy loaded on mobile -->
                        <a href="{{ route('chat') }}" class="block w-5/6 lg:w-2/3 2xl:w-3/5 max-w-[500px] 2xl:max-w-[580px]">
                            <video autoplay="" loop="" muted="" playsinline=""
                                   class="w-full h-auto rounded-2xl alpha-video hover:scale-105 transition-all duration-300 cursor-pointer opacity-0"
                                   preload="none"
                                   loading="lazy"
                                   width="500"
                                   height="500"
                                   style="aspect-ratio: 1/1;"
                                   onloadeddata="this.style.opacity=1; this.style.transition='opacity 1000ms ease-in-out';">
                                <source src="{{Vite::asset('resources/videos/grillbert.webm')}}" type="video/webm">
                            </video>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="block sm:hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 text-center" data-aos="fade-up">
                <h1 class="mx-auto max-w-4xl font-display text-5xl font-medium text-brand-neutral sm:text-7xl">A
                    Company<br>You Can Trust<br><span class="text-brand-primary">Since 1976</span></h1>
            </div>
        </div>

        <!-- Reviews Marquee -->
        <x-reviews-marquee />

        <!-- Enhanced Services Section -->
        <div class="relative pt-6 pb-4 overflow-hidden bg-outdoor-primary">
            <!-- Transparent leaf texture -->
            <div class="absolute inset-0 opacity-20">
            </div>

            <!-- Transparent tree ring texture -->
            <div class="absolute inset-0 opacity-10">
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">

                <!-- Enhanced services grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-5">
                @foreach(\App\Models\Category::whereNull('parent_id')->orderBy('order','asc')->get() as $category)
                    @if($category->photo()->count() > 0)
                        <div class="group relative">
                            <a aria-label="{{$category->title}}" class="block" href="{{$category->getRoute()}}">
                                <!-- Card container with enhanced hover effects -->
                                <div class="relative overflow-hidden rounded-2xl bg-white shadow-sm group-hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">

                                    <!-- Image container with aspect ratio -->
                                    <div class="aspect-square overflow-hidden bg-gray-100">
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                             src="{{asset('storage/'.$category->photo->path)}}"
                                             alt="{{$category->title}} Photo"
                                             loading="lazy"/>
                                    </div>

                                </div>

                                <!-- Enhanced title with better typography -->
                                <div class="mt-3 text-center">
                                    <p class="text-sm font-semibold text-white group-hover:text-white transition-colors duration-200">
                                        {{$category->title}}
                                    </p>
                                    <!-- Animated underline on hover -->
                                    <div class="h-0.5 w-0 group-hover:w-full mx-auto mt-2 bg-outdoor-gold transition-all duration-300"></div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
                </div>

            </div>
        </div>

        <!-- Mission Statement -->
        <x-mission-statement></x-mission-statement>

        <!-- Trusted By Section -->
        <div class="relative py-16 bg-white">

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-gray-900">Trusted by Industry Leaders</h2>
                    <p class="mt-2 text-gray-600">
                        From theme parks to retail giants - we're Central Florida's trusted choice
                    </p>
                </div>

                <!-- Logo Grid -->
                <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-10">
                    <!-- Disney World -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/Walt_Disney_World_Resort_logo.svg') }}" alt="Walt Disney World" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- SeaWorld -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/swo_logo.webp') }}" alt="SeaWorld Orlando" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- LEGOLAND -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/LEGOLAND_Florida_Resort_Logo.jpg') }}" alt="LEGOLAND Florida" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- Wawa -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/wawa-logo-logo.png') }}" alt="Wawa" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- Polk County -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/Logo_of_Polk_County,_Florida.svg') }}" alt="Polk County" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- Polk County Schools -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/polkcountyschools.webp') }}" alt="Polk County Schools" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- City of Lakeland -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/lakeland.png') }}" alt="City of Lakeland" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- Bonnet Springs Park -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/bonnetsprings.png') }}" alt="Bonnet Springs Park" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>

                    <!-- Bok Tower Gardens -->
                    <div class="flex justify-center items-center h-16 w-32 sm:w-36 md:w-40">
                        <img src="{{ asset('images/trustedby/boktower.webp') }}" alt="Bok Tower Gardens" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200" width="160" height="64" loading="lazy">
                    </div>
                </div>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">+ Many more trusted partners across Central Florida</p>
                </div>
            </div>
        </div>

        <!-- Why Choose Danielle Fence Section -->
        <div class="relative py-20 overflow-hidden bg-gray-200">
            <!-- Subtle pattern overlay -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Cpath d="M0 40L40 0H20L0 20M40 40V20L20 40"/%3E%3C/g%3E%3C/svg%3E');">
                </div>
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold text-gray-900">Why Choose Danielle Fence?</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        {{ date('Y') - 1976 }}+ years of proven excellence in Central Florida
                    </p>
                    <div class="mt-6 inline-block px-6 py-3 bg-outdoor-primary text-white rounded-lg font-semibold">
                        We specialize in new construction and fence replacements
                    </div>
                </div>

                <div class="mx-auto mt-12 grid max-w-4xl grid-cols-1 gap-8 lg:grid-cols-3">
                    <div class="perspective-card">
                        <div class="perspective-card-inner bg-white rounded-lg p-6 text-center shadow-sm border border-gray-100">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-outdoor-primary">
                                <i class="fa-solid fa-shield-check h-6 w-6 text-white"></i>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Proven Experience</h3>
                            <p class="mt-2 text-sm text-gray-600">Over 5 million linear feet manufactured since 1976. Family-owned and operated with fences still standing after 35+ years.</p>
                        </div>
                    </div>

                    <div class="perspective-card">
                        <div class="perspective-card-inner bg-white rounded-lg p-6 text-center shadow-sm border border-gray-100">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-outdoor-primary">
                                <i class="fa-solid fa-users h-6 w-6 text-white"></i>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Dedicated Team</h3>
                            <p class="mt-2 text-sm text-gray-600">60+ full-time professionals with 300+ years of collective experience. Every crew has a dedicated foreman on site with extensive training and experience.</p>
                        </div>
                    </div>

                    <div class="perspective-card">
                        <div class="perspective-card-inner bg-white rounded-lg p-6 text-center shadow-sm border border-gray-100">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-outdoor-primary">
                                <i class="fa-solid fa-award h-6 w-6 text-white"></i>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">American Quality</h3>
                            <p class="mt-2 text-sm text-gray-600">Made in USA materials that are lead-free, child/pet-friendly, and recyclable. Industry's best warranty with 97% customer satisfaction.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 text-center">
                    <a href="{{route('why-danielle-fence')}}" class="inline-flex items-center px-6 py-3 bg-outdoor-primary text-white font-medium rounded-lg hover:bg-outdoor-primary/90 transition-colors duration-200">
                        Learn More About Our Story
                        <i class="fa-solid fa-arrow-right ml-2 h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>

        <livewire:areas-we-serve lazy="on-load" wire:key="areas-we-serve{{rand(0,10000)}}"/>
        <livewire:reviews lazy="on-load" wire:key="reviews{{rand(0,10000)}}"/>
    </div>

    <!-- Perspective Card CSS -->
    <style>
    .perspective-card {
        perspective: 1000px;
    }

    .perspective-card-inner {
        transform-style: preserve-3d;
        transition: transform 0.6s;
    }

    .perspective-card:hover .perspective-card-inner {
        transform: rotateY(10deg) rotateX(10deg);
    }

    @media (prefers-reduced-motion: reduce) {
        .perspective-card:hover .perspective-card-inner {
            transform: none;
        }
    }
    </style>
</x-app-layout>
