@props([
    'id'
])
<a href="{{route('loginAs',['id'=>$id])}}">
    <x-button.warning size="small">Login As</x-button.warning>
</a>
