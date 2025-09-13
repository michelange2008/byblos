<x-layouts.app :title="'Modifier le commentaire'">

    <x-flash />

    <div class="max-w-3xl mx-auto p-4 bg-white shadow rounded dark:bg-gray-600">

        <h1 class="text-2xl font-bold mb-4">Modifier votre commentaire</h1>

        <form action="{{ route('comments.update', $comment) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="content" class="block font-medium mb-1">Commentaire :</label>
                <textarea id="content" name="content" rows="6"
                    class="w-full border rounded px-3 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 @error('content') border-red-500 @enderror">{{ old('content', $comment->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-left gap-2 items-center">
                <x-form-button>Enregistrer</x-form-button>
                <x-cancel-button href="{{ route('books.show', $comment->book) }}">Annuler</x-cancel-button>

            </div>
        </form>

    </div>

</x-layouts.app>
