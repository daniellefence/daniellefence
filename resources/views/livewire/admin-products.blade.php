<div>
    <ul wire:sortable="updateProductOrder" role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        @if($this->parent_model)
            @foreach($this->parent_model->products()->orderBy('order','asc')->get() as $product)
                <li wire:sortable.item="{{$product->id}}" wire:key="product-{{$product->id}}" class="flex flex-wrap items-center justify-between gap-x-6 px-5 gap-y-4 py-5 sm:flex-nowrap">
                    <div>

                        <div class="text-sm font-semibold leading-6 text-gray-900 flex items-center gap-4">
                            <button wire:sortable.handle>
                                <x-icon.drag class="w-8"></x-icon.drag>
                            </button>
                            <div>
                                <a href="{{route('product',['product_id'=>$product->id,'product_title'=>$product->title])}}" class="hover:underline">
                                    {{$product->title}}
                                </a>
                                <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                    {{$product->photos()->count()}} Photos<br/>
                                    @if($product->pip)
                                        1 PIP
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                    <dl class="flex w-full flex-none justify-between gap-x-8 sm:w-auto">
                        <div class="flex -space-x-0.5">
                            @foreach($product->photos as $photo)
                                <dd>
                                    <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="{{asset('storage/'.$photo->path)}}" alt="{{$product->title}}">
                                </dd>
                            @endforeach
                        </div>
                        <div class="flex w-16 gap-1">
                            <a href="{{route('admin.products.product.edit',['id'=>$product->id])}}">
                                <x-button size="small">
                                    <x-icon.edit class="w-4 fill-white"></x-icon.edit>
                                </x-button>
                            </a>
                            <x-delete-button type="product" :guid="$product->id"/>
                        </div>
                    </dl>
                </li>
            @endforeach
        @endif
    </ul>
</div>

