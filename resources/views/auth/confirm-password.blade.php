<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gradient-to-br from-slate-50 to-orange-50">
        <div class="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            {{-- Security Section --}}
            <div class="md:block hidden">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-key text-2xl text-orange-600"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Confirm Your Password</h2>
                    <p class="text-lg text-slate-600 mb-6">For your security, please confirm your password before accessing this sensitive area.</p>
                </div>
                <div class="space-y-4">
                    <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                        <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-lock text-orange-600"></i>
                            Why We Ask
                        </h4>
                        <p class="text-sm text-slate-600">This protects your account and sensitive data from unauthorized access, even if someone has access to your computer.</p>
                    </div>
                    <div class="bg-slate-100 rounded-lg p-4">
                        <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-info-circle text-slate-600"></i>
                            This Session
                        </h4>
                        <p class="text-sm text-slate-600">You'll only need to confirm your password once per session.</p>
                    </div>
                </div>
            </div>

            {{-- Password Confirmation Form --}}
            <div class="w-full bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-900 text-center mb-2">{{ __('Confirm Password') }}</h2>
                <p class="text-sm text-slate-600 text-center mb-6">{{ __('This is a secure area. Please confirm your password before continuing.') }}</p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 transition">
                        {{ __('Confirm') }}
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-guest-layout>
