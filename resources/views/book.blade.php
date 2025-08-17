<x-layouts.app : title="__('common.book')">
    <div class="flex flex-col gap-2 xl:w-4/5 mr-5">
        <div class="pl-8">
            <h1 class="font-bold text-3xl">
                {{  $book->title }}
            </h1>
            <h1 class="font-bold">{{ $book->author }} </h1>
        </div>
        <div class="flex flex-col md:flex-row gpa-5">
            <div class="basis-1/3">
                <img src="{{ asset('storage/books/'.$book->cover) }}" alt="">
            </div>
            <div class="basis-2/3 flex flex-col gap-5 text-justify pt-2 md:pt-8">
                    <p>{{ $book->description }} </p>

            </div>
        </div>
        <div>
            @foreach ($book->tags as $tag)
                <p>{{ $tag->name }} </p>
            @endforeach
        </div>
    </div>


</x-layouts.app>
