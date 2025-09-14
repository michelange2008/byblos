@props([
    'route' => 'books.index',
    'icon' => null,
])

<a href="{{ route($route) }}" class="hover:bg-gray-300 p-1 pl-2 rounded border flex flex-row gap-2 items-center">
    @if($icon)
        <x-flux::icon :icon="$icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</a>
