<div class="pb-16 pt-6 sm:pb-24">
    <div class="mx-auto mt-8 max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">

            <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                <div class="bg-gray-100 rounded-lg p-8 text-center">
                    <p class="text-gray-600">Product images will be displayed here</p>
                    {{-- <x-product-carousel :product="$product"></x-product-carousel> --}}
                </div>
                <div class="my-8 text-center">
                    <p class="text-gray-500">Share this product</p>
                    {{-- <x-share-this/> --}}
                </div>
            </div>

            <div class="mt-8 lg:col-span-5">
                <h3 class="text-2xl font-bold text-gray-900">{{$product->title}}</h3>
                <div class="mt-10 text-gray-700">{!! $product->description !!}</div>
                <div class="mt-10 flex flex-col items-center gap-4">

                    @if($product->pip()->exists())
                        <div class="hidden sm:block">
                            <embed style="width:290px;height:352px;" src="{{asset('storage/'.$product->pip()->first()->path)}}#toolbar=0&navpanes=0&scrollbar=0&page=1" alt="{{$product->title}}"/>
                        </div>
                        <a class="text-lg font-bold flex flex-col gap-4 items-center" href="{{asset('storage/'.$product->pip()->first()->path)}}" target="_blank">
                            <button class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <span>View product information page.</span>
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <a href="{{route('request-a-quote')}}" class="block w-full">
            <button class="w-full mt-14 py-4 px-8 bg-red-600 text-white font-semibold text-lg rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-lg">
                Request an estimate
            </button>
        </a>
    </div>
</div>
