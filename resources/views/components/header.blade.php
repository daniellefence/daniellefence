<div x-data="{
        showMobile:false
    }">
    <!-- Header with Hero Background -->
    <header class="relative z-40 parallax-header" >
        <!-- Gradient Overlay for Text Readability -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/20 to-black/40"></div>
        
        <!-- Upper Header with Phone Numbers -->
        <div class="relative z-10 py-2 text-white bg-black/10 backdrop-blur-sm">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between">
                    <div>
                        <!-- Desktop: Show both numbers with "Call" -->
                        <span class="hidden md:inline">
                            Call <a href="tel:8634253182" class="font-semibold hover:text-gray-300">(863) 425-3182</a> or <a href="tel:8136816181" class="font-semibold hover:text-gray-300">(813) 681-6181</a>
                        </span>
                        <!-- Mobile: Show only first number without "Call" -->
                        <span class="md:hidden">
                            <a href="tel:8634253182" class="font-semibold hover:text-gray-300">(863) 425-3182</a>
                        </span>
                    </div>
                    
                    <!-- Search Bar - Hidden on mobile -->
                    <div class="hidden md:flex flex-1 max-w-md mx-8">
                        <div class="relative w-full">
                            <input type="search" 
                                   placeholder="Search products, services..."
                                   class="w-full pl-10 pr-4 py-2 text-sm text-brand-dark bg-brand-cream/90 backdrop-blur-sm border border-white/30 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-light focus:border-transparent placeholder-brand-dark/60">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-brand-dark/60 text-sm"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('diy.quote') }}">
                            <button class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold text-danielle bg-white hover:bg-gray-100 border-0 ring-0">
                                <span class="hidden md:inline">Request an estimate</span>
                                <span class="md:hidden">Get Estimate</span>
                            </button>
                        </a>
                        <button class="relative inline-flex items-center justify-center w-10 h-10 rounded-md bg-white hover:bg-gray-100 border-0 ring-0">
                            <i class="fas fa-shopping-cart text-danielle text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation Container -->
        <nav class="relative z-30">
            <!-- Logo and Mobile Toggle -->
            <div class="mx-auto flex max-w-7xl items-center justify-between py-3 px-4">
                <div class="flex lg:flex-1 relative flex-shrink-0 mt-3.5" id="logo-holder">
                    <a aria-label="Danielle Fence Logo" href="{{ route('welcome') }}" class="relative inline-block flex-shrink-0 rounded-lg border-4 border-white px-10 py-4 logo-plate">
                        <span class="sr-only">{{ config('app.name') }}</span>
                        <!-- License plate corner holes -->
                        <div class="absolute top-2 left-2 w-3 h-3 bg-white rounded-full z-20 logo-dot"></div>
                        <div class="absolute top-2 right-2 w-3 h-3 bg-white rounded-full z-20 logo-dot"></div>
                        <div class="absolute bottom-2 left-2 w-3 h-3 bg-white rounded-full z-20 logo-dot"></div>
                        <div class="absolute bottom-2 right-2 w-3 h-3 bg-white rounded-full z-20 logo-dot"></div>
                        <img
                            class="h-12 sm:h-16 lg:h-20 xl:h-24 w-auto flex-shrink-0 relative z-10"
                            src="{{ asset('images/logo.webp') }}"
                            alt="Danielle Fence Logo">
                    </a>
                </div>
                <div class="flex gap-6 lg:hidden">
                    <button
                        @click="showMobile = true"
                        @keyup.escape.window="showMobile = false"
                        type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-white bg-gradient-to-b from-danielle to-daniellealt border-2 border-[#5a1d1d]">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-white text-lg"></i>
                    </button>
                </div>
                
                <!-- Desktop Two-Row Navigation -->
                <div class="hidden lg:block px-6 py-3 nav-hover animate-fade-in-up animate-delay-100">
                    <!-- First Row: First 4 Product Categories -->
                    <div class="flex justify-center gap-x-4 mb-3">
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories->take(4) as $category)
                                <a href="{{ route('diyproductcategories.category', $category->slug) }}" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        @else
                            <!-- Fallback categories if no database categories -->
                            <a href="{{ route('diy.index') }}#vinyl" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                Vinyl/PVC
                            </a>
                            <a href="{{ route('diy.index') }}#aluminum" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                Aluminum
                            </a>
                            <a href="{{ route('diy.index') }}#wood" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                Wood
                            </a>
                            <a href="{{ route('diy.index') }}#chain-link" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                Chain Link
                            </a>
                        @endif
                    </div>

                    <!-- Second Row: Remaining Categories + Main Navigation -->
                    <div class="flex justify-center items-center gap-x-6">
                        <!-- Remaining 2 Product Categories -->
                        @if(isset($categories) && $categories->count() > 4)
                            @foreach($categories->skip(4)->take(2) as $category)
                                <a href="{{ route('diyproductcategories.category', $category->slug) }}" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        @else
                            <!-- Fallback categories for second row if no database categories -->
                            <a href="{{ route('diy.index') }}#gates" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                Gates
                            </a>
                            <a href="{{ route('diy.index') }}#accessories" class="category-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 rounded-lg transition-all duration-200">
                                Accessories
                            </a>
                        @endif

                        <!-- DIY -->
                        <a aria-label="DIY" href="{{ route('diy.index') }}" class="main-nav-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 transition-colors duration-200">
                            DIY
                        </a>

                        <!-- Specials -->
                        <a aria-label="Specials" href="{{ route('specials') }}" class="main-nav-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 transition-colors duration-200">
                            Specials
                        </a>

                        <!-- About Dropdown -->
                        <div class="relative group">
                            <div class="absolute top-full left-0 right-0 h-4 invisible group-hover:visible"></div>
                            <button class="main-nav-item px-4 py-2 text-base font-bold text-gray-800 hover:text-gray-900 transition-colors duration-200 inline-flex items-center gap-x-1" aria-expanded="false">
                                About
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div class="nav-dropdown absolute right-0 z-50 -mt-1 pt-3 flex w-screen max-w-max opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none group-hover:pointer-events-auto">
                                <div class="w-screen max-w-sm flex-auto overflow-hidden rounded-2xl text-sm leading-6 backdrop-blur-xl bg-white/95 border border-white/20 shadow-2xl">
                                    <div class="p-6">
                                        <div class="space-y-2">
                                            <div class="dropdown-item group relative flex gap-x-6 rounded-lg p-3 hover:bg-gray-50 transition-colors duration-200">
                                                <div>
                                                    <a href="{{ route('about.history') }}" class="font-semibold text-gray-900">
                                                        Our Story
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">49 years of excellence</p>
                                                </div>
                                            </div>
                                            <div class="dropdown-item group relative flex gap-x-6 rounded-lg p-3 hover:bg-gray-50 transition-colors duration-200">
                                                <div>
                                                    <a href="{{ route('reviews') }}" class="font-semibold text-gray-900">
                                                        Reviews
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Customer testimonials</p>
                                                </div>
                                            </div>
                                            <div class="dropdown-item group relative flex gap-x-6 rounded-lg p-3 hover:bg-gray-50 transition-colors duration-200">
                                                <div>
                                                    <a href="{{ route('contact') }}" class="font-semibold text-gray-900">
                                                        Contact
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Get in touch</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </nav>
        
        @if(Route::currentRouteName() === 'welcome')
            <!-- Hero Content Section (Home Page Only) -->
            <div class="relative z-10 py-16 sm:py-20 lg:py-24">
                <div class="container mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                        <!-- Left Column - Hero Content -->
                        <div class="mx-auto max-w-4xl text-center animate-fade-in-up animate-delay-200">
                            <div class="mb-4">
                                <span class="inline-block px-4 py-2 bg-success text-white text-sm font-semibold rounded-full animate-slide-in-left animate-delay-300">
                                    Since 1976 • Family-Owned & Operated
                                </span>
                            </div>
                            <h1 class="mx-auto max-w-4xl font-display text-5xl font-medium tracking-tight text-white sm:text-7xl animate-fade-in-up animate-delay-400" style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0 0 20px rgba(0, 0, 0, 0.5);">
                                <span class="text-2xl sm:text-3xl">Central Florida's</span>
                                <span class="relative whitespace-nowrap text-yellow-400 block text-6xl sm:text-8xl">
                                    <svg aria-hidden="true" viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-white/80" preserveAspectRatio="none">
                                        <path d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"></path>
                                    </svg>
                                    <span class="relative">Five Star</span>
                                </span>
                                <div class="flex items-center justify-center gap-2 mt-2">
                                    <i class="fas fa-star text-yellow-400 text-3xl sm:text-5xl"></i>
                                    <i class="fas fa-star text-yellow-400 text-3xl sm:text-5xl"></i>
                                    <i class="fas fa-star text-yellow-400 text-3xl sm:text-5xl"></i>
                                    <i class="fas fa-star text-yellow-400 text-3xl sm:text-5xl"></i>
                                    <i class="fas fa-star text-yellow-400 text-3xl sm:text-5xl"></i>
                                </div>
                                <span class="text-2xl sm:text-3xl -mt-4">Fence Company</span>
                            </h1>
                            <p class="mx-auto mt-6 max-w-2xl text-lg tracking-tight text-white/90 animate-fade-in-up animate-delay-500" style="text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);">
                                Nearly 50 years of quality craftsmanship. From Disney World to your backyard - professional installation and premium DIY supplies with American-made materials.
                            </p>
                            <div class="mt-10 flex justify-center gap-x-6 animate-fade-in-up animate-delay-600">
                                <a href="{{ route('diy.quote') }}" class="group inline-flex items-center justify-center rounded-full py-3 px-6 text-sm font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 bg-danielle text-white hover:bg-daniellealt focus-visible:outline-danielle">
                                    Get Free Quote
                                </a>
                                <a href="tel:863-425-3182" class="group inline-flex ring-1 items-center justify-center rounded-full py-3 px-6 text-sm ring-white/30 text-white hover:text-white hover:ring-white/50 active:bg-white/10">
                                    <svg aria-hidden="true" class="h-3 w-3 flex-none fill-white group-active:fill-current">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    <span class="ml-3">(863) 425-3182</span>
                                </a>
                            </div>
                        </div>

                        <!-- Right Column - Video -->
                        <div class="relative animate-fade-in-up animate-delay-400 max-w-xs mx-auto" style="background: transparent;">
                            <!-- Thought Bubble -->
                            <div class="absolute -top-16 left-1/2 transform -translate-x-1/2 z-20 animate-fade-in-up animate-delay-600">
                                <a href="/chat" class="block group">
                                    <div class="relative bg-white rounded-2xl px-4 py-3 shadow-lg border-2 border-danielle/20 hover:border-danielle/40 transition-all duration-300 hover:scale-105">
                                        <div class="text-center text-sm font-semibold text-danielle">
                                            Questions?<br>
                                            <span class="text-xs font-normal">Chat with Grillbert!</span>
                                        </div>
                                        <!-- Bubble tail pointing down -->
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2">
                                            <div class="w-0 h-0 border-l-[8px] border-r-[8px] border-t-[12px] border-l-transparent border-r-transparent border-t-white"></div>
                                            <div class="absolute -top-[13px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-[9px] border-r-[9px] border-t-[13px] border-l-transparent border-r-transparent border-t-danielle/20"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <a href="/chat" class="block cursor-pointer">
                                <video autoplay loop muted playsinline class="w-full h-auto rounded-2xl alpha-video hover:scale-105 transition-transform duration-300" style="background: transparent !important; display: block;">
                                    <source src="{{ asset('videos/grillbert.webm') }}" type="video/webm">
                                    <source src="{{ asset('videos/grillbert.mov') }}" type="video/quicktime">
                                </video>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </header>

    <!-- 5 Star Reviews Marquee -->
    <div class="marquee-container bg-success py-3 border-b border-white/20">
        <div class="marquee-content">
            @if(isset($marquee_reviews) && $marquee_reviews->isNotEmpty())
                @foreach($marquee_reviews as $review)
                <div class="inline-flex items-center mx-8">
                    <div class="flex text-yellow-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star text-sm"></i>
                            @else
                                <i class="far fa-star text-sm text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-white text-sm font-medium">"{{ Str::limit($review->content ?: 'Great service and quality work!', 80) }}"</span>
                    <span class="text-white/80 text-sm ml-2">- {{ $review->author }}</span>
                </div>
                @endforeach
                @foreach($marquee_reviews as $review)
                <div class="inline-flex items-center mx-8">
                    <div class="flex text-yellow-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star text-sm"></i>
                            @else
                                <i class="far fa-star text-sm text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-white text-sm font-medium">"{{ Str::limit($review->content ?: 'Great service and quality work!', 80) }}"</span>
                    <span class="text-white/80 text-sm ml-2">- {{ $review->author }}</span>
                </div>
                @endforeach
            @else
                {{-- Fallback content when no reviews --}}
                <div class="inline-flex items-center mx-8">
                    <div class="flex text-yellow-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-sm"></i>
                        @endfor
                    </div>
                    <span class="text-white text-sm font-medium">"Excellent service and professional installation. Highly recommend!"</span>
                    <span class="text-white/80 text-sm ml-2">- Verified Customer</span>
                </div>
                <div class="inline-flex items-center mx-8">
                    <div class="flex text-yellow-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-sm"></i>
                        @endfor
                    </div>
                    <span class="text-white text-sm font-medium">"Quality materials and expert workmanship. Very satisfied!"</span>
                    <span class="text-white/80 text-sm ml-2">- Happy Customer</span>
                </div>
                <div class="inline-flex items-center mx-8">
                    <div class="flex text-yellow-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-sm"></i>
                        @endfor
                    </div>
                    <span class="text-white text-sm font-medium">"49 years of experience shows in every fence they install."</span>
                    <span class="text-white/80 text-sm ml-2">- Local Homeowner</span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-data="{
            showDIY: false,
            showServices: false,
            showAbout: false,
        }" class="lg:hidden" role="dialog" aria-modal="true" aria-label="Menu">
            <div x-show="showMobile" x-cloak class="fixed inset-0 z-[60]"></div>
            <div x-show="showMobile" x-cloak @click.outside="showMobile=false"
                 class="fixed inset-y-0 right-0 z-[60] w-full overflow-y-auto bg-danielle px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-white">
                        Call <a aria-label="Phone Number" href="tel:863-425-3182">(863) 425-3182</a>
                    </div>
                    <button @click="showMobile = false" type="button" class="-m-2.5 rounded-md p-2.5 text-danielle">
                        <span class="sr-only">Close menu</span>
                        <i class="fas fa-times text-white text-xl"></i>
                    </button>
                </div>
                
                <!-- Mobile Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="search" 
                               placeholder="Search products, services..."
                               class="w-full pl-10 pr-4 py-3 text-sm text-brand-dark bg-brand-cream/90 backdrop-blur-sm border border-white/30 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-light focus:border-transparent placeholder-brand-dark/60">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="fas fa-search text-brand-dark/60 text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <!-- Home -->
                            <a aria-label="Home" href="{{ route('welcome') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">Home</a>
                            
                            <!-- Product Categories Section -->
                            <div class="space-y-2">
                                <div class="-mx-3 px-3 py-2 text-base font-semibold leading-7 text-white">
                                    Product Categories
                                </div>
                                <div class="space-y-2 pl-6">
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $category)
                                            <a aria-label="{{ $category->name }}" href="{{ route('diyproductcategories.category', $category->slug) }}"
                                               class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">{{ $category->name }}</a>
                                        @endforeach
                                    @else
                                        <!-- Fallback categories if no database categories -->
                                        <a aria-label="Vinyl/PVC" href="{{ route('diy.index') }}#vinyl"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Vinyl/PVC</a>
                                        <a aria-label="Aluminum" href="{{ route('diy.index') }}#aluminum"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Aluminum</a>
                                        <a aria-label="Wood" href="{{ route('diy.index') }}#wood"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Wood</a>
                                        <a aria-label="Chain Link" href="{{ route('diy.index') }}#chain-link"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Chain Link</a>
                                        <a aria-label="Gates" href="{{ route('diy.index') }}#gates"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Gates</a>
                                        <a aria-label="Accessories" href="{{ route('diy.index') }}#accessories"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Accessories</a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Specials -->
                            <a aria-label="Specials" href="{{ route('specials') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">Specials</a>

                            <!-- DIY Section -->
                            <div class="space-y-2">
                                <button @click="showDIY = !showDIY" type="button" class="-mx-3 flex w-full items-center justify-between rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">
                                    DIY
                                    <i :class="showDIY ? 'rotate-180' : ''" class="fas fa-chevron-down flex-none transition-transform"></i>
                                </button>
                                <div x-show="showDIY" x-collapse class="space-y-2 pl-6">
                                    <a aria-label="DIY Products" href="{{ route('diy.index') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">DIY Products</a>
                                    <a aria-label="Easy Fixes" href="{{ route('diy.easy-fixes') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Easy Fixes</a>
                                    <a aria-label="Installation Guides" href="{{ route('diy.guide') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Installation Guides</a>
                                    <a aria-label="Get Quote" href="{{ route('diy.quote') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Get Quote</a>
                                </div>
                            </div>
                            
                            
                            <!-- Blog -->
                            <a aria-label="Blog" href="{{ route('blog.index') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">Blog</a>
                            
                            <!-- About Section -->
                            <div class="space-y-2">
                                <button @click="showAbout = !showAbout" type="button" class="-mx-3 flex w-full items-center justify-between rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">
                                    About
                                    <svg :class="showAbout ? 'rotate-180' : ''" class="h-5 w-5 flex-none transition-transform" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div x-show="showAbout" x-collapse class="space-y-2 pl-6">
                                    <a aria-label="Our Story" href="{{ route('about.history') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Our Story</a>
                                    <a aria-label="Why Choose Us" href="{{ route('why-danielle-fence') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Why Choose Us</a>
                                    <a aria-label="Service Areas" href="#"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Service Areas</a>
                                    <a aria-label="Reviews" href="{{ route('reviews') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Reviews</a>
                                </div>
                            </div>
                            
                            <!-- Contact -->
                            <a aria-label="Contact Us" href="{{ route('contact') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">Contact</a>
                            
                            <!-- Get Quote Button -->
                            <div class="pt-4">
                                <a aria-label="Request Quote" href="{{ route('diy.quote') }}"
                                   class="-mx-3 block rounded-lg bg-white px-3 py-2 text-center text-base font-semibold leading-7 text-danielle hover:bg-gray-100">Get Free Quote</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>