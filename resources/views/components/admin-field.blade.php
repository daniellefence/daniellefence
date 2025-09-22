@props([
    'label' => null,
    'name' => null,
    'help' => null,
    'required' => false,
    'error' => null
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        {{ $slot }}
    </div>

    @if($help)
        <p class="form-help">{{ $help }}</p>
    @endif

    @if($error || $errors->has($name))
        <p class="mt-1 text-sm text-red-600">
            {{ $error ?? $errors->first($name) }}
        </p>
    @endif
</div>