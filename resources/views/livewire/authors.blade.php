<div class="max-w-3xl mx-auto p-4">

    <!-- Barre de recherche -->
    <div class="relative mb-4">
        <input type="text" wire:model.live="query" placeholder="Rechercher par auteur ou titre..."
            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-300" />
        <div wire:loading wire:target="query" class="absolute right-3 top-2.5">
            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>
    </div>

    <!-- Liste des auteurs et leurs livres -->
    @foreach ($authors as $author)
        <div class="mb-6">
            <h2 class="text-lg font-bold mb-2">
                {{ $author->author }}
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 items-baseline">
                @foreach ($books as $book)
                    @if ($book->lastName === $author->lastName)
                        <div class="flex flex-col gap-1 justify-center">
                            <a href="{{ route('books.show', $book->id) }}">
                                <img class="h-[10vh] w-auto object-cover border-2 border-gray-300 rounded"
                                    src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" title="Cliquer pour plus de détail">
                            </a>
                            <p class="text-sm truncate">{{ $book->title }}</p>
                        </div>
                        <!-- Icons visibles mobile -->
                        <div class="flex justify-center gap-4 mt-2 text-gray-700 sm:hidden">
                            <a href="{{ route('books.prepareDownload', $book->id) }}"
                                class="text-gray-700 hover:text-black transition">
                                <i class="fa-solid fa-download text-xl"></i>
                            </a>
                            <a href="{{ route('books.show', $book->id) }}"
                                class="text-gray-700 hover:text-black transition">
                                <i class="fa-regular fa-eye text-xl"></i>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach

</div>
