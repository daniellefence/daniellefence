@props([
    'model',
])
@php
    switch(get_class($model)) {
        case "App\Models\Category":
            $items = $model->subcategories()->orderBy('order','asc')->get();
    		$items = $items->merge($model->products()->orderBy('order','asc')->get());
 
            break;
        case "App\Models\Subcategory":
                $items=$model->subcategories()->orderBy('order','asc')->get();
                if(count($items) == 0) {
                    $items = $model->products()->orderBy('order','asc')->get();
                }
                break;
            }
@endphp
<x-page-heading>
    <x-slot name="heading">{{$model->title}}
    </x-slot>
    <x-slot name="subheading">{!! $model->description !!}</x-slot>
</x-page-heading>
<div class="mx-auto max-w-7xl overflow-hidden px-4 py-4 sm:px-6 sm:py-8 lg:px-8">
    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-8">
        @foreach($items as $item)
            <livewire:item wire:key="item-{{$item->key.rand(0,10000)}}" :item="$item" lazy="true" />
        @endforeach
    </div>
</div>
