@props([
    'size'=>'normal',
])

<button {{ $attributes->merge(['type' => 'button', 'class' => danielle()->defaultButtonClasses('info').danielle()->defaultButtonPadding($size)]) }}>
    {{ $slot }}
</button>
