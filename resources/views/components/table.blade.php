@props([])

@php
    $classes = 'min-w-full relative';
@endphp

<div class="border rounded-lg overflow-hidden">
    <table {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </table>
</div>
