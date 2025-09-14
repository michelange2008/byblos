@props([
    'action' => null,
    'method' => 'DELETE',
    'class' => 'btn-danger',
    'title' => 'Confirmation',
    'message' => 'Voulez-vous vraiment continuer ?',
    'confirmText' => 'Confirmer',
    'cancelText' => 'Annuler',
    'icon' => 'trash',
])

<div x-data="{ open: false }" class="inline-block">
    <!-- Bouton déclencheur -->
    <button type="button" @click="open = true" class="{{ $class }}">
        @if ($icon)
            <x-flux::icon :icon="$icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
    </button>

    <!-- Fenêtre modale -->
    <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        @click.self="open = false">

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-bold mb-2">{{ $title }}</h2>
            <p class="mb-4">{{ $message }}</p>

            <div class="flex justify-end gap-2">
                <button type="button" class="btn-secondary" @click="open = false">
                    {{ $cancelText }}
                </button>

                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method($method)
                    <button type="submit" class="btn-danger">
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
