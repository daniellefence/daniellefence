<div class="bg-slate-100 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <p class="text-base font-semibold leading-7 text-outdoor-primary">Service Area</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Neighborhoods we love to serve.</h1>
            <div class="mt-4 py-4">
                @if(!empty($areas))
                    @foreach($areas as $area)
                        <a href="{{ route('city.landing', $area->slug) }}"
                           class="bg-outdoor-primary inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-outdoor-primary text-white ring-1 ring-inset m-1 hover:bg-outdoor-primary/90 transition-colors">
                            {{ $area->title }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
