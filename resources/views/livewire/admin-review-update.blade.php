<div>
    <form wire:submit.prevent="save">
        <div class="mb-2">
            <label>Star Rating</label>
            <x-input.five-star wire:model="stars"></x-input.five-star>
            <x-input-error for="stars"></x-input-error>
        </div>
        <div class="mb-2">
            <x-input.text label="Customer Name" wire:model="name"/>
        </div>
        <div class="mb-2">
            <x-input.trix wire:model="content" label="Review Content"></x-input.trix>
        </div>
        <div class="flex items-center justify-end gap-1">
            <a href="{{route('admin.review.read')}}">
                <x-button.warning>Cancel</x-button.warning>
            </a>
            <x-button.submit text="Save"/>
        </div>

    </form>
</div>
