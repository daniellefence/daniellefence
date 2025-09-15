<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-gray-50 to-brand-cream/20">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-danielle to-daniellealt py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl font-bold text-white mb-4">Current Specials</h1>
                    <p class="text-xl text-white mb-8">
                        Save on quality fencing materials and installation services. Don't miss these limited-time offers from Central Florida's premier fence company.
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                            <span class="text-white text-lg font-semibold">49 Years of Excellence Since 1976</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Our Specials Section -->
        <div class="bg-gradient-to-r from-white to-brand-cream/30 py-12">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="bg-danielle/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tags text-danielle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Real Savings</h3>
                        <p class="text-gray-600">Genuine discounts on premium materials and professional installation services.</p>
                    </div>
                    <div>
                        <div class="bg-danielle/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-danielle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Limited Time</h3>
                        <p class="text-gray-600">Take advantage of these exclusive offers while they last - savings you won't find elsewhere.</p>
                    </div>
                    <div>
                        <div class="bg-danielle/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-award text-danielle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Quality Guaranteed</h3>
                        <p class="text-gray-600">Same high-quality materials and workmanship, now at special prices.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Specials Section -->
        <div class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Current Promotions</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Explore our current special offers and promotional deals designed to help you save on your fencing project.
                    </p>
                </div>

                @if($specials->count() > 0)
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 max-w-7xl mx-auto">
                        @foreach($specials as $special)
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-danielle/30 transition-all duration-200 group">
                                <!-- Special Image -->
                                @if($special->getFirstMediaUrl('banner'))
                                    <div class="aspect-w-16 aspect-h-9">
                                        <img src="{{ $special->getFirstMediaUrl('banner') }}"
                                             alt="{{ $special->title }}"
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-200">
                                    </div>
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-danielle to-daniellealt flex items-center justify-center">
                                        <i class="fas fa-tag text-white text-4xl"></i>
                                    </div>
                                @endif

                                <!-- Special Info -->
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-danielle transition-colors">
                                            {{ $special->title }}
                                        </h3>
                                        @if($special->is_featured)
                                            <span class="inline-block bg-danielle/10 text-danielle px-2 py-1 rounded-full text-xs font-bold">
                                                FEATURED
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Discount Info -->
                                    <div class="mb-4">
                                        @if($special->discount_percentage)
                                            <div class="text-3xl font-bold text-danielle">
                                                {{ $special->discount_percentage }}% OFF
                                            </div>
                                        @elseif($special->discount_amount)
                                            <div class="text-3xl font-bold text-danielle">
                                                ${{ number_format($special->discount_amount, 0) }} OFF
                                            </div>
                                        @endif

                                        @if($special->min_purchase_amount)
                                            <div class="text-sm text-gray-600 mt-1">
                                                Minimum purchase: ${{ number_format($special->min_purchase_amount, 0) }}
                                            </div>
                                        @endif
                                    </div>

                                    @if($special->description)
                                        <div class="text-gray-600 text-sm mb-4 line-clamp-3">
                                            {!! Str::limit(strip_tags($special->description), 120) !!}
                                        </div>
                                    @endif

                                    <!-- Promo Code -->
                                    @if($special->promo_code)
                                        <div class="mb-4">
                                            <div class="bg-gray-100 rounded-lg p-3 border-2 border-dashed border-gray-300">
                                                <div class="text-xs text-gray-500 mb-1">Promo Code:</div>
                                                <div class="font-bold text-lg text-gray-900 tracking-wider">{{ $special->promo_code }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Timing Info -->
                                    <div class="text-xs text-gray-500 mb-4">
                                        @if($special->end_date)
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                Expires: {{ $special->end_date->format('M j, Y') }}
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <i class="fas fa-infinity mr-1"></i>
                                                No expiration date
                                            </div>
                                        @endif

                                        @if($special->usage_limit)
                                            <div class="flex items-center mt-1">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $special->usage_limit - $special->usage_count }} uses remaining
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('contact') }}?subject=Inquiry%20about%20{{ urlencode($special->title) }}"
                                           class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-danielle text-white font-bold text-sm rounded-lg hover:bg-daniellealt transition-colors">
                                            <i class="fas fa-envelope mr-2"></i>
                                            Get Quote
                                        </a>
                                        <a href="tel:8634253182"
                                           class="inline-flex items-center justify-center px-4 py-2 border border-danielle text-danielle font-bold text-sm rounded-lg hover:bg-danielle hover:text-white transition-colors">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($specials->hasPages())
                        <div class="mt-12 flex justify-center">
                            {{ $specials->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Current Specials -->
                    <div class="text-center py-16">
                        <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-tag text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No Current Specials</h3>
                        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                            We don't have any active promotions right now, but check back soon for exciting deals on quality fencing!
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center px-8 py-4 bg-danielle text-white font-bold text-lg rounded-lg hover:bg-daniellealt transition-colors">
                                <i class="fas fa-envelope mr-3"></i>
                                Get Quote
                            </a>
                            <a href="{{ route('diy.index') }}"
                               class="inline-flex items-center px-8 py-4 border border-danielle text-danielle font-bold text-lg rounded-lg hover:bg-danielle hover:text-white transition-colors">
                                <i class="fas fa-tools mr-3"></i>
                                View Products
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="bg-gradient-to-r from-danielle to-daniellealt">
            <div class="container mx-auto px-4 py-16 grass-offset text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Save on Your Fencing Project?</h2>
                <p class="text-xl text-white mb-8 max-w-3xl mx-auto">
                    Take advantage of these limited-time offers or contact us to discuss your specific fencing needs.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 bg-white text-danielle font-bold text-lg rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-calculator mr-3"></i>
                        Get Free Quote
                    </a>
                    <a href="tel:8634253182" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold text-lg rounded-lg hover:bg-white hover:text-danielle transition-colors">
                        <i class="fas fa-phone mr-3"></i>
                        (863) 425-3182
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>