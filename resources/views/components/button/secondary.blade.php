@props([
    'size'=>'normal',
])

<button {{ $attributes->merge(['type' => 'button', 'class' => danielle()->defaultButtonClasses('secondary').danielle()->defaultButtonPadding($size)]) }}>
    {{ $slot }}
</button>
