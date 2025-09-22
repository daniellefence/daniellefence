<div class="pb-16 pt-6 sm:pb-24 bg-gradient-to-br from-outdoor-light to-white">
    <div class="mx-auto mt-8 max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">

            <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-outdoor-light">
                    <div>
                        <x-product-carousel :product="$product"></x-product-carousel>
                    </div>
                    <p class="text-center text-base text-slate-600 mt-4 flex items-center justify-center gap-2 bg-outdoor-light/30 rounded-lg py-3 px-4">
                        <i class="fad fa-search-plus w-5 h-5"></i>
                        Click an image for a larger view.
                    </p>
                </div>
                <div class="mt-6">
                    <x-share-this/>
                </div>
                @if($product->id == 203)
                    <div class="mt-6 bg-white rounded-2xl shadow-lg p-6 border border-outdoor-light">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/7VW1CregxxE?si=C6-w2u1ADc7f7ni-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="rounded-lg"></iframe>
                    </div>
                @endif
            </div>

            <div class="mt-8 lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-outdoor-light">
                    <h3 class="text-3xl font-bold text-outdoor-primary font-display mb-6">{{$product->title}}</h3>
                    <div class="mt-6 text-slate-700 prose prose-slate max-w-none">
                        {!! $product->description !!}


</div>
                    <div class="mt-10 flex flex-col items-center gap-4">
                        @if($product->pip()->count() >0)
                            <div class="hidden sm:block bg-gray-50 rounded-lg p-4">
                                <embed style="width:290px;height:352px;" src="{{asset('storage/'.$product->pip->path)}}#toolbar=0&navpanes=0&scrollbar=0&page=1" alt="{{$product->title}}"/>
                            </div>
                            <a class="text-lg font-bold flex flex-col gap-4 items-center" href="{{asset('storage/'.$product->pip->path)}}" target="_blank">
                                <button class="inline-flex items-center px-6 py-3 bg-outdoor-secondary text-white font-semibold rounded-lg hover:bg-outdoor-secondary/90 transition-colors duration-200">
                                    <span>View product information page</span>
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-16">
            <a href="{{route('request-a-quote',['product'=>$product->title])}}" class="block w-full">
                <button class="w-full py-4 px-8 bg-outdoor-primary text-white font-semibold text-lg rounded-lg hover:bg-outdoor-primary/90 transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    Request an estimate
                </button>
            </a>
        </div>
    </div>
</div>
