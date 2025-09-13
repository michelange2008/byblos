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
        <i data-lucide={{ e($icon) }} class="w-4 h-4"></i>
    @endif
    {{ $slot }}
</button>
