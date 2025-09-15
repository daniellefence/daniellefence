<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-gray-50 to-brand-cream/20">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-danielle to-daniellealt py-20 ">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl font-bold text-white mb-4">Customer Reviews</h1>
                    <p class="text-xl text-white mb-8">
                        See what our customers say about our fence installation services. 49 years of satisfied customers in Central Florida.
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-2xl"></i>
                            @endfor
                        </div>
                        <span class="text-white text-lg font-semibold">4.9/5 Average Rating</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-gradient-to-r from-white to-brand-cream/30 py-12 ">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-danielle mb-2">2,500+</div>
                        <div class="text-gray-600">Happy Customers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-danielle mb-2">49</div>
                        <div class="text-gray-600">Years in Business</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-danielle mb-2">4.9</div>
                        <div class="text-gray-600">Average Rating</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-danielle mb-2">98%</div>
                        <div class="text-gray-600">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonial Tuesday Section -->
        <div class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <div class="inline-block bg-danielle text-white px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        #TestimonialTuesday
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Customer Stories</h2>
                    <p class="text-lg text-gray-600">Every Tuesday, we highlight amazing customer feedback</p>
                </div>

                <!-- Featured Review -->
                <div class="bg-white rounded-lg  p-8 mb-12 max-w-4xl mx-auto">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400 mr-4">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-xl"></i>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">Featured Review</span>
                    </div>
                    <blockquote class="text-xl text-gray-800 mb-6 italic leading-relaxed">
                        "From start to finish, Danielle Fence exceeded our expectations. The team was professional, 
                        punctual, and incredibly skilled. Our new vinyl fence looks absolutely stunning and has 
                        completely transformed our backyard. The quality of the American-made materials is evident, 
                        and the installation was flawless. We couldn't be happier with our choice!"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="bg-danielle rounded-full w-12 h-12 flex items-center justify-center mr-4">
                            <span class="text-white font-bold">SM</span>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Sarah & Mike Thompson</div>
                            <div class="text-gray-600">Lakeland, FL • Vinyl Privacy Fence</div>
                            <div class="text-sm text-gray-500">Installed March 2024</div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Masonry Grid -->
                @if(isset($reviews) && $reviews->count() > 0)
                    <div class="reviews-masonry mb-12">
                        @foreach($reviews as $review)
                            <div class="reviews-masonry-item bg-white rounded-lg shadow-sm p-6 mb-6 break-inside-avoid">
                                <div class="flex items-center mb-4">
                                    <div class="flex text-yellow-400 mr-2">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for($i = $review->rating; $i < 5; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('M j, Y') }}</span>
                                </div>
                                <p class="text-gray-600 mb-4 leading-relaxed">{{ $review->content }}</p>
                                <div class="border-t pt-4">
                                    <div class="font-semibold text-gray-900">{{ $review->customer_name }}</div>
                                    @if($review->location)
                                        <div class="text-sm text-gray-500">{{ $review->location }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <!-- Sample Reviews Masonry -->
                    <div class="reviews-masonry mb-12">
                        <div class="reviews-masonry-item bg-white rounded-lg shadow-sm p-6 mb-6 break-inside-avoid">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">Feb 15, 2024</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">"Exceptional service from start to finish. The team was professional, and our aluminum pool fence looks fantastic. Highly recommend!"</p>
                            <div class="border-t pt-4">
                                <div class="font-semibold text-gray-900">Jennifer Rodriguez</div>
                                <div class="text-sm text-gray-500">Winter Haven, FL</div>
                            </div>
                        </div>

                        <div class="reviews-masonry-item bg-white rounded-lg shadow-sm p-6 mb-6 break-inside-avoid">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">Feb 8, 2024</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">"Three generations of quality shows in every detail. Our wood fence installation was completed perfectly and on time. The attention to detail was impressive, and the team left our property cleaner than when they arrived. We've received countless compliments from neighbors about how professional the fence looks."</p>
                            <div class="border-t pt-4">
                                <div class="font-semibold text-gray-900">Robert Chen</div>
                                <div class="text-sm text-gray-500">Auburndale, FL</div>
                            </div>
                        </div>

                        <div class="reviews-masonry-item bg-white rounded-lg shadow-sm p-6 mb-6 break-inside-avoid">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">Jan 28, 2024</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">"Outstanding customer service and quality workmanship. The automatic gate works perfectly, and the installation was seamless."</p>
                            <div class="border-t pt-4">
                                <div class="font-semibold text-gray-900">Maria Gonzalez</div>
                                <div class="text-sm text-gray-500">Plant City, FL</div>
                            </div>
                        </div>

                        <div class="reviews-masonry-item bg-white rounded-lg shadow-sm p-6 mb-6 break-inside-avoid">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">Jan 15, 2024</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">"Impressed by the American-made quality of materials. The vinyl fence looks great and the team cleaned up perfectly after installation. From the initial consultation to the final walkthrough, everything exceeded our expectations. The pricing was fair and transparent with no hidden costs. We're already planning our next project with them!"</p>
                            <div class="border-t pt-4">
                                <div class="font-semibold text-gray-900">David Wilson</div>
                                <div class="text-sm text-gray-500">Bartow, FL</div>
                            </div>
                        </div>

                        <div class="reviews-masonry-item bg-white rounded-lg shadow-sm p-6 mb-6 break-inside-avoid">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">Dec 20, 2023</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">"49 years in business and it shows! Professional from quote to completion. Our commercial fence project was handled expertly."</p>
                            <div class="border-t pt-4">
                                <div class="font-semibold text-gray-900">Amanda Foster</div>
                                <div class="text-sm text-gray-500">Mulberry, FL</div>
                            </div>
                        </div>

                        <div class="reviews-masonry-item bg-white rounded-lg shadow-sm p-6 mb-6 break-inside-avoid">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">Dec 5, 2023</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">"Excellent experience throughout. Fair pricing, quality materials, and skilled installation. Would definitely recommend to others. The team was punctual, courteous, and worked efficiently to complete our privacy fence installation ahead of schedule."</p>
                            <div class="border-t pt-4">
                                <div class="font-semibold text-gray-900">Steven Martinez</div>
                                <div class="text-sm text-gray-500">Haines City, FL</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Leave a Review Section -->
        <div class="bg-white py-16">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Share Your Experience</h2>
                    <p class="text-lg text-gray-600 mb-12">
                        Had a great experience with Danielle Fence? We'd love to hear from you!
                    </p>

                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <!-- QR Code Section -->
                        <div class="text-center">
                            <div class="bg-gray-50 rounded-2xl p-8 inline-block">
                                <img src="{{ asset('images/google_review_qr_code.png') }}"
                                     alt="Scan to leave a Google review"
                                     class="w-40 h-40 mx-auto mb-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Quick Review</p>
                                <p class="text-xs text-gray-500">Scan with your phone camera</p>
                            </div>
                        </div>

                        <!-- Button Section -->
                        <div class="text-center">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Leave a Review</h3>
                            <div class="space-y-4">
                                <a href="https://g.page/r/CRf_8juw8RDYEAE/review" target="_blank" rel="noopener noreferrer"
                                   class="block w-full px-8 py-4 bg-[#4285F4] text-white font-semibold rounded-lg hover:bg-[#3367D6] transition-colors shadow-lg">
                                    <i class="fab fa-google mr-3 text-xl"></i>
                                    Review on Google
                                </a>
                                <a href="{{ route('contact') }}"
                                   class="block w-full px-8 py-4 border-2 border-danielle text-danielle font-semibold rounded-lg hover:bg-danielle hover:text-white transition-colors">
                                    <i class="fas fa-envelope mr-3"></i>
                                    Contact Us Instead
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-danielle py-16 grass-offset">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Join Our Satisfied Customers?</h2>
                <p class="text-xl text-white mb-8">Experience the quality and service that has earned us these amazing reviews</p>
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