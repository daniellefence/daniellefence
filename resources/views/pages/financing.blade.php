<x-app-layout>
    <!-- Hero Section -->
    <x-modern-hero
        title="Financing Options"
        subtitle="Flexible Payment Solutions"
        description="Make your outdoor living dreams a reality with flexible financing options and convenient payment methods."
        :background-image="Vite::asset('resources/images/fence2.jpg')"
        cta="Get Your Quote"
        :cta-url="route('request-a-quote')" />

    <!-- Payment Methods Section -->
    <x-modern-section spacing="py-20 md:py-28">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Payment Methods Accepted
            </h2>
            <p class="text-xl text-gray-700 max-w-3xl mx-auto">
                We make it easy to pay for your outdoor project with multiple convenient payment options.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
            <div class="text-center mb-8">
                <p class="text-lg text-gray-700 leading-relaxed">
                    Danielle Fence & Outdoor Living accepts all major credit cards, debit cards, checks, and cash for your convenience.
                </p>
            </div>
            <div class="flex items-center justify-center">
                <img src="{{Vite::asset('resources/images/cards.webp')}}" alt="Accepted payment cards" class="max-w-lg w-full h-auto"/>
            </div>
        </div>
    </x-modern-section>

    <!-- Financing Options Section -->
    <x-modern-section background="bg-outdoor-light" spacing="py-20 md:py-28">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Financing Solutions
            </h2>
            <p class="text-xl text-gray-700 max-w-4xl mx-auto leading-relaxed">
                Adding an outdoor project to your home is an investment, and we realize that you might need assistance to make your dream a reality.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        Partner with OneMain Financial
                    </h3>
                    <p class="text-lg text-gray-700 leading-relaxed mb-8">
                        We've partnered with OneMain Financial to provide you with flexible financing options. Simply mention that Danielle Fence & Outdoor Living sent you when you contact them for details about their financing solutions.
                    </p>

                    <!-- Contact Info -->
                    <div class="bg-outdoor-light rounded-xl p-6 border border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            Ready to Get Started?
                        </h4>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-outdoor-primary rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Call OneMain Financial</p>
                                    <a href="tel:863-291-0809" class="text-xl font-bold text-outdoor-primary hover:text-outdoor-primary/80 transition-colors">
                                        (863) 291-0809
                                    </a>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-gray-700">
                                    Need help? <a class="text-outdoor-primary font-semibold hover:text-outdoor-primary/80 transition-colors" href="{{route("contact")}}">Contact us</a> for assistance.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo -->
                <div class="flex items-center justify-center" data-aos="fade-left" data-aos-delay="400">
                    <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">
                        <img src="{{Vite::asset('resources/images/one-main-financial_355x115.webp')}}" alt="OneMain Financial" class="max-w-full h-auto"/>
                    </div>
                </div>
            </div>
        </div>
    </x-modern-section>

    <!-- CTA Section -->
    <x-modern-cta
        title="Start Your Project Today"
        description="Ready to transform your outdoor space? Get your free estimate and explore financing options that work for your budget."
        button-text="Get Free Estimate"
        :button-url="route('request-a-quote')"
        secondary-text="Call (863) 425-3182"
        secondary-url="tel:863-425-3182"
        :pattern="true" />
</x-app-layout>
