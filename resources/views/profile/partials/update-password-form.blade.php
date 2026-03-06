<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-slate-700">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" class="mt-1 block w-full border-slate-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm" />
            @if ($errors->updatePassword->has('current_password'))
                <ul class="mt-2 text-sm text-red-600 space-y-1">
                    @foreach ($errors->updatePassword->get('current_password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block font-medium text-sm text-slate-700">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" class="mt-1 block w-full border-slate-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm" />
            @if ($errors->updatePassword->has('password'))
                <ul class="mt-2 text-sm text-red-600 space-y-1">
                    @foreach ($errors->updatePassword->get('password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-slate-700">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="mt-1 block w-full border-slate-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm" />
            @if ($errors->updatePassword->has('password_confirmation'))
                <ul class="mt-2 text-sm text-red-600 space-y-1">
                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
