<div>
    <div class="mt-8 pb-16">
        <ul role="list"
            class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            @foreach($specials as $special)
                <li class="relative bg-gray-200 p-2 rounded-lg">
                    <a href="{{$special->getRoute()}}">
                        <!-- Current: "ring-2 ring-indigo-500 ring-offset-2", Default: "focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100" -->
                        <div class=" aspect-w-10 aspect-h-7 group block w-full overflow-hidden rounded-lg bg-gray-100">
                            <!-- Current: "", Default: "group-hover:opacity-75" -->
                            <img
                                    src="{{asset('storage/'.$special->photos()->first()->path)}}"
                                    alt="{{url($special->title)}}"
                                    class="object-cover">
                        </div>
                        <p class="mt-2 block truncate text-sm font-medium text-gray-900">
                            {{$special->price}}<br>
                            {{$special->title}}
                        </p>
                    </a>

                    <div class="flex gap-1 justify-end">
                        <a href="{{route('admin.specials.update',['id'=>$special->id])}}">
                            <x-button size="small">
                                <x-icon.edit class="w-4 h-4 fill-white"/>
                            </x-button>
                        </a>

                        <x-delete-button type="specials" :guid="$special->id"/>
                    </div>
                </li>
            @endforeach
            <!-- More files... -->
        </ul>
    </div>
</div>
