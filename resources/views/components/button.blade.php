@props([
    'size'=>'normal',
])

<button {{ $attributes->merge(['type' => 'submit', 'class' => danielle()->defaultButtonClasses('primary').danielle()->defaultButtonPadding($size)]) }}>
    {{ $slot }}
</button>
