<x-page-wrap>
    <div class="mt-8 pb-16" aria-labelledby="gallery-heading">
        <div role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-8">
            @foreach($specials as $special)
                <div>
{{--                    <a data-fslightbox="gallery" href="{{asset('storage/'.$special->photos()->first()->path)}} ">--}}
                        <img src="{{asset('storage/'.$special->photos()->first()->path)}}" alt="{{$special->title}}" class="">
{{--                    </a>--}}
                    <div class="text-xl mb-2 mt-4">{{$special->title}}</div>
                    <div>{!! $special->content !!}</div>
                </div>
            @endforeach
        </div>
    </div>
</x-page-wrap>

