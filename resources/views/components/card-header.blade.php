@props(['disabled' => false])

@php
    $classes = 'flex flex-col space-y-1.5 p-6';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
