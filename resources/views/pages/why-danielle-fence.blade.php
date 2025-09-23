<x-app-layout>
    <!-- Hero Section -->
    <x-modern-hero
        title="Why Choose Danielle Fence?"
        subtitle="The Difference is YOU • Since 1976"
        description="Discover what makes us Central Florida's most trusted fencing company. Nearly 50 years of proven excellence, family values, and unmatched quality."
        :background-image="asset('images/whychoose.webp')"
        cta="Get Your Free Quote"
        :cta-url="route('request-a-quote')"
        />

    <!-- Main Content -->
    <x-modern-section spacing="py-20 md:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Content -->
            <div data-aos="fade-right">
                <div class="prose prose-lg max-w-none">
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-brand-neutral-900 mb-8">
                        The Difference is YOU!
                    </h2>

                    <div class="space-y-8">
                        <div>
                            <h3 class="text-xl font-bold text-brand-primary-900 mb-4">Proven, Time-tested Experience!</h3>
                            <p class="text-brand-neutral-700 leading-relaxed">
                                In 1976, two teenage brothers began building a fence in their backyard. Over 40 years later, Danielle Fence has manufactured over 5 million linear feet of fencing. That's enough to circle the globe over 200 times! Now the largest fence manufacturer in Central Florida, the company is still owned and operated by the same family that founded the business. In fact, many of the original fences installed 35 years ago are still standing.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-brand-primary-900 mb-4">Our People Make the Difference</h3>
                            <p class="text-brand-neutral-700 leading-relaxed">
                                Danielle Fence employs over 60 full-time, dedicated, and highly trained professionals. Everyone you meet with or speak to at Danielle Fence actually works for the company. We do not use sub-contracted labor! Our employees are highly experienced and incredibly committed to every customer, and every home improvement project. With over 300 years of collective experience, there is not a project that we cannot handle.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-brand-primary-900 mb-4">You Have Options!</h3>
                            <p class="text-brand-neutral-700 leading-relaxed">
                                A variety of colors and exciting wood-grain textures completes our full line of outdoor living products. We don't just sell fences, we also have water and fire features, gazebos, arbors, pavers, and screen rooms. Our "Hurricane Ready" line of Florida State and Miami-Dade County High-Velocity Hurricane Zone (NOA) approved fence materials come in an array of color choices as well.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image & Social -->
            <div data-aos="fade-left" data-aos-delay="200">
                <div class="relative mb-8">
                    <img src="{{Vite::asset('resources/images/why-danielle-fence.webp')}}"
                         alt="Why Danielle Fence"
                         class="w-full h-auto rounded-2xl shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">

                    <!-- Badge -->
                    <div class="absolute -top-4 -right-4 bg-brand-accent-900 text-white px-6 py-3 rounded-full shadow-lg transform -rotate-12">
                        <div class="text-center">
                            <div class="text-sm font-bold">Family Owned</div>
                            <div class="text-xs">Since 1976</div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-brand-light-100 rounded-2xl p-6">
                    <h3 class="font-display text-xl font-bold text-brand-neutral-900 mb-4">
                        Follow Our Story
                    </h3>
                    <livewire:social wire:key="why-page{{rand(0,10000)}}" orientation="vertical" />
                </div>
            </div>
        </div>
    </x-modern-section>

    <!-- Additional Details Section -->
    <x-modern-section background="bg-brand-light-100" spacing="py-20 md:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div data-aos="fade-right">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-brand-neutral-900 mb-8">
                    Quality Counts Because You Deserve the Best!
                </h2>
                <div class="prose prose-lg max-w-none">
                    <p class="text-brand-neutral-700 leading-relaxed mb-6">
                        There are numerous materials and processes used to cut costs by many other fence providers. Some even import inferior products from abroad that contain harmful or dangerous chemicals and compounds that are in many cases difficult, if not impossible, to warranty.
                    </p>
                    <p class="text-brand-neutral-700 leading-relaxed mb-6">
                        Every Danielle Fence is made in the USA. Always clean and green, products are also lead-free, child/pet-friendly, and recyclable. Always know what you are getting before you buy. With every quote, you receive a full-color "product information page" that carefully details the unique specifications of the fence style(s) you selected.
                    </p>
                </div>
            </div>

            <div data-aos="fade-left" data-aos-delay="200">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-brand-neutral-900 mb-8">
                    The Industry's Best Warranty
                </h2>
                <div class="prose prose-lg max-w-none">
                    <p class="text-brand-neutral-700 leading-relaxed mb-6">
                        Before you invest in a fence, be sure that you carefully understand the terms and conditions of its warranty, including registration, exclusions, and what to do if you need to make a claim. The best warranty is the one you will never have to use!
                    </p>
                    <p class="text-brand-neutral-700 leading-relaxed">
                        In more than 25 years in direct partnership with Nebraska Plastics and Country Estate™, there has been not one warranty claim!
                    </p>
                </div>
            </div>
        </div>
    </x-modern-section>

    <!-- Customer Satisfaction Section -->
    <x-modern-section spacing="py-20 md:py-28">
        <div class="text-center max-w-4xl mx-auto" data-aos="fade-up">
            <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-brand-neutral-900 mb-8">
                You Will be Delighted!
            </h2>
            <p class="text-lg text-brand-neutral-700 leading-relaxed mb-12">
                Every week at Danielle Fence results from "Customer Satisfaction Surveys" are independently reviewed and tabulated. The result: 97% of the ACTUAL REAL customers who responded were VERY SATISFIED in the following areas: Sales Experience, Service Prior to Installation, Installation of Fence, Installers Were Courteous and Professional, Value, and Overall Service.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="text-center p-6 bg-brand-light-100 rounded-xl">
                    <div class="text-4xl font-bold text-brand-primary-900 mb-2">97%</div>
                    <div class="text-sm font-medium text-brand-neutral-700">Customer Satisfaction</div>
                </div>
                <div class="text-center p-6 bg-brand-light-100 rounded-xl">
                    <div class="text-4xl font-bold text-brand-primary-900 mb-2">5M+</div>
                    <div class="text-sm font-medium text-brand-neutral-700">Linear Feet Manufactured</div>
                </div>
                <div class="text-center p-6 bg-brand-light-100 rounded-xl">
                    <div class="text-4xl font-bold text-brand-primary-900 mb-2">47+</div>
                    <div class="text-sm font-medium text-brand-neutral-700">Years Experience</div>
                </div>
            </div>

            <p class="text-brand-neutral-700">
                Your feedback is always welcome. Help us to know about ways we can improve. We are not happy until you are 100% satisfied.
            </p>
        </div>
    </x-modern-section>

    <!-- Experience CTA -->
    <x-modern-cta
        title="Experience the Danielle Difference"
        description="Join thousands of satisfied customers who chose quality, experience, and American-made excellence for their outdoor living spaces."
        button-text="Get Your Free Quote"
        :button-url="route('request-a-quote')"
        secondary-text="Call (863) 425-3182"
        secondary-url="tel:863-425-3182"
        :pattern="true" />
</x-app-layout>
