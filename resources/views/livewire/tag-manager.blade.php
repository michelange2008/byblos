<div class="p-4 bg-white rounded shadow-md">
    <h2 class="text-xl font-bold mb-4">Gestion des tags</h2>

    <!-- Formulaire ajout/modification -->
    <div class="flex gap-2 mb-4">
        <input type="text" wire:model="name"
               placeholder="Nom du tag"
               class="border rounded px-2 py-1 w-full">
        <button wire:click="save"
                class="bg-gray-500 text-white hover:bg-gray-800 px-4 py-1 rounded">
            {{ $editingId ? 'Modifier' : 'Ajouter' }}
        </button>
        @if($editingId)
            <button wire:click="cancelEdit"
                    class="bg-gray-400 text-white px-4 py-1 rounded">
                Annuler
            </button>
        @endif
    </div>

    @error('name') <p class="text-red-600 text-sm mb-2">{{ $message }}</p> @enderror

    <!-- Liste des tags -->
    <div>
        <ul class="p-4 bg-white rounded shadow-md text-lg 
            columns-1 sm:columns-2 xl:columns-3 gap-x-12">
            @foreach($tags as $tag)
                <li class="flex justify-between items-center border-b pb-1 break-inside-avoid"
                    x-data="{ confirmDelete: false }">
                    <span>{{ $tag->name }}</span>
                    <div class="flex gap-2">
                        <button wire:click="edit({{ $tag->id }})" title="Modifier ce tag"
                                class="text-gray-600 hover:text-green-600 cursor-pointer">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
    
                        <!-- Bouton suppression avec confirmation -->
                        <button x-show="!confirmDelete" @click="confirmDelete = true" title="Supprimer ce tag"
                                class="text-zinc-600 hover:text-red-600 cursor-pointer">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
    
                        <span x-show="confirmDelete" x-cloak class="flex gap-1">
                            <button @click="$wire.delete({{ $tag->id }}); confirmDelete = false"
                                    class="text-white bg-red-600 px-2 rounded">Confirmer</button>
                            <button @click="confirmDelete = false"
                                    class="text-gray-700 px-2 rounded border">Annuler</button>
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
