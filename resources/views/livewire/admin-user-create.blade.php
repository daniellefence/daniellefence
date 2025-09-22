<div>
    <form wire:submit.prevent="save">
        <x-input.text wire:model="name" label="Name"/>
        <x-input.email wire:model="email" label="Email"/>
        <x-input.password wire:model="password" label="Password"/>
        <x-input.password wire:model="password_confirmation" label="Password Confirmation"/>
        <x-button.submit text="save"/>
    </form>

</div>
