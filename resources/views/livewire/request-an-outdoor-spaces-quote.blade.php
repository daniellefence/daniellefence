<div>
    <h4 class="text-2xl mb-4">Request an outdoor spaces estimate.</h4>
    <form wire:submit.prevent="submit">
        <x-input.text wire:model="product_name" label="Product Name"/>
        <x-input.textarea wire:model="design_options" label="Design Options"/>
        <x-input.text wire:model="size_of_area" label="Size of Available Area"/>
        <x-input.select wire:model="will_you_need_pavers" label="Will You Need Pavers" :options="['No'=>'No','Yes'=>'Yes']"/>
        <x-input.textarea wire:model="features" label="Type of Features Wanted"/>
        <x-input.textarea wire:model="additional_comments" label="Additional Comments"/>
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
