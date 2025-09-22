@props([
    'title' => null,
    'subtitle' => null,
    'actions' => null,
    'padding' => true
])

<div {{ $attributes->merge(['class' => 'bg-white shadow-sm rounded-lg border border-gray-200']) }}>
    @if($title || $actions)
        <div class="px-6 py-4 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <div class="min-w-0 flex-1">
                @if($title)
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ $title }}
                    </h3>
                @endif
                @if($subtitle)
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            @if($actions)
                <div class="mt-4 sm:mt-0 sm:ml-4">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>
</div>