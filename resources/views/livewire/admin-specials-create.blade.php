<div>
    <form wire:submit.prevent="save">
        <x-input.text wire:model="title" label="Title"/>
        <x-input.text wire:model="price" label="Price"/>
        <x-input.text wire:model="url" label="Url"/>
        <x-input.select wire:model="condition" :options="['new'=>'New','used'=>'Used','refurbished'=>'Refurbished']" label="Condition"/>
        <x-input.text wire:model="brand" label="Brand"/>
        <x-input.trix wire:model="content" label="Content"/>
        <x-input.filepond wire:model="photos" label="Photos"/>
        <div class="mt-2">
            <x-button.submit/>
        </div>
    </form>
</div>
