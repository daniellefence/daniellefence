<div>
    <form wire:submit.prevent="save" class="mx-auto mt-8 max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
            <div class="lg:col-span-5 lg:col-start-8">
                <x-input.text label="Title" wire:model="title"/>
                <x-input.textarea label="Keywords" wire:model="keywords"/>
            </div>
            <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                    <img src="{{asset('storage/'.$photo->path)}}"
                         alt="{{$photo->title}}"
                         class="lg:col-span-2 lg:row-span-2 rounded-lg">
                </div>
            </div>
            <div class="flex gap-1">
                <x-button.submit text="save"/>
            </div>

        </div>
    </form>
</div>