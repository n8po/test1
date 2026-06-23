@props(['value'])

@php
    $classes = 'inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50';
    $activeClass = 'bg-white text-gray-900 shadow-sm';
    $inactiveClass = 'text-gray-500 hover:text-gray-700';
@endphp

<button 
    type="button"
    role="tab"
    aria-selected="{{ $attributes->get('data-state') === 'active' ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => $classes . ' ' . ($attributes->get('data-state') === 'active' ? $activeClass : $inactiveClass)]) }}
>
    {{ $slot }}
</button>
