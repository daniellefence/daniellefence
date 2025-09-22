<div>
    <form wire:submit.prevent="save" class="mt-4">
        <div class="my-6">
            <h3>Route: {{$seo->title}}</h3>
        </div>
        <x-input.text wire:model="title" label="Title"/>
        <x-input.textarea wire:model="description" label="Description"/>
        <x-input.textarea wire:model="keywords" label="Keywords"/>
        <div class="my-6 flex justify-end gap-1">
            <a href="{{route('admin.seo.read')}}">
                <x-button.warning>
                    Cancel
                </x-button.warning>
            </a>

            <x-button.submit>Save</x-button.submit>
        </div>
    </form>
</div>

