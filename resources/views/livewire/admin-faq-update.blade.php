<div>
    <form wire:submit.prevent="update">
        <x-input.textarea wire:model="question" label="Question"/>
        <x-input.textarea wire:model="answer" label="Answer"/>

        <div class="flex items-center gap-1 justify-end">
            <a href="{{route('admin.faq.read')}}">
                <x-button.warning>Cancel</x-button.warning>
            </a>
            <x-button.submit text="Save"/>
        </div>
    </form>
</div>

