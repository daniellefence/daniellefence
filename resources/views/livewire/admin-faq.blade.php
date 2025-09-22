<div>
    <div x-data="{
            showForm:@entangle('showForm')
        }"
         @click.away="showForm = false"
         @keyup.window.escape="showForm = false"
         class="mb-2">
        <x-button @click="showForm = !showForm">New</x-button>
        <form wire:submit.prevent="save" x-cloak x-show="showForm" class="mt-4">
            <x-input.text label="Question:" wire:model="question"/>
            <x-input.textarea label="Answer:" wire:model="answer"/>
            <div class="mb-2 flex justify-end gap-1">
                <x-button.submit text="Save"/>
            </div>
        </form>
    </div>
    <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        @foreach($faq as $f)
            <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            Question:  {{$f->question}}
                        </p>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            Answer:  {!! $f->answer !!}
                        </p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-x-4">
                    <a href="{{route('admin.faq.edit',['id'=>$f->id])}}">
                        <x-button size="small">
                            <x-icon.edit class="w-4 fill-white"></x-icon.edit>
                        </x-button>
                    </a>
                    <x-delete-button :guid="$f->id" type="faq"/>
                </div>
            </li>
        @endforeach
    </ul>

</div>
