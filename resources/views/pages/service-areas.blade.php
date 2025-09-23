<x-app-layout>
    <x-page-heading subheading="Danielle Fence proudly serves over 130 cities across Central Florida. Find your city below for local fence installation services.">
        Central Florida Service Areas
    </x-page-heading>

    <!-- Counties Section -->
    <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Counties We Serve
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Click on any city to learn about our fencing services in your area.
                </p>
            </div>

            @if($areas->isNotEmpty())
                <div class="grid gap-8">
                    @foreach($areas as $county => $cities)
                        <div class="bg-white rounded-lg shadow-lg p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $county }} County</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($cities as $city)
                                    <a href="{{ route('city.landing', $city->slug) }}"
                                       class="block p-3 rounded-lg border border-gray-200 hover:border-brand-primary-300 hover:bg-brand-primary-50 transition-colors">
                                        <span class="text-gray-900 hover:text-brand-primary-600 font-medium">
                                            {{ $city->title }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No service areas found.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-brand-primary-600">
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Don't see your city listed?
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">
                    We may still serve your area! Contact us for a free consultation and estimate.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('contact') }}" class="rounded-md bg-yellow-500 px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-yellow-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500">
                        Contact Us
                    </a>
                    <a href="tel:{{ config('app.phone', '863-665-1447') }}" class="text-sm font-semibold leading-6 text-white">
                        Call (863) 665-1447 <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>