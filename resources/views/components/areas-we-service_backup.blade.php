<div class="bg-gray-100 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <p class="text-base font-semibold leading-7 text-indigo-600">Service Area</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Areas we service.</h1>
            <div class="mt-4">


            @foreach(danielle()->serviceCities() as $city)

                <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-gray-800 bg-outdoor-primary">
  <svg class="h-1.5 w-1.5 fill-green-400" viewBox="0 0 6 6" aria-hidden="true">
    <circle cx="3" cy="3" r="3" />
  </svg>
  {{$city}}
</span>
@endforeach

            </div>
        </div>
    </div>

</div>

