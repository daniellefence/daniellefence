<div>
    <h4 class="text-2xl mb-4">Request an outdoor pavers estimate.</h4>
    <form wire:submit.prevent="submit">
        <x-input.text wire:model="product_name" label="Product Name"/>
        <x-input.text wire:model="color_options" label="Color Options"/>
        <x-input.text wire:model="size_of_area" label="Size of Area Needed to Pave?"/>
        <x-input.textarea wire:model="what_will_this_area_be_used_for" label="What will this area be used for?"/>
        <x-input.textarea wire:model="additional_comments" label="Additional Comments"/>
        <div class="mb-4">
            <x-label>What type of pattern would you like?</x-label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 mt-6 gap-4">
                <button wire:click="setPaverType('basketweave')" type="button" class="{{ $paver_type == 'basketweave'? 'bg-success text-white':'bg-white hover:bg-success hover:bg-opacity-80 hover:text-white' }} group p-4 rounded-lg text-center border-2 border-transparent shadow">
                    <x-label class="{{ $paver_type == 'basketweave'? 'text-white':'group-hover:text-white' }}">Basketweave</x-label>
                    <img class="w-full mt-2" src="{{Vite::asset('resources/images/DF_Basketweave_Pattern.jpg')}}"
                         alt="T-Pattern"/>
                </button>
                <button wire:click="setPaverType('random-running-bond')" type="button" class="{{ $paver_type == 'random-running-bond'? 'bg-success text-white':'bg-white hover:bg-success hover:bg-opacity-80 hover:text-white' }} group p-4 rounded-lg text-center border-2 border-transparent shadow">
                    <x-label class="{{ $paver_type == 'random-running-bond'? 'text-white':'group-hover:text-white' }}">Random Running Bond</x-label>
                    <img class="w-full mt-2" src="{{Vite::asset('resources/images/DF_Random_Running_Bond_Pattern.jpg')}}"
                         alt="Random Running Bond"/>
                </button>
                <button wire:click="setPaverType('herringbone-90')" type="button" class="{{ $paver_type == 'herringbone-90'? 'bg-success text-white':'bg-white hover:bg-success hover:bg-opacity-80 hover:text-white' }} group p-4 rounded-lg text-center border-2 border-transparent shadow">
                    <x-label class="{{ $paver_type == 'herringbone-90'? 'text-white':'group-hover:text-white' }}">Herringbone 90&deg;</x-label>
                    <img class="w-full mt-2" src="{{Vite::asset('resources/images/DF_Herringbone_90_Pattern.jpg')}}"
                         alt="Herringbone 90&deg;"/>
                </button>
                <button wire:click="setPaverType('herringbone-47')" type="button" class="{{ $paver_type == 'herringbone-47'? 'bg-success text-white':'bg-white hover:bg-success hover:bg-opacity-80 hover:text-white' }} group p-4 rounded-lg text-center border-2 border-transparent shadow">
                    <x-label class="{{ $paver_type == 'herringbone-47'? 'text-white':'group-hover:text-white' }}">Herringbone 45&deg;</x-label>
                    <img class="w-full mt-2" src="{{Vite::asset('resources/images/DF_Herringbone_45_Pattern.jpg')}}"
                         alt="Herringbone 48&deg;"/>
                </button>
                <button wire:click="setPaverType('t-pattern')" type="button" class="{{ $paver_type == 't-pattern'? 'bg-success text-white':'bg-white hover:bg-success hover:bg-opacity-80 hover:text-white' }} group p-4 rounded-lg text-center border-2 border-transparent shadow">
                    <x-label class="{{ $paver_type == 't-pattern'? 'text-white':'group-hover:text-white' }}">T Pattern</x-label>
                    <img class="w-full" src="{{Vite::asset('resources/images/DF_TPattern.jpg')}}"
                         alt="Basketweave"/>
                </button>
            </div>

        </div>
        <x-input.text wire:model="first_name" label="First Name"/>
        <x-input.text wire:model="last_name" label="Last Name"/>
        <x-input.text wire:model="phone_number" label="Phone"/>
        <x-input.text wire:model="email" label="Email"/>
        <x-input.text wire:model="address_line_one" label="Address Line One"/>
        <x-input.text wire:model="address_line_two" label="Address Line Two"/>
        <x-input.text wire:model="city" label="City"/>
        <x-input.text wire:model="state" label="State"/>
        <x-input.text wire:model="zip_code" label="Zip Code"/>
        <x-input.filepond multiple="true" wire:model="attachments" label="Attachments - (Photos, Surveys, Etc.)"/>
        <x-button.submit/>
    </form>
    <script src="https://www.google.com/recaptcha/api.js?render={{\App\Models\GeneralSetting::where([['key','=','google_recaptcha_site_key']])->first()->value}}"></script>
    <script>
        function handle(e) {
            grecaptcha.ready(function () {
                grecaptcha.execute('{{\App\Models\GeneralSetting::where([['key','=','google_recaptcha_site_key']])->first()->value}}', {action: 'submit'})
                    .then(function (token) {
                        @this.set('captcha', token);
                    });
            })
        }
    </script>
</div>
