@props([
    'name',
    'title' => 'Confirm Action',
    'message' => 'Are you sure?',
    'confirmText' => 'Confirm',
    'confirmClass' => 'bg-red-600 hover:bg-red-700',
    'cancelText' => 'Cancel',
])

<x-modal :name="$name" :maxWidth="$attributes->get('maxWidth', 'md')">
    <div class="px-6 py-4">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-3xl text-yellow-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900">
                    {{ $title }}
                </h3>
                <p class="mt-2 text-sm text-slate-600">
                    {{ $message }}
                </p>
            </div>
        </div>
    </div>

    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
        <button
            type="button"
            @click="show = false"
            class="inline-flex items-center px-4 py-2 bg-slate-200 text-slate-800 rounded-lg hover:bg-slate-300 font-medium transition"
        >
            {{ $cancelText }}
        </button>
        <button
            type="button"
            x-data="{ confirming: false }"
            :disabled="confirming"
            @click="confirming = true; show = false; $dispatch('confirm-action', '{{ $name }}')"
            class="inline-flex items-center px-4 py-2 {{ $confirmClass }} text-white rounded-lg font-medium transition disabled:opacity-75 disabled:cursor-not-allowed"
        >
            <svg x-show="confirming" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5 2.686 5 12h4z"></path>
            </svg>
            <span x-text="confirming ? 'Processing...' : '{{ $confirmText }}'"></span>
        </button>
    </div>
</x-modal>
