{{-- CTA Section --}}
<section class="py-16 bg-slate-900 text-white">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-4">Ready to Monitor Your Capstone Progress?</h2>
        <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">Join the platform that keeps capstone teams accountable, advisers informed, and development visible.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Log In</a>
            @endauth
        </div>
    </div>
</section>
