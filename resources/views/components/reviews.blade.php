<div>

        <a href="https://g.page/r/CRf_8juw8RDYEB0/review" target="_blank" class="flex items-center justify-center mt-8">
            <x-button size="large">Leave a Review</x-button.danger>
        </a>
        <div
            class="relative -mx-4 mt-16 grid h-[49rem] max-h-[150vh] grid-cols-1 items-start gap-8 overflow-hidden px-4 sm:mt-20 md:grid-cols-2 lg:grid-cols-3">
            @if(isset($reviews[0]))
                <div class="animate-marquee space-y-8 py-4" style="--marquee-duration: 128320ms;">
                    @foreach($reviews[0] as $review)
                        <figure
                            class="animate-fade-in rounded-3xl bg-white p-6 opacity-0  "
                            aria-hidden="false" style="animation-delay: 0.1s;">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review->content}}"/>
                            @endif
                            <blockquote class="text-gray-900">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <div class="prose mt-3 text-base leading-7">
                                    {!! $review['content'] !!}
                                </div></blockquote>
                            <figcaption
                                class="mt-3 text-sm text-gray-600 before:content-['–_']">{{$review['name']}}</figcaption>
                        </figure>
                    @endforeach
                </div>

            @endif
            @if(isset($reviews[1]))
                <div class="animate-marquee space-y-8 py-4 hidden md:block" style="--marquee-duration: 168320ms;">
                    @foreach($reviews[1] as $review)
                        <figure
                            class="animate-fade-in rounded-3xl bg-white p-6 opacity-0  "
                            aria-hidden="false" style="animation-delay: 0.1s;">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review['content']}}"/>
                            @endif
                            <blockquote class="text-gray-900">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <div class="prose mt-3 text-base leading-7">
                                    {!! $review['content'] !!}
                                </div>
                            </blockquote>
                            <figcaption
                                class="mt-3 text-sm text-gray-600 before:content-['–_']">{{$review['name']}}</figcaption>
                        </figure>
                    @endforeach
                </div>
            @endif
            @if(isset($reviews[2]))
                <div class="animate-marquee space-y-8 py-4 hidden lg:block" style="--marquee-duration: 108320ms;">
                    @foreach($reviews[2] as $review)
                        <figure
                            class="animate-fade-in rounded-3xl bg-white p-6 opacity-0  "
                            aria-hidden="false" style="animation-delay: 0.5s;">
                            @if(isset($review['photos'][0]))
                                <img src="{{url($review['photos'][0]['path'])}}" alt="{{$review['content']}}"/>
                            @endif
                            <blockquote class="text-gray-900">
                                <x-output.five-star :stars="$review['stars']"></x-output.five-star>
                                <p class="mt-3 text-base leading-7">
                                    {!! $review['content'] !!}
                                </p>
                            </blockquote>
                            <figcaption
                                class="mt-3 text-sm text-gray-600 before:content-['–_']">{{$review['name']}}</figcaption>
                        </figure>
                    @endforeach
                </div>
            @endif
        </div>


</div>
