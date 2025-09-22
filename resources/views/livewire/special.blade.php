<x-page-wrap>
    <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8 mt-14">
        <!-- Image gallery -->

        <div class="flex flex-col-reverse">
            <!-- Image selector -->
            @if($special->photos()->count() >0)
                <div class="aspect-h-1 aspect-w-1 w-full">
                    <!-- Tab panel, show/hide based on tab state. -->
                    <div role="tabpanel" tabindex="0">
                        <img src="{{asset('storage/'.$special->photos()->first()->path)}}" alt="{{$special->title}}"
                             class="h-full w-full object-cover object-center sm:rounded-lg">
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{$special->title}}</h1>
            <div class="mt-3">
                <h2 class="sr-only">Product information</h2>
                <p class="text-3xl tracking-tight text-gray-900">
                    {{$special->price}}
                </p>
            </div>
            <div class="mt-6">
                <div class="space-y-6 prose prose-xl">
                    {!! $special->content !!}
                </div>
            </div>
            <form class="mt-6">
                <div class="mt-10 flex">
                    <a href="{{route('request-a-quote')}}">
                        <x-danger-button type="submit">
                            Request A Quote
                        </x-danger-button>
                    </a>
{{--                    @shane add to favorites component--}}
{{--                    <button type="button"--}}
{{--                            class="ml-4 flex items-center justify-center rounded-md px-3 py-3 text-gray-400 hover:bg-gray-100 hover:text-gray-500">--}}
{{--                        <svg class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                             stroke="currentColor" aria-hidden="true">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
                </div>
            </form>

        </div>
    </div>
</x-page-wrap>

