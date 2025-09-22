@props([
    'size'=>'normal',
])

<button {{ $attributes->merge(['type' => 'button', 'class' => danielle()->defaultButtonClasses('success').danielle()->defaultButtonPadding($size)]) }}>
    {{ $slot }}
</button>
