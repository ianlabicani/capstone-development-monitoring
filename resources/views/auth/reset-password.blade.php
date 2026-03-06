<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gradient-to-br from-slate-50 to-orange-50">
        <div class="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            {{-- Security Section --}}
            <div class="md:block hidden">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-2xl text-orange-600"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Create a New Password</h2>
                    <p class="text-lg text-slate-600 mb-6">Choose a strong password to protect your account and keep your capstone team's data secure.</p>
                </div>
                <div class="bg-orange-50 rounded-lg p-6 border border-orange-200">
                    <h4 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-check-circle text-orange-600"></i>
                        Password Tips
                    </h4>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2">
                            <span class="text-orange-600">✓</span>
                            <span>At least 8 characters long</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-orange-600">✓</span>
                            <span>Mix of uppercase and lowercase letters</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-orange-600">✓</span>
                            <span>Include numbers and special characters</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-orange-600">✓</span>
                            <span>Avoid using personal information</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Reset Form --}}
            <div class="w-full bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-900 text-center mb-6">{{ __('Reset Password') }}</h2>

            <form method="POST" action="{{ route('password.store') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-slate-700">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" :disabled="loading"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 transition disabled:opacity-75 disabled:cursor-not-allowed">
                        <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5 2.686 5 12h4z"></path>
                        </svg>
                        <span x-text="loading ? 'Resetting...' : 'Reset Password'"></span>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-guest-layout>
