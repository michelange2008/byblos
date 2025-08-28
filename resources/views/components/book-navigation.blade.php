<div
    x-data="bookNavigation({{ Js::from($books->pluck('id')) }}, {{ $books->search(fn($b) => $b->id === $currentBook->id) }})"
    @pointerdown.window.passive="start($event)"
    @pointerup.window.passive="end($event)"
    @touchstart.window.passive="start($event.touches[0])"
    @touchend.window.passive="end($event.changedTouches[0])"
    @keydown.window="
        if ($event.key === 'ArrowRight') nextBook();
        if ($event.key === 'ArrowLeft') prevBook();
    "
    style="touch-action: pan-y;"
    class="overflow-hidden"
>
    <div x-ref="container" class="transition-transform duration-300 ease-in-out">
        <!-- Navigation Desktop -->
        <div class="flex justify-between mb-2">
            <!-- Bouton précédent -->
            <button @click="prevBook()"
                    :disabled="currentIndex === 0"
                    :class="currentIndex === 0 ? 'opacity-0 pointer-events-none' : 'opacity-100'"
                    class="hidden md:inline-block px-3 py-1 text-sm hover:underline cursor-pointer text-gray-500">
                ← Livre précédent
            </button>

            <!-- Bouton suivant -->
            <button @click="nextBook()"
                    :disabled="currentIndex === books.length - 1"
                    :class="currentIndex === books.length - 1 ? 'opacity-0 pointer-events-none' : 'opacity-100'"
                    class="hidden md:inline-block px-3 py-1 text-sm hover:underline cursor-pointer text-gray-500">
                Livre suivant →
            </button>
        </div>

        <!-- Contenu du livre -->
        <div
            x-bind:class="animating ? (swipeDirection === 'left' ? 'slide-left' : 'slide-right') : ''"
            x-transition:enter="transition-transform duration-300 ease-out"
            x-transition:enter-start="translate-x-full opacity-0 scale-90"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transition-transform duration-300 ease-in"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="-translate-x-full opacity-0 scale-90"
        >
            {{ $slot }}
        </div>
    </div>
</div>

<script>
function bookNavigation(books, currentIndex) {
    return {
        books,
        currentIndex,
        animating: false,
        swipeDirection: null,
        startX: null,
        startY: null,

        start(e) { 
            this.startX = e.clientX;
            this.startY = e.clientY;
        },

        end(e) {
            if (this.startX === null) return;

            const dx = e.clientX - this.startX;
            const dy = e.clientY - this.startY;
            this.startX = this.startY = null;

            // Seulement swipe horizontal
            if (Math.abs(dx) < 40 || Math.abs(dx) < Math.abs(dy)) return;

            if (dx < 0) this.swipe('left');
            else this.swipe('right');
        },

        swipe(direction) {
            if (this.animating) return;
            this.animating = true;
            this.swipeDirection = direction;

            setTimeout(() => {
                if (direction === 'left') this.nextBook();
                else this.prevBook();
                this.animating = false;
            }, 300);
        },

        goTo(index) {
            if (index < 0 || index >= this.books.length) return;
            window.location.href = '/books/' + this.books[index];
        },

        nextBook() { this.goTo(this.currentIndex + 1) },
        prevBook() { this.goTo(this.currentIndex - 1) },
    }
}
</script>

<style>
.slide-left  { transform: translateX(-100vw); opacity: 0; }
.slide-right { transform: translateX(100vw); opacity: 0; }
</style>
