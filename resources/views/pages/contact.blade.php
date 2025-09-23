@once
    @push('head')
        <script src="https://www.google.com/recaptcha/api.js?render={{setting()->get("google_recaptcha_site_key")}}"></script>
    @endpush
@endonce
<x-app-layout>
    <x-page-heading subheading="Ready to transform your outdoor space? Our expert team is here to help with personalized consultations and detailed project quotes.">
        Contact Danielle Fence
    </x-page-heading>

    <!-- Quick Contact Section -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Phone -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-outdoor-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-phone-volume w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Call Now</h3>
                    <a href="tel:863-425-3182" class="text-2xl font-bold text-outdoor-primary hover:text-outdoor-primary/80 transition-colors">
                        (863) 425-3182
                    </a>
                    <p class="text-sm text-gray-600 mt-1">Speak with an expert today</p>
                </div>

                <!-- Quote -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-outdoor-cedar rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-file-invoice w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Free Quote</h3>
                    <a href="{{route('request-a-quote')}}" class="text-lg font-semibold text-outdoor-cedar hover:text-outdoor-cedar/80 transition-colors">
                        Get Your Estimate
                    </a>
                    <p class="text-sm text-gray-600 mt-1">Fast, detailed proposals</p>
                </div>

                <!-- Visit -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-outdoor-gold rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-location-dot w-8 h-8"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Visit Us</h3>
                    <p class="text-lg font-semibold text-outdoor-gold">Design Center</p>
                    <p class="text-sm text-gray-600 mt-1">20,000+ sq ft showroom</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Contact Form Section -->
    <x-modern-section spacing="py-20 md:py-28">
        <div class="grid grid-cols-1 xl:grid-cols-5 gap-16">
            <!-- Contact Form -->
            <div class="xl:col-span-3" data-aos="fade-right">
                <div class="mb-8">
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Send Us a Message
                    </h2>
                    <p class="text-lg text-gray-700">
                        Fill out the form below and we'll get back to you within 24 hours.
                    </p>
                </div>
                <livewire:contact/>
            </div>

            <!-- Contact Information -->
            <div class="xl:col-span-2" data-aos="fade-left" data-aos-delay="200">
                <div class="bg-outdoor-light rounded-2xl p-8 h-fit">
                    <h3 class="font-display text-2xl font-bold text-gray-900 mb-6">
                        Get in Touch
                    </h3>

                    <div class="space-y-6">
                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-outdoor-primary rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fa-solid fa-phone-volume w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Phone</h4>
                                <a href="tel:863-425-3182" class="text-outdoor-primary font-semibold hover:text-outdoor-primary/80 transition-colors">
                                    (863) 425-3182
                                </a>
                                <p class="text-sm text-gray-600">Monday - Friday: 8AM - 5PM<br>Saturday: 9AM - 3PM</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-outdoor-cedar rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fa-solid fa-envelope w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                                <a href="mailto:info@daniellefence.com" class="text-outdoor-cedar font-semibold hover:text-outdoor-cedar/80 transition-colors">
                                    info@daniellefence.com
                                </a>
                                <p class="text-sm text-gray-600">We'll respond within 24 hours</p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-outdoor-gold rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fa-solid fa-location-dot w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Visit Our Showroom</h4>
                                <p class="text-gray-700">
                                    4855 State Road 60 West<br>
                                    Mulberry, FL 33860
                                </p>
                                <p class="text-sm text-gray-600 mt-1">20,000+ sq ft design center</p>
                            </div>
                        </div>

                        <!-- Service Areas -->
                        <div class="pt-6 border-t border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-2">Service Areas</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Serving all of Central Florida including Lakeland, Tampa, Winter Haven, Bartow, Plant City, Auburndale, Haines City, and surrounding communities.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-modern-section>

    <!-- Map Section -->
    <section class="bg-outdoor-light py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Find Our Design Center
                </h2>
                <p class="text-lg text-gray-700">
                    Located on State Road 60 West in Mulberry - easy access from anywhere in Central Florida
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <livewire:map/>
            </div>
        </div>
    </section>
</x-app-layout>
