@props([
    'size'=>'normal',
])

<button {{ $attributes->merge(['type' => 'button', 'class' => danielle()->defaultButtonClasses('primary').danielle()->defaultButtonPadding($size)]) }}>
    {{ $slot }}
</button>
