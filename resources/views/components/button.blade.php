@props([
    'class' => 'primary',  // primary | secondary | danger
    'icon' => null,
])

<{{ $attributes->get('as', 'button') }}
    {{ $attributes->except('as')->merge([
        'class' => "btn-$class"
    ]) }}
>
    @if($icon)
        <x-dynamic-component :component="$icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</{{ $attributes->get('as', 'button') }}>

