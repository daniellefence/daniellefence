<div>
    <ul x-data="{
    editing:@entangle('editing')
}"
        wire:sortable="updatePhotoOrder"
        role="list" class="divide-y divide-gray-100 bg-white p-4 rounded-lg">
        @foreach($photos as $photo)
            <li wire:sortable.item="{{$photo->id}}" wire:key="photo-{{$photo->id}}" class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <div wire:sortable.handle>
                        <x-icon.drag class="w-4"></x-icon.drag>
                    </div>
                    <a data-fslightbox="gallery" href="{{asset('storage/'.$photo->path)}}">
                        <img class="w-48 flex-none bg-gray-50" src="{{asset('storage/'.$photo->path)}}" alt="{{$photo->title}}">
                    </a>
                    <div class="min-w-0 flex-auto">
                        <p x-cloak x-show="editing != {{$photo->id}}" class="text-sm font-semibold leading-6 text-gray-900">
                            {{$photo->title}}
                        </p>
                        <div x-cloak x-show="editing == {{$photo->id}}">
                            <x-input.textarea wire:model="title"/>

                        </div>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            {{$photo->created_at->format('m/d/Y')}}
                        </p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-x-1">
                    <div class="flex items-center gap-1 ">
                        @if($editing == $photo->id && $key == 'home')
                        <div class="text-sm mr-2 flex flex-col items-center justify-center">
                            <x-input.toggle title="Show Title on Photo" wire:model="show_title"/>
                        </div>
                        @endif
                        <x-button x-show="editing != {{$photo->id}}" wire:click="setEditing({{$photo->id}})" size="small">
                            <x-icon.edit class="w-4 fill-white"></x-icon.edit>
                        </x-button>
                        <x-button.warning wire:click="clearEditing()" x-cloak x-show="editing == {{$photo->id}}" size="small">
                            <x-icon.cancel class="w-4"></x-icon.cancel>
                        </x-button.warning>
                        <x-button.success wire:click="saveTitle()" x-cloak x-show="editing == {{$photo->id}}" size="small">
                            <x-icon.save class="w-4 fill-white"></x-icon.save>
                        </x-button.success>
                    </div>
                    <x-delete-button type="photo" :guid="$photo->id"></x-delete-button>
                </div>
            </li>
        @endforeach
    </ul>
</div>

