<div>
    <form wire:submit.prevent="save" class="my-4">
        <x-input.textarea label="Google Analytics Code" wire:model="analytics"/>
        <x-button.submit text="Save"/>
    </form>

</div>

