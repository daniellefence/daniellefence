<div>
    <form wire:submit.prevent="save">
        <x-input.text label="Title" wire:model="title"/>
        <x-input.trix label="Content" wire:model="content"/>
        <x-input.select :options="danielle()->getDropdownBlogCategories()" label="Category" wire:model="category"/>
        <x-input.tag wire:model="keywords" label="Keywords"/>
        <x-input.filepond wire:model="photo" label="Photo"/>
        <x-input.text wire:model="photo_title" label="Photo Title"/>
        <div class="mb-2">
            <div class="flex justify-end gap-1">
                <a href="{{route('admin.blog.read')}}">
                    <x-button.warning>Cancel</x-button.warning>
                </a>
                <x-button.submit text="Save"/>
            </div>
        </div>
    </form>

</div>
