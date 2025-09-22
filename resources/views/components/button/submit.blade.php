@props([
    'text'=>'Submit'
])
<div class="flex justify-end">
    <x-button.danger type="submit">{{$text}}</x-button.danger>
</div>
