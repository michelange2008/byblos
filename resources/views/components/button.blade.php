@props([
    'class' => 'btn-primary', // btn-primary | btn-secondary | btn-danger
    'icon' => null,
])


<{{ $attributes->get('as', 'button') }} {{ $attributes->except('as')->class([$class]) }}>
    @if ($icon)
        <x-flux::icon :icon="$icon" class="w-4 h-4" />

    @endif
    {{ $slot }}
    </{{ $attributes->get('as', 'button') }}>
