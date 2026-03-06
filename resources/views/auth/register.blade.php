<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-slate-50">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
            <h2 class="text-2xl font-bold text-slate-900 text-center mb-6">{{ __('Create an account') }}</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">{{ __('Name') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-slate-700">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
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
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 transition">
                        {{ __('Register') }}
                    </button>
                </div>

                <div class="mt-4 text-center text-sm">
                    <span class="text-slate-600">{{ __('Already have an account?') }}</span>
                    <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium">{{ __('Log in') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
