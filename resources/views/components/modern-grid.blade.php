@props([
    'columns' => '3',
    'gap' => 'gap-6 lg:gap-8',
    'responsive' => true,
    'aos' => 'fade-up',
    'stagger' => 100
])

@php
$columnClasses = [
    '1' => 'grid-cols-1',
    '2' => $responsive ? 'grid-cols-1 md:grid-cols-2' : 'grid-cols-2',
    '3' => $responsive ? 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3' : 'grid-cols-3',
    '4' => $responsive ? 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4' : 'grid-cols-4',
    '5' => $responsive ? 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5' : 'grid-cols-5',
    '6' => $responsive ? 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6' : 'grid-cols-6'
];
@endphp

<div class="grid {{ $columnClasses[$columns] }} {{ $gap }}">
    {{ $slot }}
</div>