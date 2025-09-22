<div>
    <form wire:submit.prevent="save">
        <x-input.text label="Title" wire:model="title"/>
        <x-input.filepond label="Photo" wire:model="photo"/>
        <x-button.submit text="Save"/>
    </form>
</div>
