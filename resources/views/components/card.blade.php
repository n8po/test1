@props([])

@php
    $classes = 'rounded-lg border bg-white shadow-sm';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
