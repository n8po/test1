@props([])

@php
    $classes = 'space-y-2';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
