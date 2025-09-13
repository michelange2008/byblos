@props([
    'href' => '#',
    'class' => 'btn-secondary',
    'icon' => 'undo-2', 
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
    @if($icon)
        <i data-lucide={{ e($icon) }} class="w-4 h-4"></i>
    @endif
    {{ $slot }}
</a>
