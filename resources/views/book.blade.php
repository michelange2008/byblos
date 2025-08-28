<x-layouts.app :title="$book->title">

    <x-flash />

    <div class="sm:grid sm:grid-cols-[2fr_3fr] lg:gap-3 xl:gap-4">


        <p class="text-gray-500 underline mb-2 content-center py-1">
            <a href="{{ route('books.index') }}"><i class="fa-solid fa-caret-left"></i>&nbsp;Retour à la bibliothèque</a>
        </p>

        <div class="mb-2">
            <x-book-navigation :books="$books" :current-book="$book" />

        </div>

        <div class="flex flex-col">

            <h1 class="font-bold text-3xl">{{ $book->title }}</h1>
            <h2 class="font-bold">{{ $book->author }}</h2>
        </div>

        <div></div>

        <div class="flex justify-center">
            <img class="border-2" src="{{ asset('storage/' . $book->cover) }}" alt="">
        </div>

        <div class="flex flex-col gap-5 text-justify pt-2 px-8 justify-between">

            <p>{{ $book->description }}</p>

            <div class="flex flex-row justify-between items-center text-sm ">
                <a href="{{ route('books.prepareDownload', $book) }}"
                    class="flex gap-1 py-2 px-5 border rounded-sm bg-gray-100 hover:bg-gray-200">
                    <x-flux::icon.download/>Télécharger
                </a>

                <div class="flex gap-2">
                    <a href="{{ route('books.edit', $book) }}"
                        class="inline-block px-5 py-2 border rounded-sm hover:bg-gray-200">
                        Modifier
                    </a>

                    @if (($book->getOwnerAttribute()?->id ?? null) === auth()->id() || Auth::user()->hasRole('admin'))
                        <form action="{{ route('books.destroy', $book) }}" method="POST" x-data="{ open: false }">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="px-5 py-2 text-red-800 border rounded hover:bg-red-700 hover:text-white"
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
        </div>
    </div>

    <livewire:book-tags :book="$book" />


</x-layouts.app>
