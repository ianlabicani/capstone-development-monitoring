<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <nav x-data="{ open: false }" class="bg-white shadow-sm">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <a href="/" class="flex items-center gap-2">
                        <svg class="h-8 w-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                        </svg>
                        <span class="text-xl font-bold text-slate-900">Capstone<span class="text-orange-600">Monitor</span></span>
                    </a>

                    {{-- Desktop links --}}
                    <div class="hidden sm:flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Register</a>
                            @endif
                        @endauth
                    </div>

                    {{-- Mobile hamburger --}}
                    <button @click="open = !open" class="sm:hidden inline-flex items-center justify-center rounded-md p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition">
                        <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg x-show="open" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div x-show="open" x-cloak x-transition class="sm:hidden border-t border-slate-200">
                <div class="px-4 py-3 space-y-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-center bg-orange-600 text-white hover:bg-orange-700">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        {{ $slot }}
    </body>
</html>
