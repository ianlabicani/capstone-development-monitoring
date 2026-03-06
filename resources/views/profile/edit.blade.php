<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8 space-y-6">
            @if ($user->must_change_password)
                <div class="p-4 sm:p-8 bg-yellow-50 ring-1 ring-yellow-200 rounded-2xl border-l-4 border-yellow-500">
                    <div class="flex items-start gap-4">
                        <i class="fas fa-exclamation-triangle text-2xl text-yellow-600 mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-900">Change Your Password</h3>
                            <p class="mt-1 text-sm text-yellow-800">You are required to change your password before accessing other features. Please update your password below.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
