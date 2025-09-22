<div>
    <h4 class="text-2xl mb-4">Request a fence and/or gate estimate.</h4>
    <form wire:submit.prevent="submit">
        <div class=" ">
            <x-input.select wire:model="fence_type" label="Fence Type" :options="[
                    'PVCVinyl'=>'PVC/Vinyl',
                    'Wood'=>'Wood',
                    'Aluminum'=>'Aluminum',
                    'ChainLink'=>'Chain Link',
                    'Trex'=>'Trex',
                    'Gates'=>'Gates',
                    'Composite'=>'Composite',
                    'AlleghenyNSherwood'=>'Allegheny & Sherwood'
                    ]"/>
            <x-input.text wire:model="style_options" label="Style Options"/>
            <div class="mb-4">
                <x-input.select wire:model="haul_away" label="Will you need us to take down and haul away existing fence?" :options="[
                    'No'=>'No',
                    'Yes'=>'Yes'
                ]"/>
            </div>
            <x-input.select wire:model="fence_height" label="What height fence do you need?" :options="[
                    '48'=>'48in.',
                    '60'=>'60in.',
                    '72'=>'72in.',
                    '84'=>'84in.',
                    '96'=>'96in.'
                ]"/>
            <x-input.text wire:model="how_many_gates" label="How many gates do you need?"/>
            <x-input.textarea wire:model="additional_comments" label="Additional Comments"></x-input.textarea>
            <x-input.text wire:model="first_name" label="First Name"/>
            <x-input.text wire:model="last_name" label="Last Name"/>
            <x-input.text wire:model="phone_number" label="Phone Number"/>
            <x-input.email wire:model="email" label="Email"/>
            <x-input.text wire:model="address_line_one" label="Address Line One"/>
            <x-input.text wire:model="address_line_two" label="Address Line Two"/>
            <x-input.text wire:model="city" label="City"/>
            <x-input.text wire:model="state" label="State"/>
            <x-input.text wire:model="zip_code" label="Zip Code"/>
            <x-input.filepond multiple="true"
                label="To help with the accuracy of your quote, please include a property survey, if available, and photos of the area you would like to fence."
                wire:model="attachments"/>
            <x-button.submit/>
        </div>
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
