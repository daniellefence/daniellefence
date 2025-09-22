<div class="mx-auto max-w-7xl px-6 pb-32 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
    <label class="sr-only block text-sm font-medium leading-6 text-gray-900">Search Everywhere</label>
    <div class="p-2 bg-outdoor-primary rounded-lg">
        <div class="text-white text-center text-lg mb-4">Search Products</div>
        <div class="flex rounded-md shadow-sm">
            <div class="relative flex flex-grow items-stretch focus-within:z-10">
                <input wire:keyup="calculate" wire:model="q" type="text"
                       class="search-input-without-button block w-full rounded-md py-1.5 text-gray-900 placeholder:text-gray-400 ring-0 focus:ring-0 sm:text-sm sm:leading-6 border-0 focus:border-0"
                       placeholder="Search Everywhere">
            </div>
        </div>
    </div>
    @if($photos->count() >0)
    <div class=" py-14">
        <h3>Products</h3>
    </div>
    @if($q)
    <div>
        <ul role="list"
            class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-1 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 xl:gap-x-8">
            @foreach($photos as $photo)
                @if(isset($photo->product_id))
                    <li class="relative glass p-4 rounded-lg shadow">
                        <a href="{{$photo->product->getRoute()}}"
                            class="ring-2 ring-indigo-500 ring-offset-2 aspect-w-10 aspect-h-7 group block w-full overflow-hidden rounded-lg bg-gray-100">
                            <img src="{{asset('storage/'.$photo->path)}}" alt="{{$photo->title}}"
                                 class=" object-cover">
                        </a>
                        <div class="flex flex-col gap-4 align-center justify-center items-center">
                            <a href="{{$photo->product->getRoute()}}">
                                <span class="mt-2  text-center text-sm font-medium text-gray-900">{{$photo->title}}</span>
                            </a>
                            <livewire:keyword-tags :model="$photo" wire:key="product-keywords-{{$photo->id.rand(0,10000)}}"/>
                            <a href="{{$photo->product->getRoute()}}">
                                <x-button>View Product Page</x-button>
                            </a>
                        </div>

                    </li>
                @endif
            @endforeach
        </ul>
        <div class="my-8">
            @if($photos->hasPages())
                <div>
                    {!! $photos->links() !!}
                </div>
            @endif
        </div>
    </div>
    @endif
    @else
        <div class="mt-8 relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
            </svg>
            <span class="my-4 block text-sm font-semibold text-gray-900">Can't find what you're looking for?</span>
            <a href="{{route('contact')}}">
                <x-button.danger size="large">Contact Us</x-button.danger>
            </a>
        </div>
    @endif
</div>
