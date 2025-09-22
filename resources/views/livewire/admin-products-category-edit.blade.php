<div>
    <form wire:submit.prevent="save">
        <x-input.text wire:model="title" label="Title"/>
        <x-input.trix wire:model="description" label="Description"/>
        <x-input.filepond wire:model="photo"/>
        <x-button.submit text="Save"/>
    </form>
    @if($category->photo)
        <div>
            <img class="mb-4" src="{{asset('storage/'.$category->photo->path)}}" alt="{{$category->photo->title}}"/>
        </div>
        <div class="flex gap-1">
            @if(!$editingPhoto)
                <div>{{$category->photo->title}}</div>
            @else
                <x-input.text wire:model="photoTitle"/>

            @endif

        </div>

    @endif
    <div class="flex items-center gap-1 mt-4">
        @if(!$editingPhoto)
            <x-button.info wire:click="setEditingPhoto(true)" size="small">
                <x-icon.edit class="w-4 h-4"/>
            </x-button.info>
        @else
            <x-button.warning wire:click="cancelEditingPhoto()" size="small">
                <x-icon.cancel class="w-4 h-4"/>
            </x-button.warning>
            <x-button.success wire:click="saveEditingPhoto()" size="small">
                <x-icon.save class="fill-white w-4 h-4"/>
            </x-button.success>
        @endif
        @if($category->photo)
            <x-delete-button type="photo" :guid="$category->photo->id"/>
        @endif
    </div>
</div>
