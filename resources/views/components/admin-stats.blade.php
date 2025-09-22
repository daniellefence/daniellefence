@props([
    'stats' => []
])

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    @foreach($stats as $stat)
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if(isset($stat['icon']))
                            <x-dynamic-component :component="$stat['icon']" class="h-6 w-6 text-gray-400" />
                        @endif
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ $stat['label'] }}</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stat['value'] }}</div>
                                @if(isset($stat['change']))
                                    <div class="ml-2 flex items-baseline text-sm font-semibold {{ $stat['change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $stat['change'] > 0 ? '+' : '' }}{{ $stat['change'] }}%
                                        @if($stat['change'] >= 0)
                                            <x-icon.trending-up class="ml-1 h-4 w-4 text-green-500" />
                                        @else
                                            <x-icon.trending-down class="ml-1 h-4 w-4 text-red-500" />
                                        @endif
                                    </div>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @if(isset($stat['link']))
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ $stat['link']['url'] }}" class="font-medium text-outdoor-primary hover:text-outdoor-primary-dark">
                            {{ $stat['link']['text'] }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>