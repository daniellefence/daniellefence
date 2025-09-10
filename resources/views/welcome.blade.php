<x-app-layout>
    <style>
        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
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
        .marquee-content-slow {
            display: inline-flex;
            animation: marquee 160s linear infinite;
            white-space: nowrap;
            padding-right: 4rem;
        }
    </style>
    <!-- Service Areas Marquee -->
    @if($service_areas->isNotEmpty())
    <div class="bg-danielle py-4">
        <h3 class="text-center text-white font-semibold text-lg mb-2">Proudly Serving These Areas</h3>
        <div class="marquee-container">
            <div class="marquee-content-slow">
                @foreach($service_areas as $area)
                <span class="inline-flex items-center mx-6 text-white text-sm font-medium">{{ $area->name }}</span>
                @endforeach
                @foreach($service_areas as $area)
                <span class="inline-flex items-center mx-6 text-white text-sm font-medium">{{ $area->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Business Partners/Clients Logo Section -->
    <div class="bg-white py-12 scroll-reveal">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h3 class="text-center text-lg font-semibold text-brand-dark mb-8">Trusted By Industry Leaders</h3>
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-6 items-center">
                <!-- Disney World -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/Walt_Disney_World_Resort_logo.svg') }}" alt="Walt Disney World" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- SeaWorld -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/swo_logo.webp') }}" alt="SeaWorld Orlando" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- Universal Studios -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/UOR_GlobeLogo_4C-768x445.jpg') }}" alt="Universal Orlando Resort" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- Publix -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/publix.png') }}" alt="Publix Supermarkets" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- City of Lakeland -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/lakeland.png') }}" alt="City of Lakeland" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- Polk County -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/Logo_of_Polk_County,_Florida.svg') }}" alt="Polk County" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
            </div>
            
            <!-- Second row for additional partners -->
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-6 items-center mt-8">
                <!-- Legoland -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/LEGOLAND_Florida_Resort_Logo.jpg') }}" alt="LEGOLAND Florida Resort" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- Wawa -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/wawa-logo-logo.png') }}" alt="Wawa" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- Home Depot -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/THD_logo.jpg') }}" alt="The Home Depot" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- Lowes -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/Lowes_logo_pms_280.png') }}" alt="Lowe's Home Improvement" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
                
                <!-- School Board -->
                <div class="col-span-1 flex justify-center items-center h-20">
                    <img src="{{ asset('images/trustedby/polkcountyschools.webp') }}" alt="Polk County Schools" class="h-16 w-auto object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                </div>
            </div>
            
            <p class="text-center text-sm text-gray-500 mt-8">
                From theme parks to retail giants, municipalities to movie sets - we're the trusted choice for Central Florida's most demanding projects.
            </p>
        </div>
    </div>

        <!-- Features Section -->
        <div class="bg-white py-24 sm:py-32 scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-base font-semibold leading-7 text-danielle">Why Choose DIY?</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Professional Results, DIY Savings
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Get the same high-quality materials we use for professional installations at wholesale prices.
                    </p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <svg class="h-5 w-5 flex-none text-danielle" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                </svg>
                                Save 40-60% on Labor Costs
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Our DIY kits include everything you need with detailed instructions. Most homeowners save $3,000-$5,000 on a typical fence project.</p>
                            </dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <svg class="h-5 w-5 flex-none text-danielle" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                Professional-Grade Materials
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Same premium aluminum, vinyl, and wood materials we use for professional installations. No compromise on quality.</p>
                            </dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <svg class="h-5 w-5 flex-none text-danielle" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                Expert Support Included
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Get phone support from our installation experts. We're here to help you succeed with your DIY project.</p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-danielle scroll-reveal">
            <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Start Your DIY Fence Project Today
                    </h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-white">
                        Get a personalized quote for your fence project. Our experts will calculate exactly what you need and provide detailed installation instructions.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('diy.quote') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-danielle shadow-sm hover:bg-gray-100">
                            Get Your Free Quote
                        </a>
                        <a href="tel:863-425-3182" class="text-sm font-semibold leading-6 text-white">
                            Call (863) 425-3182 <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Heritage & Trust Section -->
        <div class="bg-white py-24 sm:py-32 scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-base font-semibold leading-7 text-danielle">Since 1976</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Nearly 50 Years of Florida Excellence
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        From Disney World to SeaWorld, from movie sets to family homes - we've built Central Florida's reputation one fence at a time.
                    </p>
                </div>
                
                <!-- Marquee Projects -->
                <div class="mx-auto mt-16 max-w-2xl text-center lg:max-w-none">
                    <h3 class="text-xl font-semibold text-gray-900 mb-8">Trusted by Industry Leaders</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 items-center text-center">
                        <div class="flex flex-col items-center">
                            <div class="text-2xl font-bold text-danielle">Disney World</div>
                            <div class="text-sm text-gray-600">Theme Park Projects</div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="text-2xl font-bold text-danielle">SeaWorld</div>
                            <div class="text-sm text-gray-600">Marine Park Fencing</div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="text-2xl font-bold text-danielle">Movie Sets</div>
                            <div class="text-sm text-gray-600">Entertainment Industry</div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="text-2xl font-bold text-danielle">Maze Rebuild</div>
                            <div class="text-sm text-gray-600">Specialty Projects</div>
                        </div>
                    </div>
                </div>

                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">49+</div>
                        <div class="mt-2 text-base text-gray-600">Years of Excellence</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">10,000+</div>
                        <div class="mt-2 text-base text-gray-600">Projects Completed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">100%</div>
                        <div class="mt-2 text-base text-gray-600">American Materials</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">3rd</div>
                        <div class="mt-2 text-base text-gray-600">Generation Family-Owned</div>
                    </div>
                </div>
                
                <!-- Why Choose Us -->
                <div class="mx-auto mt-16 max-w-4xl">
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <h3 class="text-xl font-semibold text-gray-900 text-center mb-6">Why Choose Danielle Fence</h3>
                        <div class="grid md:grid-cols-3 gap-6 text-center">
                            <div>
                                <div class="text-danielle font-semibold">In-House Installation Crews</div>
                                <p class="text-sm text-gray-600 mt-1">No subcontractors. Our trained professionals handle every project.</p>
                            </div>
                            <div>
                                <div class="text-danielle font-semibold">American-Made Materials</div>
                                <p class="text-sm text-gray-600 mt-1">Premium quality materials sourced from trusted US manufacturers.</p>
                            </div>
                            <div>
                                <div class="text-danielle font-semibold">Family Legacy</div>
                                <p class="text-sm text-gray-600 mt-1">Three generations of quality craftsmanship and customer service.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Install of the Week Section -->
        <div class="bg-danielle py-24 sm:py-32 scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-base font-semibold leading-7 text-white/80">Featured Project</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Install of the Week
                    </p>
                    <p class="mt-6 text-lg leading-8 text-white/90">
                        Showcasing our latest professional installations across Central Florida.
                    </p>
                </div>
                
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-2 items-center">
                    <!-- Project Image Placeholder -->
                    <div class="relative">
                        <div class="aspect-[4/3] rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                            <div class="text-center text-white/60">
                                <i class="fas fa-camera text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Featured Installation Photo</p>
                                <p class="text-sm">Updated Weekly</p>
                            </div>
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-[#68bf21] text-white text-sm font-semibold rounded-full">
                                This Week
                            </span>
                        </div>
                    </div>
                    
                    <!-- Project Details -->
                    <div class="text-white">
                        <h3 class="text-2xl font-bold mb-4">Premium Vinyl Privacy Fence</h3>
                        <div class="space-y-4 text-white/90">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt text-[#68bf21] mt-1"></i>
                                <div>
                                    <p class="font-medium">Lakeland, FL</p>
                                    <p class="text-sm text-white/70">Residential Installation</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-ruler text-[#68bf21] mt-1"></i>
                                <div>
                                    <p class="font-medium">200 Linear Feet</p>
                                    <p class="text-sm text-white/70">6ft Height with Privacy Slats</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-clock text-[#68bf21] mt-1"></i>
                                <div>
                                    <p class="font-medium">2 Day Installation</p>
                                    <p class="text-sm text-white/70">Professional Crew</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-star text-[#68bf21] mt-1"></i>
                                <div>
                                    <p class="font-medium">Customer Testimonial</p>
                                    <p class="text-sm text-white/70 italic">"Exceptional quality and service. The team was professional and efficient!"</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <a href="{{ route('diy.quote') }}" class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2 text-sm font-semibold text-danielle shadow-sm hover:bg-gray-100">
                                Get Your Free Quote
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Previous Installs Preview -->
                <div class="mx-auto mt-16 text-center">
                    <h4 class="text-lg font-semibold text-white mb-6">Recent Featured Installations</h4>
                    <div class="flex flex-wrap justify-center gap-4">
                        <span class="px-3 py-1 bg-white/10 text-white text-sm rounded-full border border-white/20">
                            Aluminum Pool Fence - Tampa
                        </span>
                        <span class="px-3 py-1 bg-white/10 text-white text-sm rounded-full border border-white/20">
                            Wood Privacy Fence - Winter Haven
                        </span>
                        <span class="px-3 py-1 bg-white/10 text-white text-sm rounded-full border border-white/20">
                            Chain Link Commercial - Mulberry
                        </span>
                        <span class="px-3 py-1 bg-white/10 text-white text-sm rounded-full border border-white/20">
                            Vinyl Decorative - Bartow
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        @if($featured_products->isNotEmpty())
        <div class="bg-gray-50 py-24 sm:py-32 scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Featured DIY Fence Products
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Professional-grade materials perfect for your DIY fence project. Same quality we use in our installations.
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach($featured_products->take(6) as $product)
                    <article class="flex flex-col items-start">
                        @if($product->getFirstMediaUrl())
                        <div class="relative w-full">
                            <img src="{{ $product->getFirstMediaUrl() }}" alt="{{ $product->name }}" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                        </div>
                        @endif
                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <span class="text-gray-500">{{ $product->category->name ?? 'Fencing' }}</span>
                                @if($product->base_price)
                                <span class="text-danielle font-semibold">Starting at ${{ number_format($product->base_price, 2) }}</span>
                                @endif
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="{{ route('diy.products') }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                    {{ Str::limit(strip_tags($product->description), 120) }}
                                </p>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('diy.products') }}" class="rounded-md bg-danielle px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-daniellealt focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danielle">
                        View All Products
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Current Specials Section -->
        @if($specials->isNotEmpty())
        <div class="bg-danielle py-24 sm:py-32 scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Current Specials & Promotions
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-white">
                        Limited-time offers on premium fencing materials and services.
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach($specials as $special)
                    <div class="bg-white rounded-2xl p-8 text-center ring-1 ring-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $special->title }}</h3>
                        <p class="mt-4 text-gray-600">{{ $special->description }}</p>
                        @if($special->discount_percentage)
                        <div class="mt-6">
                            <span class="text-3xl font-bold text-danielle">{{ $special->discount_percentage }}% OFF</span>
                        </div>
                        @endif
                        @if($special->end_date)
                        <p class="mt-4 text-sm text-gray-500">Valid until {{ $special->end_date->format('F j, Y') }}</p>
                        @endif
                        <a href="{{ route('diy.quote') }}" class="mt-6 block w-full rounded-md bg-danielle px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-daniellealt">
                            Get Quote
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Blog Posts Section -->
        @if($recent_blogs->isNotEmpty())
        <div class="bg-white py-24 sm:py-32 scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Latest Fencing Tips & Insights
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Expert advice from our 49 years of fencing experience in Central Florida.
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach($recent_blogs as $blog)
                    <article class="flex flex-col items-start">
                        @if($blog->featured_image)
                        <div class="relative w-full">
                            <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                        </div>
                        @endif
                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $blog->published_at->format('Y-m-d') }}" class="text-gray-500">{{ $blog->published_at->format('M j, Y') }}</time>
                                @if($blog->category)
                                <span class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">{{ $blog->category->name }}</span>
                                @endif
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                    {{ $blog->excerpt }}
                                </p>
                            </div>
                            <div class="relative mt-8 flex items-center gap-x-4">
                                <div class="text-sm leading-6">
                                    <p class="font-semibold text-gray-900">{{ $blog->author->name ?? 'Danielle Fence Team' }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
        @endif


        <!-- Service Areas Section -->
        @if($service_areas->isNotEmpty())
        <div class="bg-white py-24 sm:py-32 scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Areas We Serve
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Proudly serving Central Florida communities with professional fence installation and DIY supplies.
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-2 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    @foreach($service_areas as $area)
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $area->name }}</h3>
                        @if($area->description)
                        <p class="mt-2 text-sm text-gray-600">{{ Str::limit($area->description, 80) }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('diy.quote') }}" class="rounded-md bg-danielle px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-daniellealt focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danielle">
                        Get Quote for Your Area
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Final CTA Section -->
        <div class="bg-gradient-to-br from-[#8e2a2a] to-[#7a2424]">
            <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <div class="mb-6">
                        <span class="inline-block px-4 py-2 bg-white/20 text-white text-sm font-semibold rounded-full border border-white/30">
                            Trusted Since 1976
                        </span>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Ready to Experience 49 Years of Excellence?
                    </h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-white/90">
                        Join thousands of satisfied customers who chose Central Florida's most trusted fencing company. From Disney World to your backyard - American-made quality guaranteed.
                    </p>
                    <div class="mt-10 space-y-4">
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('diy.quote') }}" class="w-full sm:w-auto rounded-md bg-[#68bf21] px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-[#5da61e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#68bf21] transition-colors">
                                Get Your Free Quote Today
                            </a>
                            <a href="tel:863-425-3182" class="w-full sm:w-auto rounded-md bg-white px-6 py-3 text-lg font-semibold text-danielle shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors">
                                Call (863) 425-3182
                            </a>
                        </div>
                        <div class="flex items-center justify-center gap-6 text-white/80 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>Free Estimates</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>Expert Installation</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>Lifetime Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>