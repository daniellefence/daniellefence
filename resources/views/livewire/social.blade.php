<div>
    @if($orientation == 'vertical')
        <div>
            <ul role="list">
                @foreach($social as $key=>$data)
                    <li class="flex items-center mb-2">
                        <a title="{{$data['text']}}" class="bg-gray-50 rounded-2xl w-full px-4 py-2 border border-gray-300 group items-center flex font-medium text-gray-800 transition hover:text-outdoor-primary "
                           href="{{$data['url']}}" target="_blank">
                            <x-dynamic-component class="h-8 w-8 flex-none fill-zinc-500 transition group-hover:fill-outdoor-primary" :component="'icon.'.$key"/>
                            <span class="ml-4">{{$data['text']}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    @else
        <div class="flex items-center gap-4">
            @foreach($social as $key=>$data)
                <a title="{{$data['text']}}" href="{{$data['url']}}" target="_blank" class="text-white hover:text-brand-accent">
                    <span class="sr-only">{{$data['text']}}</span>
                    <x-dynamic-component class="fill-white h-6 w-6 hover:fill-brand-accent transition-colors" :component="'icon.'.$key"/>
                </a>
            @endforeach
        </div>

    @endif
</div>

