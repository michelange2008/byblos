<x-layouts.app :title="$book->title">

    <x-flash />

    <div class="flex flex-col gap-2 xl:w-4/5 mr-5">

        <p class="text-gray-500 underline mb-2">
            <a href="{{ route('books.index') }}"><i class="fa-solid fa-caret-left"></i>&nbsp;Retour à la bibliothèque</a>
        </p>

        <h1 class="font-bold text-3xl">{{ $book->title }}</h1>
        <h2 class="font-bold">{{ $book->author }}</h2>

        <div class="flex flex-col md:flex-row gap-5">
            <div class="basis-1/3">
                <img class="border-2" src="{{ asset('storage/' . $book->cover) }}" alt="">
            </div>

            <div class="basis-2/3 flex flex-col gap-5 text-justify py-2 px-8">

                <p>{{ $book->description }}</p>

                <div class="flex justify-between items-center">
                    <a href="{{ route('books.prepareDownload', $book) }}"
                        class="inline-block m-auto px-5 py-1.5 border text-sm rounded-sm hover:bg-gray-200">
                        Télécharger
                    </a>

                    <div class="flex gap-2">
                        <a href="{{ route('books.edit', $book) }}"
                            class="inline-block px-5 py-1.5 border text-sm rounded-sm hover:bg-gray-200">
                            Modifier
                        </a>

                        @if (($book->getOwnerAttribute()?->id ?? null) === auth()->id() || Auth::user()->hasRole('admin'))
                            <form action="{{ route('books.destroy', $book) }}" method="POST" x-data="{ open: false }">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-4 py-2 text-red-800 border rounded"
                                    @click="open = true">Supprimer</button>

                                <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black/50">
                                    <div class="bg-white p-6 rounded shadow-lg">
                                        <p class="mb-4">Voulez-vous vraiment supprimer ce livre ?</p>
                                        <div class="flex justify-end gap-2">
                                            <button @click="open = false" type="button"
                                                class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
                                            <button @click="$el.closest('form').submit()" type="button"
                                                class="px-4 py-2 bg-red-600 text-white rounded">Supprimer</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Navigation livres -->
                <div x-data="{
                    books: {{ Js::from($books->pluck('id')) }},
                    currentIndex: {{ $books->search(fn($b) => $b->id === $book->id) }},
                    nextBook() {
                        if (this.currentIndex < this.books.length - 1) {
                            window.location.href = '/books/' + this.books[this.currentIndex + 1];
                        }
                    },
                    prevBook() {
                        if (this.currentIndex > 0) {
                            window.location.href = '/books/' + this.books[this.currentIndex - 1];
                        }
                    },
                    startX: 0,
                    endX: 0,
                    handleTouchStart(event) { this.startX = event.touches[0].clientX },
                    handleTouchEnd(event) {
                        this.endX = event.changedTouches[0].clientX;
                        if (this.startX - this.endX > 50) this.nextBook();
                        if (this.endX - this.startX > 50) this.prevBook();
                    }
                }" @touchstart="handleTouchStart($event)" @touchend="handleTouchEnd($event)">
                    <!-- boutons navigation desktop -->
                    <div class="flex justify-between mt-6">
                        <button @click="prevBook()" class="hidden md:inline-block px-3 py-1 bg-gray-200 rounded"
                            :disabled="currentIndex === 0">
                            ← Livre précédent
                        </button>

                        <button @click="nextBook()" class="hidden md:inline-block px-3 py-1 bg-gray-200 rounded"
                            :disabled="currentIndex === books.length - 1">
                            Livre suivant →
                        </button>
                    </div>
                </div>
                <div>
                </div>

            </div>
        </div>

        <livewire:book-tags :book="$book" />
    </div>

</x-layouts.app>
