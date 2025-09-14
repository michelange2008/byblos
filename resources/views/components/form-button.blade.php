@props([
    'type' => 'submit',
    'class' => 'btn-primary',  // primary | secondary | danger | small
    'icon' => 'save',
    'confirm' => null,
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $class]) }}
    @if($confirm)
        x-data
        @click.prevent="
            if(confirm('Êtes-vous sûr ?')) { $el.closest('form').submit() }
        "
    @endif
>
    @if($icon)
        <x-flux::icon :icon="$icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</button>
