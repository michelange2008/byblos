<!-- resources/views/admin/user-create.blade.php -->

<x-layouts.app :title="'Ajouter un utilisateur'">
    <div class="max-w-lg mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Ajouter un nouvel utilisateur</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nom complet -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                              focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                              focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                              focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <!-- Retaper le mot de passe -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Retaper le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                              focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <!-- Bouton -->
            <div class="flex gap-4">
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Ajouter l'utilisateur
                </button>
                <a href="{{ route('books.index') }}"
                   class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
