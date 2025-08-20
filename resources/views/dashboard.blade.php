<x-layouts.app :title="__('common.Library')">
    <div class="flex w-full flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-1">

        </div>
        <div class="h-full flex flex-row gap-3 justify-start">
            @foreach ($books as $book)
            <div class="m-3">
                <a href="{{ route('books.show', $book->id) }}">
                    <img class="h-100 w-min-25 border border-2" src="{{ asset('storage/' . $book->cover) }}" alt="">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
