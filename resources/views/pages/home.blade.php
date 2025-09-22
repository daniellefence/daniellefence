<x-app-layout>
    <!-- Enhanced Services Section -->
    <div class="relative pt-6 pb-4 overflow-hidden bg-outdoor-primary">
        <!-- Transparent leaf texture -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="leaves" width="100" height="100" patternUnits="userSpaceOnUse"%3E%3Cellipse cx="25" cy="30" rx="8" ry="15" fill="none" stroke="%23ffffff" stroke-width="1.5" transform="rotate(45 25 30)"/%3E%3Cellipse cx="75" cy="70" rx="6" ry="12" fill="none" stroke="%23ffffff" stroke-width="1.5" transform="rotate(-30 75 70)"/%3E%3Ccircle cx="50" cy="20" r="3" fill="%23ffffff" opacity="0.4"/%3E%3Ccircle cx="20" cy="80" r="2" fill="%23ffffff" opacity="0.4"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23leaves)" /%3E%3C/svg%3E');"></div>
        </div>

        <!-- Transparent tree ring texture -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="150" height="150" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="rings" width="150" height="150" patternUnits="userSpaceOnUse"%3E%3Ccircle cx="75" cy="75" r="30" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.3"/%3E%3Ccircle cx="75" cy="75" r="20" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.4"/%3E%3Ccircle cx="75" cy="75" r="10" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.5"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23rings)" /%3E%3C/svg%3E');"></div>
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

                                <!-- Enhanced badge/label on hover -->
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                                    <div class="bg-outdoor-primary text-white p-2 rounded-lg shadow-lg">
                                        <i class="fad fa-arrow-right w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced title with better typography -->
                            <div class="mt-3 text-center">
                                <p class="text-sm font-semibold text-white group-hover:text-outdoor-gold transition-colors duration-200">
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


    <div class="relative">
        <div class="hidden sm:block relative min-h-[600px] lg:min-h-[700px] bg-cover bg-center bg-no-repeat" style="background-image: url('{{ Vite::asset('resources/images/home_hero.webp') }}')">
            <div class="relative z-0 min-h-[600px] lg:min-h-[700px]">
                <div class="max-w-[1920px] mx-auto flex">
                    <!-- Left column -->
                    <div class="w-1/2 flex items-center justify-center p-8 lg:p-12 2xl:p-16">
                        <div class="mx-auto max-w-2xl 2xl:max-w-3xl text-center bg-black/30 backdrop-blur-sm rounded-3xl p-8 lg:p-10 2xl:p-12" data-aos="fade-up" data-aos-delay="200">
                            <div class="mb-4" data-aos="fade-right" data-aos-delay="400">
                                <span class="inline-block px-4 py-2 bg-outdoor-primary text-white text-sm lg:text-base font-semibold rounded-full">
                                    Since 1976 • Family-Owned &amp; Operated
                                </span>
                            </div>
                            <h1 class="mx-auto font-display text-5xl font-bold tracking-tight text-white sm:text-7xl lg:text-7xl 2xl:text-8xl" style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0 0 20px rgba(0, 0, 0, 0.5); letter-spacing: -0.02em;" data-aos="fade-up" data-aos-delay="600">
                                <span class="text-2xl sm:text-3xl lg:text-3xl 2xl:text-4xl">Central Florida's</span>
                                <span class="relative whitespace-nowrap text-outdoor-gold block text-6xl sm:text-8xl lg:text-8xl 2xl:text-9xl">
                                    <svg aria-hidden="true" viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-white/80" preserveAspectRatio="none">
                                        <path d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"></path>
                                    </svg>
                                    <span class="relative">Five Star</span>
                                </span>
                                <div class="flex items-center justify-center gap-4 mt-2" data-aos="zoom-in" data-aos-delay="800">
                                    <i class="fad fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg" style="--fa-primary-color: #d97706; --fa-secondary-color: #d97706; --fa-secondary-opacity: 1.0;"></i>
                                    <i class="fad fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg" style="--fa-primary-color: #d97706; --fa-secondary-color: #d97706; --fa-secondary-opacity: 1.0;"></i>
                                    <i class="fad fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg" style="--fa-primary-color: #d97706; --fa-secondary-color: #d97706; --fa-secondary-opacity: 1.0;"></i>
                                    <i class="fad fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg" style="--fa-primary-color: #d97706; --fa-secondary-color: #d97706; --fa-secondary-opacity: 1.0;"></i>
                                    <i class="fad fa-star w-8 h-8 sm:w-12 sm:h-12 lg:w-12 lg:h-12 2xl:w-14 2xl:h-14 text-outdoor-gold drop-shadow-lg" style="--fa-primary-color: #d97706; --fa-secondary-color: #d97706; --fa-secondary-opacity: 1.0;"></i>
                                </div>
                                <span class="text-2xl sm:text-3xl lg:text-3xl 2xl:text-4xl -mt-4">Fence Company</span>
                            </h1>
                            <p class="mx-auto mt-6 max-w-lg lg:max-w-xl 2xl:max-w-2xl text-lg lg:text-xl 2xl:text-2xl tracking-tight text-white font-medium animate-fade-in-up animate-delay-500" style="text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.9), 0 0 15px rgba(0, 0, 0, 0.7);">
                                Nearly 50 years of quality craftsmanship. From Disney World to your backyard - professional installation with premium American-made materials.
                            </p>
                            <div class="mt-10 flex justify-center animate-fade-in-up animate-delay-600">
                                <a href="{{route('request-a-quote')}}" class="group inline-flex items-center justify-center rounded-full py-4 px-12 lg:py-5 lg:px-14 2xl:py-6 2xl:px-16 text-lg lg:text-xl 2xl:text-2xl font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 bg-outdoor-primary text-white hover:bg-outdoor-primary/80 focus-visible:outline-outdoor-primary transform hover:scale-105 transition-transform duration-200">
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

                        <!-- Video -->
                        <a href="{{ route('chat') }}" class="block w-5/6 lg:w-2/3 2xl:w-3/5 max-w-[500px] 2xl:max-w-[580px]">
                            <video autoplay="" loop="" muted="" playsinline="" class="w-full h-auto rounded-2xl alpha-video hover:scale-105 transition-transform duration-300 cursor-pointer" style="background: transparent !important; display: block;">
                                <source src="{{Vite::asset('resources/videos/grillbert.webm')}}" type="video/webm">
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
        <x-mission-statement></x-mission-statement>

        <!-- Trusted By Section -->
        <div class="relative py-16 bg-white">
            <!-- Transparent subtle pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="corporateGrid" width="100" height="100" patternUnits="userSpaceOnUse"%3E%3Cpath d="M20,20 L80,20 L80,80 L20,80 Z" fill="none" stroke="%23000000" stroke-width="1"/%3E%3Ccircle cx="20" cy="20" r="2" fill="%23000000" opacity="0.3"/%3E%3Ccircle cx="80" cy="20" r="2" fill="%23000000" opacity="0.3"/%3E%3Ccircle cx="80" cy="80" r="2" fill="%23000000" opacity="0.3"/%3E%3Ccircle cx="20" cy="80" r="2" fill="%23000000" opacity="0.3"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23corporateGrid)" /%3E%3C/svg%3E');"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-gray-900">Trusted by Industry Leaders</h2>
                    <p class="mt-2 text-gray-600">
                        From theme parks to retail giants - we're Central Florida's trusted choice
                    </p>
                </div>

                <!-- Logo Grid - First Row -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-x-8 gap-y-10 items-center mb-8">
                    <!-- Disney World -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/Walt_Disney_World_Resort_logo.svg') }}" alt="Walt Disney World" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- SeaWorld -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/swo_logo.webp') }}" alt="SeaWorld Orlando" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- Universal Studios -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/UOR_GlobeLogo_4C-768x445.jpg') }}" alt="Universal Orlando Resort" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- LEGOLAND -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/LEGOLAND_Florida_Resort_Logo.jpg') }}" alt="LEGOLAND Florida" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- Publix -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/publix.png') }}" alt="Publix Supermarkets" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- Wawa -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/wawa-logo-logo.png') }}" alt="Wawa" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>
                </div>

                <!-- Logo Grid - Second Row -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-8 gap-y-10 items-center">
                    <!-- Home Depot -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/THD_logo.jpg') }}" alt="The Home Depot" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- Lowes -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/Lowes_logo_pms_280.png') }}" alt="Lowe's Home Improvement" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- Polk County -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/Logo_of_Polk_County,_Florida.svg') }}" alt="Polk County" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- Polk County Schools -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/polkcountyschools.webp') }}" alt="Polk County Schools" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>

                    <!-- City of Lakeland -->
                    <div class="flex justify-center items-center h-16">
                        <img src="{{ asset('images/trustedby/lakeland.png') }}" alt="City of Lakeland" class="max-h-full w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-200">
                    </div>
                </div>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">+ Many more trusted partners across Central Florida</p>
                </div>
            </div>
        </div>

        <!-- Why Choose Danielle Fence Section -->
        <div class="relative py-20 overflow-hidden bg-outdoor-light">
            <!-- Transparent grass pattern -->
            <div class="absolute inset-0 opacity-25">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="80" height="80" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grass" width="80" height="80" patternUnits="userSpaceOnUse"%3E%3Cpath d="M10,70 Q15,30 10,10 M15,70 Q20,25 15,5 M25,70 Q30,35 25,15" stroke="%23ffffff" stroke-width="1.5" fill="none" opacity="0.4"/%3E%3Cpath d="M35,70 Q40,30 35,10 M45,70 Q50,25 45,5 M55,70 Q60,35 55,15" stroke="%23ffffff" stroke-width="1.5" fill="none" opacity="0.3"/%3E%3Cpath d="M65,70 Q70,30 65,10 M70,70 Q75,25 70,5" stroke="%23ffffff" stroke-width="1.5" fill="none" opacity="0.4"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grass)" /%3E%3C/svg%3E');"></div>
            </div>

            <!-- Transparent garden pattern -->
            <div class="absolute inset-0 opacity-15">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="120" height="120" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="garden" width="120" height="120" patternUnits="userSpaceOnUse"%3E%3Ccircle cx="30" cy="30" r="8" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.3"/%3E%3Cpath d="M30,22 Q25,15 20,22 Q25,29 30,22" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.4"/%3E%3Ccircle cx="90" cy="60" r="6" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.3"/%3E%3Cpath d="M90,54 Q85,49 80,54 Q85,59 90,54" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.4"/%3E%3Ccircle cx="60" cy="90" r="7" fill="none" stroke="%23ffffff" stroke-width="1" opacity="0.3"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23garden)" /%3E%3C/svg%3E');"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold text-gray-900">Why Choose Danielle Fence?</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Nearly 50 years of proven excellence in Central Florida
                    </p>
                </div>

                <div class="mx-auto mt-12 grid max-w-4xl grid-cols-1 gap-8 lg:grid-cols-3">
                    <div class="bg-white rounded-lg p-6 text-center shadow-sm border border-gray-100">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-outdoor-primary">
                            <i class="fad fa-check-circle h-6 w-6 text-white"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Proven Experience</h3>
                        <p class="mt-2 text-sm text-gray-600">Over 5 million linear feet manufactured since 1976. Family-owned and operated with fences still standing after 35+ years.</p>
                    </div>

                    <div class="bg-white rounded-lg p-6 text-center shadow-sm border border-gray-100">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-outdoor-primary">
                            <i class="fad fa-users h-6 w-6 text-white"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Dedicated Team</h3>
                        <p class="mt-2 text-sm text-gray-600">60+ full-time professionals with 300+ years of collective experience. No subcontractors - only our trained experts.</p>
                    </div>

                    <div class="bg-white rounded-lg p-6 text-center shadow-sm border border-gray-100">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-outdoor-primary">
                            <i class="fad fa-star h-6 w-6 text-white"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">American Quality</h3>
                        <p class="mt-2 text-sm text-gray-600">Made in USA materials that are lead-free, child/pet-friendly, and recyclable. Industry's best warranty with 97% customer satisfaction.</p>
                    </div>
                </div>

                <div class="mt-10 text-center">
                    <a href="{{route('why-danielle-fence')}}" class="inline-flex items-center px-6 py-3 bg-outdoor-primary text-white font-medium rounded-lg hover:bg-outdoor-primary/90 transition-colors duration-200">
                        Learn More About Our Story
                        <i class="fad fa-arrow-right ml-2 h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>

        <livewire:areas-we-serve lazy="on-load" wire:key="areas-we-serve{{rand(0,10000)}}"/>
        <livewire:reviews lazy="on-load" wire:key="reviews{{rand(0,10000)}}"/>
    </div>
</x-app-layout>
