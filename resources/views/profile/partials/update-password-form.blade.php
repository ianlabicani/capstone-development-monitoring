<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    {{-- Success Alert --}}
    @if (session('status') === 'password-updated')
        <div class="mt-6 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                <div>
                    <h3 class="font-semibold text-emerald-900">{{ __('Password Updated') }}</h3>
                    <p class="mt-1 text-sm text-emerald-700">{{ __('Your password has been changed successfully.') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" x-data="{ loading: false }" @submit="loading = true">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-slate-700">{{ __('Current Password') }}</label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
            />
            @if ($errors->updatePassword->has('current_password'))
                <div class="mt-2 rounded-lg bg-red-50 p-3 ring-1 ring-red-200">
                    @foreach ($errors->updatePassword->get('current_password') as $message)
                        <p class="text-sm text-red-700 font-medium">{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- New Password --}}
        <div>
            <label for="update_password_password" class="block font-medium text-sm text-slate-700">{{ __('New Password') }}</label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
            />
            @if ($errors->updatePassword->has('password'))
                <div class="mt-2 rounded-lg bg-red-50 p-3 ring-1 ring-red-200">
                    @foreach ($errors->updatePassword->get('password') as $message)
                        <p class="text-sm text-red-700 font-medium">{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-slate-700">{{ __('Confirm Password') }}</label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
            />
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="mt-2 rounded-lg bg-red-50 p-3 ring-1 ring-red-200">
                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                        <p class="text-sm text-red-700 font-medium">{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            :disabled="loading"
            class="inline-flex items-center px-6 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300 transition ease-in-out duration-150 disabled:opacity-75 disabled:cursor-not-allowed"
        >
            <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5 2.686 5 12h4z"></path>
            </svg>
            <span x-text="loading ? 'Updating...' : 'Update Password'"></span>
        </button>
    </form>
</section>
