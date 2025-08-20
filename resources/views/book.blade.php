<x-layouts.app : title="{{ $book->title }}">
    <div class="flex flex-col gap-2 xl:w-4/5 mr-5">
        <div class="pl-8">
            <h1 class="font-bold text-3xl">
                {{ $book->title }}
            </h1>
            <h1 class="font-bold">{{ $book->author }} </h1>
        </div>
        <div class="flex flex-col md:flex-row gpa-5">
            <div class="basis-1/3">
                <img class="border border-2" src="{{ asset('storage/' . $book->cover) }}" alt="">
            </div>
            <div class="basis-2/3 flex flex-col gap-5 text-justify pt-2 md:pt-8">
                <p>{{ $book->description }} </p>
                <a href="{{ route('books.download', $book) }}"
                    class="inline-block m-auto px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:bg-gray-200 hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Télécharger
                </a>
            </div>
        </div>
        <div>
            @foreach ($book->tags as $tag)
                <p>{{ $tag->name }} </p>
            @endforeach
        </div>
    </div>


</x-layouts.app>
