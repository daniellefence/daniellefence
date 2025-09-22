<div>
    <form wire:submit.prevent="save">
        <x-input.text label="Title" wire:model="title"/>
        <x-input.trix label="Description" wire:model="description"/>
        <x-input.textarea label="Keywords" wire:model="keywords"/>
        <x-input.filepond label="Photos" wire:model="photos" multiple="true"/>
        <x-input.filepond label="PIP" wire:model="pip"/>
        <x-button.submit text="Save"/>
    </form>
</div>
