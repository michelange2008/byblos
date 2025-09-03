@props([
    'type' => 'submit',
    'class' => 'primary',  // primary | secondary | danger | small
    'icon' => null,
    'confirm' => false,
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "btn-$class"]) }}
    @if($confirm)
        x-data
        @click.prevent="
            if(confirm('Êtes-vous sûr ?')) { $el.closest('form').submit() }
        "
    @endif
>
    @if($icon)
        <x-dynamic-component :component="$icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</button>
