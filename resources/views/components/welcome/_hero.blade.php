{{-- Hero Section --}}
<section class="relative overflow-hidden bg-slate-900">
    <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-slate-900/80"></div>
    <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <div class="text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white">Monitor Your Capstone Team's Development Progress</h1>
            <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto">Track commits, branches, pull requests, and contributor activity — all in one place. Stay accountable, stay visible, stay on track.</p>
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Log In</a>
                @endauth
            </div>
        </div>
    </div>
</section>
