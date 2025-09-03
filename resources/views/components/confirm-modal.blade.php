@props([
    'title' => 'Confirmation',
    'message' => 'Voulez-vous vraiment effectuer cette action ?',
    'confirmText' => 'Confirmer',
    'cancelText' => 'Annuler',
    'onConfirm' => null, // callback (souvent "submit le formulaire")
])

<div 
    x-data="{ open: false }"
    x-on:open-confirm-modal.window="open = true; $refs.action = $event.detail?.onConfirm"
    x-show="open"
    x-cloak
    class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
>
    <div @click.away="open = false" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg max-w-md w-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ $title }}</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">{{ $message }}</p>

        <div class="flex justify-end gap-2">
            <button type="button" @click="open = false" class="btn-secondary">
                {{ $cancelText }}
            </button>

            <button 
                type="button" 
                class="btn-danger"
                x-ref="action"
                @click="
                    if ($refs.action && typeof $refs.action === 'function') { 
                        $refs.action(); 
                    }
                    open = false
                "
            >
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>
