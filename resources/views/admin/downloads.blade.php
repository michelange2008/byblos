<x-layouts.app title="Téléchargements">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Historique des téléchargements</h1>

        <table class="table-auto w-full border-collapse border border-gray-300 shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Utilisateur</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Livre</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Statut</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Message</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($downloads as $download)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $download->user?->name ?? 'Inconnu' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $download->book?->title ?? 'Livre introuvable' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $download->downloaded_at->translatedFormat('d F Y H:i') }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            @if ($download->status === 'success')
                                <span class="text-green-600 text-xl">✅</span>
                            @else
                                <span class="text-red-600 text-xl">❌</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                            {{ $download->message ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border border-gray-300 px-4 py-4 text-center text-gray-500">
                            Aucun téléchargement enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $downloads->links() }}
        </div>
    </div>
</x-layouts.app>
