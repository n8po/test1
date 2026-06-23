@props(['value'])

<div data-tabs="{{ $value }}" class="w-full">
    {{ $slot }}
</div>
