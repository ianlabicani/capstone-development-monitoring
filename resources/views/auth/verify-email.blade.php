<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-slate-50">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
            <h2 class="text-2xl font-bold text-slate-900 text-center mb-2">{{ __('Verify Your Email') }}</h2>
            <p class="text-sm text-slate-600 text-center mb-6">{{ __('Thanks for signing up! Please verify your email address by clicking the link we just sent you.') }}</p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-emerald-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </div>
            @endif

            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 transition">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-600 hover:text-slate-900">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
