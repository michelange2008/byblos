@props([
    'href',
    'class',
    'icon' => null,
])

<x-button as="a" href="{{ $href }}" :class="$class" :icon="$icon" {{ $attributes }}>
    {{ $slot }}
</x-button>
