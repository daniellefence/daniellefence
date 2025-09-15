<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-gray-50 to-brand-cream/20">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-danielle to-daniellealt py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl font-bold text-white mb-4">Residential Fencing</h1>
                    <p class="text-xl text-white mb-8">
                        Transform your property with quality fencing solutions from Central Florida's most trusted fence company since 1976.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('diy.quote') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-danielle bg-white hover:bg-gray-100">
                            Get Free Quote
                        </a>
                        <a href="tel:863-425-3182" class="inline-flex justify-center items-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-danielle">
                            <i class="fas fa-phone mr-2"></i> (863) 425-3182
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fence Types Section -->
        <div class="py-16 bg-gradient-to-br from-white to-brand-cream/30">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Residential Fence Types</h2>
                    <p class="text-lg text-gray-600">Choose from our wide selection of quality fencing materials</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Vinyl/PVC -->
                    <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg  overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-home text-6xl text-white"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3">Vinyl/PVC Fencing</h3>
                            <ul class="text-gray-600 space-y-2 mb-4">
                                <li>• Low maintenance</li>
                                <li>• Weather resistant</li>
                                <li>• Long-lasting durability</li>
                                <li>• Multiple styles available</li>
                            </ul>
                            <a href="{{ route('diy.index') }}#vinyl" class="text-danielle font-semibold hover:underline">
                                Learn More →
                            </a>
                        </div>
                    </div>

                    <!-- Aluminum -->
                    <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg  overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-6xl text-white"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3">Aluminum Fencing</h3>
                            <ul class="text-gray-600 space-y-2 mb-4">
                                <li>• Rust-resistant</li>
                                <li>• Elegant appearance</li>
                                <li>• Pool code compliant</li>
                                <li>• Minimal maintenance</li>
                            </ul>
                            <a href="{{ route('diy.index') }}#aluminum" class="text-danielle font-semibold hover:underline">
                                Learn More →
                            </a>
                        </div>
                    </div>

                    <!-- Wood -->
                    <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg  overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-amber-600 to-amber-700 flex items-center justify-center">
                            <i class="fas fa-tree text-6xl text-white"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3">Wood Fencing</h3>
                            <ul class="text-gray-600 space-y-2 mb-4">
                                <li>• Natural beauty</li>
                                <li>• Traditional appeal</li>
                                <li>• Customizable designs</li>
                                <li>• Privacy options</li>
                            </ul>
                            <a href="{{ route('diy.index') }}#wood" class="text-danielle font-semibold hover:underline">
                                Learn More →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="bg-gradient-to-tr from-white to-brand-cream py-16 ">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Choose Danielle Fence for Your Home?</h2>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-danielle rounded-full p-3">
                                    <i class="fas fa-award text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold mb-2">Nearly 50 Years Experience</h3>
                                <p class="text-gray-600">Family-owned and operated since 1976, serving Central Florida with pride.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-danielle rounded-full p-3">
                                    <i class="fas fa-flag-usa text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold mb-2">American-Made Materials</h3>
                                <p class="text-gray-600">We use only the highest quality American-manufactured products.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-danielle rounded-full p-3">
                                    <i class="fas fa-users text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold mb-2">Expert Installation</h3>
                                <p class="text-gray-600">Professional installation by experienced, trained technicians.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-danielle rounded-full p-3">
                                    <i class="fas fa-shield-alt text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold mb-2">Comprehensive Warranties</h3>
                                <p class="text-gray-600">Backed by manufacturer warranties and our installation guarantee.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Areas -->
        <div class="bg-gradient-to-r from-gray-100 to-brand-cream/20 py-16 ">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Serving Central Florida</h2>
                    <p class="text-lg text-gray-600">Professional residential fence installation throughout the region</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">Lakeland</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">Winter Haven</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">Auburndale</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">Plant City</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">Bartow</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">Mulberry</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">Haines City</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt text-danielle mb-2"></i>
                        <div class="font-semibold">And More!</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-br from-danielle to-brand-red py-16 ">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Enhance Your Property?</h2>
                <p class="text-xl text-white mb-8">Get a free quote for your residential fencing project today</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('diy.quote') }}" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-danielle bg-white hover:bg-gray-100">
                        Get Free Quote
                    </a>
                    <a href="tel:863-425-3182" class="inline-flex justify-center items-center px-8 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-danielle">
                        <i class="fas fa-phone mr-2"></i> Call (863) 425-3182
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>