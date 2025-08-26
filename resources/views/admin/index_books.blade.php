<x-layouts.app title="Livres par utilisateur">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Livres par utilisateur</h1>

        {{-- Livres sans utilisateur --}}
        @php
            $orphanBooks = $books->filter(fn($book) => !$book->owner);
        @endphp
        @if ($orphanBooks->isNotEmpty())
            <div class="mb-6 border rounded shadow-sm">
                <button type="button"
                    class="w-full text-left px-4 py-2 bg-red-200 hover:bg-red-300 font-semibold flex justify-between items-center"
                    data-toggle="books-orphan">
                    Livres sans utilisateur ({{ $books->count() }})
                    <span class="ml-2">▼</span>
                </button>
                <div id="books-orphan" class="hidden p-4">
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">Titre</th>
                                <th class="border px-4 py-2">Auteur</th>
                                <th class="border px-4 py-2">Date d’ajout</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orphanBooks as $book)
                                <tr>
                                    <td class="border px-4 py-2">{{ $book->title }}</td>
                                    <td class="border px-4 py-2">{{ $book->author }}</td>
                                    <td class="border px-4 py-2">
                                        {{ $book->created_at->locale('fr')->isoFormat('D MMMM YYYY') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Livres par utilisateur --}}
        @foreach ($users as $user)
            <div class="mb-4 border rounded shadow-sm">
                <button type="button"
                    class="w-full text-left px-4 py-2 bg-gray-200 hover:bg-gray-300 font-semibold flex justify-between items-center"
                    data-toggle="books-{{ $user->id }}">
                    {{ $user->name }} ({{ $user->books->count() }})
                    <span class="ml-2">▼</span>
                </button>

                <div id="books-{{ $user->id }}" class="hidden p-4">
                    @if ($user->books->isEmpty())
                        <p class="text-gray-500">Aucun livre ajouté par cet utilisateur.</p>
                    @else
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 py-2">Titre</th>
                                    <th class="border px-4 py-2">Auteur</th>
                                    <th class="border px-4 py-2">Date d’ajout</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->books as $book)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $book->title }}</td>
                                        <td class="border px-4 py-2">{{ $book->author }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $book->created_at->locale('fr')->isoFormat('D MMMM YYYY') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionne tous les boutons qui contrôlent les sections
            const buttons = document.querySelectorAll('button[data-toggle]');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.dataset.toggle;
                    const target = document.getElementById(targetId);

                    // Ferme tous les autres
                    buttons.forEach(btn => {
                        const otherTarget = document.getElementById(btn.dataset.toggle);
                        if (otherTarget !== target) {
                            otherTarget.classList.add('hidden');
                        }
                    });

                    // Toggle l'élément actuel
                    target.classList.toggle('hidden');
                });
            });
        });
    </script>
</x-layouts.app>
