@props([
    'size'=>'normal',
])
<button {{ $attributes->merge(['type' => 'button', 'class' => danielle()->defaultButtonClasses('danger').danielle()->defaultButtonPadding($size)]) }}>
    {{ $slot }}
</button>
