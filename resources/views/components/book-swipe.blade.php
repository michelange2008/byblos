<div x-data="bookSwipe()" 
     @touchstart="handleTouchStart($event)" 
     @touchend="handleTouchEnd($event)" 
     class="overflow-hidden">

    <div 
        x-ref="bookContainer"
        x-bind:class="animating ? 'translate-x-0 opacity-100 scale-100' : ''"
        x-transition:enter="transition-transform duration-700 ease-out"
        x-transition:enter-start="translate-x-full opacity-0 scale-90"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100"
        x-transition:leave="transition-transform duration-700 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100 scale-100"
        x-transition:leave-end="-translate-x-full opacity-0 scale-90"
    >
        {{ $slot }}
    </div>
</div>

<script>
function bookSwipe() {
    return {
        books: {{ Js::from($books->pluck('id')) }},
        currentIndex: {{ $books->search(fn($b) => $b->id === $currentBook->id) }},
        startX: 0,
        endX: 0,
        animating: false,

        nextBook() {
            if (this.currentIndex < this.books.length - 1) {
                this.animating = true
                setTimeout(() => {
                    window.location.href = '/books/' + this.books[this.currentIndex + 1];
                }, 250)
            }
        },
        prevBook() {
            if (this.currentIndex > 0) {
                this.animating = true
                setTimeout(() => {
                    window.location.href = '/books/' + this.books[this.currentIndex - 1];
                }, 250)
            }
        },
        handleTouchStart(event) {
            this.startX = event.touches[0].clientX
        },
        handleTouchEnd(event) {
            this.endX = event.changedTouches[0].clientX
            let distance = this.startX - this.endX
            if (distance > 50) this.nextBook()
            if (distance < -50) this.prevBook()
        }
    }
}
</script>
