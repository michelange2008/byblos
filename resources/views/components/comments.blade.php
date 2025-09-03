<div class="mt-6">
    <h2 class="text-lg font-bold mb-2 text-gray-500">Commentaires</h2>

    {{-- Formulaire d’ajout --}}
    <form action="{{ route('comments.store', $book) }}" method="POST">
        @csrf
        <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Écrire un commentaire..."></textarea>
        {{-- <button type="submit" class="mt-2 text-teal-800 dark:text-teal-400 text-sm  px-3 py-1 border rounded">Publier</button> --}}
        <x-form-button class="primary">Publier</x-form-button>

    </form>

    {{-- Liste des commentaires --}}
    <div class="mt-4 space-y-4">
        @foreach($book->comments()->latest()->get() as $comment)
            <div class="p-3 border rounded">
                <p class="text-sm text-gray-600">
                    <strong>{{ $comment->user->name }}</strong>
                    — {{ $comment->created_at->diffForHumans() }}
                </p>
                <p>{{ $comment->content }}</p>

                {{-- Actions si autorisé --}}
                <div class="mt-2 flex space-x-2">
                    @can('update', $comment)
                        <x-link-button href="{{ route('comments.edit', $comment) }}" class="secondary" icon="icon.pen">Modifier</x-link-button>
                        {{-- <a href="{{ route('comments.edit', $comment) }}" class="text-blue-500">Modifier</a> --}}
                    @endcan

                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')">
                            @csrf
                            @method('DELETE')
                            {{-- <button class="text-red-500">Supprimer</button> --}}
                            <x-confirm-button icon="icon.trash">Supprimer</x-confirm-button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
</div>
