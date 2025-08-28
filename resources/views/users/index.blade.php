<x-layouts.app :title="'Liste de utilisateurs'">
    <div class="container">
        <h1 class="text-xl font-bold mb-4">Gestion des utilisateurs</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Rôles</th>
                    <th class="px-4 py-2">Livres apportés</th>
                    <th class="px-4 py-2">Livres téléchargés</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            {{ $user->roles->pluck('name')->join(', ') }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $user->books_added_count }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->downloads_count }}</td>
                        <td class="px-4 py-2 flex gap-2 justify-center">
                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600">✏️</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
