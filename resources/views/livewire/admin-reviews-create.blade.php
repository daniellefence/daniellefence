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
            <x-input.trix label="Review Content" wire:model="content"></x-input.trix>
        </div>
        <div class="mb-2">
            <label>Review Photo</label>
            <x-input.filepond wire:model="photo"></x-input.filepond>
        </div>
        <div class="flex justify-end gap-1">
            <a href="{{route('admin.review.read')}}">
                <x-button.warning>Cancel</x-button.warning>
            </a>
            <x-button.submit text="Save"/>
        </div>
    </form>

</div>

