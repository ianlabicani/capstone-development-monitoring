<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gradient-to-br from-slate-50 to-orange-50">
        <div class="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            {{-- Help Section --}}
            <div class="md:block hidden">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-lock text-2xl text-orange-600"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Password Reset</h2>
                    <p class="text-lg text-slate-600 mb-6">Don't worry, we've got you covered. Follow these simple steps to regain access to your account.</p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center flex-shrink-0 font-semibold">1</div>
                        <div>
                            <h4 class="font-semibold text-slate-900">Enter Your Email</h4>
                            <p class="text-sm text-slate-600">Provide the email address associated with your account.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center flex-shrink-0 font-semibold">2</div>
                        <div>
                            <h4 class="font-semibold text-slate-900">Check Your Email</h4>
                            <p class="text-sm text-slate-600">We'll send you a secure link to reset your password.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center flex-shrink-0 font-semibold">3</div>
                        <div>
                            <h4 class="font-semibold text-slate-900">Set New Password</h4>
                            <p class="text-sm text-slate-600">Click the link and create a new, secure password.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reset Form --}}
            <div class="w-full bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-900 text-center mb-2">{{ __('Forgot Password') }}</h2>
                <p class="text-sm text-slate-600 text-center mb-6">{{ __('Enter your email and we\'ll send you a password reset link.') }}</p>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-emerald-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('email')
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
                        <span x-text="loading ? 'Sending...' : 'Email Password Reset Link'"></span>
                    </button>
                </div>

                <div class="mt-4 text-center text-sm">
                    <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium">{{ __('Back to login') }}</a>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-guest-layout>
