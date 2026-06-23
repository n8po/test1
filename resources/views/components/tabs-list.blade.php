@props(['value'])

<div role="tablist" aria-label="{{ $attributes->get('aria-label', 'Tabs') }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-gray-100 p-1 text-gray-500">
    {{ $slot }}
</div>
