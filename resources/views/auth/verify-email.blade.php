<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Verify Email') }} — {{ config('app.name', 'CapstoneMonitor') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 antialiased bg-slate-50">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2 mb-8">
            <svg class="h-8 w-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
            </svg>
            <span class="text-xl font-bold text-slate-900">Capstone<span class="text-orange-600">Monitor</span></span>
        </a>

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
</body>
</html>
