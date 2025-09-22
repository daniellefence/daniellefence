<div>
    <ul wire:sortable="updateSubcategoryOrder" role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        @if($this->parent_model)
            @foreach($this->parent_model->children()->orderBy('order','asc')->get() as $subcategory)
                <li wire:sortable.item="{{$subcategory->id}}" wire:key="subcategory-{{$subcategory->id}}" class="flex flex-wrap items-center justify-between gap-x-6 px-5 gap-y-4 py-5 sm:flex-nowrap">
                    <div>
                        <div class="text-sm font-semibold leading-6 text-gray-900 flex items-center gap-4">
                            <button wire:sortable.handle>
                                <x-icon.drag class="w-8"></x-icon.drag>
                            </button>
                            <div>
                                <a href="{{$subcategory->getRoute()}}" class="hover:underline">
                                    {{$subcategory->title}}
                                </a>
                                <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                    {{$subcategory->products()->count()}} Products
                                </div>
                            </div>
                        </div>
                    </div>
                    <dl class="flex w-full flex-none justify-between gap-x-8 sm:w-auto">
                        <div class="flex items-center gap-x-2">
                            @if($subcategory->photo)
                                <img class="h-8 w-8 rounded-full bg-gray-50 ring-2 ring-white object-cover"
                                     src="{{asset('storage/'.$subcategory->photo->path)}}"
                                     alt="{{$subcategory->title}}">
                            @endif
                        </div>
                        <div class="flex w-16 gap-1">
                            <a href="{{route('admin.products.subcategory.edit',['id'=>$subcategory->id])}}">
                                <x-button size="small">
                                    <x-icon.edit class="w-4 fill-white"></x-icon.edit>
                                </x-button>
                            </a>
                            <x-delete-button type="category" :guid="$subcategory->id"/>
                        </div>
                    </dl>
                </li>
            @endforeach
        @endif
    </ul>

    @if($this->parent_model && $this->parent_model->children()->count() === 0)
        <div class="text-center py-8 text-gray-500">
            <p>No subcategories found for this category.</p>
            <p class="text-sm">Create subcategories to organize products within this category.</p>
        </div>
    @endif
</div>