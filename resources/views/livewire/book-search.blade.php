<div class="max-w-3xl mx-auto p-4">
    <!-- Barre de recherche -->
    <div class="relative mb-4">
        <input type="text" 
               wire:model.live="query"
               placeholder="Rechercher par titre, auteur, tag..."
               class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-300" />
        
        <!-- Loader recherche -->
        <div wire:loading wire:target="query" class="absolute right-3 top-2.5">
            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>
    </div>

    <!-- Liste des livres -->
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
                             title="{{ $book->author.' - '.$book->title." (".$book->lastName.")" }}">
                    </a>

                    <!-- Overlay (desktop only) -->
                    <div class="absolute inset-0 bg-black/50 rounded items-center justify-center gap-6
                                opacity-0 group-hover:opacity-100 transition duration-300
                                hidden sm:flex"
                                title="{{ $book->author.' - '.$book->title." (".$book->lastName.")" }}">
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
                </div>

            </div>
            @endforeach
        </div>
    </div>


    <!-- Loader scroll infini -->
    <div wire:loading wire:target="loadMore" class="flex justify-center mt-6">
        <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
    </div>

    <!-- Trigger scroll infini -->
    @if($this->hasMore)
        <div
            x-data="{
                observe() {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('loadMore')
                            }
                        })
                    }, { threshold: 0.5 })
                    observer.observe(this.$el)
                }
            }"
            x-init="observe"
            class="h-10">
        </div>
    @endif
</div>
