@props([
    'href' => '#',
    'class' => 'secondary',
    'icon' => 'flux::icon.x', // par ex. une icône "X" pour annuler
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => "btn-$class"]) }}>
    @if($icon)
        <x-dynamic-component :component="$icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</a>
