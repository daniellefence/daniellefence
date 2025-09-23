{{-- Simple textarea replacement for old Trix component --}}
<div class="mb-4">
    @if(isset($label))
        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif
    <textarea
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent']) }}
        rows="6"
    ></textarea>
</div>