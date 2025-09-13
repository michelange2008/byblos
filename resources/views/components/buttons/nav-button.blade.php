@props([
    'route' => 'books.index',
    'icon' => null,
])

<a href="{{ route($route) }}" class="flex flex-row gap-3 text-gray-500 text-sm items-end px-3 my-2">
    @if($icon)
        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
    @endif
    {{ $slot }}
</a>
