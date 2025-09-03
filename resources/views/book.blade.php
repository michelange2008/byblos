<x-layouts.app :title="$book->title">

    <x-flash />

    <x-book-swipe :books="$books" :current-book="$book">

        <div class="sm:grid sm:grid-cols-[2fr_3fr] lg:gap-3 xl:gap-4">


            <p class="text-gray-500 underline mb-2 content-center py-1">
                <a href="{{ route('books.index') }}"><i class="fa-solid fa-caret-left"></i>&nbsp;Retour à la
                    bibliothèque</a>
            </p>

            <div class="mb-2">
                <x-book-navigation :books="$books" :current-book="$book" />

            </div>

            <div class="flex flex-col mb-2 md:mb-0">

                <h1 class="font-bold text-3xl">{{ $book->title }}</h1>
                <h2 class="font-bold">{{ $book->author }}</h2>
            </div>

            <div></div>

            <div class="flex justify-center">
                <img class="border-2" src="{{ asset('storage/' . $book->cover) }}" alt="">
            </div>

            <div class="flex flex-col gap-5 text-justify pt-2 px-8 justify-between">

                <p>{{ $book->description }}</p>

                <div class="flex flex-row justify-between items-center">

                    <x-button :href="route('books.prepareDownload', $book)" class="primary" icon="flux::icon.download">
                        Télécharger
                    </x-button>

                    <div class="flex gap-2">

                        <x-link-button :href="route('books.edit', $book)" class="secondary" icon="flux::icon.pen">
                            Modifier
                        </x-link-button>

                        @if (($book->getOwnerAttribute()?->id ?? null) === auth()->id() || Auth::user()->hasRole('admin'))
                            <x-confirm-button :action="route('books.destroy', $book)" title="Supprimer le livre" icon="flux::icon.trash"
                                message="Voulez-vous vraiment supprimer ce livre ?">
                                Supprimer
                            </x-confirm-button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-book-swipe>

    <livewire:book-tags :book="$book" />

    <x-comments :book="$book" />

</x-layouts.app>
