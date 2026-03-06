<section x-data="{ confirmingDeletion: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }}, loading: false }" class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button @click="confirmingDeletion = true" type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ __('Delete Account') }}
    </button>

    {{-- Modal --}}
    <div x-show="confirmingDeletion" x-cloak x-transition class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" @keydown.escape.window="confirmingDeletion = false">
        <div class="fixed inset-0 transform transition-all" @click="confirmingDeletion = false">
            <div class="absolute inset-0 bg-slate-500 opacity-75"></div>
        </div>

        <div class="mb-6 bg-white rounded-2xl overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto relative">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6" @submit="loading = true">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-slate-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-slate-600">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" placeholder="{{ __('Password') }}" class="mt-1 block w-3/4 border-slate-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm" />
                    @if ($errors->userDeletion->has('password'))
                        <ul class="mt-2 text-sm text-red-600 space-y-1">
                            @foreach ($errors->userDeletion->get('password') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="confirmingDeletion = false" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" :disabled="loading" class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-75 disabled:cursor-not-allowed">
                        <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5 2.686 5 12h4z"></path>
                        </svg>
                        <span x-text="loading ? 'Deleting...' : 'Delete Account'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
