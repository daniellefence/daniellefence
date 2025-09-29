<div class=" ">
    @if($show_map)
    <div>
        <livewire:map  :show_text="$show_text" lazy/>
    </div>
    @endif
    <div class="h-48 grass-decoration -mt-36 relative z-10"></div>
    <footer class="bg-success footer-content" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>

        <div class="mx-auto max-w-7xl px-6 lg:px-8 py-12 pb-16 sm:pb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="mb-6">
                        <h3 class="text-white font-semibold text-lg mb-3">Danielle Fence & Outdoor Living</h3>
                        <address class="text-gray-300 text-sm not-italic leading-relaxed">
                            4855 State Road 60 W<br/>
                            Mulberry, FL 33860<br/>
                            <a href="tel:8634253182" class="hover:text-white transition-colors">(863) 425-3182</a> or
                            <a href="tel:8136816181" class="hover:text-white transition-colors">(813) 681-6181</a>
                        </address>
                        <div class="mt-4">
                            <h4 class="text-white font-medium text-sm mb-2">Office Hours</h4>
                            <p class="text-gray-300 text-sm">
                                Monday - Friday: 8 AM - 5 PM EST<br/>
                                Closed weekends and major holidays
                            </p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="https://www.bbb.org/us/fl/mulberry/profile/fence-contractors/danielle-fence-manufacturing-company-inc-0733-22003257/#sealclick" target="_blank" rel="nofollow" class="inline-block hover:opacity-80 transition-opacity">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='280' height='80'%3E%3C/svg%3E"
                                 data-src="https://seal-centralflorida.bbb.org/seals/blue-seal-280-80-bbb-22003257.png"
                                 alt="BBB Accredited Business"
                                 class="h-12 w-auto lazy"
                                 width="280"
                                 height="80"
                                 loading="lazy" />
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-medium text-sm mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{route('financing')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Financing</a>
                        </li>
                        <li>
                            <a href="{{route('product-warranties')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Warranties</a>
                        </li>
                        <li>
                            <a href="{{route('easy-fixes')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Easy Fixes</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-medium text-sm mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{route('about-us')}}" class="text-sm text-gray-300 hover:text-white transition-colors">About</a>
                        </li>
                        <li>
                            <a href="{{route('contact')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Contact</a>
                        </li>
                        <li>
                            <a href="{{route('showroom')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Showroom</a>
                        </li>
                        <li>
                            <a href="{{route('blog')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Blog</a>
                        </li>
                        <li>
                            <a href="{{route('careers')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Careers</a>
                        </li>
                        <li>
                            <a href="{{route('reviews')}}" class="text-sm text-gray-300 hover:text-white transition-colors">Reviews</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-medium text-sm mb-4">Questions?</h4>
                    <p class="text-sm text-white mb-4">Chat with Grillbert!</p>

                    <!-- Grillbert Video -->
                    <div class="mb-6">
                        <a href="{{ route('chat') }}" class="block">
                            <div class="max-w-32 rounded-xl overflow-hidden hover:scale-105 transition-transform cursor-pointer">
                                <video autoplay loop muted playsinline class="w-full h-auto alpha-video" preload="none" loading="lazy">
                                    <source src="{{ Vite::asset('resources/videos/grillbert.webm') }}" type="video/webm">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </a>
                    </div>
                </div>
                </div>
            </div>

            <div class="mt-8 border-t border-white/20 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <livewire:social orientation="horzontal" wire:key="footer-social"/>
                </div>
                <p class="mt-8 text-xs leading-5 text-white/80 md:order-1 md:mt-0">&copy; {{date('Y')}} Danielle Fence & Outdoor Living. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>