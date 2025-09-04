@php
    $data = $this->getViewData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Actions
        </x-slot>

        <x-slot name="description">
            Frequently used admin panel shortcuts
        </x-slot>

        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($data['actions'] as $action)
                @if(!isset($action['permission']) || auth()->user()?->can($action['permission']))
                    <a href="{{ $action['url'] }}" 
                       class="group p-4 border border-gray-200 rounded-lg hover:border-{{ $action['color'] }}-300 hover:bg-{{ $action['color'] }}-50 transition-all duration-200 block">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-{{ $action['color'] }}-100 group-hover:bg-{{ $action['color'] }}-200 rounded-lg flex items-center justify-center transition-colors">
                                    <x-filament::icon 
                                        icon="{{ $action['icon'] }}" 
                                        class="w-5 h-5 text-{{ $action['color'] }}-600 group-hover:text-{{ $action['color'] }}-700"
                                    />
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-{{ $action['color'] }}-900 transition-colors">
                                    {{ $action['title'] }}
                                </p>
                                <p class="text-xs text-gray-600 group-hover:text-{{ $action['color'] }}-700 transition-colors mt-1">
                                    {{ $action['description'] }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>