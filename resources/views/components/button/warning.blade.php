@props([
    'size'=>'normal',
])

<button {{ $attributes->merge(['type' => 'button', 'class' => danielle()->defaultButtonClasses('warning').danielle()->defaultButtonPadding($size)]) }}>
    {{ $slot }}
</button>
