<div class="relative bg-outdoor-white">
    <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8">
        <div class="px-6 pb-24 pt-10 sm:pb-32 lg:col-span-7 lg:px-0 lg:pb-56 lg:pt-48 xl:col-span-6">
            <form wire:submit.prevent="save">
                <div class="space-y-12 sm:space-y-16 bg-outdoor-white p-4 rounded-lg shadow">
                    <div>
                        <div class=" space-y-8 pb-12 sm:space-y-0 sm:pb-0">
                            <x-input.text wire:model="job_position" label="Job Position"/>
                            <x-input.text wire:model="first_name" label="First Name"/>
                            <x-input.text wire:model="last_name" label="Last Name"/>
                            <x-input.text wire:model="phone" label="Phone"/>
                            <x-input.text wire:model="email" label="Email"/>
                            <x-input.filepond wire:model="resume" label="Upload Your Resume"></x-input.filepond>
                        </div>

                    </div>
                </div>



        <div class="mt-6 flex items-center justify-end gap-x-1">
            <a href="{{route('careers')}}">
                <x-button.warning>Cancel</x-button.warning>
            </a>
            <x-button type="submit">Apply</x-button>
        </div>
        </form>
    </div>
    <div class="relative lg:col-span-5 lg:-mr-8 xl:absolute xl:inset-0 xl:left-1/2 xl:mr-0">
        <img class="aspect-[3/2] w-full bg-gray-50 object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-full"
             src="{{Vite::asset('resources/images/careers.jpg')}}" alt="Danielle Fence & Outdoor Living"
             width="2432" height="1442" loading="lazy">
    </div>
</div>
</div>
