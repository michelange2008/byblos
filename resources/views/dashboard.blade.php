<x-layouts.app :title="__('common.Library')">
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-1">

        </div>
        <div class="relative h-full flex-1 overflow-hidden ">
            @foreach ($books as $book)
            <div class="m-3">
                <a href="{{ url('/livre/'.$book->id) }}">
                    <img class="w-1/4 w-min-25" src="{{ asset('storage/books/' . $book->cover) }}" alt="">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
