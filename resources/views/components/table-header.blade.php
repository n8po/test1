@props([])

@php
    $classes = '[&_tr]:border-b';
@endphp

<thead {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</thead>
