<div>
    <ul wire:sortable="updateCategoryOrder" role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        @foreach($categories as $category)
            <li wire:sortable.item="{{$category->id}}" wire:key="category-{{$category->id}}" class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                <div class="flex min-w-0 gap-x-4">
                    <button wire:sortable.handle>
                        <x-icon.drag class="w-8"/>
                    </button>
                    @if($category->photo)
                    <img class="h-12 w-auto flex-none bg-gray-50" src="{{asset('storage/'.$category->photo->path)}}" alt="">
                    @endif
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="{{url($category->getRoute())}}" target="_blank">
                                {{$category->title}}
                            </a>
                        </p>
                        <div class="mt-1 flex flex-col text-xs leading-5 text-gray-500">
                            <a href="{{route('admin.products.subcategories',['parent'=>'category','parent_id'=>$category->id])}}">{{ $category->subcategories()->count() }} Subcategor{{$category->subcategories()->count() == 1 ? 'y':'ies'}}</a>
                            <a href="{{route("admin.products.products",['parent'=>'category','parent_id'=>$category->id])}}">{{$category->products()->count()}} Products</a>
                        </div>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-x-1">
                    <a href="{{route('admin.products.category.edit',['id'=>$category->id])}}">
                        <x-button.info size="small">
                            <x-icon.edit class="h-4 fill-white"/>
                        </x-button.info>
                    </a>
                    <x-delete-button type="category" :guid="$category->id"/>
                </div>
            </li>
        @endforeach
    </ul>
</div>

