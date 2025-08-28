<x-layouts.app :title="'modifier un utilisateur'">
    <div class="container">
        <h1 class="text-xl font-bold mb-4">Modifier l’utilisateur</h1>

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Nom</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-2 w-full">
            </div>

            <div>
                <label class="block">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border p-2 w-full">
            </div>

            <div>
                <label class="block">Rôles</label>
                <select name="roles[]" multiple class="border p-2 w-full">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </div>
</x-layouts.app>
