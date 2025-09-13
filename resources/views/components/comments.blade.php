<div class="mt-6">
    <h2 class="text-lg font-bold mb-2 text-gray-500">Commentaires</h2>

    {{-- Liste des commentaires --}}
    <div class="my-4 space-y-4 p-3 border rounded">
        @foreach ($book->comments()->latest()->get() as $comment)
            <div class="">
                <p>{{ $comment->content }}</p>
                <p class="text-sm text-gray-600 ml-3">
                    {{ $comment->user->name }}
                    — {{ $comment->created_at->diffForHumans() }}
                </p>

            </div>
            <div>

                {{-- Actions si autorisé --}}
                <div class="mt-2 flex space-x-2">
                    @can('update', $comment)
                        <x-link-button href="{{ route('comments.edit', $comment) }}" class="btn-secondary" icon="pencil"
                            title="Modifier le commentaire"></x-link-button>
                    @endcan

                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                            onsubmit="return confirm('Supprimer ce commentaire ?')" title="Supprimer le commentaire">
                            @csrf
                            @method('DELETE')
                            <x-confirm-button></x-confirm-button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
</div>
{{-- Formulaire d’ajout --}}
<form action="{{ route('comments.store', $book) }}" method="POST">
    @csrf
    <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Écrire un commentaire..."></textarea>

    <x-form-button class="btn-primary my-2" icon="pencil">Publier</x-form-button>

</form>
