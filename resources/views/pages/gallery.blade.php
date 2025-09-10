<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-[#8e2a2a] to-[#7a2525] py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl font-bold text-white mb-4">Our Work Showcase</h1>
                    <p class="text-xl text-white mb-8">
                        See the quality and craftsmanship that has made us Central Florida's trusted fence company since 1976.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('diy.quote') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-[#8e2a2a] bg-white hover:bg-gray-100">
                            Get Free Quote
                        </a>
                        <a href="tel:863-425-3182" class="inline-flex justify-center items-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-[#8e2a2a]">
                            <i class="fas fa-phone mr-2"></i> (863) 425-3182
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Categories -->
        <div class="py-8 bg-white shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center gap-4">
                    <button class="px-6 py-2 bg-[#8e2a2a] text-white rounded-full font-semibold">All Projects</button>
                    <button class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full font-semibold transition-colors">Residential</button>
                    <button class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full font-semibold transition-colors">Commercial</button>
                    <button class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full font-semibold transition-colors">Vinyl/PVC</button>
                    <button class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full font-semibold transition-colors">Aluminum</button>
                    <button class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full font-semibold transition-colors">Wood</button>
                    <button class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-full font-semibold transition-colors">Gates</button>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="py-16">
            <div class="container mx-auto px-4">
                <!-- Featured Projects Section -->
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Featured Marquee Projects</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Disney World -->
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden group cursor-pointer">
                            <div class="aspect-square bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-castle text-6xl text-white group-hover:scale-110 transition-transform"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-1">Disney World</h3>
                                <p class="text-sm text-gray-600">Magic Kingdom installations</p>
                            </div>
                        </div>

                        <!-- SeaWorld -->
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden group cursor-pointer">
                            <div class="aspect-square bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center">
                                <i class="fas fa-fish text-6xl text-white group-hover:scale-110 transition-transform"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-1">SeaWorld</h3>
                                <p class="text-sm text-gray-600">Marine park safety barriers</p>
                            </div>
                        </div>

                        <!-- Movie Sets -->
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden group cursor-pointer">
                            <div class="aspect-square bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center">
                                <i class="fas fa-film text-6xl text-white group-hover:scale-110 transition-transform"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-1">Movie Sets</h3>
                                <p class="text-sm text-gray-600">Hollywood productions</p>
                            </div>
                        </div>

                        <!-- Complex Projects -->
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden group cursor-pointer">
                            <div class="aspect-square bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                                <i class="fas fa-puzzle-piece text-6xl text-white group-hover:scale-110 transition-transform"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-1">Complex Projects</h3>
                                <p class="text-sm text-gray-600">Specialized installations</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Gallery -->
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Recent Installations</h2>
                    
                    <!-- Placeholder for actual project images -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @for($i = 1; $i <= 12; $i++)
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden group cursor-pointer">
                                <div class="aspect-video bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-gray-500 text-sm">Project Image {{ $i }}</p>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 mb-2">
                                        @switch($i % 6)
                                            @case(1) Vinyl Privacy Fence @break
                                            @case(2) Aluminum Pool Fence @break  
                                            @case(3) Wood Picket Fence @break
                                            @case(4) Commercial Security Fence @break
                                            @case(5) Custom Gate Installation @break
                                            @case(0) Decorative Aluminum Fence @break
                                        @endswitch
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        @switch($i % 4)
                                            @case(1) Lakeland, FL @break
                                            @case(2) Winter Haven, FL @break
                                            @case(3) Auburndale, FL @break
                                            @case(0) Plant City, FL @break
                                        @endswitch
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs bg-[#8e2a2a] text-white px-2 py-1 rounded">
                                            @switch($i % 3)
                                                @case(1) Residential @break
                                                @case(2) Commercial @break
                                                @case(0) Pool Fence @break
                                            @endswitch
                                        </span>
                                        <span class="text-xs text-gray-500">{{ now()->subDays($i * 7)->format('M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Load More Button -->
                <div class="text-center">
                    <button class="bg-[#8e2a2a] hover:bg-[#9c3030] text-white font-semibold py-3 px-8 rounded-md transition-colors">
                        Load More Projects
                    </button>
                </div>
            </div>
        </div>

        <!-- Install of the Week -->
        <div class="bg-white py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <div class="inline-block bg-[#8e2a2a] text-white px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        #InstallOfTheWeek
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured This Week</h2>
                    <p class="text-lg text-gray-600">Showcasing our latest exceptional installation</p>
                </div>
                
                <div class="max-w-4xl mx-auto">
                    <div class="bg-gray-50 rounded-lg shadow-lg overflow-hidden">
                        <div class="aspect-video bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-home text-6xl mb-4"></i>
                                <p class="text-xl font-semibold">This Week's Featured Install</p>
                                <p class="text-sm opacity-90">Premium Vinyl Privacy Fence - Lakeland, FL</p>
                            </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Premium Vinyl Privacy Fence Installation</h3>
                            <p class="text-gray-600 mb-6">
                                This beautiful privacy fence installation showcases our premium white vinyl fencing with decorative caps. 
                                The homeowner wanted maximum privacy while maintaining an elegant appearance that complements their 
                                landscaping. Our team completed the 200-foot installation in just two days, including a matching gate 
                                with premium hardware.
                            </p>
                            <div class="flex flex-wrap gap-4 text-sm">
                                <span class="bg-[#8e2a2a] text-white px-3 py-1 rounded">6ft Height</span>
                                <span class="bg-[#8e2a2a] text-white px-3 py-1 rounded">200 Linear Feet</span>
                                <span class="bg-[#8e2a2a] text-white px-3 py-1 rounded">Matching Gate</span>
                                <span class="bg-[#8e2a2a] text-white px-3 py-1 rounded">2-Day Install</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-[#8e2a2a] py-16">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Your Project?</h2>
                <p class="text-xl text-white mb-8">Let us create something beautiful for your property</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('diy.quote') }}" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-[#8e2a2a] bg-white hover:bg-gray-100">
                        Get Free Quote
                    </a>
                    <a href="{{ route('showroom') }}" class="inline-flex justify-center items-center px-8 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-[#8e2a2a]">
                        Visit Our Showroom
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>