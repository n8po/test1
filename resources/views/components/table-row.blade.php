@props([])

@php
    $classes = 'border-b transition-colors hover:bg-gray-50';
@endphp

<tr {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</tr>
