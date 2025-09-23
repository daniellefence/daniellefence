<div class="bg-white" data-aos="fade-up">
    <!-- Content -->
    <div class="relative">
        <!-- Header section -->
        <div class="text-center py-16 px-6" data-aos="fade-down" data-aos-delay="200">
            <h2 class="text-3xl sm:text-4xl font-bold text-brand-neutral mb-4">
                Customer Reviews
            </h2>
            <p class="text-lg text-brand-neutral/80 max-w-2xl mx-auto leading-relaxed">
                See what our customers have to say about their experience with Danielle Fence & Outdoor Living
            </p>

            <!-- CTA Button -->
            <div class="mt-8" data-aos="zoom-in" data-aos-delay="400">
                <a href="https://g.page/r/CRf_8juw8RDYEB0/review" target="_blank" class="inline-flex items-center gap-2 bg-brand-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-brand-secondary transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Leave a Review
                </a>
            </div>
        </div>

        <!-- Reviews container with enhanced design -->
        <div class="relative px-6 pb-16">
            <div
                class="relative mx-auto max-w-7xl grid h-[49rem] max-h-[150vh] grid-cols-1 items-start gap-8 overflow-hidden md:grid-cols-2 lg:grid-cols-3 rounded-3xl bg-white/60 backdrop-blur-sm border border-white/50 shadow-2xl p-8">

                <!-- Inner glow effect -->
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-blue-500/5 via-transparent to-purple-500/5"></div>

                <!-- Reviews columns with enhanced backdrop -->
                <div class="absolute inset-4 rounded-2xl bg-gradient-to-br from-white/30 to-gray-50/30 backdrop-blur-sm"></div>
            @if(isset($reviews[0]))
                <div class="animate-marquee-vertical duration-45 space-y-8 py-4 relative z-10">
                    @foreach($reviews[0] as $review)
                        <figure
                            class="relative rounded-lg bg-white p-6 shadow-lg hover:shadow-xl transition-shadow duration-200"
                            aria-hidden="false">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review->content}}"/>
                            @endif

                            <blockquote class="text-gray-900 relative">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <div class="prose mt-3 text-base leading-7">
                                    {!! $review['content'] !!}
                                </div>
                            </blockquote>
                            <figcaption class="mt-6 flex items-center space-x-3">
                                <!-- Customer avatar placeholder -->
                                <div class="w-10 h-10 bg-brand-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($review['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{$review['name']}}</div>
                                    <div class="text-xs text-gray-500">Verified Customer</div>
                                </div>
                                <!-- Verification badge -->
                                <div class="ml-auto">
                                    <div class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Verified</span>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                    {{-- Duplicate content for seamless loop --}}
                    @foreach($reviews[0] as $review)
                        <figure
                            class="relative rounded-lg bg-white p-6 shadow-lg hover:shadow-xl transition-shadow duration-200"
                            aria-hidden="false">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review->content}}"/>
                            @endif

                            <blockquote class="text-gray-900 relative">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <div class="prose mt-3 text-base leading-7">
                                    {!! $review['content'] !!}
                                </div>
                            </blockquote>
                            <figcaption class="mt-6 flex items-center space-x-3">
                                <!-- Customer avatar placeholder -->
                                <div class="w-10 h-10 bg-brand-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($review['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{$review['name']}}</div>
                                    <div class="text-xs text-gray-500">Verified Customer</div>
                                </div>
                                <!-- Verification badge -->
                                <div class="ml-auto">
                                    <div class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Verified</span>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>

            @endif
            @if(isset($reviews[1]))
                <div class="animate-marquee-vertical duration-50 space-y-8 py-4 hidden md:block relative z-10">
                    @foreach($reviews[1] as $review)
                        <figure
                            class="relative rounded-lg bg-white p-6 shadow-lg hover:shadow-xl transition-shadow duration-200"
                            aria-hidden="false">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review['content']}}"/>
                            @endif
                            <blockquote class="text-gray-900">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <div class="prose mt-3 text-base leading-7">
                                    {!! $review['content'] !!}
                                </div>
                            </blockquote>
                            <figcaption class="mt-6 flex items-center space-x-3">
                                <!-- Customer avatar placeholder -->
                                <div class="w-10 h-10 bg-brand-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($review['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{$review['name']}}</div>
                                    <div class="text-xs text-gray-500">Verified Customer</div>
                                </div>
                                <!-- Verification badge -->
                                <div class="ml-auto">
                                    <div class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Verified</span>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                    {{-- Duplicate content for seamless loop --}}
                    @foreach($reviews[1] as $review)
                        <figure
                            class="relative rounded-lg bg-white p-6 shadow-lg hover:shadow-xl transition-shadow duration-200"
                            aria-hidden="false">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review['content']}}"/>
                            @endif
                            <blockquote class="text-gray-900">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <div class="prose mt-3 text-base leading-7">
                                    {!! $review['content'] !!}
                                </div>
                            </blockquote>
                            <figcaption class="mt-6 flex items-center space-x-3">
                                <!-- Customer avatar placeholder -->
                                <div class="w-10 h-10 bg-brand-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($review['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{$review['name']}}</div>
                                    <div class="text-xs text-gray-500">Verified Customer</div>
                                </div>
                                <!-- Verification badge -->
                                <div class="ml-auto">
                                    <div class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Verified</span>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            @endif
            @if(isset($reviews[2]))
                <div class="animate-marquee-vertical duration-25 space-y-8 py-4 hidden lg:block relative z-10">
                    @foreach($reviews[2] as $review)
                        <figure
                            class="relative rounded-lg bg-white p-6 shadow-lg hover:shadow-xl transition-shadow duration-200"
                            aria-hidden="false">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review['content']}}"/>
                            @endif
                            <blockquote class="text-gray-900">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <!-- Content with better typography -->
                                <div class="relative">
                                    <div class="prose prose-sm text-gray-700 leading-relaxed font-medium">
                                        {!! $review['content'] !!}
                                    </div>
                                    <!-- Subtle gradient overlay for long text -->
                                    <div class="absolute bottom-0 left-0 right-0 h-4 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                                </div>
                            </blockquote>
                            <figcaption class="mt-6 flex items-center space-x-3">
                                <!-- Customer avatar placeholder -->
                                <div class="w-10 h-10 bg-brand-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($review['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{$review['name']}}</div>
                                    <div class="text-xs text-gray-500">Verified Customer</div>
                                </div>
                                <!-- Verification badge -->
                                <div class="ml-auto">
                                    <div class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Verified</span>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                    {{-- Duplicate content for seamless loop --}}
                    @foreach($reviews[2] as $review)
                        <figure
                            class="relative rounded-lg bg-white p-6 shadow-lg hover:shadow-xl transition-shadow duration-200"
                            aria-hidden="false">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review['content']}}"/>
                            @endif
                            <blockquote class="text-gray-900">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <!-- Content with better typography -->
                                <div class="relative">
                                    <div class="prose prose-sm text-gray-700 leading-relaxed font-medium">
                                        {!! $review['content'] !!}
                                    </div>
                                    <!-- Subtle gradient overlay for long text -->
                                    <div class="absolute bottom-0 left-0 right-0 h-4 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                                </div>
                            </blockquote>
                            <figcaption class="mt-6 flex items-center space-x-3">
                                <!-- Customer avatar placeholder -->
                                <div class="w-10 h-10 bg-brand-primary rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($review['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{$review['name']}}</div>
                                    <div class="text-xs text-gray-500">Verified Customer</div>
                                </div>
                                <!-- Verification badge -->
                                <div class="ml-auto">
                                    <div class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Verified</span>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
