<x-layouts.app :title="__('common.Library')">
    <div class="flex w-full flex-col gap-4 rounded-xl px-4 md:px-8 lg:px-16">
        <div class="grid grid-cols-[repeat(auto-fill,minmax(150px,1fr))] gap-4 w-full">
            @foreach ($books as $book)
            <div class="flex flex-col gap-1 justify-center">
                
                <!-- Container cover + overlay (desktop) -->
                <div class="relative group flex justify-center">
                    <a href="{{ route('books.show', $book->id) }}">
                        <img class="h-[25vh] w-auto object-cover border-2 border-gray-300 rounded"
                             src="{{ asset('storage/' . $book->cover) }}"
                             alt="{{ $book->title }}"
                             title="{{ $book->author.' - '.$book->title }}">
                    </a>

                    <!-- Overlay (desktop only) -->
                    <div class="absolute inset-0 bg-black/50 rounded flex items-center justify-center gap-6
                                opacity-0 group-hover:opacity-100 transition duration-300
                                hidden sm:flex">
                        <a href="{{ route('books.download', $book) }}"
                           class="text-white text-2xl hover:scale-125 transition">
                            <i class="fa-solid fa-download"></i>
                        </a>
                        <a href="{{ route('books.show', $book) }}"
                           class="text-white text-2xl hover:scale-125 transition">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Icons visible on mobile (sm:hidden) -->
                <div class="flex justify-center gap-4 mt-2 text-gray-700 sm:hidden">
                    <a href="{{ route('books.download', $book) }}"
                       class="text-gray-700 hover:text-black transition">
                        <i class="fa-solid fa-download text-xl"></i>
                    </a>
                    <a href="{{ route('books.show', $book) }}"
                       class="text-gray-700 hover:text-black transition">
                        <i class="fa-regular fa-eye text-xl"></i>
                    </a>
                </div>

            </div>
            @endforeach
        </div>
    </div>

</x-layouts.app>
