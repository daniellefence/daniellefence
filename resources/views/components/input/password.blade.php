@props(
    [
        'disabled' => false,
        'label'=>''
    ]
)
<div class="mb-4">
    @if($label)
        <label class="mb-2" for="{{$attributes['wire:model']}}">{{$label}}</label>
    @endif
    <div class="mt-2">
        <input {{$attributes}} type="password" class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-outdoor-primary sm:text-sm sm:leading-6">
    </div>
    <p class="mt-2 text-sm text-gray-500">
        <x-input-error for="{{$attributes['wire:model']}}"></x-input-error>
    </p>
</div>
