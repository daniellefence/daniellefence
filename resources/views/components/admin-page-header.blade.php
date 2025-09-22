<div wire:ignore>
    <div class="md:flex md:items-center md:justify-between p-2 pl-4  ">
        <div class="min-w-0 flex-1">
            <h2 class="text-xl font-bold leading-7 text-gray-800 sm:truncate sm:text-2xl sm:tracking-tight">{{danielle()->pageHeader('title')}}</h2>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0 gap-1">
            @foreach(danielle()->pageHeader('buttons') as $button)
                <a href="{{$button['route']}}">
                    <x-dynamic-component :component="'button.'.$button['type']" size="small" title="{{$button['label']}}">
                        @if(isset($button['icon']))
                            <x-dynamic-component :component="'icon.'.$button['icon']" class="w-4"></x-dynamic-component>
                        @else
                            {{$button['label']}}
                        @endif
                    </x-dynamic-component>
                </a>
            @endforeach
        </div>
    </div>

</div>
