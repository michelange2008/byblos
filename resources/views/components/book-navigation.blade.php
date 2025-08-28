<div
    x-data="{
        books: {{ Js::from($books->pluck('id')) }},
        currentIndex: {{ $books->search(fn($b) => $b->id === $currentBook->id) }},
        sx: null, sy: null,
        animating: false,

        start(e) { this.sx = e.clientX; this.sy = e.clientY },

        end(e) {
            if (this.sx === null) return;
            const dx = e.clientX - this.sx;
            const dy = e.clientY - this.sy;
            this.sx = this.sy = null;

            // Seulement un vrai swipe horizontal (>40px et plus horizontal que vertical)
            if (Math.abs(dx) < 40 || Math.abs(dx) < Math.abs(dy)) return;

            if (dx < 0) this.swipe('left');
            else this.swipe('right');
        },

        swipe(direction) {
            if (this.animating) return;
            this.animating = true;

            const container = this.$refs.container;
            container.classList.remove('swipe-left', 'swipe-right');

            if (direction === 'left') {
                container.classList.add('swipe-left');
                setTimeout(() => this.nextBook(), 250);
            } else {
                container.classList.add('swipe-right');
                setTimeout(() => this.prevBook(), 250);
            }
        },

        goTo(index) {
            if (index < 0 || index >= this.books.length) return;
            window.location.href = '/books/' + this.books[index];
        },

        nextBook() { this.goTo(this.currentIndex + 1) },
        prevBook() { this.goTo(this.currentIndex - 1) },
    }"

    @pointerdown.window.passive="start($event)"
    @pointerup.window.passive="end($event)"
    @touchstart.window.passive="start($event.touches[0])"
    @touchend.window.passive="end($event.changedTouches[0])"
    style="touch-action: pan-y;"
>
    <div x-ref="container" class="transition-transform duration-200">
        <!-- boutons navigation desktop -->
        <div class="flex justify-between">
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
</div>

<style>
.swipe-left { transform: translateX(-80px); opacity: 0.6; }
.swipe-right { transform: translateX(80px); opacity: 0.6; }
</style>
