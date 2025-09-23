<x-app-layout>
    <!-- Hero Section -->
    <x-modern-hero
        title="About Danielle Fence"
        subtitle="Since 1976 • Family-Owned & Operated"
        description="Central Florida's premier fence and outdoor living company, serving over 100,000 families with five-star service and American-made quality."
        :background-image="Vite::asset('resources/images/about--hero.webp')"
        cta="Get Your Free Estimate"
        :cta-url="route('request-a-quote')"
        />

    <!-- Our Story Section -->
    <x-modern-section spacing="py-20 md:py-28" aos="fade-up">
        <div class="grid grid-cols-1 gap-16 lg:grid-cols-2 lg:gap-20 items-center">
            <!-- Content -->
            <div data-aos="fade-right" data-aos-delay="200">
                <div class="mb-6">
                    <span class="inline-block px-4 py-2 bg-outdoor-secondary text-white text-sm font-semibold rounded-full">
                        Our Journey
                    </span>
                </div>
                <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-slate-900 mb-8">
                    From Humble Beginnings to
                    <span class="text-outdoor-primary">Five-Star Excellence</span>
                </h2>

                <div class="space-y-6 text-lg text-slate-700 leading-relaxed">
                    <p>In 1976, a group of young brothers had an idea to sell wood fences to customers who bought above ground swimming pools from their father's pool company. They didn't have tools, a truck, materials or a proper place to build fences. What they did have was initiative and a willingness to work hard.</p>

                    <p>Together, with help from their parents and grandmother, they began taking orders, building fences and building a name. That small backyard fence company was the beginning of what is today known as <strong class="text-gray-900">Danielle Fence & Outdoor Living</strong>.</p>

                    <p>From manufacturing 6'x8' cypress panels in the 1980s to becoming Central Florida's premier outdoor living specialists, we've continuously evolved to meet our customers' dreams while maintaining our family values and commitment to excellence.</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-6 mt-10" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center p-6 bg-green-50 border border-green-200 rounded-xl">
                        <div class="text-3xl font-bold text-green-700 mb-2">100,000+</div>
                        <div class="text-sm font-medium text-gray-600">Families Served</div>
                    </div>
                    <div class="text-center p-6 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="text-3xl font-bold text-blue-700 mb-2">47+</div>
                        <div class="text-sm font-medium text-gray-600">Years Experience</div>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div data-aos="fade-left" data-aos-delay="300">
                <div class="relative">
                    <img src="{{Vite::asset('resources/images/about--photo.webp')}}"
                         alt="Danielle Fence Family Business"
                         class="w-full h-auto rounded-2xl shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">

                    <!-- Floating Badge -->
                    <div class="absolute -top-4 -right-4 bg-outdoor-primary text-white px-6 py-3 rounded-full shadow-lg transform -rotate-12">
                        <div class="text-center">
                            <div class="text-sm font-bold">Family Owned</div>
                            <div class="text-xs">Since 1976</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-modern-section>

    <!-- Values Section -->
    <x-modern-section background="bg-slate-50" spacing="py-20 md:py-28">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-slate-900 mb-6">
                Why Families Choose Us
            </h2>
            <p class="text-xl text-slate-700 max-w-3xl mx-auto">
                Nearly five decades of experience, innovation, and unwavering commitment to quality.
            </p>
        </div>

        <x-modern-grid columns="3">
            <x-modern-card
                title="Proven Experience"
                description="Over 5 million linear feet manufactured since 1976. Family-owned and operated with fences still standing after 35+ years."
                aos="fade-up" delay="100">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fa-solid fa-shield-check w-6 h-6 text-green-700"></i>
                </div>
            </x-modern-card>

            <x-modern-card
                title="Dedicated Team"
                description="60+ full-time professionals with 300+ years of collective experience. No subcontractors - only our trained experts."
                aos="fade-up" delay="200">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fa-solid fa-users w-6 h-6 text-blue-700"></i>
                </div>
            </x-modern-card>

            <x-modern-card
                title="American Quality"
                description="Made in USA materials that are lead-free, child/pet-friendly, and recyclable. Industry's best warranty with 97% customer satisfaction."
                aos="fade-up" delay="300">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fa-solid fa-star w-6 h-6 text-yellow-700"></i>
                </div>
            </x-modern-card>
        </x-modern-grid>
    </x-modern-section>


    <!-- Visit Us CTA -->
    <x-modern-cta
        title="Visit Our Design Center"
        description="Experience our 20,000+ square foot showroom at 4855 State Road 60 West, Mulberry, FL. See our products up close and meet with our design experts."
        button-text="Schedule Your Visit"
        :button-url="route('request-a-quote')"
        secondary-text="Call (863) 425-3182"
        secondary-url="tel:863-425-3182"
        :pattern="true" />
</x-app-layout>
