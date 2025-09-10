<x-app-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/company-history-hero.jpg') }}');">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative z-10 py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                            Our Story Since 1976
                        </h1>
                        <p class="mt-6 text-xl leading-8 text-white">
                            Nearly five decades of family ownership, quality craftsmanship, and Central Florida pride.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Legacy Section -->
        <div class="py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h2 class="text-base font-semibold leading-7 text-[#8e2a2a]">The Danielle Legacy</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Three Generations of Excellence
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        What started as a small family business in 1976 has grown into Central Florida's most trusted fencing company. Through nearly five decades, we've maintained our commitment to quality, family values, and customer satisfaction.
                    </p>
                </div>
                
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col">
                        <div class="text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#8e2a2a]">
                                <i class="fas fa-handshake text-2xl text-white"></i>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">Family Founded</h3>
                            <p class="mt-4 text-gray-600">
                                Founded by the Danielle family with a vision to provide honest, quality fencing services to Central Florida communities.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#68bf21]">
                                <i class="fas fa-tools text-2xl text-white"></i>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">Craft Perfected</h3>
                            <p class="mt-4 text-gray-600">
                                Decades of experience perfecting our installation techniques and building relationships with premium material suppliers.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#8e2a2a]">
                                <i class="fas fa-users text-2xl text-white"></i>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">Legacy Continues</h3>
                            <p class="mt-4 text-gray-600">
                                Now in our third generation of family ownership, carrying forward the values and quality that built our reputation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="bg-gray-50 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Our Journey Through the Decades
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Key milestones in our nearly 50-year history of serving Central Florida.
                    </p>
                </div>
                
                <div class="mx-auto mt-16 max-w-4xl">
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute left-1/2 transform -translate-x-px h-full w-0.5 bg-[#8e2a2a]"></div>
                        
                        <!-- Timeline Items -->
                        <div class="space-y-12">
                            <!-- 1976 -->
                            <div class="relative flex items-center">
                                <div class="flex-shrink-0 w-1/2 pr-8 text-right">
                                    <div class="bg-white rounded-lg p-6 shadow-sm border-l-4 border-[#8e2a2a]">
                                        <div class="text-[#8e2a2a] font-bold text-lg">1976</div>
                                        <h3 class="font-semibold text-gray-900 mt-2">Company Founded</h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            Danielle Fence established in Central Florida with a commitment to quality craftsmanship and customer service.
                                        </p>
                                    </div>
                                </div>
                                <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#8e2a2a] rounded-full border-4 border-white shadow"></div>
                                <div class="w-1/2 pl-8"></div>
                            </div>
                            
                            <!-- 1980s -->
                            <div class="relative flex items-center">
                                <div class="w-1/2 pr-8"></div>
                                <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#68bf21] rounded-full border-4 border-white shadow"></div>
                                <div class="flex-shrink-0 w-1/2 pl-8">
                                    <div class="bg-white rounded-lg p-6 shadow-sm border-r-4 border-[#68bf21]">
                                        <div class="text-[#68bf21] font-bold text-lg">1980s</div>
                                        <h3 class="font-semibold text-gray-900 mt-2">Major Contracts</h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            Secured major contracts with Disney World and SeaWorld, establishing our reputation for handling complex, high-profile projects.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 1990s -->
                            <div class="relative flex items-center">
                                <div class="flex-shrink-0 w-1/2 pr-8 text-right">
                                    <div class="bg-white rounded-lg p-6 shadow-sm border-l-4 border-[#8e2a2a]">
                                        <div class="text-[#8e2a2a] font-bold text-lg">1990s</div>
                                        <h3 class="font-semibold text-gray-900 mt-2">Entertainment Industry</h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            Expanded into entertainment industry projects, providing fencing for movie sets and television productions.
                                        </p>
                                    </div>
                                </div>
                                <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#8e2a2a] rounded-full border-4 border-white shadow"></div>
                                <div class="w-1/2 pl-8"></div>
                            </div>
                            
                            <!-- 2000s -->
                            <div class="relative flex items-center">
                                <div class="w-1/2 pr-8"></div>
                                <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#68bf21] rounded-full border-4 border-white shadow"></div>
                                <div class="flex-shrink-0 w-1/2 pl-8">
                                    <div class="bg-white rounded-lg p-6 shadow-sm border-r-4 border-[#68bf21]">
                                        <div class="text-[#68bf21] font-bold text-lg">2000s</div>
                                        <h3 class="font-semibold text-gray-900 mt-2">Second Generation</h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            Second generation of family leadership takes over, modernizing operations while maintaining core values.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 2010s -->
                            <div class="relative flex items-center">
                                <div class="flex-shrink-0 w-1/2 pr-8 text-right">
                                    <div class="bg-white rounded-lg p-6 shadow-sm border-l-4 border-[#8e2a2a]">
                                        <div class="text-[#8e2a2a] font-bold text-lg">2010s</div>
                                        <h3 class="font-semibold text-gray-900 mt-2">DIY Innovation</h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            Launched DIY program, making professional-grade materials available to homeowners with expert support.
                                        </p>
                                    </div>
                                </div>
                                <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#8e2a2a] rounded-full border-4 border-white shadow"></div>
                                <div class="w-1/2 pl-8"></div>
                            </div>
                            
                            <!-- 2020s -->
                            <div class="relative flex items-center">
                                <div class="w-1/2 pr-8"></div>
                                <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#68bf21] rounded-full border-4 border-white shadow"></div>
                                <div class="flex-shrink-0 w-1/2 pl-8">
                                    <div class="bg-white rounded-lg p-6 shadow-sm border-r-4 border-[#68bf21]">
                                        <div class="text-[#68bf21] font-bold text-lg">2020s</div>
                                        <h3 class="font-semibold text-gray-900 mt-2">Third Generation</h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            Third generation joins the business, bringing fresh ideas while honoring our founding principles of quality and service.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Our Core Values
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        The principles that have guided us for nearly five decades.
                    </p>
                </div>
                
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#8e2a2a]">
                                <i class="fas fa-heart text-white"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Family First</h3>
                        </div>
                        <p class="text-gray-600">
                            As a family-owned business, we treat every customer like family. This personal touch has been our foundation since day one.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#68bf21]">
                                <i class="fas fa-medal text-white"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Quality Craftsmanship</h3>
                        </div>
                        <p class="text-gray-600">
                            Every fence we install represents our family name and reputation. We use only American-made materials and employ skilled craftsmen.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#8e2a2a]">
                                <i class="fas fa-flag-usa text-white"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">American Made</h3>
                        </div>
                        <p class="text-gray-600">
                            We proudly source our materials from American manufacturers, supporting domestic industry and ensuring consistent quality.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#68bf21]">
                                <i class="fas fa-handshake text-white"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Community Commitment</h3>
                        </div>
                        <p class="text-gray-600">
                            Central Florida is our home. We're committed to contributing to our communities and supporting local families and businesses.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-[#8e2a2a]">
            <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Ready to Experience the Danielle Difference?
                    </h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-white">
                        Join thousands of satisfied customers who have trusted us with their fencing needs for nearly five decades.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('diy.quote') }}" class="rounded-md bg-white px-6 py-3 text-lg font-semibold text-[#8e2a2a] shadow-sm hover:bg-gray-100">
                            Get Free Quote
                        </a>
                        <a href="tel:863-425-3182" class="text-lg font-semibold leading-6 text-white hover:text-gray-200">
                            Call (863) 425-3182 <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>