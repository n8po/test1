@props([])

@php
    $classes = 'text-sm font-medium';
@endphp

<label {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</label>
