<footer>
    <!-- Grass decoration at top -->
    <div class="h-48 grass-decoration -mt-36 relative z-10"></div>

    <!-- Footer Content -->
    <div class="bg-gradient-to-br from-brand-green via-brand-green to-brand-green/90 pb-8 footer-content relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 left-10 w-32 h-32 bg-white rounded-full"></div>
            <div class="absolute top-40 right-20 w-16 h-16 bg-white rounded-full"></div>
            <div class="absolute bottom-20 left-1/3 w-24 h-24 bg-white rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-8 h-8 bg-white rounded-full"></div>
        </div>

        <div class="mx-auto max-w-7xl px-6 lg:px-8 relative z-10">
            <!-- Main Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-12 pt-8">

                <!-- Services Column -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 tracking-tight flex items-center">
                        <i class="fas fa-tools mr-3 text-yellow-200"></i>
                        Our Services
                    </h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('services.residential') }}" class="text-white hover:text-yellow-100 transition-all duration-200 text-sm font-medium leading-relaxed flex items-center group hover:translate-x-1">
                            <i class="fas fa-chevron-right text-xs text-yellow-200 mr-2 group-hover:animate-pulse"></i>
                            Residential Fencing
                        </a></li>
                        <li><a href="{{ route('commercial') }}" class="text-white hover:text-yellow-100 transition-all duration-200 text-sm font-medium leading-relaxed flex items-center group hover:translate-x-1">
                            <i class="fas fa-chevron-right text-xs text-yellow-200 mr-2 group-hover:animate-pulse"></i>
                            Commercial Fencing
                        </a></li>
                        <li><a href="{{ route('services.pool') }}" class="text-white hover:text-yellow-100 transition-all duration-200 text-sm font-medium leading-relaxed flex items-center group hover:translate-x-1">
                            <i class="fas fa-chevron-right text-xs text-yellow-200 mr-2 group-hover:animate-pulse"></i>
                            Pool Fencing
                        </a></li>
                        <li><a href="{{ route('services.gates') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Gates & Access Control</a></li>
                        <li><a href="{{ route('services.repair') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Fence Repair</a></li>
                        <li><a href="{{ route('diy.index') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">DIY Materials</a></li>
                    </ul>
                </div>

                <!-- Company Column -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 tracking-tight flex items-center">
                        <i class="fas fa-info-circle mr-3 text-yellow-200"></i>
                        About Us
                    </h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about.story') }}" class="text-white hover:text-yellow-100 transition-all duration-200 text-sm font-medium leading-relaxed flex items-center group hover:translate-x-1">
                            <i class="fas fa-chevron-right text-xs text-yellow-200 mr-2 group-hover:animate-pulse"></i>
                            Our Story
                        </a></li>
                        <li><a href="{{ route('about.why') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Why Choose Us</a></li>
                        <li><a href="{{ route('about.history') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Company History</a></li>
                        <li><a href="{{ route('reviews') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Customer Reviews</a></li>
                        <li><a href="{{ route('showroom') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Visit Our Showroom</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Blog & Tips</a></li>
                        <li><a href="{{ route('careers') }}" class="text-white hover:text-yellow-100 transition-all duration-200 text-sm font-medium leading-relaxed flex items-center group hover:translate-x-1">
                            <i class="fas fa-chevron-right text-xs text-yellow-200 mr-2 group-hover:animate-pulse"></i>
                            Careers
                        </a></li>
                    </ul>
                </div>

                <!-- Service Areas & Legal Column -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 tracking-tight flex items-center">
                        <i class="fas fa-map-marker-alt mr-3 text-yellow-200"></i>
                        Service Areas
                    </h3>
                    <ul class="space-y-3 mb-8">
                        <li><a href="{{ route('about.areas') }}" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium leading-relaxed">Central Florida</a></li>
                        <li><span class="text-white text-sm font-medium leading-relaxed">Lakeland</span></li>
                        <li><span class="text-white text-sm font-medium leading-relaxed">Winter Haven</span></li>
                        <li><span class="text-white text-sm font-medium leading-relaxed">Polk County</span></li>
                        <li><span class="text-white text-sm font-medium leading-relaxed">Tampa Bay Area</span></li>
                    </ul>

                    <h4 class="text-base font-bold text-white mb-4 tracking-tight">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('privacy') }}" class="text-white hover:text-yellow-100 transition-colors text-xs font-medium">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="text-white hover:text-yellow-100 transition-colors text-xs font-medium">Terms of Service</a></li>
                        <li><a href="{{ route('product-warranties') }}" class="text-white hover:text-yellow-100 transition-colors text-xs font-medium">Warranties</a></li>
                    </ul>
                </div>

                <!-- Contact & Grillbert Column -->
                <div>
                    <a href="/chat" class="block group">
                        <h3 class="text-lg font-bold text-white mb-6 tracking-tight hover:text-yellow-100 transition-colors cursor-pointer">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-comments mr-3 text-yellow-200 group-hover:animate-bounce"></i>
                                Questions?
                            </div>
                            <div class="text-sm font-normal pl-8">
                                Chat with Grillbert!
                            </div>
                        </h3>
                    </a>

                    <!-- Grillbert Video -->
                    <div class="mb-6">
                        <a href="/chat" class="block">
                            <div class="max-w-40 mx-auto rounded-xl overflow-hidden hover:scale-105 transition-transform cursor-pointer">
                                <video autoplay loop muted playsinline class="w-full h-auto alpha-video">
                                    <source src="{{ asset('videos/grillbert.webm') }}" type="video/webm">
                                    <source src="{{ asset('videos/grillbert.mov') }}" type="video/quicktime">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- BBB & Trust Signals Column -->
                <div class="flex flex-col items-center lg:items-end">
                    <!-- BBB Seal -->
                    <div class="mb-6">
                        <a href="https://www.bbb.org/us/fl/mulberry/profile/fence-contractor/danielle-fence-outdoor-living-llc-0733-90049729"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-block hover:scale-105 transition-transform duration-200 group">
                            <img src="{{ asset('images/bbb-seal.png') }}"
                                 alt="Danielle Fence & Outdoor Living LLC BBB Business Review"
                                 class="h-28 w-auto shadow-lg rounded-lg group-hover:shadow-xl transition-shadow">
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="text-center lg:text-right space-y-2">
                        <div class="flex items-center justify-center lg:justify-end text-white text-xs">
                            <i class="fas fa-shield-alt text-yellow-200 mr-2"></i>
                            Licensed & Insured
                        </div>
                        <div class="flex items-center justify-center lg:justify-end text-white text-xs">
                            <i class="fas fa-award text-yellow-200 mr-2"></i>
                            49 Years Experience
                        </div>
                        <div class="flex items-center justify-center lg:justify-end text-white text-xs">
                            <i class="fas fa-users text-yellow-200 mr-2"></i>
                            Family Owned
                        </div>
                    </div>
                </div>

            </div>

            <!-- Contact Information Bar -->
            <div class="mt-12 mb-8 bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <h4 class="font-bold text-white mb-3 text-sm uppercase tracking-wider flex items-center justify-center">
                            <i class="fas fa-phone mr-2 text-yellow-200"></i>
                            Call Us Today
                        </h4>
                        <div class="space-y-1">
                            <p><a href="tel:8634253182" class="text-yellow-200 hover:text-yellow-100 font-bold text-lg transition-colors">(863) 425-3182</a></p>
                            <p><a href="tel:8136816181" class="text-yellow-200 hover:text-yellow-100 font-bold text-lg transition-colors">(813) 681-6181</a></p>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-white mb-3 text-sm uppercase tracking-wider flex items-center justify-center">
                            <i class="fas fa-envelope mr-2 text-yellow-200"></i>
                            Email Us
                        </h4>
                        <p><a href="mailto:sales@daniellefence.net" class="text-white hover:text-yellow-100 transition-colors text-sm font-medium">sales@daniellefence.net</a></p>
                    </div>

                    <div>
                        <h4 class="font-bold text-white mb-3 text-sm uppercase tracking-wider flex items-center justify-center">
                            <i class="fas fa-clock mr-2 text-yellow-200"></i>
                            Business Hours
                        </h4>
                        <div class="text-sm text-white space-y-1">
                            <p><span class="font-medium">Mon-Fri:</span> 8:00 AM - 5:00 PM</p>
                            <p><span class="font-medium">Sat:</span> 9:00 AM - 3:00 PM</p>
                            <p><span class="font-medium">Sun:</span> Closed</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-danielle text-white font-bold text-sm rounded-lg hover:bg-daniellealt focus:outline-none focus:ring-4 focus:ring-danielle/30 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg">
                            <i class="fas fa-quote-right mr-2"></i>
                            Get Free Quote
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright Bar -->
            <div class="pt-6 border-t border-white/20 text-center">
                <p class="text-sm text-white/80 mb-2">
                    &copy; {{ date('Y') }} Danielle Fence & Outdoor Living. All rights reserved.
                </p>
                <p class="text-xs text-white/70">
                    Proudly serving Central Florida since 1976 •
                    <span class="inline-flex items-center"><i class="fas fa-home mr-1"></i>Residential</span> •
                    <span class="inline-flex items-center"><i class="fas fa-building mr-1"></i>Commercial</span> •
                    <span class="inline-flex items-center"><i class="fas fa-tools mr-1"></i>DIY</span>
                </p>
            </div>
        </div>
    </div>
</footer>