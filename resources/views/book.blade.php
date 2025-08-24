<x-layouts.app : title="{{ $book->title }}">
    <div class="flex flex-col gap-2 xl:w-4/5 mr-5">
        <div class="">
            <p class="text-gray-500 underline mb-2">
                <a href="{{ route('books.index') }}"><i class="fa-solid fa-caret-left"></i>&nbsp;Retour à la
                    bibliothèque</a>
            </p>
            <h1 class="font-bold text-3xl">
                {{ $book->title }}
            </h1>
            <h1 class="font-bold">{{ $book->author }} </h1>
        </div>
        <div class="flex flex-col md:flex-row gap-5">
            <div class="basis-1/3">
                <img class="border-2" src="{{ asset('storage/' . $book->cover) }}" alt="">
            </div>
            <div class="basis-2/3 flex flex-col gap-5 text-justify py-2 px-8">
                <p>{{ $book->description }} </p>

                <div class="flex flex-row justify-between">
                    <div>
                        <a href="{{ route('books.download', $book) }}"
                            class="inline-block m-auto px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:bg-gray-200 hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Télécharger
                        </a>
                    </div>
                    <div class="flex flex-row gap-2">
                        <a href="{{ route('books.edit', $book) }}"
                            class="inline-block m-auto px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:bg-gray-200 hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Modifier
                        </a>
                        <form action="{{ route('books.destroy', $book) }}" method="GET" x-data="{ open: false }">
                            @csrf
                            @method('GET')

                            <button type="button"
                                class="inline-block m-auto px-5 py-1.5 text-red-800 dark:text-[#EDEDEC] border-[#19140035] hover:bg-red-800 hover:text-white hover:border-[#1915014a] border dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                                @click="open = true">
                                Supprimer
                            </button>

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

                    </div>
                </div>
            </div>
        </div>
        <livewire:book-tags :book="$book" />
    </div>


</x-layouts.app>
