<div>
    <form wire:submit.prevent="save">
        <x-input.text label="Title" wire:model="title"/>
        <x-input.trix label="Content" wire:model="content"/>
        <x-input.select label="Category" :options="$category_options" wire:model="category"/>
        <x-input.tag label="Keywords" wire:model="keywords"></x-input.tag>
        <x-input.filepond wire:model="photo" label="Photo"/>
        <div class="mb-2">
            <div class="flex justify-end gap-1">
                <a href="{{route('admin.blog.read')}}">
                    <x-button.warning>Cancel</x-button.warning>
                </a>
                <x-button.submit text="Save"/>
            </div>
        </div>

    </form>
    <div>
        @if($blog->photo)
            <div class="relative w-40">
                <x-delete-button class="absolute z-40 top-4 right-4" type="photo" :guid="$blog->photo->id"/>
                @if(!$this->editing_photo_title)
                    <x-button wire:click="editPhotoTitle()" size="small" class="absolute z-40 top-4 left-4">
                        <x-icon.edit class="w-4 h-4 fill-white"></x-icon.edit>
                    </x-button>
                @else
                    <x-button.warning wire:click="editPhotoTitle()" class="absolute z-40 top-4 left-4 " size="small">
                        <x-icon.cancel class="w-4 h-4"></x-icon.cancel>
                    </x-button.warning>
                    <x-button wire:click="savePhotoTitle()" class="absolute z-40 top-4 left-12" size="small">
                        <x-icon.save class="w-4 h-4 fill-white"></x-icon.save>
                    </x-button>
                @endif
                <img class="relative w-40" src="{{asset('storage/'.$blog->photo->path)}}" alt="{{$blog->photo->title}}"/>
                <div>
                    @if(!$this->editing_photo_title)
                        <p>{{$blog->photo->title}}</p>
                    @else
                        <textarea wire:model="photo_title"></textarea>
                    @endif
                </div>

            </div>
        @endif
    </div>

</div>

