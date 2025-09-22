<div>
    <ul role="list" class="divide-y divide-gray-100">
        @foreach($seo as $s)
            <li class="flex justify-between gap-x-6 py-5 bg-white my-1 py-2">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            Route: {{$s->route}}
                        </p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                            Title: {{$s->title}}
                        </p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                            Keywords: {{$s->keywords}}
                        </p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                            Description: {{\Illuminate\Support\Str::limit($s->description,240)}}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{route('admin.seo.update',['id'=>$s->id])}}">
                        <x-button size="small">
                            <x-icon.edit class="w-4 h-4 fill-white"/>
                        </x-button>
                    </a>

                </div>
            </li>
        @endforeach
    </ul>
    <div>
        @if($seo->hasPages())
            <div>
                {{$seo->links()}}
            </div>
        @endif
    </div>
</div>
