<x-app-layout>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="menu-image relative bg-gray-900">
            <div class="absolute inset-0 bg-gradient-to-r from-danielle/90 to-daniellealt/80"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-6 py-24 text-center lg:py-32">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                    Professional DIY Fence Solutions
                </h1>
                <p class="mt-6 text-lg leading-8 text-white max-w-3xl mx-auto">
                    Save thousands on your fence project with our professional-grade materials and expert guidance. 
                    49 years of experience helping Central Florida homeowners build beautiful, lasting fences.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('diy.products') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-danielle shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                        Browse Products
                    </a>
                    <a href="{{ route('diy.quote') }}" class="text-sm font-semibold leading-6 text-white border border-white rounded-md px-3.5 py-2.5 hover:bg-white hover:text-danielle transition-colors">
                        Get Free Quote <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white py-24 sm:py-32">
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
        <div class="bg-danielle">
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

        <!-- Trust Section -->
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Trusted by Central Florida Homeowners
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        49 years of experience in the fencing industry. Over 10,000 satisfied customers.
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">49+</div>
                        <div class="mt-2 text-base text-gray-600">Years in Business</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">10,000+</div>
                        <div class="mt-2 text-base text-gray-600">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">100%</div>
                        <div class="mt-2 text-base text-gray-600">Satisfaction Guaranteed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-danielle">24/7</div>
                        <div class="mt-2 text-base text-gray-600">Expert Support</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>