@props([
    'variant' => 'default',
    'size' => 'default',
    'href' => null,
    'type' => 'button',
    'as' => null,
    'color' => null,
    'colorForeground' => null,
])

@php
    $base = "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-offset-2";
    
    $variants = [
        'default' => 'bg-blue-600 text-white hover:bg-blue-700',
        'destructive' => 'bg-red-600 text-white hover:bg-red-700',
        'outline' => 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50',
        'secondary' => 'bg-gray-200 text-gray-900 hover:bg-gray-300',
        'ghost' => 'text-gray-700 hover:bg-gray-100',
        'link' => 'text-blue-600 underline-offset-4 hover:underline',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
    ];
    
    $sizes = [
        'default' => 'h-9 px-4 py-2',
        'xs' => 'h-7 px-2.5 text-xs',
        'sm' => 'h-8 px-3 text-sm',
        'lg' => 'h-10 px-6',
        'icon' => 'h-9 w-9',
    ];
    
    $classes = $base.' '.($variants[$variant] ?? $variants['default']).' '.($sizes[$size] ?? $sizes['default']);
    $tag = $as ?: ($href ? 'a' : 'button');
@endphp

<{{ $tag }}
    @if ($tag === 'a' && $href) href="{{ $href }}" @endif
    @if ($tag === 'button') type="{{ $type }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</{{ $tag }}>
