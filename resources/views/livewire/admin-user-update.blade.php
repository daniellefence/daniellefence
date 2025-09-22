<div>
        <form wire:submit.prevent="save" class="divide-y divide-gray-200 lg:col-span-9">
            <div class=" py-6 lg:pb-8">
                <div class="mt-6 flex flex-col bg-white p-2 rounded-lg lg:flex-row">
                    <div class="flex-grow space-y-6">
                        <x-input.text wire:model="name" label="Name"/>
                        <x-input.text wire:model="title" label="Title"/>
                    </div>
                    <div class="mt-6 flex-grow lg:ml-6 lg:mt-0 lg:flex-shrink-0 lg:flex-grow-0">
                        <p class="text-sm font-medium leading-6 text-gray-900" aria-hidden="true">Photo</p>
                        <div class="mt-2 lg:hidden">
                            <div class="flex items-center">
                                <div class="inline-block h-12 w-12 flex-shrink-0 overflow-hidden rounded-full"
                                     aria-hidden="true">
                                    @if(!$photo)
                                        <img class="h-full w-full rounded-full"
                                             src="{{$user->profile_photo_url}}"
                                             alt="{{$user->name}}">
                                    @else
                                        <img class="h-full w-full rounded-full"
                                             src="{{$photo->temporaryUrl()}}"
                                             alt="{{$user->name}}">
                                    @endif
                                </div>
                                <div class="relative ml-5">
                                    <input wire:model="photo" id="mobile-user-photo" name="user-photo" type="file"
                                           class="peer absolute h-full w-full rounded-md opacity-0">
                                    <label for="mobile-user-photo"
                                           class="pointer-events-none block rounded-md px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 peer-hover:ring-gray-400 peer-focus:ring-2 peer-focus:ring-sky-500">
                                        <span>Change</span>
                                        <span class="sr-only"> user photo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="relative hidden overflow-hidden rounded-full lg:block mb-2">
                                @if(!$photo)
                                    <img class="relative h-40 w-40 rounded-full" src="{{$user->profile_photo_url}}" alt="{{$user->name}}">
                                @else
                                    <img class="relative h-40 w-40 rounded-full" src="{{$photo->temporaryUrl()}}" alt="{{$user->name}}">
                                @endif
                            </div>
                            <input wire:model="photo" type="file">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-x-3 px-4 py-4 sm:px-6">
                <a href="{{route('admin.user.read')}}">
                    <x-button.warning>
                        Cancel
                    </x-button.warning>
                </a>
                <x-button type="submit">
                    Save
                </x-button>
            </div>
        </form>
        <div class="divide-y divide-gray-200 pt-6 bg-white">
            <div class="px-4 sm:px-6">
                <h2 class="text-xl font-bold leading-6 text-black mb-8">Permissions</h2>
                <div class="flex justify-between pb-4 border-b-2 border-gray-200 mb-4">
                    <div class="text-lg font-medium leading-6 text-gray-900">Superuser</div>
                    <x-input.toggle wire:model="superUser"></x-input.toggle>
                </div>
                @foreach(permission()->get() as $permission)
                    <div x-data="{
                    open:false,
                    toggleOpen() {
                        this.open = !this.open;
                    }
                }" class="mb-2">
                        <div @click="toggleOpen()" class="cursor-pointer flex justify-between">
                            <div class="text-md font-medium leading-6 text-gray-900">{{$permission['label']}}</div>
                            <x-icon.chevron x-cloak x-bind:class="open ? '  w-6 fill-gray-400':'-rotate-90 w-6 fill-gray-400'"></x-icon.chevron>
                        </div>
                        <ul x-show="open" role="list" class="mt-2 divide-y divide-gray-200">
                            @foreach($permission['actions'] as $key=>$description)
                                <li class="flex items-center justify-between py-4" x-data="{ on: true }">
                                    <div class="flex flex-col">
                                        {{$permission['category'].$key}}
                                        <p class="text-sm font-medium leading-6 text-gray-900" id="privacy-option-1-label">{{ucfirst($key)}}</p>
                                        <p class="text-sm text-gray-500" id="privacy-option-1-description">{{ucfirst($description)}}</p>
                                    </div>
                                    <x-input.toggle wire:model="{{$permission['category'].ucfirst($key)}}" :key="$permission['category'].$key"></x-input.toggle>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr/>
                @endforeach
            </div>

        </div>
</div>
