<div>
    <form wire:submit.prevent="save">
        <x-input.text label="Title" wire:model="title"/>
        <x-input.trix label="Content" wire:model="content"/>
        <div class="mb-2">
            <div class="flex justify-end gap-1">
                <a href="{{route('admin.career.read')}}">
                    <x-button.warning>Cancel</x-button.warning>
                </a>
                <x-button.submit text="Save"/>
            </div>
        </div>
    </form>
</div>