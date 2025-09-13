@props([
    'class' => 'btn-primary',  // btn-primary | btn-secondary | btn-danger
    'icon' => null,
])


<{{ $attributes->get('as', 'button') }}
    {{ $attributes->except('as')->class([
        $class
    ]) }}
>
    @if($icon)

        <i data-lucide={{ e($icon) }} class="w-4 h-4"></i>
    @endif
    {{ $slot }}
</{{ $attributes->get('as', 'button') }}>

