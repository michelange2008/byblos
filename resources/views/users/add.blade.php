<x-layouts.app :title="'Ajouter un utilisateur'">
    <div class="max-w-md mx-auto py-10 px-6 sm:px-8 lg:px-10 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Ajouter un nouvel utilisateur</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5 space-y-1">
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
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                              focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-gray-900
                              placeholder-gray-400 sm:text-base" placeholder="Ex: Michel Bouy" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                              focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-gray-900
                              placeholder-gray-400 sm:text-base" placeholder="Ex: michel@example.com" required>
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" id="password"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                              focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-gray-900
                              placeholder-gray-400 sm:text-base" placeholder="••••••••" required>
            </div>

            <!-- Retaper le mot de passe -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Retaper le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                              focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-gray-900
                              placeholder-gray-400 sm:text-base" placeholder="••••••••" required>
            </div>

            <!-- Boutons -->
            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <button type="submit"
                        class="flex-1 px-6 py-3 bg-teal-400 hover:text-white font-medium rounded-lg 
                               hover:bg-teal-800 transition">
                    Ajouter
                </button>
                <a href="{{ route('books.index') }}"
                   class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg 
                          hover:bg-gray-300 text-center transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>

