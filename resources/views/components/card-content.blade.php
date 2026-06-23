@props([])

@php
    $classes = 'p-6 pt-0';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
