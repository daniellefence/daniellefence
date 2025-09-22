<div class="mt-4">
        <form wire:submit.prevent="save">
                @foreach($settings as $setting)
                        @if($setting->input_type)
                                <x-dynamic-component wire:model="{{$setting->key}}" :label="danielle()->decode($setting->key)" :component="'input.'.$setting->input_type"></x-dynamic-component>
                        @endif
                @endforeach
                <x-button.submit text="Save"/>
        </form>
</div>
