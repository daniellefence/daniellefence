@props([
    'background' => 'bg-white',
    'spacing' => 'py-16 md:py-24',
    'container' => 'max-w-7xl mx-auto px-6 lg:px-8',
    'aos' => 'fade-up',
    'delay' => '0'
])

<section class="{{ $background }} {{ $spacing }}" data-aos="{{ $aos }}" data-aos-delay="{{ $delay }}">
    <div class="{{ $container }}">
        {{ $slot }}
    </div>
</section>