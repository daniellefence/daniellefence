<x-app-layout>
    @once
        @push('head')
            <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
            <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
                  rel="stylesheet">
            <script src="https://www.google.com/recaptcha/api.js?render={{setting()->get("google_recaptcha_site_key")}}"></script>
        @endpush
        @push('scripts')
            <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"
                    defer></script>
            <script src="https://unpkg.com/filepond/dist/filepond.js" defer></script>
        @endpush
    @endonce

    <!-- Hero Section -->
    <x-modern-hero
        title="Get Your Free Estimate"
        subtitle="Professional • Reliable • Affordable"
        description="Transform your outdoor space with Central Florida's premier fencing and outdoor living experts. Get a personalized quote in minutes."
        :background-image="asset('images/fence2.jpg')"
        cta="Start Your Quote"
        cta-anchor="#quote-form"
        />

    <!-- Quote Form Section -->
    <section id="quote-form" class="relative py-20 md:py-28 bg-gradient-to-br from-slate-50 via-white to-blue-50">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23e2e8f0" fill-opacity="0.3"%3E%3Ccircle cx="7" cy="7" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>

        <div class="relative">
            <livewire:request-a-quote wire:key="request-a-quote{{rand(0,10000)}}" lazy=/>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-white">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-outdoor-primary">Why Choose Danielle Fence</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Your Trusted Outdoor Living Partner
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    With decades of experience and thousands of satisfied customers, we deliver exceptional quality and service you can trust.
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <i class="fad fa-check-circle h-5 w-5 flex-none text-outdoor-primary"></i>
                            Licensed & Insured
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Fully licensed, bonded, and insured for your peace of mind and protection.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <i class="fad fa-star h-5 w-5 flex-none text-outdoor-primary"></i>
                            Premium Materials
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Only the finest materials from trusted manufacturers for lasting quality.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <i class="fad fa-thumbs-up h-5 w-5 flex-none text-outdoor-primary"></i>
                            Satisfaction Guarantee
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Your complete satisfaction is our commitment. We stand behind our work.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</x-app-layout>

