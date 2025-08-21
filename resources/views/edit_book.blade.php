<x-layouts.app :title="'Modifier : '.$book->title">
    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Modifier le livre : {{ $book->title }}</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Auteur -->
            <div>
                <label for="author" class="block text-sm font-medium text-gray-700">Auteur</label>
                <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="5"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $book->description) }}</textarea>
            </div>

            <!-- Cover -->
            <div>
                <label for="cover" class="block text-sm font-medium text-gray-700">Couverture</label>
                <input type="file" name="cover" id="cover"
                       class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                              file:rounded file:border-0 file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @if ($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="cover" class="mt-4 w-40 border rounded">
                @endif
            </div>

            <!-- Boutons -->
            <div class="flex gap-4">
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Enregistrer
                </button>
                <a href="{{ route('books.show', $book) }}"
                   class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
