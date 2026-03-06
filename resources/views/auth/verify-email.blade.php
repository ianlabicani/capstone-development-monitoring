<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gradient-to-br from-slate-50 to-emerald-50">
        <div class="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            {{-- Verification Info Section --}}
            <div class="md:block hidden">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-envelope-circle-check text-2xl text-emerald-600"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Verify Your Email</h2>
                    <p class="text-lg text-slate-600 mb-6">We've sent you a verification link to confirm your email address. Check your inbox!</p>
                </div>
                <div class="space-y-4">
                    <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-200">
                        <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-inbox text-emerald-600"></i>
                            Check Your Inbox
                        </h4>
                        <p class="text-sm text-slate-600">Look for an email from us with the verification link.</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-spam text-blue-600"></i>
                            Check Spam Folder
                        </h4>
                        <p class="text-sm text-slate-600">Sometimes our email might end up in your spam folder. Check there if you don't see it.</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                        <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-redo text-orange-600"></i>
                            Didn't Receive It?
                        </h4>
                        <p class="text-sm text-slate-600">Use the button below to resend the verification email.</p>
                    </div>
                </div>
            </div>

            {{-- Verification Actions --}}
            <div class="w-full bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-900 text-center mb-2">{{ __('Verify Your Email') }}</h2>
                <p class="text-sm text-slate-600 text-center mb-6">{{ __('Thanks for signing up! Please verify your email address by clicking the link we just sent you.') }}</p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-emerald-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </div>
            @endif

                <div class="space-y-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 transition">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg py-2.5 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
