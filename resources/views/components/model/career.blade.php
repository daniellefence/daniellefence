<li class="item-holder">
    <div>
        <p class="text-sm font-semibold leading-6 text-gray-900">
            <a href="{{route('careers')}}" class="hover:underline">{{$career->title}}</a>
        </p>
        <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
            <p>Created by:
                    {{$career->user->name}}
            </p>
            <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                <circle cx="1" cy="1" r="1" />
            </svg>
            <p>{{$career->created_at->format('m/d/Y')}}</p>
            <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                <circle cx="1" cy="1" r="1" />
            </svg>
            <p>{{$career->created_at->diffForHumans()}}</p>
        </div>
    </div>
    <div class="flex items-center gap-1">
        <x-dynamic-component wire:click="togglePublished({{$career->id}})" size="small" component="button.info">
            @if($career->published == 1)
                Unpublish
            @else
                Publish
            @endif
        </x-dynamic-component>
        <a href="{{route('admin.career.update',['id'=>$career->id])}}">
            <x-button title="Edit" size="small">
                <x-icon.edit class="w-4 fill-white"/>
            </x-button>
        </a>
        <x-delete-button type="career" :guid="$career->id"/>
    </div>
</li>
