@props([
    'href' => '#',
    'class' => 'btn-secondary',
    'icon' => 'undo-2', 
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
    @if($icon)
        <x-flux::icon :icon="$icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</a>
