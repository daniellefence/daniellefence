<div>
    <form wire:submit.prevent="update">
        <div class="mb-2">
            <label>Question:</label>
            <input type="text" wire:model="question"/>
            <x-input-error for="question"></x-input-error>
        </div>
        <div class="mb-2">
            <label>Answer:</label>
            <textarea wire:model="answer"></textarea>
            <x-input-error for="answer"></x-input-error>
        </div>
        <div class="mb-2">
            <a href="{{route('admin.faq.read')}}">
                <x-button.warning>Cancel</x-button.warning>
            </a>
            <x-button type="submit">Save</x-button>
        </div>
    </form>
</div>