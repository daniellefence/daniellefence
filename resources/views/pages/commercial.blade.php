<x-app-layout>
<div class="min-h-screen bg-gradient-to-r from-white to-brand-cream/20">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-danielle to-daniellealt text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">Commercial Fencing Solutions</h1>
                <p class="mt-6 max-w-3xl text-xl text-white">Professional fencing solutions for businesses throughout Central Florida. 49 years of experience serving commercial clients.</p>
                <div class="mt-8 bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 inline-block">
                    <span class="text-white text-lg font-semibold">Trusted by Industry Leaders Since 1976</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg border border-gray-200 p-6 ">
                <h3 class="text-lg font-semibold text-gray-900">Security Fencing</h3>
                <p class="mt-2 text-gray-600">High-security perimeter fencing for industrial facilities, warehouses, and commercial properties.</p>
            </div>
            <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg border border-gray-200 p-6 ">
                <h3 class="text-lg font-semibold text-gray-900">Decorative Fencing</h3>
                <p class="mt-2 text-gray-600">Enhance your business's curb appeal with ornamental aluminum or vinyl fencing.</p>
            </div>
            <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg border border-gray-200 p-6 ">
                <h3 class="text-lg font-semibold text-gray-900">Access Control</h3>
                <p class="mt-2 text-gray-600">Automated gates, keypads, and card readers for controlled access to your property.</p>
            </div>
            <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg border border-gray-200 p-6 ">
                <h3 class="text-lg font-semibold text-gray-900">Construction Sites</h3>
                <p class="mt-2 text-gray-600">Temporary and permanent fencing solutions for construction sites and development projects.</p>
            </div>
            <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg border border-gray-200 p-6 ">
                <h3 class="text-lg font-semibold text-gray-900">Sports Facilities</h3>
                <p class="mt-2 text-gray-600">Chain link fencing for tennis courts, baseball fields, and recreational facilities.</p>
            </div>
            <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg border border-gray-200 p-6 ">
                <h3 class="text-lg font-semibold text-gray-900">Dumpster Enclosures</h3>
                <p class="mt-2 text-gray-600">Custom enclosures to screen dumpsters and maintain property aesthetics.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-gray-50 to-brand-cream/20 ">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">Ready to Get Started?</h2>
                <p class="mt-4 text-lg text-gray-600">Contact us today for a free commercial fencing consultation.</p>
                <div class="mt-8">
                    <a href="{{ route('quote.request') }}" class="inline-flex items-center rounded-md bg-blue-600 px-6 py-3 text-base font-medium text-white hover:bg-blue-700">
                        Request a Quote
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
