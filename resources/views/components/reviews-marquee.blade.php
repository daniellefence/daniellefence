<a href="{{ route('reviews') }}" class="block bg-outdoor-primary/90 text-white py-3 overflow-hidden whitespace-nowrap transition-colors duration-300 cursor-pointer">
    <div class="animate-marquee inline-block">
        @foreach(\App\Models\Review::where('hidden', false)->orderBy('order', 'asc')->get() as $review)
            <span class="inline-flex items-center mx-8">
                <span class="text-white font-bold">{{ $review->name }}</span>
                <div class="inline-flex items-center mx-3">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->stars)
                            <x-icon.star class="w-4 h-4 text-outdoor-gold fill-current drop-shadow-sm" />
                        @else
                            <x-icon.empty-star class="w-4 h-4 text-gray-400 fill-current" />
                        @endif
                    @endfor
                </div>
                <span class="text-brand-light">{{ Str::limit($review->content, 80) }}</span>
            </span>
        @endforeach

        {{-- Duplicate content for seamless loop --}}
        @foreach(\App\Models\Review::where('hidden', false)->orderBy('order', 'asc')->get() as $review)
            <span class="inline-flex items-center mx-8">
                <span class="text-white font-bold">{{ $review->name }}</span>
                <div class="inline-flex items-center mx-3">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->stars)
                            <x-icon.star class="w-4 h-4 text-outdoor-gold fill-current drop-shadow-sm" />
                        @else
                            <x-icon.empty-star class="w-4 h-4 text-gray-400 fill-current" />
                        @endif
                    @endfor
                </div>
                <span class="text-brand-light">{{ Str::limit($review->content, 80) }}</span>
            </span>
        @endforeach
    </div>
</a>

<style>
@keyframes marquee {
    0% { transform: translateX(0%); }
    100% { transform: translateX(-50%); }
}

.animate-marquee {
    animation: marquee 500s linear infinite;
}
</style>

