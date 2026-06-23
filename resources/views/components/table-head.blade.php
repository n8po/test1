@props([])

@php
    $classes = 'h-12 px-4 text-left align-middle font-medium text-gray-500';
@endphp

<th {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</th>
