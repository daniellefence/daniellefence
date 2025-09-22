<div x-data="{
    on:@entangle($attributes->wire('model'))
}" >
    <button @if(isset($title)) title="{{$title}}" @endif type="button"
            class="relative ml-4 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
            role="switch" aria-checked="true" x-ref="switch"
            :class="{ 'bg-primary': on, 'bg-gray-200': !(on) }"
             @click="on = !on;$wire.update('{{$attributes->wire('model')->value}}')">
        <span aria-hidden="true" class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5"
              :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
    </button>
    <input type="hidden" x-model="on">
</div>
