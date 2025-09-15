<x-app-layout>
    <div class="min-h-screen">
        <!-- Heritage & Trust Section -->
        <div class="bg-slate-50 py-24 sm:py-32 scroll-reveal section-slate-texture">
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
                <div class="mx-auto mt-16 max-w-7xl">
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
        <div class="bg-amber-50 py-24 sm:py-32 scroll-reveal section-amber-texture">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-base font-semibold leading-7 text-danielle">Featured Project</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Install of the Week
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Showcasing our latest professional installations across Central Florida.
                    </p>
                </div>
                
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-2 items-center">
                    <!-- Project Image Placeholder -->
                    <div class="relative">
                        <div class="aspect-[4/3] rounded-2xl bg-white border border-gray-200 flex items-center justify-center">
                            <div class="text-center text-gray-400">
                                <i class="fas fa-camera text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Featured Installation Photo</p>
                                <p class="text-sm">Updated Weekly</p>
                            </div>
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-danielle text-white text-sm font-semibold rounded-full">
                                This Week
                            </span>
                        </div>
                    </div>
                    
                    <!-- Project Details -->
                    <div class="text-gray-900">
                        <h3 class="text-2xl font-bold mb-4">Premium Vinyl Privacy Fence</h3>
                        <div class="space-y-4 text-gray-700">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt text-danielle mt-1"></i>
                                <div>
                                    <p class="font-medium">Lakeland, FL</p>
                                    <p class="text-sm text-gray-500">Residential Installation</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-ruler text-danielle mt-1"></i>
                                <div>
                                    <p class="font-medium">200 Linear Feet</p>
                                    <p class="text-sm text-gray-500">6ft Height with Privacy Slats</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-clock text-danielle mt-1"></i>
                                <div>
                                    <p class="font-medium">2 Day Installation</p>
                                    <p class="text-sm text-gray-500">Professional Crew</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fas fa-star text-danielle mt-1"></i>
                                <div>
                                    <p class="font-medium">Customer Testimonial</p>
                                    <p class="text-sm text-gray-600 italic">"Exceptional quality and service. The team was professional and efficient!"</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <a href="{{ route('diy.quote') }}" class="inline-flex items-center gap-2 rounded-md bg-danielle px-4 py-2 text-sm font-semibold text-white hover:bg-daniellealt">
                                Get Your Free Quote
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Previous Installs Preview -->
                <div class="mx-auto mt-16 text-center">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Recent Featured Installations</h4>
                    <div class="flex flex-wrap justify-center gap-4">
                        <span class="px-3 py-1 bg-white text-gray-700 text-sm rounded-full border border-gray-200">
                            Aluminum Pool Fence - Tampa
                        </span>
                        <span class="px-3 py-1 bg-white text-gray-700 text-sm rounded-full border border-gray-200">
                            Wood Privacy Fence - Winter Haven
                        </span>
                        <span class="px-3 py-1 bg-white text-gray-700 text-sm rounded-full border border-gray-200">
                            Chain Link Commercial - Mulberry
                        </span>
                        <span class="px-3 py-1 bg-white text-gray-700 text-sm rounded-full border border-gray-200">
                            Vinyl Decorative - Bartow
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        @if($featured_products->isNotEmpty())
        <div class="bg-gray-50 py-24 sm:py-32 scroll-reveal section-gray-texture">
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
                                    <a href="{{ route('diy.index') }}">
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
                    <a href="{{ route('diy.index') }}" class="rounded-md bg-danielle px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-daniellealt focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danielle">
                        View All Products
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Current Specials Section -->
        @if($specials->isNotEmpty())
        <div class="bg-emerald-900 py-24 sm:py-32 scroll-reveal section-emerald-texture">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Current Specials & Promotions
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-brand-cream">
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
                            <span class="text-3xl font-bold text-success">{{ $special->discount_percentage }}% OFF</span>
                        </div>
                        @endif
                        @if($special->end_date)
                        <p class="mt-4 text-sm text-gray-500">Valid until {{ $special->end_date->format('F j, Y') }}</p>
                        @endif
                        <a href="{{ route('diy.quote') }}" class="mt-6 block w-full rounded-md bg-danielle px-3 py-2 text-center text-sm font-semibold text-white hover:bg-daniellealt">
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
        <div class="bg-blue-50 py-24 sm:py-32 scroll-reveal section-blue-texture">
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
        <div class="bg-orange-50 py-24 sm:py-32 scroll-reveal section-orange-texture">
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
                    <a href="{{ route('diy.quote') }}" class="rounded-md bg-danielle px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-daniellealt focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danielle">
                        Get Quote for Your Area
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Trusted by Industry Leaders Section -->
        <div class="bg-white py-24 sm:py-32 grass-offset scroll-reveal">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Trusted by Industry Leaders</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        From theme parks to retail giants, municipalities to movie sets - we're the trusted choice for Central Florida's most demanding projects.
                    </p>
                </div>

                <!-- Logo Grid -->
                <div class="mx-auto mt-16 grid w-full grid-cols-4 gap-x-6 gap-y-12 items-center justify-items-center">
                    <!-- Disney World -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/Walt_Disney_World_Resort_logo.svg') }}" alt="Walt Disney World" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- SeaWorld -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/swo_logo.webp') }}" alt="SeaWorld Orlando" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- Universal Studios -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/UOR_GlobeLogo_4C-768x445.jpg') }}" alt="Universal Orlando Resort" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- Publix -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/publix.png') }}" alt="Publix Supermarkets" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- City of Lakeland -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/lakeland.png') }}" alt="City of Lakeland" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- Polk County -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/Logo_of_Polk_County,_Florida.svg') }}" alt="Polk County" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- Legoland -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/LEGOLAND_Florida_Resort_Logo.jpg') }}" alt="LEGOLAND Florida Resort" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- Wawa -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/wawa-logo-logo.png') }}" alt="Wawa" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- Home Depot -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/THD_logo.jpg') }}" alt="The Home Depot" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- Lowes -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/Lowes_logo_pms_280.png') }}" alt="Lowe's Home Improvement" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- School Board -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <img src="{{ asset('images/trustedby/polkcountyschools.webp') }}" alt="Polk County Schools" class="w-full object-contain filter grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                    </div>

                    <!-- And More -->
                    <div class="col-span-1 flex justify-center items-center p-8">
                        <div class="text-center">
                            <div class="text-gray-400 text-4xl mb-1">+</div>
                            <div class="text-gray-500 text-sm font-medium">Many More</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>