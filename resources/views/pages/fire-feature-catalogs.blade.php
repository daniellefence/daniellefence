<x-app-layout>

    <div class="">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <x-page-heading heading="Fire Feature Catalogs"/>

            <div class="mt-6 grid grid-cols-1 gap-x-6  sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                @foreach($catalogs as $catalog)
                    <a href="{{$catalog['pdf']}}" target="_blank" class="group flex items-center justify-center flex-col">
                        <div class="mt-4 mb-2 flex justify-between">
                            <h3 class="text-sm text-center text-gray-700">
                                {{$catalog['label']}}
                            </h3>
                        </div>
                        <div class=" w-full   group-hover:opacity-75 ">
                            <img alt="{{$catalog['label']}}" src="{{$catalog['image']}}" class=" ">
                        </div>
                    </a>
                @endforeach
                <!-- More products... -->
            </div>
        </div>
    </div>

</x-app-layout>