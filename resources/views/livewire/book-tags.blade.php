<div class="mt-4 p-5">
    <div class="mb-4 pb-4 border-b">
        <p class="text-sm text-gray-500">
            Etiquettes du livre (cliquer pour supprimer)
        </p>
        <!-- Liste des tags -->
        <div class="flex flex-wrap gap-2 m-3">
            @foreach ($tags as $tag)
                @if ($book->tags->contains($tag->id))
                    <span wire:click="toggleTag({{ $tag->id }})"
                        class="cursor-pointer px-3 py-1 rounded text-sm transition
            bg-gray-500 text-white hover:bg-gray-700">
                        {{ $tag->name }}
                    </span>
                @endif
            @endforeach
        </div>
    </div>
    <div>
        <p class="text-sm text-gray-500">
            Etiquettes disponibles (cliquer pour ajouter au livre)
        </p>
        <div class="flex flex-wrap gap-2 m-3">
            @foreach ($tags as $tag)
                @if (!$book->tags->contains($tag->id))
                    <span wire:click="toggleTag({{ $tag->id }})"
                        class="cursor-pointer px-3 py-1 rounded text-sm transition
                                    bg-gray-100 text-gray-600 hover:bg-gray-300">
                        {{ $tag->name }}
                    </span>
                @endif
            @endforeach
        </div>
    </div>

</div>
