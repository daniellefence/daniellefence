<div>
    <form wire:submit.prevent="save">
        <div class="mb-2">
            <x-input.text wire:model="title" label="Title"/>
        </div>
        <div class="mb-2">
            <x-input.trix id="trix-{{rand(0,1000)}}" wire:model="content" label="Content"></x-input.trix>
        </div>
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
