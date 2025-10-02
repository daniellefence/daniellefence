<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('DIY Fence Catalog') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">DIY Fence Catalog</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Build your perfect fence with our online DIY catalog. Choose your style, customize colors, heights, and spacing, then order panels for delivery or pickup.
                </p>
            </div>

            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach($categories as $category)
                    <div class="flex flex-col overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 bg-white border border-gray-200">
                        @if($category->hasMedia('category-photos'))
                            <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                <img src="{{ $category->getFirstMediaUrl('category-photos') }}"
                                     alt="{{ $category->name }}"
                                     class="w-full h-64 object-cover">
                            </div>
                        @endif
                        <div class="flex flex-col p-8">
                            <h3 class="text-2xl font-semibold leading-7 text-gray-900">{{ $category->name }}</h3>
                            <p class="mt-4 flex-1 text-base leading-7 text-gray-600">{{ $category->description }}</p>
                            <div class="mt-6">
                                <a href="{{ route('diy.category', $category->id) }}"
                                   class="inline-flex items-center gap-x-2 rounded-md bg-outdoor-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-outdoor-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-outdoor-primary">
                                    Browse Products
                                    <i class="fa-solid fa-arrow-right h-4 w-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>