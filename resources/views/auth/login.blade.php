<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gradient-to-br from-slate-50 to-orange-50">
        <div class="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            {{-- Welcome Section --}}
            <div class="md:block hidden">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-code text-2xl text-orange-600"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Capstone<span class="text-orange-600">Monitor</span></h2>
                    <p class="text-lg text-slate-600 mb-6">Track your team's development progress with real-time GitHub activity monitoring.</p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fas fa-check text-orange-600 text-xs"></i>
                        </div>
                        <p class="text-slate-700 text-sm"><span class="font-semibold">Automatic Tracking:</span> GitHub activity synced in real-time</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fas fa-check text-orange-600 text-xs"></i>
                        </div>
                        <p class="text-slate-700 text-sm"><span class="font-semibold">Team Dashboards:</span> Monitor commits, branches, and PRs</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fas fa-check text-orange-600 text-xs"></i>
                        </div>
                        <p class="text-slate-700 text-sm"><span class="font-semibold">Full Transparency:</span> Every contribution is visible</p>
                    </div>
                </div>
            </div>

            {{-- Login Form --}}
            <div class="w-full bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-900 text-center mb-6">{{ __('Log in') }}</h2>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-emerald-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-slate-700">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="mt-4 flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-slate-300 text-orange-600 shadow-sm focus:ring-orange-500">
                    <label for="remember_me" class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</label>
                </div>

                <div class="mt-6">
                    <button type="submit" :disabled="loading"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 transition disabled:opacity-75 disabled:cursor-not-allowed">
                        <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5 2.686 5 12h4z"></path>
                        </svg>
                        <span x-text="loading ? 'Logging in...' : 'Log in'"></span>
                    </button>
                </div>

                <div class="mt-4 flex items-center justify-between text-sm">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-orange-600 hover:text-orange-700">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-slate-600 hover:text-slate-900">
                            {{ __('Create an account') }}
                        </a>
                    @endif
                </div>
            </form>
            </div>
        </div>
    </div>
</x-guest-layout>
