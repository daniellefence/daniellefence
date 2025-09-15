<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-gray-50 to-brand-cream/20">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-danielle to-daniellealt py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl font-bold text-white mb-4">Join Our Team</h1>
                    <p class="text-xl text-white mb-8">
                        Build your career with Central Florida's premier fence company. 49 years strong and growing - discover opportunities to grow with us.
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                            <span class="text-white text-lg font-semibold">Family-Owned & Operated Since 1976</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Work With Us Section -->
        <div class="bg-gradient-to-r from-white to-brand-cream/30 py-12">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="bg-danielle/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-danielle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Great Team</h3>
                        <p class="text-gray-600">Join a supportive family environment where your growth and success matter.</p>
                    </div>
                    <div>
                        <div class="bg-danielle/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-trophy text-danielle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Industry Leader</h3>
                        <p class="text-gray-600">Work with Central Florida's most trusted fence company with 49 years of excellence.</p>
                    </div>
                    <div>
                        <div class="bg-danielle/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-rocket text-danielle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Career Growth</h3>
                        <p class="text-gray-600">Opportunities for advancement and skill development in a growing company.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Openings Section -->
        <div class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Current Openings</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Explore our current job opportunities and take the next step in your career with Danielle Fence.
                    </p>
                </div>

                @if($careers->count() > 0)
                    <div class="grid gap-8 max-w-4xl mx-auto">
                        @foreach($careers as $career)
                            <div class="bg-white rounded-xl border border-gray-200 p-8 hover:border-danielle/30 transition-all duration-200">
                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $career->title }}</h3>
                                        @if($career->location)
                                            <div class="flex items-center text-gray-600 mb-4">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <span>{{ $career->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500 mb-2">Posted</div>
                                        <div class="text-sm font-medium text-gray-700">{{ $career->published_at?->format('M j, Y') }}</div>
                                    </div>
                                </div>

                                @if($career->description)
                                    <div class="prose prose-gray max-w-none mb-6">
                                        {!! $career->description !!}
                                    </div>
                                @endif

                                @if($career->requirements)
                                    <div class="mb-6">
                                        <h4 class="font-bold text-gray-900 mb-3">Requirements:</h4>
                                        <div class="prose prose-gray max-w-none">
                                            {!! $career->requirements !!}
                                        </div>
                                    </div>
                                @endif

                                @if($career->tags->count() > 0)
                                    <div class="flex flex-wrap gap-2 mb-6">
                                        @foreach($career->tags as $tag)
                                            <span class="inline-block bg-danielle/10 text-danielle px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                    <div class="text-sm text-gray-500">
                                        Ready to apply? Contact us today!
                                    </div>
                                    <a href="{{ route('contact') }}?subject=Application%20for%20{{ urlencode($career->title) }}"
                                       class="inline-flex items-center px-6 py-3 bg-danielle text-white font-bold text-sm rounded-lg hover:bg-daniellealt focus:outline-none focus:ring-4 focus:ring-danielle/30 transition-all duration-200">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($careers->hasPages())
                        <div class="mt-12 flex justify-center">
                            {{ $careers->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Current Openings -->
                    <div class="text-center py-16">
                        <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No Current Openings</h3>
                        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                            We don't have any open positions right now, but we're always looking for talented individuals to join our team.
                        </p>
                        <a href="{{ route('contact') }}?subject=General%20Inquiry%20About%20Employment"
                           class="inline-flex items-center px-8 py-4 bg-danielle text-white font-bold text-lg rounded-lg hover:bg-daniellealt focus:outline-none focus:ring-4 focus:ring-danielle/30 transition-all duration-200">
                            <i class="fas fa-envelope mr-3"></i>
                            Submit Your Resume
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="bg-gradient-to-r from-danielle to-daniellealt py-16">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Build Your Future?</h2>
                <p class="text-xl text-white mb-8 max-w-3xl mx-auto">
                    Whether you're experienced in fencing or looking to start a new career, we'd love to hear from you.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}?subject=Career%20Inquiry"
                       class="inline-flex items-center px-8 py-4 bg-white text-danielle font-bold text-lg rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all duration-200">
                        <i class="fas fa-phone mr-3"></i>
                        Contact Us
                    </a>
                    <a href="tel:8634253182"
                       class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold text-lg rounded-lg hover:bg-white hover:text-danielle focus:outline-none focus:ring-4 focus:ring-white/30 transition-all duration-200">
                        <i class="fas fa-phone mr-3"></i>
                        (863) 425-3182
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>