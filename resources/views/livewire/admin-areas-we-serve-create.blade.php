<div>
    <form wire:submit.prevent="save">
        <x-input.text label="Title" wire:model="title"/>
        <x-button.submit text="Save"/>
    </form>
</div>

