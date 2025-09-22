<div x-data="{
    show_modal:@entangle('show_modal'),
     currentTab:1,
     setTab(tab) {
        this.currentTab = tab;
     }
}" class=" ">
    <x-page-heading>
        <x-slot name="heading">Product Warranties</x-slot>
        <x-slot name="subheading">
            Danielle Fence & Outdoor Living is proud to offer industry leading brand-names that carry some of the
            best warranties on the market. Click below to view product warranties by brand. If you have further
            questions, please feel free to contact a member of our Sales Team at (863) 425-3182 or (813) 681-6181,
            or you can send an email to Sales@DanielleFence.net
        </x-slot>
    </x-page-heading>
    <div class="mx-auto max-w-7xl px-6 lg:px-8 grid grid-cols-4">
        @foreach($warranties as $key=>$warranty)
            <div class="aspect-video w-full h-48 bg-cover bg-center relative" style="background-image:url({{ Vite::asset('resources/images/' . $warranty['image']) }})">
                <div class="absolute inset-0 flex items-center justify-center text-white bg-black/40">
                    {{ $warranty['label'] }} test
                </div>
            </div>
        @endforeach
    </div>


</div>
