<style>
    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .marquee-container {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    
    .marquee-content {
        display: inline-flex;
        animation: marquee 60s linear infinite;
        white-space: nowrap;
        padding-right: 4rem;
    }
    
    .parallax-header {
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animate-slide-in-left {
        animation: slideInLeft 0.8s ease-out forwards;
    }
    
    .animate-delay-100 {
        animation-delay: 0.1s;
    }
    
    .animate-delay-200 {
        animation-delay: 0.2s;
    }
    
    .animate-delay-300 {
        animation-delay: 0.3s;
    }
    
    .animate-delay-400 {
        animation-delay: 0.4s;
    }
    
    .animate-delay-500 {
        animation-delay: 0.5s;
    }
    
    .animate-delay-600 {
        animation-delay: 0.6s;
    }
    
    .scroll-reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-out;
    }
    
    .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Navigation hover effects */
    .nav-hover {
        transition: all 0.3s ease;
    }
    
    .nav-hover:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Scroll reveal animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);
    
    // Observe all scroll-reveal elements
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });
});
</script>
<div x-data="{
        showMobile:false
    }">
    <!-- 5 Star Reviews Marquee - Top of Site -->
    <div class="marquee-container bg-[#68bf21] py-3 border-b border-white/20">
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

    <!-- Header with Hero Background -->
    <header class="relative z-40 parallax-header" style="background-image: url('{{ asset('images/home_hero.webp') }}');">
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
                    <a aria-label="Danielle Fence Logo" href="{{ route('welcome') }}" class="relative inline-block flex-shrink-0 rounded-lg shadow-lg border-4 border-white px-6 py-4" style="background-color: #8f2a2a; box-shadow: 0 4px 8px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.2), inset 0 -1px 0 rgba(0,0,0,0.3);">
                        <span class="sr-only">{{ config('app.name') }}</span>
                        <!-- License plate corner holes -->
                        <div class="absolute top-2 left-2 w-3 h-3 bg-white rounded-full z-20" style="box-shadow: inset 0 1px 3px rgba(0,0,0,0.4);"></div>
                        <div class="absolute top-2 right-2 w-3 h-3 bg-white rounded-full z-20" style="box-shadow: inset 0 1px 3px rgba(0,0,0,0.4);"></div>
                        <div class="absolute bottom-2 left-2 w-3 h-3 bg-white rounded-full z-20" style="box-shadow: inset 0 1px 3px rgba(0,0,0,0.4);"></div>
                        <div class="absolute bottom-2 right-2 w-3 h-3 bg-white rounded-full z-20" style="box-shadow: inset 0 1px 3px rgba(0,0,0,0.4);"></div>
                        <img
                            class="h-10 sm:h-14 lg:h-16 xl:h-20 w-auto flex-shrink-0 relative z-10"
                            src="{{ asset('images/logo.webp') }}"
                            alt="Danielle Fence Logo">
                    </a>
                </div>
                <div class="flex gap-6 lg:hidden">
                    <button
                        @click="showMobile = true"
                        @keyup.escape.window="showMobile = false"
                        type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-white bg-gradient-to-b from-[#8e2a2a] to-[#7a2525] border-2 border-[#6b1f1f]">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-white text-lg"></i>
                    </button>
                </div>
                
                <!-- Desktop Two-Line Navigation -->
                <div class="hidden lg:block px-6 py-3 nav-hover animate-fade-in-up animate-delay-100">
                    <!-- First Line: Product Categories -->
                    <div class="flex justify-center gap-x-4 mb-2">
                        @if(isset($product_categories) && $product_categories->count() > 0)
                            @foreach($product_categories as $category)
                                <a href="{{ route('diy.products') }}#{{ $category->slug }}" class="px-3 py-1 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        @else
                            <!-- Fallback categories if no database categories -->
                            <a href="{{ route('diy.products') }}#vinyl" class="px-3 py-1 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                Vinyl/PVC
                            </a>
                            <a href="{{ route('diy.products') }}#aluminum" class="px-3 py-1 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                Aluminum
                            </a>
                            <a href="{{ route('diy.products') }}#wood" class="px-3 py-1 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                Wood
                            </a>
                            <a href="{{ route('diy.products') }}#chain-link" class="px-3 py-1 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                Chain Link
                            </a>
                            <a href="{{ route('diy.products') }}#gates" class="px-3 py-1 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                Gates
                            </a>
                            <a href="{{ route('diy.products') }}#accessories" class="px-3 py-1 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                Accessories
                            </a>
                        @endif
                    </div>
                    
                    <!-- Second Line: Main Navigation -->
                    <div class="flex justify-center gap-x-4">
                        <!-- Commercial -->
                        <a aria-label="Commercial" href="{{ route('commercial') }}" class="px-4 py-2 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                            Commercial
                        </a>
                        
                        <!-- DIY Solutions -->
                        <a aria-label="DIY Solutions" href="{{ route('diy.index') }}" class="px-4 py-2 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                            DIY Solutions
                        </a>
                        
                        <!-- Specials -->
                        <a aria-label="Specials" href="#" class="px-4 py-2 text-base font-bold text-white hover:text-[#68bf21] hover:bg-black/30 rounded-lg transition-all duration-200" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                            Specials
                        </a>
                        
                        <!-- Resources Dropdown -->
                        <div class="relative group">
                            <!-- Invisible bridge to prevent hover loss -->
                            <div class="absolute top-full left-0 right-0 h-4 invisible group-hover:visible"></div>
                            <button class="px-4 py-2 text-base font-bold text-white hover:text-[#68bf21] transition-colors duration-200 inline-flex items-center gap-x-1" aria-expanded="false">
                                Resources
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div class="absolute left-0 z-50 -mt-1 pt-3 flex w-screen max-w-max opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none group-hover:pointer-events-auto">
                                <div class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl text-sm leading-6 shadow-xl backdrop-blur-xl bg-white/70 border border-white/20">
                                    <div class="p-4">
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="#" class="font-semibold text-gray-900">
                                                    Hardware Catalog
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">Browse our complete hardware catalog</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('gallery') }}" class="font-semibold text-gray-900">
                                                    Showcase
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">View our featured projects and installations</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('fire-feature-catalogs') }}" class="font-semibold text-gray-900">
                                                    Fire Feature Catalogs
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">Explore our fire pit and fireplace options</p>
                                            </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Company Dropdown -->
                        <div class="relative group">
                            <!-- Invisible bridge to prevent hover loss -->
                            <div class="absolute top-full left-0 right-0 h-4 invisible group-hover:visible"></div>
                            <button class="px-4 py-2 text-base font-bold text-white hover:text-[#68bf21] transition-colors duration-200 inline-flex items-center gap-x-1" aria-expanded="false">
                                Company
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div class="absolute right-0 z-50 -mt-1 pt-3 flex w-screen max-w-max opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none group-hover:pointer-events-auto">
                                <div class="w-screen max-w-sm flex-auto overflow-hidden rounded-3xl text-sm leading-6 shadow-xl backdrop-blur-xl bg-white/70 border border-white/20">
                                    <div class="p-4">
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('about.history') }}" class="font-semibold text-gray-900">
                                                    About Us
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">Learn about our company history</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('showroom') }}" class="font-semibold text-gray-900">
                                                    Visit Our Showroom
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">See our products and displays in person</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('blog.index') }}" class="font-semibold text-gray-900">
                                                    Blog
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">Tips, guides, and industry insights</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('why-danielle-fence') }}" class="font-semibold text-gray-900">
                                                    Why Danielle Fence?
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">49 years of excellence in Central Florida</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="#" class="font-semibold text-gray-900">
                                                    FAQ
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">Frequently asked questions</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('reviews') }}" class="font-semibold text-gray-900">
                                                    Reviews
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">See what our customers say</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="#" class="font-semibold text-gray-900">
                                                    Careers
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">Join our team</p>
                                            </div>
                                        </div>
                                        <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-white/30 transition-colors duration-200">
                                            <div>
                                                <a href="{{ route('contact') }}" class="font-semibold text-gray-900">
                                                    Contact Us
                                                    <span class="absolute inset-0"></span>
                                                </a>
                                                <p class="mt-1 text-gray-600">Get in touch with our team</p>
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
                    <div class="max-w-3xl animate-fade-in-up animate-delay-200">
                        <div class="mb-4">
                            <span class="inline-block px-4 py-2 bg-[#68bf21] text-white text-sm font-semibold rounded-full animate-slide-in-left animate-delay-300">
                                Since 1976 • Family-Owned & Operated
                            </span>
                        </div>
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl animate-fade-in-up animate-delay-400" style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0 0 20px rgba(0, 0, 0, 0.5);">
                            Central Florida's Premier Fence Company
                        </h1>
                        <div class="mt-6 bg-black/30 backdrop-blur-sm rounded-lg p-4 animate-fade-in-up animate-delay-500">
                            <p class="text-xl leading-8 text-white">
                                Nearly 50 years of quality craftsmanship. From Disney World to your backyard - professional installation and premium DIY supplies with American-made materials.
                            </p>
                        </div>
                        <div class="mt-10 flex items-center gap-x-6 animate-fade-in-up animate-delay-600">
                            <a href="{{ route('diy.quote') }}" class="rounded-md bg-[#8e2a2a] px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-[#7a2424] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#8e2a2a]">
                                Get Free Quote
                            </a>
                            <a href="tel:863-425-3182" class="text-lg font-semibold leading-6 text-white hover:text-gray-200">
                                Call (863) 425-3182 <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </header>
    
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
                                    @if(isset($product_categories) && $product_categories->count() > 0)
                                        @foreach($product_categories as $category)
                                            <a aria-label="{{ $category->name }}" href="{{ route('diy.products') }}#{{ $category->slug }}"
                                               class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">{{ $category->name }}</a>
                                        @endforeach
                                    @else
                                        <!-- Fallback categories if no database categories -->
                                        <a aria-label="Vinyl/PVC" href="{{ route('diy.products') }}#vinyl"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Vinyl/PVC</a>
                                        <a aria-label="Aluminum" href="{{ route('diy.products') }}#aluminum"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Aluminum</a>
                                        <a aria-label="Wood" href="{{ route('diy.products') }}#wood"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Wood</a>
                                        <a aria-label="Chain Link" href="{{ route('diy.products') }}#chain-link"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Chain Link</a>
                                        <a aria-label="Gates" href="{{ route('diy.products') }}#gates"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Gates</a>
                                        <a aria-label="Accessories" href="{{ route('diy.products') }}#accessories"
                                           class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Accessories</a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Commercial -->
                            <a aria-label="Commercial" href="{{ route('commercial') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">Commercial</a>
                            
                            <!-- DIY Solutions Section -->
                            <div class="space-y-2">
                                <button @click="showDIY = !showDIY" type="button" class="-mx-3 flex w-full items-center justify-between rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">
                                    DIY Solutions
                                    <i :class="showDIY ? 'rotate-180' : ''" class="fas fa-chevron-down flex-none transition-transform"></i>
                                </button>
                                <div x-show="showDIY" x-collapse class="space-y-2 pl-6">
                                    <a aria-label="DIY Products" href="{{ route('diy.products') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">DIY Products</a>
                                    <a aria-label="Easy Fixes" href="{{ route('diy.easy-fixes') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Easy Fixes</a>
                                    <a aria-label="Installation Guides" href="{{ route('diy.guide') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Installation Guides</a>
                                    <a aria-label="Get Quote" href="{{ route('diy.quote') }}"
                                       class="-mx-3 block rounded-lg px-3 py-2 text-sm leading-7 text-gray-200 hover:text-black hover:bg-white/30 transition-colors duration-200">Get Quote</a>
                                </div>
                            </div>
                            
                            <!-- Gallery -->
                            <a aria-label="Gallery" href="{{ route('gallery') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:text-black hover:bg-white/30 transition-colors duration-200">Gallery</a>
                            
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