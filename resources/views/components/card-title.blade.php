@props([])

@php
    $classes = 'text-2xl font-semibold leading-none tracking-tight';
@endphp

<h3 {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</h3>
