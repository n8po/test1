@props([])

@php
    $classes = 'p-4 align-middle';
@endphp

<td {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</td>
