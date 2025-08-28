<div x-data="{
    books: {{ Js::from($books->pluck('id')) }},
    currentIndex: {{ $books->search(fn($b) => $b->id === $currentBook->id) }},
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
        if (this.startX - this.endX > 50) {
            this.nextBook();
        }
        if (this.endX - this.startX > 50) {
            this.prevBook();
        }
    }
}" 
class="w-full h-full" 
@touchstart.window="handleTouchStart($event)" 
@touchend.window="handleTouchEnd($event)">

    <!-- boutons navigation desktop -->
    <div class="flex justify-between mt-6">
        <button @click="prevBook()" 
                class="hidden md:inline-block px-3 py-1 bg-gray-200 rounded"
                :disabled="currentIndex === 0">
            ← Livre précédent
        </button>

        <button @click="nextBook()" 
                class="hidden md:inline-block px-3 py-1 bg-gray-200 rounded"
                :disabled="currentIndex === books.length - 1">
            Livre suivant →
        </button>
    </div>
</div>
